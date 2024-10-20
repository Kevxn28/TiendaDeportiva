<?php
require_once '../conexion.php';  // Ajusta la ruta si es necesario

$dbConnection = new DatabaseConnection();
$database = $dbConnection->connect();

if ($database instanceof MongoDB\Database) {
    $collection = $database->clientes;  // Cambiado a la colección de clientes
} else {
    die("Error al conectar a la base de datos: " . $database);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos del formulario
    $nombre = isset($_POST['nombreCliente']) ? $_POST['nombreCliente'] : '';
    $email = isset($_POST['correoCliente']) ? $_POST['correoCliente'] : '';
    $telefono = isset($_POST['telefonoCliente']) ? $_POST['telefonoCliente'] : '';
    $direccion = isset($_POST['direccionCliente']) ? $_POST['direccionCliente'] : '';

    // Crear un nuevo documento para insertar
    $nuevoCliente = [
        'nombre' => $nombre,
        'email' => $email,
        'telefono' => $telefono,
        'direccion' => $direccion,
    ];

    // Insertar el nuevo cliente en la colección
    try {
        $result = $collection->insertOne($nuevoCliente);
        // Redirigir a la página de clientes después de agregar
        header('Location: clientes.php?mensaje=Cliente agregado exitosamente');
        exit;
    } catch (Exception $e) {
        die('Error al agregar cliente: ' . $e->getMessage());
    }
}
?>
