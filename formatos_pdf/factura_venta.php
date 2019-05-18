<?php
require('include/fpdf/fpdf.php');

class PDF3 extends FPDF
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
    public $oFactura_Venta;
    public $oOrden_Venta;
    public $oDatos_Generales;
    public $oCliente;
    public $oCliente_Contacto;
    public $oMoneda;
    public $oForma_Pago;
    public $oOperador;
    public $color;
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
    function cabecera($oFactura_Venta){
        //require ROOT_PATH . 'include/lib_fecha_texto.php';
        $this->Image(logo_documentos , 8 ,8, 70, 20 , "JPG" );
        $this->SetFont('Arial','',10);
        $this->SetTextColor(0);
        $this->SetXY(8,8);
        $this->Cell(80,30,'',0);
        $this->Cell(50,30,'Nueva central',0,0,'C');
        $this->Cell(70,30,'',1);
        $this->SetXY(138,8);
        $this->SetFont('Arial','B',15);
        $this->Cell(70,10,'R.U.C.'.$this->oDatos_Generales->ruc,0,2,'C');
        $this->Cell(70,10,'FACTURA',0,2,'C');
        $this->Cell(70,10,utf8_decode($oFactura_Venta->serie.' - N°'. $oFactura_Venta->numero_concatenado),0,0,'C');
        
        $this->Ln();
        $this->Ln();
     
        $this->SetFont('Arial','',10);
        $this->Cell(120,5,utf8_decode('Lima, '.fechaATexto($this->oOrden_Venta->fecha)),0,0,'L');
        $this->SetFont('Arial','B',10);
        $this->Cell(40,5,'Fecha de vencimiento:',0,0,'L');
        $this->SetFont('Arial','',10);
        $this->Cell(40,5,$oFactura_Venta->fecha_vencimiento,0,0,'L');
        $this->Ln();
        $this->SetFont('Arial','B',10);
        $this->Cell(25,5,utf8_decode('Señor(es):'),0,0,'L');
        $this->SetFont('Arial','',10);
        $this->Cell(95,5,utf8_decode($this->oCliente->razon_social),0,0,'L');
        $this->SetFont('Arial','B',10);
        $this->Cell(40,5,utf8_decode('Vendedor(a):'),0,0,'L');
        $this->SetFont('Arial','',10);
        $this->Cell(40,5,utf8_decode(substr($this->oOperador->nombres.','.$this->oOperador->apellido_paterno,0,22)),0,0,'L');
        $this->Ln();
        $this->SetFont('Arial','B',10);
        $this->Cell(25,5,utf8_decode('Dirección:'),0,0,'L');
        $this->SetFont('Arial','',9);
        $this->Cell(95,5,utf8_decode(substr($this->oCliente->direccion,0,50)),0,0,'L');
        $this->SetFont('Arial','B',10);
        $this->Cell(40,5,utf8_decode('N° Pedido:'),0,0,'L');
        $this->SetFont('Arial','',10);
        $this->Cell(40,5,utf8_decode($oFactura_Venta->numero_orden_venta),0,0,'L');
        $this->Ln();
        $this->SetFont('Arial','B',10);
        $this->Cell(25,5,utf8_decode('R.U.C.:'),0,0,'L');
        $this->SetFont('Arial','',10);
        $this->Cell(35,5,utf8_decode($this->oCliente->ruc),0,0,'L');
        $this->SetFont('Arial','B',10);
        $this->Cell(35,5,utf8_decode('Código del Cliente:'),0,0,'L');
        $this->SetFont('Arial','',10);
        $this->Cell(25,5,utf8_decode($this->oCliente->codigo),0,0,'L');
        $this->SetFont('Arial','B',10);
        $this->Cell(40,5,utf8_decode('N° Orden de Compra:'),0,0,'L');
        $this->SetFont('Arial','',10);
        $this->Cell(40,5,utf8_decode($oFactura_Venta->numero_orden_compra),0,0,'L');
        $this->Ln();
        $this->SetFont('Arial','B',10);
        $this->Cell(200,5,utf8_decode('Por lo siguiente:'),0,1,'L');
    }
    function contenido_detalle($dtFactura_Venta_Detalle){
        
        $this->SetXY(10,87);
        foreach($dtFactura_Venta_Detalle as $item){
            $costo_unitario=0;
            $subtotal=0;
            if($item['moneda_ID']==1){
                   $costo_unitario=number_format($item['precio_venta_unitario_soles'],bd_largo_decimal,'.',',');
                   $subtotal=number_format($item['precio_venta_subtotal_soles'],2,'.',',');

            }else {
                   $costo_unitario=number_format($item['precio_venta_unitario_dolares'],bd_largo_decimal,'.',',');
                   $subtotal=number_format($item['precio_venta_subtotal_dolares'],2,'.',',');

            }
            $this->SetFont('Arial','B',10);
            $array=array($item['cantidad'],$item['producto'],$costo_unitario,$subtotal);
            $this->Row($array,5);
            $this->SetX(30);
            $this->SetFont('Arial','',9);
            if(trim($item['descripcion'])!=''){
                $this->MultiCell(120,5,utf8_encode($item['descripcion']),0,'J',false);
                
            }
            $this->Ln();

       }

    }
    function contenedor_detalle($alto,$oFactura_Venta){
     if(!class_exists('moneda')){
         require ROOT_PATH . 'models/moneda.php';
     }
     if(!class_exists('factura_venta')){
         require ROOT_PATH . 'models/factura_venta.php';
     }
     
    //$this->SetXY(10,$y);
    $this->Ln();
    $this->SetFont('Arial','B',8);
    $this->SetTextColor(255,255,255);
    $this->SetFillColor($this->color['r'],$this->color['g'],$this->color['b']);
    //$this->SetFillColor(117,179,114);
    $this->Cell(20,7,utf8_decode('CANTIDAD'),1,0,'C',true);
    $this->Cell(120,7,utf8_decode('DESCRIPCIÓN'),1,0,'C',true);
    $this->Cell(25,7,utf8_decode('P. UNITARIO'),1,0,'C',true);
    $this->Cell(35,7,utf8_decode('VALOR DE VENTA'),1,0,'C',true);
   
    $this->Ln();
    // cuerpo del detalle
    $this->Cell(20,$alto,'',1,0,'C');
    $this->Cell(120,$alto,'',1,0,'C');
    $this->Cell(25,$alto,'',1,0,'C');
    $this->Cell(35,$alto,'',1,0,'C');
    //pie de pagina
    $precio_venta_total=$oFactura_Venta->monto_total;
    $total_facturado=explode(".",$precio_venta_total);
        $oMoneda=moneda::getByID($oFactura_Venta->moneda_ID);
        $decimal="00";
        if(isset($total_facturado[1])){
            if(strlen($total_facturado[1])==1){
                $decimal=$total_facturado[1].'0';
            }else {
                $decimal=$total_facturado[1];
            }

        }
        $numero_texto="SON: ".numtoletras($total_facturado[0])." CON ".$decimal."/100 ".str_replace("ó","O",strtoupper(FormatTextViewHtml($oMoneda->descripcion))).".";
    
    
    $this->Ln();
    $this->SetTextColor(0);
    $this->Cell(165,10,$numero_texto,1,0,'L');
    $this->Cell(35,10,'',1,0,'C');
    $this->Ln();
    $this->Ln(2);
    
    //cuadro de giro de cheque
    $this->Cell(80,5,utf8_decode('Girar cheque a JJ Soluciones Perú E.I.R.L. o depositar:'),1,0,'C');
    $this->Ln();
    $this->Cell(80,20,'',1);
    $cuenta="";
    $this->SetXY(10,233);
    foreach($this->dtOrden_Venta_Numero_Cuenta as $value){
        $this->SetFont('Arial','B',7);
        $this->Cell(80,5,utf8_decode($value['abreviatura'].' '.$value['numero'].'   CCI: '.$value['cci']),0,'L');
        $this->Ln(5);
        
    }
    
    $this->SetFont('Arial','B',10);
    $this->SetXY(90,227);
    $this->Cell(60,5,utf8_decode('CANCELADO'),0,2,'C');
    $this->Cell(60,5,utf8_decode('Lima         de                de'),0,2,'C');
    $this->Cell(60,15,utf8_decode('p. JJSOLUCIONES PERU E.I.R.L.'),0,2,'C');
    
    $this->SetXY(150,227);
    $this->Cell(25,10,utf8_decode('Sub-Total'),1,2,'C');
    $this->Cell(25,10,utf8_decode('I.G.V. 18%'),1,2,'C');
    $this->Cell(25,10,utf8_decode('TOTAL'),1,2,'C');
    
    $this->SetXY(175,227);
    $this->Cell(35,10,utf8_decode($oFactura_Venta->monto_total_neto),1,2,'R');
    $this->Cell(35,10,utf8_decode($oFactura_Venta->monto_total_igv),1,2,'R');
    $this->Cell(35,10,utf8_decode($precio_venta_total),1,2,'R');
   }
   
   
   function Footer(){
    
    }
   
} 


?>