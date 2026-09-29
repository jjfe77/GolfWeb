<?php
session_start();
require 'conexion.php';

// Verificar sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$canchas = $pdo->query("SELECT * FROM canchas")->fetchAll();
$alerta = $_SESSION['alerta_canchas'] ?? null;
unset($_SESSION['alerta_canchas']);
$resultado_guardar = $_SESSION['resultado_guardar_cancha'] ?? null;
unset($_SESSION['resultado_guardar_cancha']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Canchas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="estilos.css" rel="stylesheet">
    <script src="fondo.js?v=<?php echo filemtime(__DIR__ . '/fondo.js'); ?>" defer></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow mx-auto" style="max-width: 720px;">
        <div class="card-body p-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Listado de Canchas</h2>
            </div>

            <?php if ($alerta): ?>
                <div class="modal fade" id="alertaCancha" tabindex="-1" aria-labelledby="alertaCanchaTitulo" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="alertaCanchaTitulo">No se puede eliminar la cancha</h5>
                            </div>
                            <div class="modal-body">
                                <?php echo htmlspecialchars($alerta); ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($resultado_guardar): ?>
                <div class="modal fade" id="resultadoGuardarCancha" tabindex="-1" aria-labelledby="resultadoGuardarCanchaTitulo" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="resultadoGuardarCanchaTitulo">
                                    <?php echo $resultado_guardar['exito'] ? 'Cancha guardada' : 'No se pudo guardar'; ?>
                                </h5>
                            </div>
                            <div class="modal-body"><?php echo htmlspecialchars($resultado_guardar['mensaje']); ?></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                    <?php echo $resultado_guardar['exito'] ? 'Continuar' : 'Aceptar'; ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <table class="table table-striped table-hover tabla-gestion">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th class="col-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($canchas as $c): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($c['nombre']); ?></td>
                        <td class="col-acciones">
                            <a href="editar_cancha.php?id=<?php echo $c['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="eliminar_cancha.php?id=<?php echo $c['id']; ?>" class="btn btn-sm btn-danger">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="d-flex flex-wrap gap-2">
                <a href="crear_cancha.php" class="btn btn-success">Nueva Cancha</a>
                <a href="panel.php" class="btn btn-secondary">Volver al Panel</a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php if ($alerta): ?>
    <script>
        new bootstrap.Modal(document.getElementById('alertaCancha')).show();
    </script>
<?php endif; ?>
<?php if ($resultado_guardar): ?>
    <script>
        new bootstrap.Modal(document.getElementById('resultadoGuardarCancha')).show();
    </script>
<?php endif; ?>
</body>
</html>