<?php
require_once '../conexion.php';  // Ajusta la ruta si es necesario

$dbConnection = new DatabaseConnection();
$database = $dbConnection->connect();

if ($database instanceof MongoDB\Database) {
    $collection = $database->categoria;  // Cambiado a la colección de categorías
} else {
    die("Error al conectar a la base de datos: " . $database);
}

$categorias = $collection->find();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | CRUD Categorías</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
 

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="../admin_dashboard.php" class="brand-link">
      <span class="brand-text font-weight-light">SPORTLINE</span>
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="../categoria/categoria.php" class="nav-link active">
              <i class="nav-icon fas fa-tags"></i> <!-- Icono de categoría -->
              <p>Categoria CRUD</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../productos/productos.php" class="nav-link ">
              <i class="nav-icon fas fa-box"></i> <!-- Icono de productos -->
              <p>Productos CRUD</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../clientes/clientes.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i> <!-- Icono de clientes -->
              <p>Clientes CRUD</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
</aside>


  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">CRUD de Categorías</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">CRUD de Categorías</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <!-- Formulario para agregar nueva categoría -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Agregar Nueva Categoría</h3>
              </div>
              <form id="formAgregarCategoria" action="agregar.php" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="nombreCategoria">Nombre de la categoría</label>
                    <input type="text" class="form-control" id="nombreCategoria" name="nombreCategoria" placeholder="Ingresa el nombre de la categoría" required>
                  </div>
                  <div class="form-group">
                    <label for="descripcionCategoria">Descripción</label>
                    <textarea class="form-control" id="descripcionCategoria" name="descripcionCategoria" placeholder="Ingresa la descripción" required></textarea>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
              </form>
            </div>
            <!-- Tabla para mostrar las categorías -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Listado de Categorías</h3>
              </div>
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Descripción</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody id="listaCategorias">
                    <?php foreach ($categorias as $categoria): ?>
                    <tr>
                      <td><?php echo htmlspecialchars($categoria['nombre']); ?></td>
                      <td><?php echo htmlspecialchars($categoria['descripcion']); ?></td>
                      <td>
                        <a href="editar.php?id=<?php echo $categoria['_id']; ?>" class="btn btn-warning">Editar</a>
                        <a href="eliminar.php?id=<?php echo $categoria['_id']; ?>" class="btn btn-danger">Eliminar</a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
      Cualquier cosa que desees
    </div>
    <strong>Copyright &copy; 2024 <a href="#">TuSitioWeb</a>.</strong> Todos los derechos reservados.
  </footer>
</div>

<!-- REQUIRED SCRIPTS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>

</body>
</html>
