<?php
require 'auth.php'; 
require 'conexion.php';
$canchas = $pdo->query("SELECT * FROM canchas")->fetchAll();
$jugadores = $pdo->query("SELECT * FROM jugadores")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Partida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="estilos.css" rel="stylesheet">
    <script src="fondo.js?v=<?php echo filemtime(__DIR__ . '/fondo.js'); ?>" defer></script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow mx-auto" style="max-width: 720px;">
            <div class="card-body p-5">
                <h2 class="mb-4">Configurar Nueva Partida</h2>
                <form action="iniciar_partida.php" method="POST">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Seleccionar Cancha:</label>
                        <select name="cancha_id" class="form-select">
                            <?php foreach ($canchas as $c): ?>
                                <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['nombre']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Seleccionar Jugadores:</label>
                        <div class="border p-3 rounded bg-white">
                            <?php foreach ($jugadores as $j): ?>
                                <div class="form-check">
                                    <input class="form-check-input" style="border: 1px solid black !important;" type="checkbox" name="jugadores[]" value="<?php echo $j['id']; ?>" id="jugador_<?php echo $j['id']; ?>">
                                    <label class="form-check-label" for="jugador_<?php echo $j['id']; ?>">
                                        <?php echo htmlspecialchars($j['nombre']); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Bocha:</label>
                        <select name="bocha" class="form-select">
                            <option value="blanca">Blanca</option>
                            <option value="azul">Azul</option>
                            <option value="roja">Roja</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Iniciar Partida</button>
                </form>
                
                <div class="mt-4">
                    <a href="panel.php" class="btn btn-secondary w-100">Volver al Panel</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>