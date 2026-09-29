<?php
require 'auth.php'; 
require 'conexion.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM jugadores WHERE id = ?");
$stmt->execute([$id]);
$jugador = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Jugador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="estilos.css" rel="stylesheet">
    <script src="fondo.js?v=<?php echo filemtime(__DIR__ . '/fondo.js'); ?>" defer></script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow mx-auto" style="max-width: 720px;">
            <div class="card-body p-5">
                <h1 class="mb-4">Editar Jugador</h1>
                <form action="actualizar_jugador.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $jugador['id']; ?>">
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($jugador['nombre']); ?>" required>
                    </div>
                    <div class="mb-4">
                        <label for="handicap" class="form-label fw-bold">Hándicap actual</label>
                        <input type="number" step="0.1" class="form-control" id="handicap" name="handicap" value="<?php echo htmlspecialchars($jugador['handicap_actual']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
                </form>
                <a href="listar_jugadores.php" class="btn btn-secondary w-100 mt-3">Volver a Jugadores</a>
            </div>
        </div>
    </div>
</body>
</html>