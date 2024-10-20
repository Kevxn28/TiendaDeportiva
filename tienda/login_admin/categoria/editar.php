<?php
require_once '../conexion.php';  // Ajusta la ruta si es necesario

$dbConnection = new DatabaseConnection();
$database = $dbConnection->connect();

if ($database instanceof MongoDB\Database) {
    $collection = $database->categoria;  // Cambia el nombre de la colección
} else {
    die("Error al conectar a la base de datos: " . $database);
}

$id = $_GET['id'];
$categoria = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

if (!$categoria) {
    die("Categoría no encontrada.");
}

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombreCategoria']);
    $descripcion = trim($_POST['descripcionCategoria']);

    // Validar campos
    if (empty($nombre)) {
        $errorMessage = 'El nombre de la categoría no puede estar vacío.';
    } elseif (strlen($nombre) > 100) {
        $errorMessage = 'El nombre de la categoría no puede exceder los 100 caracteres.';
    } elseif (empty($descripcion)) {
        $errorMessage = 'La descripción no puede estar vacía.';
    } elseif (strlen($descripcion) > 255) {
        $errorMessage = 'La descripción no puede exceder los 255 caracteres.';
    } else {
        $resultado = $collection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($id)],
            ['$set' => [
                'nombre' => $nombre,
                'descripcion' => $descripcion
            ]]
        );

        if ($resultado->getModifiedCount() === 1) {
            header('Location: categoria.php');  // Redirige a la lista de categorías
            exit;
        } else {
            $errorMessage = "Error al editar la categoría.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoría</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

        h2 {
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
            margin-right: 10px; /* Espacio entre el texto y el cuadro de texto */
            color: #5a5a2d; /* Color marrón claro para las etiquetas */
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #d1cfcf; /* Borde gris claro */
            font-size: 16px;
            background-color: #ffffff; /* Fondo blanco para campos de texto */
        }

        input[type="submit"] {
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

        input[type="submit"]:hover {
            background-color: #e0a800; /* Un tono más oscuro al pasar el mouse */
        }

        a {
            color: #5a5a2d; /* Color marrón claro para el enlace */
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
        }

        a:hover {
            text-decoration: underline;
        }

        .input-container {
            display: flex;
            align-items: center;
            width: 100%;
        }

        .input-container i {
            margin-right: 10px;
            font-size: 22px;
            color: #5a5a2d; /* Color marrón claro para los íconos */
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
        <h1>Editar Categoría</h1>

        <?php if ($errorMessage): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="nombreCategoria">Nombre de la Categoría</label>
                <input type="text" class="form-control" id="nombreCategoria" name="nombreCategoria" value="<?php echo htmlspecialchars($categoria['nombre']); ?>" required>
            </div>
            <div class="form-group">
                <label for="descripcionCategoria">Descripción</label>
                <textarea class="form-control" id="descripcionCategoria" name="descripcionCategoria" rows="3" required><?php echo htmlspecialchars($categoria['descripcion']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
