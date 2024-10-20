<?php
session_start();
require 'conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $nombre = trim($_POST['nombre']);
    $errors = [];

    // Validación del email y nombre
    if (empty($email)) {
        $errors[] = "El campo de email no puede estar vacío.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El formato del email no es válido.";
    }

    if (empty($nombre)) {
        $errors[] = "El campo de nombre no puede estar vacío.";
    }

    // Si no hay errores, proceder con la autenticación
    if (empty($errors)) {
        $dbConnection = new DatabaseConnection();
        $collectionClientes = $dbConnection->getCollection("clientes");

        // Buscar al cliente en la colección
        $cliente = $collectionClientes->findOne([
            'email' => $email,
            'nombre' => $nombre
        ]);

        // Verifica si el cliente existe
        if ($cliente) {
            $_SESSION['nombre'] = $cliente['nombre']; // Almacena solo el nombre en la sesión
            header("Location: index.php"); // Redirigir al dashboard del cliente
            exit();
        } else {
            $errors[] = "No se encontró un cliente registrado con este correo y nombre. Por favor, verifica tu información o contacta a administración.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión del Cliente</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #1e1e1e;
        }

        .login-container {
            display: flex;
            width: 900px;
            height: 500px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .illustration {
            flex: 1;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .illustration img {
            width: 80%; /* Ajusta el tamaño de la imagen */
            height: auto;
        }

        .login-form {
            flex: 1;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form h2 {
            font-size: 26px;
            margin-bottom: 10px;
            color: #000;
            font-weight: bold;
        }

        .login-form p {
            color: #666;
            margin-bottom: 20px;
        }

        .login-form form {
            display: flex;
            flex-direction: column;
        }

        input {
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }

        input:focus {
            border-color: #000;
            outline: none;
        }

        button {
            padding: 15px;
            border: none;
            border-radius: 8px;
            background-color: #000;
            color: white;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 15px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #333;
        }

        .google-login {
            background-color: #fff;
            color: #000;
            border: 1px solid #ddd;
        }

        .google-login:hover {
            background-color: #f7f7f7;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 14px;
            color: #666;
        }

        .remember-forgot a {
            color: #000;
            text-decoration: none;
        }

        .signup-link {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }

        .signup-link a {
            color: #000;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="illustration">
            <!-- Aquí puedes agregar una imagen o un SVG similar a la que viste en la imagen -->
            <img src="img.png" alt="Ilustración">
        </div>
        <div class="login-form">
            <h2>Welcome back!</h2>
            <p>Por favor ingresa tus datos</p>
            <form method="POST" action="">
                <input type="email" name="email" placeholder="Email del Cliente" required>
                <input type="text" name="nombre" placeholder="Nombre del Cliente" required>
                <div class="remember-forgot">
                    <label><input type="checkbox" name="remember"> Remember for 30 days</label>
                    <a href="#">Forgot password?</a>
                </div>
                <button type="submit">Iniciar Sesión</button>
                <button type="button" class="google-login">Log in with Google</button>
            </form>

            <?php if (!empty($errors)): ?>
                <script>
                    swal("Error", "<?php echo implode(', ', $errors); ?>", "error");
                </script>
            <?php endif; ?>

            <div class="signup-link">
                ¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a>
            </div>
        </div>
    </div>
</body>
</html>
