<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Golf</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="estilos.css" rel="stylesheet">
    <script src="fondo.js?v=<?php echo filemtime(__DIR__ . '/fondo.js'); ?>" defer></script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow mx-auto" style="max-width: 720px;">
            <div class="card-body p-5">
                <h1 class="mb-3">Bienvenido al Panel de Golf</h1>
                <p class="text-muted">Has iniciado sesión correctamente.</p>
                
                <hr>
                
                <h5 class="mt-4 mb-3">Navegación:</h5>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><a href="crear_partida.php" class="text-decoration-none fw-bold" style="color: #14532d;">Nueva Partida</a></li>
                    <li class="list-group-item"><a href="listar_partidas.php" class="text-decoration-none fw-bold" style="color: #14532d;">Historial de Partidas</a></li>
                    <li class="list-group-item"><a href="listar_canchas.php" class="text-decoration-none fw-bold" style="color: #14532d;">Gestionar Canchas</a></li>
                    <li class="list-group-item"><a href="listar_jugadores.php" class="text-decoration-none fw-bold" style="color: #14532d;">Gestionar Jugadores</a></li>
                </ul>

                <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
            </div>
        </div>
    </div>
</body>
</html>