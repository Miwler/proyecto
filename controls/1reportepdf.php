<?php
require('include/fpdf/fpdf.php');

class PDF1 extends FPDF
{
    var $widths;
    var $aligns;
    var $borde;
    var $colorfondo;
    var $SubTitulo;
    var $dataCabecera;
    var $fecha_cabecera;
    function SetWidths($w) {  
        $this->widths=$w;
    }
    function SetAligns($a)
    {
        $this->aligns=$a;
    }
    function SetBorde($b){
        $this->borde=$b;
    }
    function SetColorFondo($f){
        $this->colorfondo=$f;
    }
    function SetSubTitulo($subtitulo){
        $this->SubTitulo=$subtitulo;
    }
   function SetCabecera($dataCabecera){
       $this->dataCabecera=$dataCabecera;
   }
   /*function SetFecha_Cabecera($fecha_cabecera){
        $this->fecha_cabecera=$fecha_cabecera;
    }*/
    public $oReportes;
    
    function Row($data,$altura)
    {
            //Calculate the height of the row
        
        $this->SetFont('Arial','',$altura);
            $nb=0;
            for($i=0;$i<count($data);$i++)
                $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
            
            $h=$altura*$nb;
            
            //Issue a page break first if needed
            $this->CheckPageBreak($h);
            //Draw the cells of the row
            $width_total=0;
            for($i=0;$i<count($data);$i++)
            {
                    $w=$this->widths[$i];
                    $width_total=$width_total+$w;
                    $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
                    $b=isset($this->borde[$i]) ? $this->borde[$i] : 0;
                    $c=isset($this->colorfondo[$i]) ? $this->colorfondo[$i] : false;
                    //Save the current position
                    $x=$this->GetX();
                    $y=$this->GetY();
                 
                    
                    //Draw the border
                    $this->MultiCell($w,$altura,$data[$i],0,$a,$c);
                    //Put the position to the right of the cell
                    $this->SetXY($x+$w,$y);
                    
            }
            $this->Ln($h);
            $y1=$this->GetY();
            $this->Line(10,$y1,$width_total+10,$y1);
            
    }

    function CheckPageBreak($h)
    {
            //If the height h would cause an overflow, add a new page immediately
            if($this->GetY()+$h>$this->PageBreakTrigger)
                $this->AddPage($this->CurOrientation);
                //$this->cabecera($this->dataCabecera,10);
                //$this->Ln();
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
       
        $this->Image("./include/img/logopdf.jpg" , 10 ,8, 35, 10 , "JPG" );
        
        //Arial bold 15
        $this->SetFont('Arial','',10);
        //Movernos a la derecha
        $this->SetXY(155,10);
        $this->SetTextColor(0);
        $this->Cell(50,5, utf8_decode('Fecha de impresión:'). $this->fecha_cabecera,0,'C',false);
        $this->SetFont('Arial','B',12);
        /*$this->SetXY(10,20);
        $this->SetTextColor(0);
        //Título
        //$this->MultiCell(190,5,strtoupper($this->oReportes->titulo),0,'C',false);
        $this->SetFont('Arial','B',10);
        //$this->MultiCell(190,5, utf8_decode($this->SubTitulo),0,'C',false);  
        $this->Ln();*/
        
        
    }

    function Footer(){
     
      //Posición: a 1,5 cm del final
   
    $this->SetY(-10);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'R');
    }
   
} 

?>