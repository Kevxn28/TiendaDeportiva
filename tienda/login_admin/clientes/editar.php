<?php
require_once '../conexion.php';  // Ajusta la ruta si es necesario

$dbConnection = new DatabaseConnection();
$database = $dbConnection->connect();

if ($database instanceof MongoDB\Database) {
    $collection = $database->clientes;  // Cambiado a la colección de clientes
} else {
    die("Error al conectar a la base de datos: " . $database);
}

$id = $_GET['id'];
$cliente = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

if (!$cliente) {
    die("Cliente no encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombreCliente'];
    $email = $_POST['emailCliente'];
    $telefono = $_POST['telefonoCliente'];
    $direccion = $_POST['direccionCliente'];

    $resultado = $collection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($id)],
        ['$set' => [
            'nombre' => $nombre,
            'email' => $email,
            'telefono' => $telefono,
            'direccion' => $direccion
        ]]
    );

    if ($resultado->getModifiedCount() === 1) {
        header('Location: clientes.php');  // Redirige a la página de listado
        exit;
    } else {
        echo "Error al editar el cliente.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <style>
        body {
            background: linear-gradient(135deg, #f5f5dc, #e1e1d3); /* Degradado beige claro */
            color: #333; /* Color oscuro para texto */
            font-family: 'Arial', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .container {
            background: rgba(255, 255, 255, 0.9); /* Fondo más blanco y opaco */
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 40px;
            max-width: 400px; /* Ajustado al diseño que proporcionaste */
            width: 100%;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h1 {
            font-size: 26px;
            margin-bottom: 20px;
            font-weight: bold;
            color: #5a5a2d; /* Un tono marrón claro para el encabezado */
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            font-size: 16px;
            margin-bottom: 10px;
            color: #5a5a2d; /* Color marrón claro para las etiquetas */
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #d1cfcf; /* Borde gris claro */
            font-size: 16px;
            background-color: #ffffff; /* Fondo blanco para campos de texto */
        }

        button {
            padding: 12px 20px;
            background-color: #ffcc00; /* Amarillo suave */
            color: black;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #e0a800; /* Un tono más oscuro al pasar el mouse */
        }

        .error-message {
            color: #ffcc00; /* Amarillo suave para mensajes de error */
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Cliente</h1>
        <form action="editar.php?id=<?php echo $cliente['_id']; ?>" method="POST">
            <input type="hidden" name="idCliente" value="<?php echo $cliente['_id']; ?>">
            <label for="nombreCliente">Nombre del cliente:</label>
            <input type="text" name="nombreCliente" id="nombreCliente" value="<?php echo htmlspecialchars($cliente['nombre']); ?>" required>
            <label for="emailCliente">Email:</label>
            <input type="email" name="emailCliente" id="emailCliente" value="<?php echo htmlspecialchars($cliente['email']); ?>" required>
            <label for="telefonoCliente">Teléfono:</label>
            <input type="text" name="telefonoCliente" id="telefonoCliente" value="<?php echo htmlspecialchars($cliente['telefono']); ?>" required>
            <label for="direccionCliente">Dirección:</label>
            <textarea name="direccionCliente" id="direccionCliente" required><?php echo htmlspecialchars($cliente['direccion']); ?></textarea>
            <button type="submit">Guardar cambios</button>
        </form>
    </div>
</body>
</html>
