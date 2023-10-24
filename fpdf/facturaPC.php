<?php
require('fpdf/fpdf.php');
date_default_timezone_set('Europe/Madrid');
class PDF extends FPDF
{
function Header() {
    $this->setY(12);
    $this->setX(10);
    
    $this->Image('img/PcComponentes.png',25,15,33);
    
    $this->SetFont('times', 'B', 12);
    $this->Text(165, 15, utf8_decode('PC Componentes'));
    $this->SetFont('times', '', 10);
    $this->Text(145, 21, utf8_decode('contactopccomponentes@gmail.com'));
    $this->Text(167, 25, utf8_decode('Teléfono: 654789123'));
    $this->Text(125, 29, utf8_decode('C. José Luis Pérez Pujadas, 6, A35, 18006 Granada'));
    $this->Line(10,33,200,33);

    //información de # de factura
    $this->SetFont('Arial','B',10);   
    $this->Text(150,48, utf8_decode('FACTURA N°:'));
    $this->SetFont('Arial','',10);  
    $this->Text(176,48, '0001');
    
    // Agregamos los datos del cliente
    $this->SetFont('Arial','B',10);    
    $this->Text(10,48, utf8_decode('Fecha:'));
    $this->SetFont('Arial','',10);    
    $this->Text(25,48, date('d/m/Y'));
    
    // Agregamos los datos de la factura
    $this->SetFont('Arial','B',10);    
    $this->Text(10,54, utf8_decode('Cliente:'));
    $this->SetFont('Arial','',10);    
    $this->Text(25,54, utf8_decode('Raúl, Omar y Pablo López'));
    
    $this->Ln(50);
}

function Footer() {
     $this->SetFont('helvetica', 'B', 8);
        $this->SetY(-15);
        $this->Cell(95,5,utf8_decode('Página ').$this->PageNo().' / {nb}',0,0,'L');
        $this->Cell(95,5,date('d/m/Y | g:i:a') ,00,1,'R');
        $this->Line(10,287,200,287);
        $this->Cell(0,5,utf8_decode("PC Componentes © Todos los derechos reservados."),0,0,"C");

}


}



$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 20);
$pdf->SetTopMargin(15);
$pdf->SetLeftMargin(10);
$pdf->SetRightMargin(10);

// En esta parte estan los encabezados
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20, 7, utf8_decode('Cod'),1,0,'C',0);
$pdf->Cell(95, 7, utf8_decode('Descripción'),1,0,'C',0);
$pdf->Cell(20, 7, utf8_decode('Cant'),1,0,'C',0);
$pdf->Cell(25, 7, utf8_decode('Precio'),1,0,'C',0);
$pdf->Cell(25, 7, utf8_decode('Total'),1,1,'C',0);

$pdf->SetFont('Arial','',10);

//Aqui inicia el for con todos los productos
    $productos = [
        ["LG OLED48C24LA 48\" OLED UltraHD 4K HDR10 Pro", 20, 949.99, 18999.8],
        ["LG OLED83C24LA 83\" OLED UltraHD 4K HDR10 Pro", 15, 3698.99, 55484.85],
        ["Samsung Galaxy Book3 Intel Core i5-1335U", 25, 799, 19975],
        ["Alurin Flex Advance Intel Core i5-1155G7", 30, 605, 18150],
        ["Lenovo V15 G2 ITL Intel Core i3-1115G4", 18, 424.99, 7649.82]
    ];

    foreach ($productos as $key => $producto) {
        $pdf->Cell(20, 7, $key + 1, 1, 0, 'L', 0);
        $pdf->Cell(95, 7, utf8_decode($producto[0]), 1, 0, 'L', 0);
        $pdf->Cell(20, 7, utf8_decode($producto[1]), 1, 0, 'R', 0);
        $pdf->Cell(25, 7, utf8_decode($producto[2]), 1, 0, 'R', 0);
        $pdf->Cell(25, 7, utf8_decode($producto[3]), 1, 1, 'R', 0);
    }

    // Calcula subtotal, descuento, impuesto y total
    $subtotal = array_sum(array_column($productos, 1)) * array_sum(array_column($productos, 3));
    $descuento = 4000;
    $impuesto = 9000;
    $total = $subtotal - $descuento + $impuesto;

    // Apartir de aqui esta la tabla con los subtotales y totales
    $pdf->Ln(10);

    $pdf->setX(95);
    $pdf->Cell(40, 6, 'Subtotal', 1, 0);
    $pdf->Cell(60, 6, number_format($subtotal, 2), '1', 1, 'R');
    $pdf->setX(95);
    $pdf->Cell(40, 6, 'Descuento', 1, 0);
    $pdf->Cell(60, 6, number_format($descuento, 2), '1', 1, 'R');
    $pdf->setX(95);
    $pdf->Cell(40, 6, 'Impuesto', 1, 0);
    $pdf->Cell(60, 6, number_format($impuesto, 2), '1', 1, 'R');
    $pdf->setX(95);
    $pdf->Cell(40, 6, 'Total', 1, 0);
    $pdf->Cell(60, 6, number_format($total, 2), '1', 1, 'R');

    $pdf->Output();
?>