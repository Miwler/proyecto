<?php

if(!class_exists('FPDF'))require('include/fpdf/fpdf.php');
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
    public $font_size=5;
    public $subtitle_size=7;
    public $color;
    //public $dtOrden_Venta_Numero_Cuenta;
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
            $x_prodcuto=0;
            $w_producto=0;
            for($i=0;$i<count($data);$i++)
            {
                    $w=$this->widths[$i];
                    $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
                    //Save the current position
                    $x=$this->GetX();
                    $y=$this->GetY();
                    //$this->Write(2,$y);
                    //$alto=$this->GetMultiCellHeight(0,0,$data[$i]);
                    if($i==3){
                        $x_prodcuto=$x;
                        $w_producto=$w;
                    }
                    //Draw the border
                    if($i+1==count($data)){
                        
                        $this->SetX($x_prodcuto);
                        $this->MultiCell($w_producto,$altura,$data[$i],0,$a,false);
                        $y1=$this->GetY();
                    //Put the position to the right of the cell
                         $this->SetXY(5,$y1);
                        
                    }else{
                        $this->MultiCell($w,$altura,$data[$i],0,$a,false);
                    //Put the position to the right of the cell
                        $this->SetXY($x+$w,$y);
                    }
                   

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
        require ROOT_PATH . 'include/lib_fecha_texto.php';
        $this->Image(logo_documentos , 8 ,8, 70, 20 , "jpg" );
        $this->SetFont('Arial','',8);
        $this->SetTextColor(0);
        $this->SetXY(8,18);
        $this->Cell(80,30,FormatTextViewPDF($this->cabecera[0]['razon_social']),0,1);
        $this->SetXY(8,25);
        $this->Cell(80,30,FormatTextViewPDF($this->cabecera[0]['direccion1']),0,1);
        //$this->Cell(50,30,'Nueva central',0,0,'C');
        $this->SetXY(138,8);
        $this->Cell(70,30,'',1);
        $this->SetXY(138,8);
        $this->SetFont('Arial','B',15);
        $this->Cell(70,10,'R.U.C.'.$this->cabecera[0]['ruc'],0,2,'C');
        $this->Cell(70,10,FormatTextViewPDF($this->cabecera[0]['tipo_comprobante'].' ELECTRÓNICA'),0,2,'C');
        $this->Cell(70,10,utf8_decode($this->cabecera[0]['serie'].' - N°'. $this->cabecera[0]['numero_concatenado']),0,0,'C');

        $this->Ln();
        $this->Ln();
       // $this->Cell(155,5,'FECHA',1,0,'R');
        //$this->Ln();$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
        //$this->SetXY(8,50);
        $this->SetFont('Arial','',$this->subtitle_size);
        $this->Cell(120,5,utf8_decode('Lima, '.fechaATexto($this->cabecera[0]['fecha_emision'])),0,0,'L');
        $this->SetFont('Arial','B',$this->subtitle_size);
        $this->Cell(40,5,'Fecha de vencimiento:',0,0,'L');
        $this->SetFont('Arial','',$this->subtitle_size);
        $this->Cell(40,5,$this->cabecera[0]['fecha_vencimiento'],0,0,'L');
        $this->Ln();
        $this->SetFont('Arial','B',$this->subtitle_size);
        $this->Cell(25,5,utf8_decode('Señor(es):'),0,0,'L');
        $this->SetFont('Arial','',$this->subtitle_size);
        $this->MultiCell(170,5,FormatTextViewPDF($this->cabecera[0]['cliente']),0,'L',false);
        
 
        $this->SetFont('Arial','B',$this->subtitle_size);
        $this->Cell(25,5,utf8_decode('Dirección:'),0,0,'L');
        $this->SetFont('Arial','',$this->subtitle_size);
        $this->MultiCell(170,4,utf8_decode($this->cabecera[0]['direccion']),0,'L',false);
        //$this->Ln();
        $this->SetFont('Arial','B',$this->subtitle_size);
        $this->Cell(25,5,utf8_decode('R.U.C.:'),0,0,'L');
        $this->SetFont('Arial','',$this->subtitle_size);
        $this->Cell(35,5,utf8_decode($this->cabecera[0]['cliente_ruc']),0,0,'L');
        $this->SetFont('Arial','B',$this->subtitle_size);
        $this->Cell(35,5,utf8_decode('Código del Cliente:'),0,0,'L');
        $this->SetFont('Arial','',$this->subtitle_size);
        $this->Cell(25,5,utf8_decode($this->cabecera[0]['cliente_codigo']),0,0,'L');
        $this->SetFont('Arial','B',$this->subtitle_size);
        $this->Cell(40,5,utf8_decode('N° Orden de Compra:'),0,0,'L');
        $this->SetFont('Arial','',$this->subtitle_size);
        $this->Cell(40,5,utf8_decode($this->cabecera[0]['numero_orden_compra']),0,0,'L');
        $this->Ln();
        //$this->SetX(10);
        
        
        $this->SetFont('Arial','B',$this->subtitle_size);
        $this->Cell(25,5,utf8_decode('Vendedor(a):'),0,0,'L');
        $this->SetFont('Arial','',$this->subtitle_size);
        $this->Cell(95,5,utf8_decode(substr($this->cabecera[0]['operador'],0,22)),0,0,'L');
        
        $this->SetFont('Arial','B',$this->subtitle_size);
        $this->Cell(40,5,utf8_decode('N° Pedido:'),0,0,'L');
        $this->SetFont('Arial','',$this->subtitle_size);
        $this->Cell(40,5,utf8_decode($this->cabecera[0]['numero_orden_venta']),0,0,'L');
        
        $this->Ln();
        $this->SetFont('Arial','B',$this->subtitle_size);
        $this->Cell(200,5,utf8_decode('Por lo siguiente:'),0,1,'L');
    }
    function contenido_detalle($dtDetalle){

        $this->SetXY(10,87);
        foreach($dtDetalle as $item){
            $costo_unitario=number_format($item['precio_unitario'],2,'.',',');
            $subtotal=number_format($item['sub_total'],2,'.',',');
            $this->SetFont('Arial','B',10);
            $texto = $item['producto'];
            //$texto .= ($item['producto']=='')?'':chr(10).$item['descripcion'];
            $array=array($item['cantidad'],$item['medida'],$item['codigo'],FormatTextViewPDF($item['producto']),$costo_unitario,$subtotal,FormatTextViewPDF($item['descripcion']));
            $this->Row($array,5);
            $this->SetX(30);
            $this->SetFont('Arial','',9);
            $this->Ln();
       }
    }
    function numero_cuenta($array){
        $y=$this->GetY()-25;
        $this->SetY($y);
        $this->SetFont('Arial','',8);
        $this->Cell(25,5,"Banco",1,0,'L');
        $this->Cell(35,5,utf8_decode("Número cuenta"),1,0,'L');
        $this->Cell(40,5,"CCI",1,0,'L');
        //$this->Cell(30,5,"Moneda",1,0,'L');
        $this->Ln();
        foreach($array as $valor){
            $this->Cell(25,5,$valor['abreviatura'],1,0,'L');
            $this->Cell(35,5,$valor['numero'],1,0,'L');
            $this->Cell(40,5,$valor['cci'],1,0,'L');
            $this->Ln();
            //$this->Cell(30,5,utf8_decode($valor['moneda']),1,0,'L');
            /*$array_fila=array($valor['abreviatura'],$valor['numero'],$valor['cci']);
            $this->Row($array_fila,5);*/
        }
        
    }
    function contenedor_detalle($alto){
    
    //pie de pagina
    $precio_venta_total=round($this->cabecera[0]['monto_total'],2);
    $total_facturado=explode(".",$precio_venta_total);
        $decimal="00";
        if(isset($total_facturado[1])){
            if(strlen($total_facturado[1])==1){
                $decimal=$total_facturado[1].'0';
            }else {
                $decimal=$total_facturado[1];
            }

        }
        $numero_texto="SON: ".FormatTextViewPDF(numtoletras($total_facturado[0]))." CON ".$decimal."/100 ".str_replace("ó","O",strtoupper($this->cabecera[0]['moneda'])).".";

    $monto_total_neto=number_format($this->cabecera[0]['monto_total_neto'],2,'.',',');
    $monto_total_igv=number_format($this->cabecera[0]['monto_total_igv'],2,'.',',');
    $monto_total=number_format($this->cabecera[0]['monto_total'],2,'.',',');
    $gravadas=number_format($this->cabecera[0]['gravadas'],2,'.',',');
    $exoneradas=number_format($this->cabecera[0]['exoneradas'],2,'.',',');
    $inafectas=number_format($this->cabecera[0]['inafectas'],2,'.',',');
    $gratuitas=number_format($this->cabecera[0]['gratuitas'],2,'.',',');
    $otros_cargos=number_format($this->cabecera[0]['otros_cargos'],2,'.',',');
    
    $this->Ln(2);
    $this->SetFont('Arial','B',9);
    $this->SetTextColor(0);
    $this->Cell(175,10,$numero_texto,1,0,'L');
    $this->Cell(25,10,'',1,0,'C');
    //$this->Ln();
    $this->Ln();
    $h_actual=$this->GetY();
    $this->SetX(145);
    $this->Cell(30,$this->font_size,utf8_decode('OP. GRAVADA'),0,0,'L');
    $this->Cell(10,$this->font_size,utf8_decode($this->cabecera[0]['simbolo']),0,0,'R');
    $this->Cell(25,$this->font_size,$gravadas,1,0,'R');
    $this->Ln();
    $this->SetX(145);
    $this->Cell(30,$this->font_size,utf8_decode('OP. INAFECTA'),0,0,'L');
    $this->Cell(10,$this->font_size,utf8_decode($this->cabecera[0]['simbolo']),0,0,'R');
    $this->Cell(25,$this->font_size,$inafectas,1,0,'R');
    $this->Ln();
    $this->SetX(145);
    $this->Cell(30,$this->font_size,utf8_decode('OP. EXONERADA'),0,0,'L');
    $this->Cell(10,$this->font_size,utf8_decode($this->cabecera[0]['simbolo']),0,0,'R');
    $this->Cell(25,$this->font_size,$exoneradas,1,0,'R');
    $this->Ln();
    $this->SetX(145);
    $this->Cell(30,$this->font_size,utf8_decode('I.G.V. '.($this->cabecera[0]['igv']*100)."%"),0,0,'L');
    $this->Cell(10,$this->font_size,utf8_decode($this->cabecera[0]['simbolo']),0,0,'R');
    $this->Cell(25,$this->font_size,$monto_total_igv,1,0,'R');
    
    $this->Ln();
    $this->SetX(145);
    $this->Cell(30,$this->font_size,utf8_decode('OTROS CARGOS'),0,0,'L');
    $this->Cell(10,$this->font_size,utf8_decode($this->cabecera[0]['simbolo']),0,0,'R');
    $this->Cell(25,$this->font_size,$otros_cargos,1,0,'R');
    $this->Ln();
    $this->SetX(145);
    $this->Cell(30,$this->font_size,utf8_decode('IMPORTE TOTAL'),0,0,'L');
    $this->Cell(10,$this->font_size,utf8_decode($this->cabecera[0]['simbolo']),0,0,'R');
    $this->Cell(25,$this->font_size,$monto_total,1,0,'R');
    
    $this->Ln();
    $this->SetX(145);
    $this->Cell(30,$this->font_size,utf8_decode('OP. GRATUITA'),0,0,'L');
    $this->Cell(10,$this->font_size,utf8_decode($this->cabecera[0]['simbolo']),0,0,'R');
    $this->Cell(25,$this->font_size,$gratuitas,1,0,'R');
    
    //cuadro de giro de cheque
   // $this->Cell(80,5,utf8_decode('Girar cheque a JJ Soluciones Perú E.I.R.L. o depositar:'),1,0,'C');
   // $this->Ln();
    /*$this->Cell(80,17,'',1);
    $cuenta="";
    $this->SetXY(10,233);
    foreach($this->numero_cuenta as $value){
        $this->SetFont('Arial','B',7);
        $this->Cell(80,5,utf8_decode($value['abreviatura'].' '.$value['numero'].'   CCI: '.$value['cci']),0,'L');
        $this->Ln(5);

    }*/

    //$this->SetFont('Arial','B',10);
    //$this->SetXY(90,227);
    $cancelado="CANCELADO".chr(10);
    $cancelado.="Lima         de                de".chr(10);
    $cancelado.="p. JJSOLUCIONES PERU E.I.R.L.";
    //$this->Cell(60,5,utf8_decode('CANCELADO'),0,2,'C');
    //$this->Cell(60,5,utf8_decode('Lima         de                de'),0,2,'C');
    //$this->Cell(60,15,utf8_decode('p. JJSOLUCIONES PERU E.I.R.L.'),0,2,'C');

   
   }


    function Footer(){
        
       $variable=$this->cabecera[0]['ruc']."|".$this->cabecera[0]['codigo_comprobante']."|".$this->cabecera[0]['serie']."|".$this->cabecera[0]['numero_concatenado']."|";
       $variable.=$this->cabecera[0]['monto_total_igv']."|".$this->cabecera[0]['monto_total']."|".$this->cabecera[0]['fecha_emision']."|06|".$this->cabecera[0]['cliente_ruc'];
       //$this->Image('http://chart.apis.google.com/chart?cht=qr&chs=230x230&chl='.$variable,8,252,25,25,'PNG');
       $this->Image(getCodigoQr($variable,"qr",array("size"=>3,"align"=>"L","border"=>1)),100,252,25,25,'PNG');
       $this->SetXY(40,257);
       $this->Cell(80,30,utf8_decode('Representación impresa de la FACTURA ELECTRÓNICA, visita wwww/comprobante/index'),0,1);
    }

}


?>
