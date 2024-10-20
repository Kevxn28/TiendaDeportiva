<?php
session_start();
require 'conexion.php';

$dbConnection = new DatabaseConnection();
$collectionUsuarios = $dbConnection->getCollection("usuarios");

$empleados = $collectionUsuarios->find();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome para los iconos -->
    <title>Lista de Empleados - CRUD</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {

            background-color: #f5f5dc; /* Beige claro */

        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #6a11cb;
            border: none;
        }
        .btn-primary:hover {
            background-color: #2575fc;
        }
        table {
            margin-top: 20px;
        }
        .table thead {
            background-color: #6a11cb;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4"><i class="fas fa-users"></i> Lista de Empleados</h2>

        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class='alert alert-info'><?php echo $_SESSION['mensaje']; ?></div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

        <div class="mb-3">
            <input type="text" id="search" class="form-control" placeholder="Buscar empleados..." onkeyup="searchEmployees()">
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Puesto</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($empleados as $empleado): ?>
                <tr>
                    <td><?php echo htmlspecialchars($empleado['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($empleado['email']); ?></td>
                    <td><?php echo htmlspecialchars($empleado['puesto'] ?? 'No especificado'); ?></td>
                    <td><?php echo htmlspecialchars($empleado['rol'] ?? 'No especificado'); ?></td>
                    <td>
                        <?php if (($empleado['rol'] ?? 'No especificado') !== 'administrador'): ?>
                            <a href="edit_empleado.php?id=<?php echo $empleado['_id']; ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a> 
                            <form id="delete-form-<?php echo $empleado['_id']; ?>" method="POST" action="delete_empleado.php?id=<?php echo $empleado['_id']; ?>" style="display:inline;">
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(event, 'delete-form-<?php echo $empleado['_id']; ?>')">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="mt-4">
            <a href="admin_dashboard.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Panel de Administración
            </a>
            <a href="exportar_empleados_pdf.php" class="btn btn-primary">
                <i class="fas fa-file-pdf"></i> Exportar a PDF
            </a>
        </div>
    </div>

    <script>
        function searchEmployees() {
            const input = document.getElementById('search').value.toLowerCase();
            const rows = document.querySelectorAll('table tbody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let found = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(input));
                row.style.display = found ? '' : 'none';
            });
        }

        function confirmDelete(event, formId) {
            event.preventDefault(); 
            const form = document.getElementById(formId);

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción eliminará permanentemente el registro. ¿Estás seguro de que deseas continuar?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminarlo!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Registro eliminado exitosamente!',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        form.submit();
                    });
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
