<?php
require 'auth.php'; 
require 'conexion.php';
$jugadores = $pdo->query("SELECT * FROM jugadores")->fetchAll();
$alerta = $_SESSION['alerta_jugadores'] ?? null;
unset($_SESSION['alerta_jugadores']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Jugadores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="estilos.css" rel="stylesheet">
    <script src="fondo.js?v=<?php echo filemtime(__DIR__ . '/fondo.js'); ?>" defer></script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow mx-auto" style="max-width: 720px;">
            <div class="card-body p-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h2 mb-0">Jugadores</h1>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle tabla-gestion">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Hándicap</th>
                                <th class="col-acciones">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($jugadores as $j): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($j['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($j['handicap_actual']); ?></td>
                                <td class="col-acciones">
                                    <a href="editar_jugador.php?id=<?php echo $j['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmarEliminarJugador" data-delete-url="eliminar_jugador.php?id=<?php echo $j['id']; ?>">Eliminar</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="crear_jugador.php" class="btn btn-success">Nuevo Jugador</a>
                    <a href="panel.php" class="btn btn-secondary">Volver al Panel</a>
                </div>

                <?php if ($alerta): ?>
                    <div class="modal fade" id="alertaJugador" tabindex="-1" aria-labelledby="alertaJugadorTitulo" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="alertaJugadorTitulo">No se puede eliminar el jugador</h5>
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
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirmarEliminarJugador" tabindex="-1" aria-labelledby="confirmarEliminarJugadorTitulo" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmarEliminarJugadorTitulo">Confirmar eliminación</h5>
                </div>
                <div class="modal-body">¿Seguro que quieres eliminar este jugador?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="#" id="confirmarEliminarJugadorBoton" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('confirmarEliminarJugador').addEventListener('show.bs.modal', function (event) {
            document.getElementById('confirmarEliminarJugadorBoton').href = event.relatedTarget.dataset.deleteUrl;
        });
        <?php if ($alerta): ?>
            new bootstrap.Modal(document.getElementById('alertaJugador')).show();
        <?php endif; ?>
    </script>
</body>
</html>