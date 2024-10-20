<?php
require_once '../conexion.php';  // Ajusta la ruta si es necesario

$dbConnection = new DatabaseConnection();
$database = $dbConnection->connect();

if ($database instanceof MongoDB\Database) {
    $collection = $database->categoria;  // Cambiado a la colección de categorías
} else {
    die("Error al conectar a la base de datos: " . $database);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombreCategoria']);
    $descripcion = trim($_POST['descripcionCategoria']);

    // Validar que ambos campos no estén vacíos
    if (!empty($nombre) && !empty($descripcion)) {
        $categoria = [
            'nombre' => $nombre,
            'descripcion' => $descripcion
        ];

        $result = $collection->insertOne($categoria);

        if ($result->getInsertedCount() === 1) {
            header('Location: categoria.php');  // Redirige a la lista de categorías
            exit;
        } else {
            echo "Error al agregar la categoría.";
        }
    } else {
        echo "Todos los campos son requeridos.";
    }
}
?>
