<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['nombre'])) {
    header("Location: index.php"); // Redirigir al login si no está autenticado
    exit();
}

// Mostrar mensaje de éxito si existe
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']); // Eliminar el mensaje de la sesión
} else {
    $mensaje = null;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <style>
        /* Reset de estilos */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            height: 100vh;
            background: url('productos/img/fondo2.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .container {
            background: rgba(255, 255, 255, 0.9); /* Fondo blanco con opacidad */
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        h2 {
            color: #ffcc00; /* Color amarillo dorado para el título */
            margin-bottom: 20px;
            font-size: 2em; /* Tamaño de fuente aumentado */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5); /* Sombra de texto */
        }

        .welcome {
            margin: 15px 0;
            color: #333; /* Color gris oscuro para el mensaje de bienvenida */
            font-size: 1.2em; /* Tamaño de fuente aumentado */
        }

        /* Botón de Cerrar Sesión */
        .logout {
            background: #ff4747;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s ease;
            margin: 10px;
            font-size: 1em; /* Tamaño de fuente del botón */
        }

        .logout:hover {
            background: #ff3030;
        }

        .admin-panel, .crud-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 20px 0;
            flex-wrap: wrap;
        }

        .admin-panel a, .crud-button {
            padding: 15px 25px;
            background-color: #333;
            color: #ffcc00;
            text-decoration: none;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.5);
            transition: background 0.3s ease, transform 0.3s ease;
            font-size: 1em; /* Tamaño de fuente de los botones */
        }

        .admin-panel a:hover, .crud-button:hover {
            background-color: #444;
            transform: translateY(-5px);
        }

        .crud-button i {
            margin-right: 8px;
        }

        img {
            width: 200px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="productos/img/logo.jpg" alt="SPORTLINE">
        <h2>Panel de Administración</h2>
        <div class="welcome">
            Bienvenido, <?php echo $_SESSION['nombre']; ?>
        </div>

        <button class="logout" onclick="window.location.href='logout.php'">
            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
        </button>

        <div class="admin-panel">
            <a href="register_empleado.php"><i class="fas fa-plus-circle"></i> Agregar Empleado</a>
            <a href="list_empleados.php"><i class="fas fa-users"></i> Ver Empleados</a>
        </div>

        <div class="crud-buttons">
            <a href="productos/productos.php" class="crud-button">
                <i class="fas fa-shoe-prints"></i> CRUD Productos
            </a>
            <a href="clientes/clientes.php" class="crud-button">
                <i class="fas fa-glasses"></i> CRUD Clientes
            </a>
            <a href="categoria/categoria.php" class="crud-button">
                <i class="fas fa-laptop"></i> CRUD Categoria
            </a>
        </div>

        <?php if ($mensaje): ?>
            <script>
                swal("Éxito", "<?php echo $mensaje; ?>", "success");
            </script>
        <?php endif; ?>
    </div>
</body>
</html>
