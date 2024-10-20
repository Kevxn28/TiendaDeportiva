<?php
session_start();
require '../conexion.php';

// Asegúrate de que la carpeta y el archivo TCPDF estén en la ubicación correcta
require_once(__DIR__ . '/tcpdf/tcpdf.php'); // Cambia esto si es necesario

$dbConnection = new DatabaseConnection();
$collectionUsuarios = $dbConnection->getCollection("usuarios");

$empleados = $collectionUsuarios->find();

// Verificar si hay empleados para exportar
if (!$empleados) {
    $_SESSION['mensaje'] = "No hay empleados disponibles para exportar.";
    header("Location: list_empleados.php");
    exit();
}

// Crear una instancia de TCPDF
$pdf = new TCPDF();

// Agregar una página
$pdf->AddPage();

// Establecer fuente para el título
$pdf->SetFont('Helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Lista de Empleados', 0, 1, 'C');
$pdf->Ln(5);

// Agregar una imagen de encabezado (asegúrate de que la imagen esté en la ruta correcta)
$pdf->Image('logo.jpg', 10, 10, 40, 20, 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);
$pdf->Ln(20);

// Establecer fuente para los encabezados
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->SetFillColor(200, 220, 255); // Color de fondo
$pdf->Cell(40, 10, 'Nombre', 1, 0, 'C', 1);
$pdf->Cell(50, 10, 'Email', 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Puesto', 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Rol', 1, 1, 'C', 1); // Salto de línea

// Establecer fuente para el contenido
$pdf->SetFont('Helvetica', '', 12);
$pdf->SetFillColor(240, 240, 240); // Color de fondo alternativo

$fill = false; // Variable para alternar el color de fondo
foreach ($empleados as $empleado) {
    $pdf->Cell(40, 10, htmlspecialchars($empleado['nombre']), 1, 0, 'L', $fill);
    $pdf->Cell(50, 10, htmlspecialchars($empleado['email']), 1, 0, 'L', $fill);
    $pdf->Cell(40, 10, htmlspecialchars($empleado['puesto'] ?? 'No especificado'), 1, 0, 'L', $fill);
    $pdf->Cell(40, 10, htmlspecialchars($empleado['rol'] ?? 'No especificado'), 1, 1, 'L', $fill);
    $fill = !$fill; // Alternar color de fondo
}

// Cerrar y generar el PDF
$pdf->Output('empleados.pdf', 'D'); // 'D' para descargar, 'I' para visualizar en el navegador
exit();
?>
