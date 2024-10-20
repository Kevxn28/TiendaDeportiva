<?php
require_once '../conexion.php';  // Ajusta la ruta si es necesario

$dbConnection = new DatabaseConnection();
$database = $dbConnection->connect();

if ($database instanceof MongoDB\Database) {
    $collection = $database->clientes;  // Cambiar el nombre de la colección
} else {
    die("Error al conectar a la base de datos: " . $database);
}

$id = $_GET['id'];

$resultado = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

if ($resultado->getDeletedCount() === 1) {
    header('Location: clientes.php');  // Redirige a la página de listado
    exit;
} else {
    echo "Error al eliminar el producto.";
}
?>
