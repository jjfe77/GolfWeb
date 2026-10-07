<?php
require 'auth.php';
require 'conexion.php';

$fecha = $_GET['fecha'] ?? '';
$aviso = $_SESSION['aviso_partidas'] ?? null;
unset($_SESSION['aviso_partidas']);
$fecha_valida = $fecha === '';
if ($fecha !== '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
    [$anio, $mes, $dia] = array_map('intval', explode('-', $fecha));
    $fecha_valida = checkdate($mes, $dia, $anio);
}

$sql = "SELECT p.id, p.fecha, p.bocha, c.nombre AS cancha,
               (SELECT COUNT(DISTINCT s.hoyo) FROM scores s WHERE s.partida_id = p.id) AS hoyos_registrados
        FROM partidas p
        LEFT JOIN canchas c ON c.id = p.cancha_id";
$parametros = [];

if ($fecha !== '' && $fecha_valida) {
    $sql .= " WHERE DATE(p.fecha) = ?";
    $parametros[] = $fecha;
} elseif (!$fecha_valida) {
    $fecha = '';
}

$sql .= " ORDER BY p.fecha DESC, p.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($parametros);
$partidas = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Partidas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="estilos.css" rel="stylesheet">
    <script src="fondo.js?v=<?php echo filemtime(__DIR__ . '/fondo.js'); ?>" defer></script>
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card shadow mx-auto" style="max-width: 1000px;">
            <div class="card-body p-4 p-md-5">
                <h1 class="h3 mb-4">Historial de Partidas</h1>

                <form method="GET" class="row g-2 align-items-end mb-4">
                    <div class="col-sm-6 col-md-4">
                        <label for="fecha" class="form-label fw-bold">Filtrar por fecha</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo htmlspecialchars($fecha); ?>">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                    <?php if ($fecha !== ''): ?>
                        <div class="col-auto">
                            <a href="listar_partidas.php" class="btn btn-secondary">Mostrar todas</a>
                        </div>
                    <?php endif; ?>
                </form>

                <?php if ($aviso): ?>
                    <div class="alert alert-info" role="status"><?php echo htmlspecialchars($aviso); ?></div>
                <?php endif; ?>

                <?php if (!$fecha_valida): ?>
                    <div class="alert alert-warning" role="alert">La fecha indicada no es válida. Se muestran todas las partidas.</div>
                <?php endif; ?>

                <?php if ($partidas): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Cancha</th>
                                    <th scope="col">Bocha</th>
                                    <th scope="col">Hoyos registrados</th>
                                    <th scope="col">Tarjeta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($partidas as $partida): ?>
                                    <tr>
                                        <td><?php echo date('d/m/Y H:i', strtotime($partida['fecha'])); ?></td>
                                        <td><?php echo htmlspecialchars($partida['cancha'] ?? 'Cancha no disponible'); ?></td>
                                        <td><?php echo htmlspecialchars(ucfirst($partida['bocha'] ?? '')); ?></td>
                                        <td><?php echo (int)$partida['hoyos_registrados']; ?> / 18</td>
                                        <td class="text-nowrap">
                                            <a href="finalizar_partida.php?partida_id=<?php echo (int)$partida['id']; ?><?php echo $fecha !== '' ? '&amp;fecha=' . urlencode($fecha) : ''; ?>" class="btn btn-sm btn-primary">Ver tarjeta</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info" role="status">
                        <?php echo $fecha !== '' ? 'No hay partidas registradas en esa fecha.' : 'Todavía no hay partidas registradas.'; ?>
                    </div>
                <?php endif; ?>

                <a href="panel.php" class="btn btn-secondary">Volver al Panel</a>
            </div>
        </div>
    </div>

</body>
</html>