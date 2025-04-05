<?php
require('fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    //$this->Image('logo.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(50);
    // Título
	$Produccion = $_GET["Id_Produccion"];
    $this->Cell(100,10,'Reporte de Costo de Producion '.$Produccion,0,0,'C');
    // Salto de línea
    $this->Ln(20);
	$this->Cell(90,10,'Insumo',1,0,'C',0);
	$this->Cell(30,10,'Cantidad',1,0,'C',0);
	$this->Cell(30,10,'Costo',1,0,'C',0);
	$this->Cell(30,10,'Total',1,1,'C',0);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

require 'cn.php';
$Id_Produccion = $_GET["Id_Produccion"];
$consulta = "select 
Producto.Nombre as Nombre_Producto,
Orden_Produccion.Id,
Orden_Produccion.Cantidad_Produccion,
Insumo.Nombre,
Detalle_Orden_Produccion.Cantidad_Insumo,
FORMAT(Detalle_Compra.Costo,2) as Costo,
FORMAT((Detalle_Orden_Produccion.Cantidad_Insumo * Format(Detalle_Compra.Costo,2)),2) as Total_Costo
 from Detalle_Orden_Produccion inner join Detalle_Compra 
on Detalle_Orden_Produccion.Id_Detalle_Compra = Detalle_Compra.Id
inner join Insumo on Detalle_Compra.Id_Insumo = Insumo.Id
inner join Orden_Produccion on Detalle_Orden_Produccion.Id_Orden_Produccion = Orden_Produccion.Id
inner join Producto on Orden_Produccion.Id_Producto = Producto.Id
where Orden_Produccion.Id=".$Id_Produccion;
$restulado = $mysqli->query($consulta);
// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$total = 0;
$producto = '';
$cantidad_produccion = 0;
while($row = $restulado->fetch_assoc()){
	$pdf->Cell(90,10,$row['Nombre'],1,0,'C',0);
	$pdf->Cell(30,10,$row['Cantidad_Insumo'],1,0,'C',0);
	$pdf->Cell(30,10,$row['Costo'],1,0,'C',0);
	$pdf->Cell(30,10,$row['Total_Costo'],1,1,'C',0);
	$producto = $row['Nombre_Producto'];
	$cantidad_produccion = $row['Cantidad_Produccion'];
	$total = $total + $row['Total_Costo'];
}
$pdf->Cell(150,10,'COSTO TOTAL DE '.$cantidad_produccion.' '.$producto,1,0,'C',0);
$pdf->Cell(30,10,$total.' Bs.',1,1,'C',0);

$consulta = "select 
Producto.Nombre as Nombre_Producto,
Orden_Produccion.Id,
Precio.Monto
 from Orden_Produccion inner join Producto on Orden_Produccion.Id_Producto = Producto.Id
 inner join Precio on Precio.Id_Producto = Producto.Id
where Precio.Id_Grupo_Tienda=1 and Orden_Produccion.Id=".$Id_Produccion;
$restulado = $mysqli->query($consulta);

$precio_producto=0;
while($row = $restulado->fetch_assoc()){
	
	$precio_producto = $row['Monto'];
	
}
$pdf->Cell(30,10,'',0,1,'C',0);

$pdf->Cell(30,10,'Cant. Produccion',1,0,'C',0);
$pdf->Cell(30,10,'Costo T.',1,0,'C',0);
$pdf->Cell(30,10,'Precio U.',1,0,'C',0);
$pdf->Cell(30,10,'Precio T.',1,0,'C',0);
$pdf->Cell(30,10,'Ganancia',1,0,'C',0);
$pdf->Cell(30,10,'% Ganancia',1,1,'C',0);


$pdf->Cell(30,10,$cantidad_produccion,1,0,'C',0);
$pdf->Cell(30,10,$total,1,0,'C',0);
$pdf->Cell(30,10,$precio_producto,1,0,'C',0);
$precio_total = ($cantidad_produccion*$precio_producto);
$pdf->Cell(30,10,($precio_total),1,0,'C',0);
$pdf->Cell(30,10,(($cantidad_produccion*$precio_producto)-$total),1,0,'C',0);
$ganancia_total = (($cantidad_produccion*$precio_producto)-$total);
$pdf->Cell(30,10,($ganancia_total*100/$precio_total),1,0,'C',0);
/*for($i=1;$i<=40;$i++)
    $pdf->Cell(0,10,'Imprimiendo línea número '.$i,0,1);*/
$pdf->Output();
?>