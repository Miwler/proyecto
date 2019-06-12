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
    public $cabecera;
    public $detalle;
    public $numero_cuenta;
    public $numero;
    public $electronico;
    public $font_size=5;
    public $subtitle_size=8;
    public $array_motivo;
    public $hash="";
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
    function cabecera_header(){
        //require ROOT_PATH . 'include/lib_fecha_texto.php';
        $this->Image(logo_documentos , 8 ,8, 70, 20 , "JPG" );
        $this->SetFont('Arial','',8);
        $this->SetTextColor(0);
        $this->SetXY(8,18);
        $this->Cell(80,30,FormatTextViewPDF($this->cabecera[0]['razon_social']),0,1);
        $this->SetXY(8,25);
        $this->Cell(80,30,FormatTextViewPDF($this->cabecera[0]['direccion1']),0,1);
        $this->SetXY(138,8);
        $this->Cell(70,30,'',1);    
        $this->SetXY(138,8);
        $this->SetFont('Arial','B',12);
        $this->Cell(70,7,'R.U.C.'.$this->cabecera[0]['ruc'],0,2,'C');
        $this->Cell(70,7,'GUIA DE REMISION',0,2,'C');
        if($this->electronico==1){
            $this->Cell(70,7,FormatTextViewPDF('ELECTRÓNICO'),0,2,'C');
        }
        
        $this->Cell(70,7,utf8_decode($this->cabecera[0]['serie'].' - N°'. $this->numero),0,0,'C');
        
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
        
        $this->Cell(40,5,$this->cabecera[0]['fecha_emision'],0,0,'L');
        $this->SetXY(80,45);
        
        $this->Cell(25,5,'FECHA DE INICIO',0,2,'L');
        $this->Cell(25,5,'DEL TRASLADO',0,2,'L');
        
        $this->SetXY(105,45);
        $this->Cell(40,5,$this->cabecera[0]['fecha_inicio_traslado'],0,0,'L');
        
        $this->SetXY(130,45);
        $this->Cell(40,5,FormatTextViewPDF('ORDEN DE PEDIDO N°:'),0,2,'L');
        $this->Cell(25,5,'ORDEN DE COMPRA',0,2,'L');
        $this->SetFont('Arial','',7);
        $this->SetXY(170,45);
        $this->Cell(40,5,$this->cabecera[0]['numero_orden_venta'],0,2,'L');
        $this->Cell(95,5,$this->cabecera[0]['numero_orden_compra'],0,2,'L');
        $this->Ln(2);
        //domicilio de partida
        $this->SetFillColor(215,215,215);
        $this->Cell(99,5,'DOMICILIO DE PARTIDA',1,2,'C',true);
        $this->MultiCell(99,10,FormatTextViewPDF($this->cabecera[0]['punto_partida']),0,'C',false);
        $this->Rect(10,62,99,10);
        $this->SetXY(111,57);
        $this->Cell(99,5,'DOMICILIO DE LLEGADA',1,2,'C',true);
        $this->MultiCell(99,5,FormatTextViewPDF($this->cabecera[0]['punto_llegada']),0,'C',false);
        $this->Rect(111,62,99,10);
        $this->Ln(7);
        
        //destinatario
        $this->SetXY(10,74);
        $this->Cell(99,5,'DESTINATARIO',1,2,'C',true);
        $this->MultiCell(80,5,'NOMBRES/RAZON SOCIAL:'.FormatTextViewPDF($this->cabecera[0]['cliente']),0,'L',false);
       
        //$this->Ln(3);
        $this->Cell(80,5,'RUC:'.FormatTextViewPDF($this->cabecera[0]['cliente_ruc']),0,1,'L',false);
      
        $this->Rect(10,79,99,10);
        $this->SetXY(111,74);
        $this->Cell(99,5,'DATOS DEL TRANSPORTE/CONDUCTOR',1,2,'C',true);
        $this->Cell(30,5,FormatTextViewPDF('VEHICULO MARCA Y PLACA N°:').utf8_encode($this->cabecera[0]['vehiculo']),0,0,'L');
        $this->Ln(3);
        $this->SetX(111);
        $this->Cell(30,5,FormatTextViewPDF('CERTIFICADO DE INSCRIPCION N°: ').utf8_encode($this->cabecera[0]['certificado_inscripcion']),0,0,'L');
        $this->Ln(3);
        $this->SetX(111);
        $this->Cell(30,5,FormatTextViewPDF('LICENCIA DE CONDUCIR N°:').utf8_encode($this->cabecera[0]['licencia_conducir']),0,0,'L');
        
        $this->Rect(111,79,99,10);
        $this->Ln(2);
        
    }
   
    function contenedor_detalle($alto){
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
       $y=$this->GetY();
       $this->SetTextColor(0);
       $this->Cell(80,5,'TRANSPORTISTA:',1,0,'C',true);
       $this->Ln();
       $this->Cell(80,5,'NOMBRE: '.FormatTextViewPDF($this->cabecera[0]["chofer"]).'   '.FormatTextViewPDF($this->cabecera[0]["licencia_conducir"]),0,0,'L',false);

       $this->Ln();
       $this->SetX(30);
       $this->Cell(80,5,FormatTextViewPDF($this->cabecera[0]["empresa_transporte"]),0,0,'L',false);
       $this->Ln(3);
       $this->SetX(30);
       $this->Cell(80,5,utf8_decode($this->cabecera[0]["ruc_empresa_transporte"]),0,0,'L',false);
       $this->Ln(3);
       $this->SetX(30);
       $this->Cell(80,5, FormatTextViewPDF($this->cabecera[0]["vehiculo"]),0,0,'L',false);
       $this->SetXY(10,243);
       $this->Cell(30,5,'R.U.C./D.N.I.:',0,0,'L',false);
       $this->Rect(10,235,80,15);
       $x=95;
       $x1=129;
       $this->SetXY($x,$y);
       $this->Cell(115,5,'MOTIVO DEL TRASLADO:',1,0,'C',true);
       $this->Ln();
       $this->SetFont('Arial','',6);
       $i=0;
       
       $y1=$this->GetY();
       $bloque=1;
       foreach($this->array_motivo as $motivo){
           if($motivo['bloque']==1){
                $this->SetX($x);
                $this->Cell(27,5,$motivo['nombre'],0,0,'L');
                $this->Cell(4,4,($motivo['ID']==$this->cabecera[0]["motivo_traslado_ID"]?"X":""),1,0,'C');
                $this->Ln();
                
           }else{
                if($i==0){
                     $this->SetY($y1);
                }
                $this->SetX($x1);
                $this->Cell(75,5,$motivo['nombre'],0,0,'L');
                $this->Cell(4,4,($motivo['ID']==$this->cabecera[0]["motivo_traslado_ID"]?"X":""),1,0,'C');
                $this->Ln();
                $i++;
           }  
       }
       $y2=$this->GetY();
       $this->Rect($x,$y1,115,($y2-$y1));
       $array_opcion=array('Venta','VENTA SUJETA A CONFIRMACION DEL COMPRADOR','Compra');
       
       
      
   }
    function contenido_detalle($dtGuia_Venta_Detalle){
        
        $this->SetXY(10,100);
        $this->SetFont('Arial','',8);
        foreach($dtGuia_Venta_Detalle as $item){
            $longitud=250;
            $largo_prod=strlen(FormatTextViewPDF($item['producto']));
            $longitud=$longitud-$largo_prod;
            $this->SetFont('Arial','B',8);
            $array=array($item['cantidad'],FormatTextViewPDF($item['producto']),$item['unidad_medida'],round($item['peso'],2));
            $this->Row($array,5);
            $this->SetX(30);
            $this->SetFont('Arial','',8);
            
                //$this->MultiCell(120,5,utf8_decode($item['producto']).chr(10).utf8_decode($item['descripcion']),0,'J',false);
                $this->MultiCell(120,5,substr(FormatTextViewPDF($item['descripcion']),0,$longitud),0,'J',false);
                
            
            $this->Ln();

       }

    }
   function Footer(){
       $this->SetXY(10,270);
    $this->Cell(200,$this->font_size,"DigestValue: ".$this->hash,0,0,'L');
    }
   
} 


?>