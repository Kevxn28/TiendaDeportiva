<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['nombre'])) {
    header("Location: index.php"); // Redirigir al login si no está autenticado
    exit();
}

require '../conexion.php';

// Inicializar variable de errores
$errors = [];

// Comprobar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $puesto = trim($_POST['puesto']);
    $rol = trim($_POST['rol']); // Nuevo campo

    // Validaciones
    if (empty($nombre) || !preg_match("/^[a-zA-Z\s]{1,20}$/", $nombre)) {
        $errors['nombre'] = "El nombre debe contener solo letras y un máximo de 20 caracteres.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "El correo electrónico debe ser válido.";
    }

    // Verificar que el puesto no contenga palabras prohibidas
    $prohibitedWords = ['administrador', 'admin', 'jefe', 'ad'];
    if (empty($puesto) || preg_match("/\b(" . implode('|', $prohibitedWords) . ")\b/i", $puesto)) {
        $errors['puesto'] = "El puesto no puede ser 'administrador', 'admin', 'jefe', o similares.";
    }

    // Validación para el rol
    if (empty($rol)) {
        $errors['rol'] = "El rol es obligatorio.";
    }

    // Si no hay errores, insertar el nuevo empleado en la base de datos
    if (empty($errors)) {
        $collectionUsuarios = $dbConnection->getCollection("usuarios");
        $collectionUsuarios->insertOne([
            'nombre' => $nombre,
            'email' => $email,
            'puesto' => $puesto,
            'rol' => $rol, // Agregar rol
            'createdAt' => new DateTime()
        ]);

        // Configurar mensaje de éxito en la sesión
        $_SESSION['mensaje'] = "Empleado registrado exitosamente.";
        header("Location: admin_dashboard.php"); // Redirigir a admin_dashboard.php
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <style>
        body {
            background: black; /* Fondo negro */
            color: white; /* Texto blanco */
            font-family: 'Roboto', sans-serif; /* Fuente más moderna */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .container {
            background: rgba(40, 40, 40, 0.9); /* Fondo más oscuro y opaco */
            border-radius: 20px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        h2 {
            font-size: 30px;
            margin-bottom: 30px;
            font-weight: bold;
            color: #FFA500; /* Color naranja para el encabezado */
        }
        label {
            font-size: 16px;
            margin-bottom: 10px;
            display: block;
            text-align: left;
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 10px;
            border: 1px solid #b0b0b0; /* Borde gris claro */
            font-size: 16px;
            color: white; /* Texto blanco en los campos de entrada */
            background-color: #333; /* Fondo oscuro para los campos */
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus, input[type="email"]:focus {
            border-color: #ffa500; /* Color naranja suave al enfocar */
        }
        input[type="submit"] {
            padding: 12px 20px;
            background-color: #4CAF50; /* Verde suave */
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #45a049; /* Un tono más oscuro al pasar el ratón */
        }
        a {
            color: #FFA500; /* Color naranja para el enlace */
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .input-group {
            display: flex;
            align-items: center;
            width: 100%;
        }
        .input-group i {
            margin-right: 10px;
            font-size: 20px;
            color: #FFA500; /* Íconos en color naranja */
        }
        .error-message {
            color: #ff4747; /* Rojo para los mensajes de error */
            font-size: 14px;
            margin-bottom: 10px;
        }
        /* Iconos para cada campo */
        .icon-user, .icon-email, .icon-position, .icon-role {
            color: #FFA500; /* Íconos en naranja */
        }
    </style>
    <title>Registrar Empleado</title>
</head>
<body>
    <div class="container">
        <h2><i class="fas fa-user-plus"></i> Registro de Empleado</h2>

        <form method="POST" action="register_empleado.php">
            <div class="input-group">
                <i class="fas fa-user icon-user"></i>
                <input type="text" name="nombre" placeholder="Nombre" value="<?php echo htmlspecialchars($nombre ?? ''); ?>" required>
            </div>
            <?php if (isset($errors['nombre'])): ?>
                <small class="error-message"><?php echo $errors['nombre']; ?></small>
            <?php endif; ?>

            <div class="input-group">
                <i class="fas fa-envelope icon-email"></i>
                <input type="email" name="email" placeholder="Correo Electrónico" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
            </div>
            <?php if (isset($errors['email'])): ?>
                <small class="error-message"><?php echo $errors['email']; ?></small>
            <?php endif; ?>

            <div class="input-group">
                <i class="fas fa-futbol icon-position"></i>
                <input type="text" name="puesto" placeholder="Puesto" value="<?php echo htmlspecialchars($puesto ?? ''); ?>" required>
            </div>
            <?php if (isset($errors['puesto'])): ?>
                <small class="error-message"><?php echo $errors['puesto']; ?></small>
            <?php endif; ?>

            <div class="input-group">
                <i class="fas fa-shield-alt icon-role"></i>
                <input type="text" name="rol" placeholder="Rol" value="<?php echo htmlspecialchars($rol ?? ''); ?>" required>
            </div>
            <?php if (isset($errors['rol'])): ?>
                <small class="error-message"><?php echo $errors['rol']; ?></small>
            <?php endif; ?>

            <input type="submit" value="Registrar Empleado">
        </form>
        <a href="admin_dashboard.php"><i class="fas fa-arrow-left"></i> Volver al Panel de Administración</a>
    </div>
</body>
</html>
