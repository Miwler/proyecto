<?php
require('include/fpdf/fpdf.php');

class PDF extends FPDF
{
    var $widths;
    var $aligns;
    var $oDatos_Generales;
    var $oProveedor;
    function SetWidths($w) {  
        $this->widths=$w;
    }
    function SetAligns($a)
    {
    $this->aligns=$a;
    }
    public $oOrden_Compra;
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
                    //Draw the border

                    //$this->Rect($x,$y,$w,$h);

                    $this->MultiCell($w,4,$data[$i],0,$a,false);
                    //Put the position to the right of the cell
                    $this->SetXY($x+$w,$y);
            }
            //Go to the next line
            $this->Ln($h);
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
        $this->Image("./include/img/logopdf.jpg" , 10 ,8, 60, 20 , "JPG" );
        
        //Arial bold 15
        $this->SetFont('Arial','B',20);
        //Movernos a la derecha
        $this->Cell(60,20,'',0);
        
        $this->SetTextColor(117,179,114);
        //Título
        $this->Cell(130,10,'ORDEN DE COMPRA',0,0,'R');
        $this->Ln();
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(29,30,29);
        $this->Cell(155,5,'FECHA',0,0,'R');
        $this->Cell(35,5,$this->oOrden_Compra->fecha,1,0,'C');
        $this->Ln();
        $this->Cell(155,5,'NRO',0,0,'R');
        //$this->Ln();
        $this->Cell(35,5,sprintf("%'.07d",$this->oOrden_Compra->numero_orden),1,2,'C');
        $this->Ln();
        //$this->SetX(10);
        $this->SetY(30);
        $this->SetFont('Arial','',10);
        $this->Cell(60,7,'RUC: '.$this->oDatos_Generales->ruc,0,2,'C');
        $this->SetFont('Arial','',8);
        $this->Cell(60,4,utf8_decode($this->oDatos_Generales->direccion),0,2,'L');
        $this->Cell(15,4,utf8_decode('Teléfono:'),0,0,'L');
        $this->Cell(45,4,$this->oDatos_Generales->telefono,0,0,'L');
        $this->Ln();
        $this->SetFont('Arial','U',8);
        $this->SetTextColor(88,143,206);
        $this->Cell(60,4,$this->oDatos_Generales->pagina_web,0,0,'L');
        $this->Ln(10);
        
      
        
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(255,255,255);
        $this->SetFillColor(117,179,114);
        $this->Cell(80,6,'VENDEDOR',0,2,'C',true);
        //$this->Cell(30,6);
        //$this->Ln();
        $this->SetTextColor(0,0,0);
        $this->SetFont('Arial','',8);
        $this->Cell(80,5,utf8_decode($this->oProveedor->razon_social),0,2,'L');
        $this->SetFillColor(255,255,255);
        $this->MultiCell(80,5,utf8_decode($this->oProveedor->direccion),0,'L','J',false);
        //$this->Ln();
        $this->Cell(20,5,utf8_decode('Teléfono: '),0,0,'L');
        $this->Cell(40,5,utf8_decode($this->oProveedor->telefono),0,0,'L');
        
        //Cuadro de envie a
        
        $this->SetXY(120,55);
        
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(255,255,255);
        $this->SetFillColor(117,179,114);        
        $this->Cell(80,6,'ENVIE A',0,2,'C',true);
        
        $this->SetTextColor(0,0,0);
        
        $this->SetFont('Arial','',8);
        $this->Cell(80,6,utf8_decode($this->oDatos_Generales->razon_social),0,2,'L',false);
        $this->Cell(80,6,utf8_decode($this->oDatos_Generales->direccion),0,2,'L',false);
        $this->Cell(30,6,utf8_decode('Teléfono: '),0,0,'L',false);
        $this->Cell(50,6,$this->oDatos_Generales->telefono,false);
        //Salto de línea
        $this->Ln(20); 
    }
   
    function Footer(){
      //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    $this->MultiCell(190,10,utf8_decode('Si usted tiene alguna pregunta sobre esta orden de compra, por favor póngase en contacto con nosotros. '),0,'C');
    //Número de página
    //$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
    }
    
}

?>