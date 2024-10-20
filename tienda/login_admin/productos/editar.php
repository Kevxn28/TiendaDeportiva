<?php
require_once '../conexion.php';  // Ajusta la ruta si es necesario

$dbConnection = new DatabaseConnection();
$database = $dbConnection->connect();

if ($database instanceof MongoDB\Database) {
    $collection = $database->productos; // Colección de productos
    $categoriasCollection = $database->categoria; // Colección de categorías
} else {
    die("Error al conectar a la base de datos: " . $database);
}

// Obtener el ID del producto a editar
if (isset($_GET['id'])) {
    $productoId = $_GET['id'];
    $producto = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($productoId)]);
} else {
    die("ID de producto no proporcionado.");
}

$errorMessage = '';

// Procesar la actualización del producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedData = [
        'nombre' => trim($_POST['nombreProducto']),
        'categoria' => trim($_POST['categoriaProducto']),
        'precio' => (float)$_POST['precioProducto'],
        'stock' => (int)$_POST['stockProducto']
    ];

    // Validar que todos los campos son válidos
    if (empty($updatedData['nombre'])) {
        $errorMessage = 'El nombre del producto no puede estar vacío.';
    } elseif (empty($updatedData['categoria'])) {
        $errorMessage = 'La categoría no puede estar vacía.';
    } elseif ($updatedData['precio'] < 0) {
        $errorMessage = 'El precio no puede ser negativo.';
    } elseif ($updatedData['stock'] < 0) {
        $errorMessage = 'El stock no puede ser negativo.';
    } else {
        $collection->updateOne(['_id' => new MongoDB\BSON\ObjectId($productoId)], ['$set' => $updatedData]);
        header('Location: productos.php'); // Redirige a la lista de productos
        exit();
    }
}

// Obtener las categorías
$categorias = $categoriasCollection->find();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Producto</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    body {
        background: linear-gradient(135deg, #f5f5dc, #e1e1d3); /* Degradado beige claro */
        color: #333; /* Color oscuro para texto */
        font-family: 'Roboto', sans-serif;
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
        max-width: 650px;
        width: 100%;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.2);
        color: #333;
    }

    h1 {
        text-align: center;
        font-size: 24px;
        color: #5a5a2d; /* Un tono marrón claro para el encabezado */
        margin-bottom: 20px;
    }

    .alert {
        margin: 15px 0;
        padding: 15px;
        background-color: #e74c3c;
        color: #fff;
        border-radius: 8px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
        margin-bottom: 8px;
        color: #5a5a2d; /* Color marrón claro para las etiquetas */
        font-size: 16px; /* Tamaño consistente del texto para los labels */
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #d1cfcf; /* Añade un borde gris claro */
        border-radius: 8px;
        background-color: #ffffff; /* Fondo blanco para campos de texto */
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease;
        font-size: 16px; /* Tamaño consistente del texto para los campos */
    }

    .form-control:focus {
        background-color: #fff;
        outline: none;
        box-shadow: 0 0 8px rgba(90, 90, 45, 0.5); /* Color marrón claro para el borde de enfoque */
    }

    .btn-primary {
        background-color: #ffcc00; /* Amarillo suave */
        color: black;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 100%;
        font-size: 18px;
        margin-top: 15px;
    }

    .btn-primary:hover {
        background-color: #e0a800; /* Un tono más oscuro al pasar el mouse */
    }
  </style>
</head>
<body>

<div class="container">
  <h1>Editar Producto de Zapatos</h1>

  <?php if ($errorMessage): ?>
      <div class="alert">
          <?php echo htmlspecialchars($errorMessage); ?>
      </div>
  <?php endif; ?>

  <form id="formEditarProductoZapatos" action="editar.php?id=<?php echo htmlspecialchars($productoId); ?>" method="POST">
    <div class="form-group">
      <label for="nombreProducto">Nombre del producto</label>
      <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
    </div>
    <div class="form-group">
      <label for="categoriaProducto">Categoría</label>
      <select class="form-control" id="categoriaProducto" name="categoriaProducto" required>
        <option value="">Selecciona una categoría</option>
        <?php foreach ($categorias as $categoria): ?>
            <option value="<?php echo htmlspecialchars($categoria['nombre']); ?>" <?php echo ($categoria['nombre'] == $producto['categoria']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($categoria['nombre']); ?>
            </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label for="precioProducto">Precio</label>
      <input type="number" step="0.01" class="form-control" id="precioProducto" name="precioProducto" value="<?php echo htmlspecialchars($producto['precio']); ?>" required>
      <small class="form-text text-muted">Formato: $<?php echo number_format($producto['precio'], 2); ?></small>
    </div>
    <div class="form-group">
      <label for="stockProducto">Stock</label>
      <input type="number" class="form-control" id="stockProducto" name="stockProducto" value="<?php echo htmlspecialchars($producto['stock']); ?>" required>
    </div>
    <button type="submit" class="btn-primary">Actualizar</button>
  </form>
</div>

</body>
</html>
