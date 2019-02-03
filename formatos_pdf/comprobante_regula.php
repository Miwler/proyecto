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
        require ROOT_PATH . 'include/lib_fecha_texto.php';
        $this->Image("files/imagenes/logo_comprobantes/".$_SESSION['empresa_ID'].".jpg", 10 ,8, 70, 20, "JPG" );
        $this->SetFont('Arial','',8);
        $this->SetTextColor(0);
        $this->SetXY(10,18);
        $this->Cell(80,30,utf8_decode($this->cabecera[0]['razon_empresa']),0,1);
        $this->SetXY(10,22);
        $this->Cell(80,30,utf8_decode($this->cabecera[0]['direccion1']),0,1);
        //$this->Cell(50,30,'Nueva central',0,0,'C');
        $this->SetXY(138,8);
        $this->Cell(70,35,'',1);
        $this->SetXY(138,8);
        $this->SetFont('Arial','B',15);
        $this->Cell(70,10,'R.U.C.'.$this->cabecera[0]['ruc'],0,2,'C');
        $this->Cell(70,8,utf8_decode($this->cabecera[0]['nombre_documento']),0,2,'C');
        $this->Cell(70,8,utf8_decode('ELECTRÓNICO'),0,2,'C');
        $this->Cell(70,10,utf8_decode($this->cabecera[0]['serie'].' - N°'. $this->cabecera[0]['numero_concatenado']),0,0,'C');

        //$this->Ln();
        $this->Ln();
       // $this->Cell(155,5,'FECHA',1,0,'R');
        //$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
        //$this->SetXY(8,50);
        //$this->SetFont('Arial','',10);
        //$this->Cell(120,5,utf8_decode('Lima, '.fechaATexto($this->cabecera[0]['fecha_emision'])),0,0,'L');
        //$this->SetFont('Arial','B',10);
        //$this->Cell(40,5,'Fecha de vencimiento:',0,0,'L');
        //$this->SetFont('Arial','',10);
        //$this->Cell(40,5,$this->cabecera[0]['fecha_vencimiento'],0,0,'L');
        
        
        $this->SetFont('Arial','B',10);
        $this->Cell(25,7,utf8_decode('Señor(es):'),0,0,'L');
        $this->SetFont('Arial','',10);
        $this->Cell(102,7,utf8_decode($this->cabecera[0]['cliente']),0,0,'L');
        $this->SetFont('Arial','B',10);
        $this->Cell(120,7,utf8_decode('Lima, '.fechaATexto($this->cabecera[0]['fecha_emision'])),0,0,'L');
        //$this->Cell(40,5,utf8_decode('Vendedor(a):'),0,0,'L');
        //$this->SetFont('Arial','',10);
        //$this->Cell(40,5,utf8_decode(substr($this->cabecera[0]['operador'],0,22)),0,0,'L');
        $this->Ln();
        $this->SetFont('Arial','B',10);
        $this->Cell(25,7,utf8_decode('Dirección:'),0,0,'L');
        $this->SetFont('Arial','',9);
        $this->Cell(102,7,utf8_decode(substr($this->cabecera[0]['direccion'],0,50)),0,0,'L');
        //$this->SetFont('Arial','B',10);
        //$this->Cell(40,5,utf8_decode('Referencia:'),0,0,'L');
        //$this->SetFont('Arial','',10);
        //$this->Cell(40,5,utf8_decode($this->cabecera[0]['factura']),0,0,'L');
        $this->Ln();
        $this->SetFont('Arial','B',10);
        $this->Cell(25,7,utf8_decode('R.U.C.:'),0,0,'L');
        $this->SetFont('Arial','',10);
        $this->Cell(35,7,utf8_decode($this->cabecera[0]['cliente_ruc']),0,0,'L');
        $this->SetFont('Arial','B',10);
        $this->Cell(35,7,utf8_decode('Código del Cliente:'),0,0,'L');
        $this->SetFont('Arial','',10);
        $this->Cell(32,7,utf8_decode($this->cabecera[0]['cliente_codigo']),0,0,'L');
        $this->SetFont('Arial','B',10);
        $this->Cell(25,7,utf8_decode('Referencia:'),0,0,'L');
        $this->SetFont('Arial','',10);
        $this->Cell(40,7,utf8_decode($this->cabecera[0]['factura']),0,0,'L');
        $this->Ln();
        $this->SetFont('Arial','',10);
        $texto="";
        if($this->cabecera[0]['tipo_documento']=="nota_credito"){
           $texto='Sirva(se) tomar nota que estamos  ABONANDO  en su cuenta corriente, por las razones siguientes:';
        }else{
            $texto='Sirva(se) tomar nota que estamos DEBITANDO  en su cuenta corriente, por las razones siguientes:';
        }
        $this->Cell(200,5,utf8_decode($texto),0,1,'L'); 
    }
    function contenido_detalle($dtDetalle){

        $this->SetXY(10,85);
        foreach($dtDetalle as $item){
            $costo_unitario=number_format($item['precio_unitario'],2,'.',',');
            $subtotal=number_format($item['subtotal'],2,'.',',');
            $this->SetFont('Arial','B',10);
            $array=array($item['cantidad'],$item['unidad_medida'],$item['codigo'],$item['producto'],$costo_unitario,$subtotal);
            $this->Row($array,5);
            $this->SetX(30);
            $this->SetFont('Arial','',9);
            $this->Ln();
       }
    }
    function contenedor_detalle($alto){
    //$this->SetXY(10,$y);
    $this->Ln();
    $this->SetFont('Arial','B',8);
    $this->SetTextColor(255,255,255);
    $this->SetFillColor(117,179,114);
    $this->Cell(20,7,utf8_decode('CANT.'),1,0,'C',true);
    $this->Cell(15,7,utf8_decode('UM'),1,0,'C',true);
    $this->Cell(15,7,utf8_decode('CÓD'),1,0,'C',true);
    $this->Cell(100,7,utf8_decode('DESCRIPCIÓN'),1,0,'C',true);
    $this->Cell(25,7,utf8_decode('P/U'),1,0,'C',true);
    $this->Cell(25,7,utf8_decode('IMPORTE'),1,0,'C',true);

    $this->Ln();
    // cuerpo del detalle
    $this->Cell(20,$alto,'',1,0,'C');
    $this->Cell(15,$alto,'',1,0,'C');
    $this->Cell(15,$alto,'',1,0,'C');
    $this->Cell(100,$alto,'',1,0,'C');
    $this->Cell(25,$alto,'',1,0,'C');
    $this->Cell(25,$alto,'',1,0,'C');
    //pie de pagina
    $precio_venta_total=$this->cabecera[0]['monto_total'];
    $total_facturado=explode(".",$precio_venta_total);
        $decimal="00";
        if(isset($total_facturado[1])){
            if(strlen($total_facturado[1])==1){
                $decimal=$total_facturado[1].'0';
            }else {
                $decimal=$total_facturado[1];
            }

        }
        $numero_texto="SON: ".numtoletras($total_facturado[0])." CON ".$decimal."/100 ".str_replace("ó","O",strtoupper($this->cabecera[0]['moneda'])).".";


    $this->Ln();
    $this->SetTextColor(0);
    $this->Cell(175,10,$numero_texto,1,0,'L');
    $this->Cell(25,10,'',1,0,'C');
    $this->Ln();
    $this->Ln(2);

    //cuadro de giro de cheque
    /*$this->Cell(80,5,utf8_decode('Girar cheque a JJ Soluciones Perú E.I.R.L. o depositar:'),1,0,'C');
    $this->Ln();
    $this->Cell(80,17,'',1);
    $cuenta="";
    $this->SetXY(10,233);*/
    /*foreach($this->numero_cuenta as $value){
        $this->SetFont('Arial','B',7);
        $this->Cell(80,5,utf8_decode($value['abreviatura'].' '.$value['numero'].'   CCI: '.$value['cci']),0,'L');
        $this->Ln(5);

    }*/
    $this->Line(80,237,140,237);
    $this->SetFont('Arial','B',10);
    $this->SetXY(80,237);
    //$this->Cell(60,5,utf8_decode('CANCELADO'),0,2,'C');
    //$this->Cell(60,5,utf8_decode('Lima         de                de'),0,2,'C');
   
    $this->Cell(60,15,utf8_decode('p. '.$this->cabecera[0]['razon_empresa']),0,2,'C');

    $this->SetXY(160,225);
    $this->Cell(25,10,utf8_decode('Sub-Total'),1,2,'C');
    $this->Cell(25,10,utf8_decode('I.G.V. 18%'),1,2,'C');
    $this->Cell(25,10,utf8_decode('TOTAL'),1,2,'C');

    $this->SetXY(185,225);
    $this->Cell(25,10,utf8_decode($this->cabecera[0]['monto_total_neto']),1,2,'R');
    $this->Cell(25,10,utf8_decode($this->cabecera[0]['monto_total_igv']),1,2,'R');
    $this->Cell(25,10,utf8_decode($this->cabecera[0]['monto_total']),1,2,'R');
   }


    function Footer(){

       $variable=$this->cabecera[0]['ruc']."|".$this->cabecera[0]['codigo_comprobante']."|".$this->cabecera[0]['serie']."|".$this->cabecera[0]['numero_concatenado']."|";
       $variable.=$this->cabecera[0]['monto_total_igv']."|".$this->cabecera[0]['monto_total']."|".$this->cabecera[0]['fecha_emision']."|06|".$this->cabecera[0]['cliente_ruc'];
       $this->Image('http://chart.apis.google.com/chart?cht=qr&chs=230x230&chl='.$variable,8,252,25,25,'PNG');
       $this->SetXY(40,257);
       $this->Cell(80,30,utf8_decode('Representación impresa de la '.$this->cabecera[0]['nombre_documento'].' ELECTRÓNICA, visita wwww/comprobante/index'),0,1);
    }

}


?>
