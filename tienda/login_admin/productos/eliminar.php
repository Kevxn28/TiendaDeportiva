<?php
require_once '../conexion.php';  // Ajusta la ruta si es necesario

if (isset($_GET['id'])) {
    $dbConnection = new DatabaseConnection();
    $database = $dbConnection->connect();

    if ($database instanceof MongoDB\Database) {
        $collection = $database->productos;

        // Eliminar el producto de la colección
        $productoId = $_GET['id'];
        $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($productoId)]);
        header('Location: productos.php'); // Redirigir después de eliminar
        exit();
    } else {
        die("Error al conectar a la base de datos: " . $database);
    }
}
?>
