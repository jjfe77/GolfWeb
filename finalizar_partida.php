<?php
require 'auth.php'; 
require 'conexion.php';
$partida_id = $_GET['partida_id'];
$fecha_historial = $_GET['fecha'] ?? '';
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_historial)) {
    $fecha_historial = '';
} else {
    [$anio_historial, $mes_historial, $dia_historial] = array_map('intval', explode('-', $fecha_historial));
    if (!checkdate($mes_historial, $dia_historial, $anio_historial)) {
        $fecha_historial = '';
    }
}

$stmt = $pdo->prepare("SELECT p.fecha, c.nombre AS cancha FROM partidas p LEFT JOIN canchas c ON c.id = p.cancha_id WHERE p.id = ?");
$stmt->execute([$partida_id]);
$partida = $stmt->fetch();

// Obtenemos todos los scores de esta partida
$stmt = $pdo->prepare("SELECT * FROM scores WHERE partida_id = ? ORDER BY hoyo ASC");
$stmt->execute([$partida_id]);
$todos_los_scores = $stmt->fetchAll();

// Obtenemos los jugadores
// Reemplaza la consulta de jugadores actual en finalizar_partida.php por esta:
$stmt = $pdo->prepare("SELECT j.id, j.nombre, j.handicap_actual 
                       FROM jugadores j 
                       JOIN scores s ON j.id = s.jugador_id 
                       WHERE s.partida_id = ? 
                       GROUP BY j.id");
$stmt->execute([$partida_id]);
$jugadores = $stmt->fetchAll();

$scores_por_jugador = [];
foreach ($todos_los_scores as $score) {
    $scores_por_jugador[$score['jugador_id']][$score['hoyo']] = (int)$score['golpes'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarjeta Final</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="estilos.css" rel="stylesheet">
    <script src="fondo.js?v=<?php echo filemtime(__DIR__ . '/fondo.js'); ?>" defer></script>
    <style>
        .score-row-chalk > * { background-color: #f4f3e8 !important; }
        .score-row-aqua > * { background-color: #d9f0e8 !important; }
        .score-total { font-weight: 700; }
        .score-handicap { color: #102a43; font-weight: 700; }
        .scorecard-table { table-layout: fixed; min-width: 1160px; }
        .scorecard-table th:not(:first-child), .scorecard-table td:not(:first-child) { width: 40px; padding-left: 2px; padding-right: 2px; }
        .scorecard-table th:first-child, .scorecard-table td:first-child { width: 150px; }
        .scorecard-table { border-collapse: collapse; }
        .scorecard-table th, .scorecard-table td { border: 1px solid #7b8589 !important; }
        .scorecard-table .score-summary { width: 64px; background-color: #bde2d5 !important; color: #000 !important; font-weight: 700; }
        .scorecard-table .score-summary-gross { background-color: #d1d5d8 !important; }
        .scorecard-table .score-summary-hcp { background-color: #102a43 !important; color: #fff !important; }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid mt-5 mb-5 px-3 px-lg-5">
        <div class="card shadow mx-auto" style="max-width: 1500px;">
            <div class="card-body p-4">
                <h1 class="h3 mb-4">Tarjeta Final</h1>
                <?php if ($partida): ?>
                    <p class="text-muted">Partida #<?php echo (int)$partida_id; ?> · <?php echo date('d/m/Y H:i', strtotime($partida['fecha'])); ?> · <?php echo htmlspecialchars($partida['cancha'] ?? 'Cancha no disponible'); ?></p>
                <?php endif; ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle text-center scorecard-table mb-4">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="text-start">Jugador</th>
                                <?php for ($i = 1; $i <= 18; $i++): ?>
                                    <th scope="col"><?php echo $i; ?></th>
                                    <?php if ($i === 9): ?><th scope="col" class="score-summary">Ida</th><?php endif; ?>
                                    <?php if ($i === 18): ?><th scope="col" class="score-summary">Vuelta</th><?php endif; ?>
                                <?php endfor; ?>
                                <th scope="col" class="score-summary score-summary-gross">Gross</th>
                                <th scope="col" class="score-summary score-summary-hcp">HCP</th>
                                <th scope="col" class="score-summary">Neto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($jugadores as $indice => $j): ?>
                                <?php
                                $gross = 0;
                                $ida = 0;
                                $vuelta = 0;
                                $hcp_actual = $j['handicap_actual'];
                                ?>
                                <tr class="<?php echo $indice % 2 === 0 ? 'score-row-chalk' : 'score-row-aqua'; ?>">
                                    <th scope="row" class="text-start"><?php echo htmlspecialchars($j['nombre']); ?></th>
                                    <?php for ($i = 1; $i <= 18; $i++): ?>
                                        <?php
                                        $golpes_hoyo = $scores_por_jugador[$j['id']][$i] ?? 0;
                                        $gross += $golpes_hoyo;
                                        if ($i <= 9) {
                                            $ida += $golpes_hoyo;
                                        } else {
                                            $vuelta += $golpes_hoyo;
                                        }
                                        ?>
                                        <td><?php echo $golpes_hoyo; ?></td>
                                        <?php if ($i === 9): ?><td class="score-summary"><?php echo $ida; ?></td><?php endif; ?>
                                        <?php if ($i === 18): ?><td class="score-summary"><?php echo $vuelta; ?></td><?php endif; ?>
                                    <?php endfor; ?>
                                    <?php $neto = $gross - $hcp_actual; ?>
                                    <td class="score-summary score-summary-gross"><?php echo $gross; ?></td>
                                    <td class="score-summary score-summary-hcp"><?php echo $hcp_actual; ?></td>
                                    <td class="score-summary"><?php echo $neto; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="jugar.php?partida_id=<?php echo urlencode($partida_id); ?>&amp;hoyo=1&amp;modo=editar" class="btn btn-warning">Editar</a>
                    <a href="listar_partidas.php<?php echo $fecha_historial !== '' ? '?fecha=' . urlencode($fecha_historial) : ''; ?>" class="btn btn-outline-primary">Volver al historial</a>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmarEliminarPartida">Eliminar partida</button>
                    <a href="panel.php" class="btn btn-secondary">Guardar y salir</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirmarEliminarPartida" tabindex="-1" aria-labelledby="confirmarEliminarPartidaTitulo" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="confirmarEliminarPartidaTitulo">Confirmar eliminación de partida</h2>
                </div>
                <div class="modal-body">
                    ¿Eliminar la partida #<?php echo (int)$partida_id; ?> del <?php echo $partida ? date('d/m/Y H:i', strtotime($partida['fecha'])) : ''; ?> y todos sus resultados? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="eliminar_partida.php" method="POST" class="m-0">
                        <input type="hidden" name="partida_id" value="<?php echo (int)$partida_id; ?>">
                        <input type="hidden" name="fecha" value="<?php echo htmlspecialchars($fecha_historial, ENT_QUOTES, 'UTF-8'); ?>">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>