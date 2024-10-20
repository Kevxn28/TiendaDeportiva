<?php
session_start();
require 'conexion.php'; // Asegúrate de tener el archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $errors = [];

    // Validación del email
    if (empty($email)) {
        $errors[] = "El campo de email no puede estar vacío.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El formato del email no es válido.";
    }

    // Validación de la contraseña
    if (empty($password)) {
        $errors[] = "El campo de contraseña no puede estar vacío.";
    }

    // Si no hay errores, proceder con la autenticación
    if (empty($errors)) {
        $dbConnection = new DatabaseConnection();
        $collectionUsuarios = $dbConnection->getCollection("usuarios");

        $usuario = $collectionUsuarios->findOne(['email' => $email]);

        // Verifica si el usuario existe y la contraseña es correcta
        if ($usuario && $usuario['password'] === $password) { // Reemplaza 'password' con la forma que guardas las contraseñas
            $_SESSION['nombre'] = $usuario['nombre'];
            header("Location: admin_dashboard.php"); // Redirigir al dashboard
            exit();
        } else {
            $errors[] = "Email o contraseña incorrectos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #000; /* Fondo negro */
            color: #fff; /* Texto blanco */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Roboto', sans-serif; /* Usando la fuente Roboto para una apariencia moderna */
            margin: 0;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.1); /* Fondo translúcido */
            backdrop-filter: blur(10px); /* Fondo translúcido con desenfoque para un toque elegante */
            border-radius: 20px;
            padding: 40px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 8px 20px rgba(255, 255, 255, 0.2);
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 30px;
            color: #fff; /* Título blanco */
            font-weight: bold;
        }

        .login-container i {
            font-size: 60px;
            background-color: #000; /* Fondo negro */
            color: #fff; /* Icono blanco */
            padding: 15px;
            border-radius: 50%;
            margin-bottom: 20px;
            border: 2px solid #fff; /* Borde blanco */
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.1); /* Fondo suave para los campos de entrada */
            border: none;
            border-radius: 5px;
            color: #fff; /* Texto blanco */
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.2);
            border: none;
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
        }

        .btn-primary, .btn-secondary {
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            width: 100%;
            color: white;
            font-weight: bold;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .btn-primary {
            background: #6a11cb; /* Fondo púrpura */
        }

        .btn-primary:hover {
            background: #2575fc; /* Color más claro al pasar el mouse */
            box-shadow: 0 5px 15px rgba(106, 17, 203, 0.4);
        }

        .btn-secondary {
            background: #333; /* Botón oscuro */
        }

        .btn-secondary:hover {
            background: #555; /* Color al pasar el mouse */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .form-group label {
            color: #fff; /* Etiquetas blancas */
            font-weight: bold;
        }

        .notification {
            background-color: #f44336; /* Fondo rojo */
            color: white; /* Texto blanco */
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
    <title>Inicio de Sesión</title>
</head>
<body>
    <div class="login-container">
        <i class="fas fa-user-circle"></i>
        <h2 class="text-center">Iniciar Sesión</h2>
        <?php if (!empty($errors)): ?>
            <div class="notification">
                <?php echo implode("<br>", $errors); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
            <a href="register_admin.php" class="btn btn-register btn-primary">Registrar Administrador</a>
            <a href="../acceso.html" class="btn btn-secondary">Regresar</a> <!-- Botón de regresar -->
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
