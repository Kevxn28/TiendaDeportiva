<?php 
// Debug: Mostrar la ruta de la imagen
$imagePath = "images/" . htmlspecialchars($producto['imagen']);
echo $imagePath; // Esto te mostrará la ruta generada
?>
<img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
