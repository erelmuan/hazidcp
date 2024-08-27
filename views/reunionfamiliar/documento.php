
<?
$path = Yii::getAlias("@vendor/setasign/fpdf/fpdf.php");
require_once($path);

// $pathqr = Yii::getAlias("@vendor/qrcode/qrcode.class.php");
// require_once($pathqr);

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Definir las coordenadas y dimensiones del recuadro
    $x = 10;  // Coordenada X inicial
    $y = 10;  // Coordenada Y inicial
    $width = 190; // Ancho del recuadro
    $height = 25; // Altura del recuadro (ajusta según sea necesario)

    // Dibujar el recuadro (excluyendo 'Documento Generado el' y 'REUNIÓN FAMILIAR')
    $this->Rect($x, $y, $width, $height);

    // Agregar contenido dentro del recuadro
    $this->SetTextColor(245,245,245);
    $this->Image(Yii::$app->basePath .'/web/img/hospitalzatti.png', $x + 8, $y + 5, 15);

    $this->SetFont('Arial','B',13);
    $this->SetTextColor(0,0,0);
    $this->SetXY($x, $y + 12);
    $this->Cell($width, 5, 'HOSPITAL ARTEMIDES ZATTI', 0, 0, 'C');

    $this->SetXY($x, $y + $height + 3);
    $this->SetFont('Arial','BU',10);
    $this->Cell($width, 5, utf8_decode('REUNIÓN FAMILIAR'), 0, 0, 'C');

}


// Pie de página
function Footer()
{

        //Posici�n: a 3,5 cm del final
        $this->SetY(-20);
        //Arial italic 7
        $this->SetFont('Arial','',7);
        //N�mero de p�gina
        $this->Ln(2);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'C');
        $this->Ln(4);
        $this->SetFont('Arial','',7);
        $this->Cell(0,10,utf8_decode('Hospital "Artémides ZATTI" - Rivadavia 391 - (8500) Viedma - Río Negro'),0,0,'C');
        $this->SetFont('Times','',7);
        $this->Ln(3);
        $this->Cell(0,10,'Tel. 02920 - 427843 | Fax 02920 - 429916 / 423780',0,0,'C');
       $this->Ln(5);
       $this->SetTextColor(150,150,150);
       $this->SetFont('Times','I','7');
       $this->Cell(0,10,'Desarrollado por: ',0,0,'C');
}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

$pdf->SetFont('Courier','B',8);
$pdf->SetFillColor(255,255,255);
$Inicio = 55;

// Definir las coordenadas de la línea horizontal
$x1 = 5;  // Coordenada X inicial
$x2 = 205; // Coordenada X final
$y = $Inicio -7 ;   // Coordenada Y (constante para una línea horizontal)

// Dibujar la línea horizontal
$pdf->Line($x1, $y, $x2, $y);

$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio,"FECHA / HORA:");
$pdf->SetFont('Times','',10);
$pdf->Text(42,$Inicio,date("d/m/Y h:i:s", strtotime($model->fechahora)));
$pdf->SetFont('Times','B',10);
$pdf->Text(120,$Inicio,"LUGAR:");
$pdf->SetFont('Times','',10);
$pdf->Text(135,$Inicio,$model->lugar);

$Inicio=$Inicio +8;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"SERVICIO:");
$pdf->SetFont('Times','',10);
$pdf->Text(35,$Inicio ,$model->solicitud->servicio->nombre);
$pdf->SetFont('Times','B',10);

$pdf->SetFont('Times','B',10);
$pdf->Text(120,$Inicio ,"PROCEDENCIA:");
$pdf->SetFont('Times','',10);
$pdf->Text(149,$Inicio ,$model->solicitud->procedencia->nombre);
$pdf->SetFont('Times','B',10);


$Inicio=$Inicio +8;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"PACIENTE:");
$pdf->SetFont('Times','',10);
$pdf->Text(35,$Inicio ,$model->solicitud->paciente->nombre.' '.$model->solicitud->paciente->apellido);

$pdf->SetFont('Times','B',10);
$pdf->Text(120,$Inicio ,"DNI:");
$pdf->SetFont('Times','',10);
$pdf->Text(132,$Inicio ,$model->solicitud->paciente->numdocumento);


$pdf->SetFont('Times','B',10);
$pdf->Text(157,$Inicio,"HC N:");
$pdf->SetFont('Times','',10);
$pdf->Text(170,$Inicio,$model->solicitud->paciente->hc);


// Definir las coordenadas de la línea horizontal
$x1 = 5;  // Coordenada X inicial
$x2 = 205; // Coordenada X final
$y = $Inicio +7 ;   // Coordenada Y (constante para una línea horizontal)

// Dibujar la línea horizontal
$pdf->Line($x1, $y, $x2, $y);


$Inicio=$Inicio +18;
$pdf->SetXY(14, $Inicio +1 );

$pdf->SetFont('Times','B',10);
$pdf->Write(5, "FAMILIARES: ");
$pdf->SetFont('Times','',10);
$pdf->MultiCell(0,5, utf8_decode($model->familiares));

$Inicio=$Inicio +10;
$pdf->SetXY(14, $Inicio +1 );

$pdf->SetFont('Times','B',10);
$pdf->Write(5, "PROFESIONALES: ");
$pdf->SetFont('Times','',10);
$pdf->MultiCell(0,5, utf8_decode($model->profesionales));

$pdf->Ln(5);

$Inicio = $pdf->GetY() + 5;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio,utf8_decode("ACEPTA ACOMPAÑAMIENTO?"));
$pdf->SetFont('Times','',10);
$pdf->Text(70,$Inicio,($model->aceptanacompañamiento)?"SI":"NO");


$Inicio=$Inicio +15;
$pdf->SetFont('Arial','BU',13);
$pdf->Text(65,$Inicio,utf8_decode('DETALLES DE LA REUNIÓN'),0,0,'C');

$Inicio=$Inicio +5;
$pdf->SetFont('Times','',12);
$pdf->SetXY(15, $Inicio +1 );
$pdf->MultiCell(0,5, utf8_decode($model->detallesreunion));


$Inicio=$Inicio +60;
$pdf->SetFont('Times','B',10);
$pdf->Text(147,$Inicio ,"........................................................");

$Inicio=$Inicio +8;
$pdf->SetFont('Times','',10);
$pdf->Text(150,$Inicio ,"FIRMA DEL FAMILIAR");



$x = 100;
$y = 200;
$s = 50;
$background = array(250,250,250);
$color = array(0,0,0);

$pdf->Output("I","REUNION FAMILIAR --- ".utf8_decode($model->solicitud->paciente->apellido." ". $model->solicitud->paciente->nombre).".pdf");


exit;
?>
