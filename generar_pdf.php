<?php
require('fpdf/fpdf.php');

// Crear instancia de FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Fondo suave azul claro
$pdf->SetFillColor(240, 248, 255); // Azul claro
$pdf->Rect(0, 0, 210, 297, 'F'); // Fondo para toda la página

// Título con fondo
$pdf->SetFont('Arial', 'B', 30);
$pdf->SetTextColor(255, 255, 255); // Blanco para el título
$pdf->SetFillColor(50, 50, 150); // Azul oscuro
$pdf->Cell(0, 20, 'Curriculum Vitae', 0, 1, 'C', true);
$pdf->Ln(10);

// Línea divisoria inferior del título
$pdf->SetDrawColor(50, 50, 150); // Azul oscuro
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
$pdf->Ln(10);

// Sección de información personal
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetTextColor(0, 0, 0); // Negro para los títulos
$pdf->Cell(0, 10, 'Información Personal', 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Nombre: ' . $_POST['nombre'], 0, 1);
$pdf->Cell(0, 10, 'Correo: ' . $_POST['email'], 0, 1);
$pdf->Cell(0, 10, 'Teléfono: ' . $_POST['telefono'], 0, 1);
$pdf->Ln(10);

// Línea divisoria
$pdf->SetDrawColor(100, 100, 100); // Gris
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
$pdf->Ln(10);

// Experiencia laboral
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Experiencia Laboral', 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);
if (!empty($_POST['empresa'])) {
    foreach ($_POST['empresa'] as $index => $empresa) {
        $pdf->Cell(0, 10, 'Empresa: ' . $empresa, 0, 1);
        $pdf->Cell(0, 10, 'Puesto: ' . $_POST['puesto'][$index], 0, 1);
        $pdf->Cell(0, 10, 'Duración: ' . $_POST['duracion'][$index], 0, 1);
        $pdf->Ln(5);
    }
} else {
    $pdf->Cell(0, 10, 'No se proporcionaron datos.', 0, 1);
}
$pdf->Ln(10);

// Línea divisoria
$pdf->SetDrawColor(100, 100, 100); 
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
$pdf->Ln(10);

// Formación académica
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Formación Académica', 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);
if (!empty($_POST['institucion'])) {
    foreach ($_POST['institucion'] as $index => $institucion) {
        $pdf->Cell(0, 10, 'Institución: ' . $institucion, 0, 1);
        $pdf->Cell(0, 10, 'Título: ' . $_POST['titulo'][$index], 0, 1);
        $pdf->Cell(0, 10, 'Fecha de Graduación: ' . $_POST['fecha'][$index], 0, 1);
        $pdf->Ln(5);
    }
} else {
    $pdf->Cell(0, 10, 'No se proporcionaron datos.', 0, 1);
}

// Línea divisoria final
$pdf->Ln(10);
$pdf->SetDrawColor(100, 100, 100); 
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());

// Salida del PDF
$pdf->Output('D', 'Curriculum_Vitae.pdf');
?>
