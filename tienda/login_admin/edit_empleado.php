<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['nombre'])) {
    header("Location: index.php");
    exit();
}

require '../conexion.php';

$dbConnection = new DatabaseConnection();
$collectionUsuarios = $dbConnection->getCollection("usuarios");

if (!isset($_GET['id'])) {
    header("Location: list_empleados.php");
    exit();
}

$empleado = $collectionUsuarios->findOne(['_id' => new MongoDB\BSON\ObjectId($_GET['id'])]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $puesto = trim($_POST['puesto']);

    // Validaciones
    $errors = [];

    // Validación del nombre
    if (empty($nombre) || !preg_match("/^[a-zA-Z\s]{1,20}$/", $nombre)) {
        $errors[] = "El nombre debe contener solo letras y un máximo de 20 caracteres.";
    }

    // Validación del correo electrónico
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El correo electrónico debe ser válido.";
    }

    // Validación del puesto
    $prohibitedWords = ['administrador', 'admin', 'jefe', 'ad'];
    if (empty($puesto) || preg_match("/\b(" . implode('|', $prohibitedWords) . ")\b/i", $puesto)) {
        $errors[] = "El puesto no puede ser 'administrador', 'admin', 'jefe', o similares.";
    }

    // Si no hay errores, actualizar el empleado
    if (empty($errors)) {
        $collectionUsuarios->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($_GET['id'])],
            ['$set' => [
                'nombre' => $nombre,
                'email' => $email,
                'puesto' => $puesto
            ]]
        );

        // Mensaje de éxito en la sesión
        $_SESSION['mensaje_exito'] = "Empleado actualizado con éxito.";
        // Redirigir para mostrar el mensaje
        header("Location: edit_empleado.php?id=" . $_GET['id']);
        exit();
    } else {
        $_SESSION['mensaje'] = implode("<br>", $errors);
        header("Location: edit_empleado.php?id=" . $_GET['id']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Editar Empleado</title>
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
<script>
    window.onload = function() {
        <?php if (isset($_SESSION['mensaje'])): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: "<?php echo str_replace("\n", "<br>", $_SESSION['mensaje']); ?>"
            }).then(function() {
                window.location = "edit_empleado.php?id=<?php echo $_GET['id']; ?>"; // Redirigir de vuelta al formulario
            });
            <?php unset($_SESSION['mensaje']); ?>
        <?php elseif (isset($_SESSION['mensaje_exito'])): ?>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: "<?php echo $_SESSION['mensaje_exito']; ?>",
                confirmButtonText: 'OK'
            }).then(function() {
                window.location = "list_empleados.php"; // Redirigir a la lista de empleados
            });
            <?php unset($_SESSION['mensaje_exito']); ?>
        <?php endif; ?>
    }

    function mostrarAlerta() {
        return Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Deseas actualizar los datos del empleado?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, se envía el formulario
                return true;
            } else {
                // Si el usuario cancela, se evita el envío del formulario
                return false;
            }
        });
    }
</script>

</head>
<body>
    <div class="container">
        <h2>Editar Empleado</h2>
        <form method="POST" action="" onsubmit="return validateForm()">
            <div class="input-container">
                <i class="fas fa-user icon"></i>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($empleado['nombre']); ?>" required>
            </div>
            <div class="input-container">
                <i class="fas fa-envelope icon"></i>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($empleado['email']); ?>" required>
            </div>
            <div class="input-container">
                <i class="fas fa-briefcase icon"></i>
                <label for="puesto">Puesto:</label>
                <input type="text" id="puesto" name="puesto" value="<?php echo htmlspecialchars($empleado['puesto'] ?? ''); ?>" required>
            </div>
            <input type="submit" value="Actualizar Empleado" onclick="return mostrarAlerta();">
        </form>
        <a href="list_empleados.php">Volver a la lista de empleados</a>
    </div>
</body>
</html>
