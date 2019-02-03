<?php
require('include/fpdf/fpdf.php');

class PDF_plantilla extends FPDF
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
    
    /*function contenido_detalle($dtGuia_Venta_Detalle){
        
        $this->SetXY(10,100);
        $this->SetFont('Arial','',8);
        foreach($dtGuia_Venta_Detalle as $item){
            
            $this->SetFont('Arial','B',8);
            $array=array($item['cantidad'],$item['producto'],$item['unidad_medida'],$item['peso']);
            $this->Row($array,5);
            $this->SetX(30);
            $this->SetFont('Arial','',8);
            if(trim($item['descripcion'])!=''){
                $this->MultiCell(120,5,utf8_encode($item['descripcion']),0,'J',false);
                
            }
            $this->Ln();

       }

    }*/
   /* function contenedor_detalle($alto,$oGuia_Venta){
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

   
    
   }*/
   
   
   function Footer(){
    
    }
   
} 


?>