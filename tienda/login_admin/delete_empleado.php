<?php
session_start();
require '../conexion.php';

$dbConnection = new DatabaseConnection();
$collectionUsuarios = $dbConnection->getCollection("usuarios");

// Verificar si se ha pasado un ID
if (isset($_GET['id'])) {
    // Eliminar el empleado de la base de datos
    $collectionUsuarios->deleteOne(['_id' => new MongoDB\BSON\ObjectId($_GET['id'])]);
    
    // Establecer mensaje de éxito
    $_SESSION['mensaje'] = "Empleado eliminado con éxito.";
}

// Redirigir a la lista de empleados
header("Location: list_empleados.php");
exit();
?>
