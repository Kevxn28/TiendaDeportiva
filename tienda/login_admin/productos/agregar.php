<?php
require_once '../conexion.php';  // Ajusta la ruta si es necesario

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dbConnection = new DatabaseConnection();
    $database = $dbConnection->connect();

    if ($database instanceof MongoDB\Database) {
        $collection = $database->productos; // Cambiar al nombre de la colección correspondiente

        // Recoger datos del formulario
        $nuevoProducto = [
            'nombre' => $_POST['nombreProducto'],
            'categoria' => $_POST['categoriaProducto'],
            'precio' => (float)$_POST['precioProducto'],
            'stock' => (int)$_POST['stockProducto'],
        ];

        // Manejo de la imagen
        if (isset($_FILES['imagenProducto']) && $_FILES['imagenProducto']['error'] == 0) {
            $targetDirectory = "img/"; // Carpeta donde se guardarán las imágenes

            // Crear la carpeta si no existe
            if (!file_exists($targetDirectory)) {
                mkdir($targetDirectory, 0777, true);
            }

            $targetFile = $targetDirectory . basename($_FILES["imagenProducto"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            
            // Validar el tipo de archivo de imagen
            $validImageTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($imageFileType, $validImageTypes)) {
                // Mover la imagen a la carpeta de destino
                if (move_uploaded_file($_FILES["imagenProducto"]["tmp_name"], $targetFile)) {
                    // Añadir la ruta de la imagen al nuevo producto
                    $nuevoProducto['imagen'] = $targetFile; // Guardar la ruta de la imagen

                    // Insertar el nuevo producto en la colección
                    $collection->insertOne($nuevoProducto);
                    header('Location: productos.php'); // Redirigir después de agregar
                    exit();
                } else {
                    echo "Error al subir la imagen.";
                }
            } else {
                echo "Formato de imagen no válido. Solo se permiten JPG, JPEG, PNG y GIF.";
            }
        } else {
            echo "Error al cargar la imagen.";
        }
    } else {
        die("Error al conectar a la base de datos: " . $database);
    }
}
?>
