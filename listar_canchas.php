<?php
session_start();
require 'conexion.php';

// Verificar sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$canchas = $pdo->query("SELECT * FROM canchas")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Canchas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5 bg-white p-4 shadow rounded">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Listado de Canchas</h2>
        <a href="crear_cancha.php" class="btn btn-success">Nueva Cancha</a>
    </div>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($canchas as $c): ?>
            <tr>
                <td><?php echo htmlspecialchars($c['nombre']); ?></td>
                <td>
                    <a href="editar_cancha.php?id=<?php echo $c['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="eliminar_cancha.php?id=<?php echo $c['id']; ?>" class="btn btn-sm btn-danger">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="panel.php" class="btn btn-secondary">Volver al Panel</a>
</div>
</body>
</html>