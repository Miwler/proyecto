<?php
require('include/fpdf/fpdf.php');

class PDF extends FPDF
{
    
    var $widths;
    var $aligns;
    var $oDatos_Generales;
    
    public $cliente;
    public $documento;
  
    function SetWidths($w) {  
        $this->widths=$w;
    }
    function SetAligns($a)
    {
    $this->aligns=$a;
    }
    public $oProforma;
    function Row($data,$altura,$numero)
    {
            //Calculate the height of the row
        $this->SetFont("Arial","",8);
        if($numero%2==0){
            $this->SetFillColor(218);
        }else{
            $this->SetFillColor(204,205,207);
            
        }
        $this->SetTextColor(78);
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

                    $this->MultiCell($w,10,$data[$i],0,$a,true);
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
        
        $this->Image(logo_documentos , 10 ,8, 50, 15 , "JPG" );
        $this->SetDrawColor(117,179,114);
        $this->Line(0,25,211,25);
        
        $this->SetDrawColor(135,127,127);
        
        
        $this->SetFont('Arial','',6);
        $this->SetXY(70,8);
        $this->SetTextColor(135,127,127);
        $this->Cell(25,3,'RUC ',0,2,'C');
        $this->SetFont('Arial','',6);
        $this->SetTextColor(0,0,0);
        $this->Cell(25,3,$this->oDatos_Generales->ruc,0,2,'C');
        
        
        
        $this->Line(94,8,94,16);
        $this->SetXY(95,8);
        $this->SetFont('Arial','',6);
        $this->SetTextColor(135,127,127);
        $this->Cell(25,3,utf8_decode('Teléfono'),0,2,'C');
        $this->SetFont('Arial','',6);
        $this->SetTextColor(0,0,0);
        $this->Cell(25,3,$this->oDatos_Generales->telefono,0,2,'C');
        
        
        $this->Line(119,8,119,16);
        $this->SetXY(120,8);
        $this->SetFont('Arial','B',6);
        $this->SetTextColor(135,127,127);
        $this->Cell(25,3,'Celular ',0,2,'C');
        $this->SetFont('Arial','',6);
        $this->SetTextColor(0,0,0);
        $this->Cell(25,3,$this->oDatos_Generales->celular,0,2,'C');
        
        
        $this->Line(144,8,144,16); 
        $this->SetXY(145,8);
        $this->SetFont('Arial','B',6);
        $this->SetTextColor(135,127,127);
        $this->Cell(46,3,utf8_decode('Dirección'),0,2,'C');
        $this->SetFont('Arial','',6);
        $this->SetTextColor(0,0,0);
        $this->Cell(46,3,utf8_decode($this->oDatos_Generales->direccion),0,2,'C');
        
        /*Segunda fila*/
        
        $this->SetFont('Arial','B',8);
        
        $this->Line(10,30,10,42);
        $this->SetXY(12,33);
        $this->SetTextColor(135,127,127);
        $this->Cell(40,5,'FECHA ',0,2,'L');
        $this->SetFont('Arial','',8);
        $this->SetTextColor(0,0,0);
        $this->Cell(40,5,"02-04-2018",0,2,'L');
        
        $this->Line(40,30,40,42);
        $this->SetXY(42,33);
        $this->SetFont('Arial','B',8);
        $this->SetTextColor(135,127,127);
        $this->Cell(40,5,utf8_decode('NÚMERO'),0,2,'L');
        $this->SetFont('Arial','',8);
        $this->SetTextColor(0,0,0);
        $this->Cell(40,5,$this->oProforma->numero_concatenado,0,2,'L');
        
        $this->Line(70,30,70,42);
        $this->SetXY(72,33);
        $this->SetFont('Arial','B',8);
        $this->SetTextColor(135,127,127);
        $this->Cell(40,5,'Celular ',0,2,'L');
        $this->SetFont('Arial','',8);
        $this->SetTextColor(0,0,0);
        $this->Cell(40,5,$this->oDatos_Generales->celular,0,2,'L');
        $this->SetXY(120,35);
        $this->SetFont('Arial','',25);
        $this->Cell(60,7,'PROFORMA ',0,2,'L');
        
        
        $this->Image("formatos_pdf/proforma/fondo_proforma.jpg" , 0 ,50, 210, 16 , "JPG" );
       
        
        $this->SetXY(10,55);
        $this->SetFont('Arial','',25);
        $this->SetTextColor(255,255,255);
        $this->Cell(60,7,'TOTAL: S/.1500.00',0,2,'L');
        
        $this->SetXY(135,59);
        $this->SetFont('Arial','',7);
        $this->SetTextColor(117,179,114);
        $this->Cell(75,3,utf8_decode('SOLUCIONES INFORMÁTICAS M&M S.R.L.'),0,2,'C');
        
        $this->SetTextColor(135,127,127);
        $this->Cell(75,3,utf8_decode('RUC: 20111579807'),0,2,'C');
        
        $this->SetTextColor(135,127,127);
        $this->Cell(75,3,utf8_decode('Av. El ejercito MZ. A Lt. 14 - Barranca'),0,2,'C');
        //Movernos a la derecha
        $this->Cell(60,20,'',0);
        
        $this->SetTextColor(117,179,114);
        //Título
       /* $this->Cell(130,10,'ORDEN DE COMPRA',0,0,'R');
        $this->Ln();
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(29,30,29);
        $this->Cell(155,5,'FECHA',0,0,'R');
        $this->Cell(35,5,$this->oProforma->fecha,1,0,'C');
        $this->Ln();
        $this->Cell(155,5,'NRO',0,0,'R');
        //$this->Ln();
        $this->Cell(35,5,sprintf("%'.07d",$this->oProforma->numero),1,2,'C');
        $this->Ln();
        //$this->SetX(10);
        $this->SetY(30);
        $this->SetFont('Arial','',10);
        $this->Cell(60,7,'RUC: '.$this->oDatos_Generales->ruc,0,2,'C');
        $this->SetFont('Arial','',8);
        $this->Cell(60,4,$this->oDatos_Generales->direccion,0,2,'L');
        $this->Cell(15,4,utf8_decode('Teléfono:'),0,0,'L');
        $this->Cell(45,4,$this->oDatos_Generales->telefono,0,0,'L');
        $this->Ln();
        $this->SetFont('Arial','U',8);
        $this->SetTextColor(88,143,206);
        $this->Cell(60,4,$this->oDatos_Generales->pagina_web,0,0,'L');
        $this->Ln(10);
        */
      
        
       /* $this->SetFont('Arial','B',10);
        $this->SetTextColor(255,255,255);
        $this->SetFillColor(117,179,114);
        $this->Cell(80,6,'VENDEDOR',0,2,'C',true);
        //$this->Cell(30,6);
        //$this->Ln();
        $this->SetTextColor(0,0,0);
        $this->SetFont('Arial','',8);
        $this->Cell(80,5,"",0,2,'L');
        $this->SetFillColor(255,255,255);
        $this->MultiCell(80,5,utf8_decode(""),0,'L','J',false);
        //$this->Ln();
        $this->Cell(20,5,utf8_decode('Teléfono: '),0,0,'L');
        $this->Cell(40,5,utf8_decode(""),0,0,'L');*/
        
        //Cuadro de envie a
        
        /*$this->SetXY(120,55);
        
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(255,255,255);
        $this->SetFillColor(117,179,114);        
        $this->Cell(80,6,'ENVIE A',0,2,'C',true);
        
        $this->SetTextColor(0,0,0);
        
        $this->SetFont('Arial','',8);
        $this->Cell(80,6,$this->oDatos_Generales->razon_social,0,2,'L',false);
        $this->Cell(80,6,$this->oDatos_Generales->direccion,0,2,'L',false);
        $this->Cell(30,6,utf8_decode('Teléfono: '),0,0,'L',false);
        $this->Cell(50,6,$this->oDatos_Generales->telefono,false);
        //Salto de línea
        $this->Ln(20); */
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