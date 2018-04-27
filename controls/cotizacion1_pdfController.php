<?php
require('include/fpdf/fpdf.php');

class PDF1 extends FPDF
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
    public $oCotizacion;
    public $oDatos_Generales;
    public $oCliente;
    public $oRepresentanteCliente;
    public $oMoneda;
    public $oForma_Pago;
    public $oOperador;
    public $oEjecutivo;
    public $dtCotizacion_Numero_Cuenta;
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

        $this->SetFont('Arial','B',20);
        
               
    }
    function presentacion(){
        //Cliente
         $representante="";
        if($this->oRepresentanteCliente!=null){
            $representante= FormatTextView($this->oRepresentanteCliente->nombres." ".$this->oRepresentanteCliente->apellido_paterno." ".$this->oRepresentanteCliente->apellido_materno);
        }
        $this->SetTextColor(0,0,0);
        $this->SetFont('Arial','B',10);
        $this->Cell(20,5,utf8_decode('Señores'),0,0,'L');
        $this->Cell(170,5,utf8_decode($this->oCliente->razon_social),0,0,'L');
        $this->Ln();
        $this->Cell(20,5,'Presente.',0,0,'L');
        $this->Ln();
        $this->Cell(20,5,utf8_decode('Atención') ,0,0,'L');
        $this->Cell(170,5,utf8_decode('Sr(a). '.$representante) ,0,0,'L');
        $this->Ln();
        $this->SetFont('Arial','',10);
        $this->Cell(190,5,utf8_decode('De nuestra consideración.'),0,0,'L');
        $this->Ln();
        $this->Cell(190,5,utf8_decode('Por medio del presente nos permitimos saludarlos y a la vez le hacemos llegar la siguiente cotización:'),0,0,'L');

    }
   function contenedor_detalle($alto,$y){
    $this->SetXY(10,$y);
    $this->SetFont('Arial','B',10);
    $this->SetTextColor(255,255,255);
    $this->SetFillColor(117,179,114);
    $this->Cell(10,7,utf8_decode('#'),1,0,'C',true);
    $this->Cell(120,7,utf8_decode('DESCRIPCIÓN'),1,0,'C',true);
    $this->Cell(15,7,utf8_decode('CANT'),1,0,'C',true);
    $this->Cell(20,7,utf8_decode('P/U'),1,0,'C',true);
    $this->Cell(25,7,utf8_decode('TOTAL'),1,0,'C',true);
    $this->Ln();
    // cuerpo del detalle
    $this->Cell(10,$alto,'',1,0,'C');
    $this->Cell(120,$alto,'',1,0,'C');
    $this->Cell(15,$alto,'',1,0,'C');
    $this->Cell(20,$alto,'',1,0,'C');
    $this->Cell(25,$alto,'',1,0,'C');
    $this->Ln();
   }
   
   function costo_total($y){
       // Costos totales
       
    $precio_neto=0;
    $precio_igv=0;
    $precio_total=0;
    if($this->oCotizacion->moneda_ID==1){
        $precio_neto=$this->oCotizacion->precio_venta_neto_soles;
        $precio_igv=$this->oCotizacion->vigv_soles;
        $precio_total=$this->oCotizacion->precio_venta_total_soles;
    }else {
        $precio_neto=$this->oCotizacion->precio_venta_neto_dolares;
        $precio_igv=$this->oCotizacion->vigv_dolares;
        $precio_total=$this->oCotizacion->precio_venta_total_dolares;
    }
    $this->SetTextColor(0,0,0);
    $this->SetFont('Arial','B',8);
    $this->SetXY(145,$y);
    $this->Cell(20,7,'SUB TOTAL',0,0,'L');
    $this->Cell(10,7,$this->oMoneda->simbolo,0,0,'R');
    $this->Cell(25,7,number_format($precio_neto,2,".",','),1,0,'R');
    $this->Ln();
    $this->SetX(145);
    $this->Cell(20,7,'IGV '.($this->oCotizacion->igv*100).'%',0,0,'L');
    $this->Cell(10,7,$this->oMoneda->simbolo,0,0,'R');
    $this->Cell(25,7,number_format($precio_igv,2,".",','),1,0,'R');
    $this->Ln();
    $this->SetX(145);
    $this->Cell(20,7,'TOTAL',0,0,'L');
    $this->Cell(10,7,$this->oMoneda->simbolo,0,0,'R');
    $this->Cell(25,7,number_format($precio_total,2,".",','),1,0,'R');
   }
   function otros_datos($y){
        $this->SetXY(10,$y);
   
    //Condiciones generales
    $condiciones='';
    
    $this->SetFont('Arial','B',8);
    $this->SetTextColor(255,255,255);
    $this->SetFillColor(117,179,114);
    $this->Cell(110,5,'Condiciones generales',0,2,'C',true);
    $this->SetTextColor(0,0,0);
    $this->SetFont('Arial','B',8);
    $this->Cell(30,5,'Lugar entrega:',0,0,'L');
    $this->SetFont('Arial','',8);
    $this->MultiCell(80,4,  $this->oCotizacion->lugar_entrega,0,'J');
    $this->Ln(1);
    $this->SetFont('Arial','B',8);
    $this->Cell(30,5,'Tiempo entrega:',0,0,'L');
    $this->SetFont('Arial','',8);
    $this->Cell(50,5,$this->oCotizacion->plazo_entrega.utf8_decode(' días'),0,0,'L');
    $this->Ln(4);
    $this->SetFont('Arial','B',8);
    $this->Cell(30,5,'Validez de la oferta:',0,0,'L');
    $this->SetFont('Arial','',8);
    $this->Cell(50,5,$this->oCotizacion->validez_oferta.utf8_decode(' días'),0,0,'L');
    $this->Ln(4);
    $this->SetFont('Arial','B',8);
    $this->Cell(30,5,utf8_decode('Garantía:'),0,0,'L');
    $this->SetFont('Arial','',8);
    $this->Cell(50,5,$this->oCotizacion->garantia,0,0,'L');
    $this->Ln(4);
    $this->SetFont('Arial','B',8);
    $this->Cell(30,5,utf8_decode('Forma pago:'),0,0,'L');
    $this->SetFont('Arial','',8);
    $this->Cell(50,5,utf8_decode($this->oForma_Pago->nombre),0,0,'L');
    $this->Ln(6);
    //Numero de cuenta
    $this->SetFont('Arial','B',8);
    $this->SetTextColor(255,255,255);
    $this->SetFillColor(117,179,114);
    
    $this->SetFont('Arial','B',8);
    $this->SetTextColor(255,255,255);
    $this->SetFillColor(117,179,114);
    $this->Cell(30,5,'Banco',0,0,'C',true);
    $this->Cell(40,5,'Nro. de cuenta ('.$this->oMoneda->simbolo.')',0,0,'C',true);
    $this->Cell(40,5,'CCI',0,0,'C',true);
    $h1=$this->GetY();
    $this->Ln();
    foreach($this->dtCotizacion_Numero_Cuenta as $item){
        $this->SetFont('Arial','',8);
        $this->SetTextColor(0,0,0);
        $this->SetFillColor(255,255,255);
        $this->Cell(30,5,$item['abreviatura'],0,0,'L',true);
        $this->Cell(40,5,$item['numero'],0,0,'L',true);
        $this->Cell(40,5,$item['cci'],0,0,'L',true);
        $this->Ln(4);
    }
    
    //Observación
    $this->SetTextColor(255,255,255);
    $this->SetFillColor(117,179,114);
    $this->SetFont('Arial','B',8);
    $this->Cell(110,5,utf8_decode('Observación'),0,0,'C',true);
    $this->Ln();
    $this->SetTextColor(0,0,0);
    $this->SetFont('Arial','',8);
    /*$this->SetFillColor(255,255,255);*/
    
    $this->MultiCell(110,5,$this->oCotizacion->observacion,0,'J',false);
  
    //Firmas
    $this->SetXY(130,$h1);
    $this->SetTextColor(255,255,255);
    $this->SetFillColor(117,179,114);
    $this->Cell(70,5,'Ejecutivo de ventas',0,2,'C',true);
    
    $this->SetTextColor(0);
    $this->SetFont('Arial','B',8);
    $this->Cell(70,5,$this->oEjecutivo->nombres.' '.$this->oEjecutivo->apellido_paterno,0,2,'C',false);
    $this->Cell(15,5,'Central:',0,0,'L',false);
    $this->SetFont('Arial','',8);
    $this->Cell(25,5,'(511) '.$this->oOperador->telefono,0,0,'L',false);
    $this->SetFont('Arial','B',8);
    $this->Cell(15,5,'Anexo:',0,0,'L',false);
    $this->Ln();
    $h1=$this->GetY();
    $this->SetXY(130,$h1);
    $this->SetFont('Arial','B',8);
    $this->Cell(15,5,'Celular: ',0,0,'L',false);
    $this->SetFont('Arial','',8);
    $this->Cell(55,5,$this->oOperador->celular,0,0,'L',false);
    $this->Ln();
    $h2=$this->GetY();
    $this->SetXY(130,$h2);
    $this->SetFont('Arial','B',8);
    $this->Cell(15,5,'e-mail: ',0,0,'L',false);
    $this->SetFont('Arial','',8);
    $this->Cell(55,5,$this->oOperador->mail,0,0,'L',false);
    $this->Ln();
        //Detalle de 
   }
   function Footer(){
    $this->SetXY(10,-20);
   
    }
   
} 

?>