<?php
session_start();
require '../conexion.php';

// Comprobar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar si el administrador ya está registrado
    $existeAdmin = $collectionUsuarios->findOne(['rol' => 'administrador']);

    if ($existeAdmin) {
        // Mostrar alerta de error si ya existe un administrador
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ya existe un administrador registrado.',
                });
            });
        </script>";
    } else {
        // Insertar el nuevo administrador en la base de datos
        $collectionUsuarios->insertOne([
            'nombre' => $nombre,
            'email' => $email,
            'password' => $password, // Aquí se almacena la contraseña en texto plano
            'rol' => 'administrador',
            'createdAt' => new DateTime()
        ]);

        // Mostrar mensaje de éxito y redirigir al index.php
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Administrador registrado exitosamente',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.php';
                    }
                });
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Íconos -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
    <style>
        body {
            background-color: #000000; /* Fondo negro */
            color: #ffffff; /* Texto blanco */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }
        .container {
            background: rgba(255, 255, 255, 0.1); /* Fondo translúcido */
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            text-align: center;
            transition: transform 0.3s;
        }
        .container:hover {
            transform: scale(1.05); /* Efecto de hover */
        }
        .container h2 {
            margin-bottom: 30px;
            font-size: 24px;
            color: #ffffff; /* Títulos en blanco */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }
        .container i {
            font-size: 60px;
            color: #ffffff; /* Color del icono en blanco */
            padding: 20px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group label {
            display: block;
            color: #ffffff; /* Etiquetas en blanco */
            font-weight: 500;
            margin-bottom: 10px;
            text-align: left; /* Alinear texto a la izquierda */
        }
        .form-control {
            background-color: rgba(255, 255, 255, 0.2); /* Fondo de los inputs */
            border: none;
            border-radius: 5px;
            color: #ffffff; /* Texto en inputs en blanco */
            width: 100%;
            padding: 10px;
            margin-bottom: 5px;
            font-size: 16px; /* Tamaño de fuente más grande */
        }
        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.3);
            border: none;
            box-shadow: none;
            outline: none; /* Eliminar borde de enfoque */
        }
        input[type="submit"], .btn-login {
            background: linear-gradient(90deg, #6a11cb, #2575fc); /* Degradado para el botón */
            border: none;
            border-radius: 5px;
            padding: 12px; /* Aumentar el padding */
            color: white;
            cursor: pointer;
            width: 100%;
            font-size: 18px; /* Tamaño de fuente más grande */
            transition: background 0.3s ease, transform 0.3s ease; /* Efectos de transición */
            margin-bottom: 15px; /* Espacio abajo del botón de registrar */
        }
        input[type="submit"]:hover, .btn-login:hover {
            background: linear-gradient(90deg, #2575fc, #6a11cb); /* Cambiar colores en hover */
            transform: translateY(-2px); /* Efecto de elevación al pasar el ratón */
        }
        .footer {
            margin-top: 20px;
            color: #ffffff; /* Texto en blanco para el pie de página */
            font-size: 14px;
        }
    </style>
    <title>Registrar Administrador</title>
</head>
<body>
    <div class="container">
        <i class="fas fa-user-circle"></i> <!-- Icono de usuario -->
        <h2>Registro de Administrador</h2>
        <form method="POST" action="register_admin.php">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <input type="submit" value="Registrar Administrador">
        </form>
        <a href="index.php" class="btn-login">Iniciar Sesión</a> <!-- Botón para iniciar sesión -->
        <div class="footer">© 2024 SPORTLINE. Todos los derechos reservados.</div> <!-- Pie de página -->
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>
