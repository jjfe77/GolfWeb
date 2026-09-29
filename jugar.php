<?php
require 'auth.php'; 
require 'conexion.php';

$partida_id = $_GET['partida_id'];
$hoyo_actual = $_GET['hoyo'];
$modo_edicion = ($_GET['modo'] ?? '') === 'editar';
$volver_hoyo = isset($_GET['volver_hoyo']) ? (int)$_GET['volver_hoyo'] : null;

// 1. Obtener datos de la partida
$stmt = $pdo->prepare("SELECT * FROM partidas WHERE id = ?");
$stmt->execute([$partida_id]);
$partida = $stmt->fetch();

// 2. Obtener jugadores (Decodificamos el JSON que guardamos en la tabla partidas)
$jugadores_ids = json_decode($partida['jugadores_ids']);

// Si los IDs están vacíos, evitamos errores
if (!empty($jugadores_ids)) {
    $placeholders = implode(',', array_fill(0, count($jugadores_ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM jugadores WHERE id IN ($placeholders)");
    $stmt->execute($jugadores_ids);
    $jugadores = $stmt->fetchAll();
} else {
    $jugadores = [];
}

$stmt = $pdo->prepare("SELECT jugador_id, golpes, putts FROM scores WHERE partida_id = ? AND hoyo = ?");
$stmt->execute([$partida_id, $hoyo_actual]);
$scores_hoyo = [];
foreach ($stmt->fetchAll() as $score) {
    $scores_hoyo[$score['jugador_id']] = $score;
}

$stmt = $pdo->prepare("SELECT jugador_id, SUM(golpes) AS parcial FROM scores WHERE partida_id = ? AND hoyo < ? GROUP BY jugador_id");
$stmt->execute([$partida_id, $hoyo_actual]);
$parciales = [];
foreach ($stmt->fetchAll() as $fila) {
    $parciales[$fila['jugador_id']] = (int)$fila['parcial'];
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Golpes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="estilos.css" rel="stylesheet">
    <script src="fondo.js?v=<?php echo filemtime(__DIR__ . '/fondo.js'); ?>" defer></script>
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card shadow mx-auto" style="max-width: 720px;">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">Hoyo <?php echo htmlspecialchars($hoyo_actual); ?></h1>
                    <div class="d-flex align-items-center gap-2">
                        <?php if ($modo_edicion): ?><span class="badge text-bg-warning">Edición</span><?php endif; ?>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmarSalida">Salir</button>
                    </div>
                </div>

                <form action="guardar_golpes.php" method="POST">
                    <input type="hidden" name="partida_id" value="<?php echo htmlspecialchars($partida_id); ?>">
                    <input type="hidden" name="hoyo" value="<?php echo htmlspecialchars($hoyo_actual); ?>">
                    <input type="hidden" name="modo" value="<?php echo $modo_edicion ? 'editar' : ''; ?>">
                    <?php if ($volver_hoyo !== null): ?>
                        <input type="hidden" name="volver_hoyo" value="<?php echo $volver_hoyo; ?>">
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-striped align-middle mb-4">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Jugador</th>
                                    <th scope="col">Golpes</th>
                                    <th scope="col">Putts</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($jugadores as $j): ?>
                                <tr>
                                    <th scope="row"><?php echo htmlspecialchars($j['nombre']); ?></th>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="input-group input-group-sm" style="min-width: 120px;">
                                                <button type="button" class="btn btn-outline-secondary" data-score-step="-1" aria-label="Quitar golpe a <?php echo htmlspecialchars($j['nombre'], ENT_QUOTES, 'UTF-8'); ?>">-</button>
                                                <input type="text" inputmode="numeric" class="form-control text-center" name="golpes[<?php echo $j['id']; ?>]" value="<?php echo (int)($scores_hoyo[$j['id']]['golpes'] ?? 0); ?>" readonly aria-label="Golpes de <?php echo htmlspecialchars($j['nombre'], ENT_QUOTES, 'UTF-8'); ?>">
                                                <button type="button" class="btn btn-outline-secondary" data-score-step="1" aria-label="Agregar golpe a <?php echo htmlspecialchars($j['nombre'], ENT_QUOTES, 'UTF-8'); ?>">+</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="input-group input-group-sm" style="min-width: 120px;">
                                                <button type="button" class="btn btn-outline-secondary" data-score-step="-1" aria-label="Quitar putt a <?php echo htmlspecialchars($j['nombre'], ENT_QUOTES, 'UTF-8'); ?>">-</button>
                                                <input type="text" inputmode="numeric" class="form-control text-center" name="putts[<?php echo $j['id']; ?>]" value="<?php echo (int)($scores_hoyo[$j['id']]['putts'] ?? 0); ?>" readonly aria-label="Putts de <?php echo htmlspecialchars($j['nombre'], ENT_QUOTES, 'UTF-8'); ?>">
                                                <button type="button" class="btn btn-outline-secondary" data-score-step="1" aria-label="Agregar putt a <?php echo htmlspecialchars($j['nombre'], ENT_QUOTES, 'UTF-8'); ?>">+</button>
                                            </div>
                                            <span class="text-dark fw-bold text-nowrap" style="display: inline-block; width: 110px;">Golpes: <?php echo $parciales[$j['id']] ?? 0; ?></span>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row g-2">
                        <?php if ((int)$hoyo_actual > 1): ?>
                            <div class="col-6">
                                <a class="btn btn-outline-secondary w-100" href="jugar.php?partida_id=<?php echo urlencode($partida_id); ?>&amp;hoyo=<?php echo (int)$hoyo_actual - 1; ?>&amp;modo=editar&amp;volver_hoyo=<?php echo $volver_hoyo ?? (int)$hoyo_actual; ?>">Hoyo anterior</a>
                            </div>
                        <?php endif; ?>
                        <div class="col-<?php echo (int)$hoyo_actual > 1 ? '6' : '12'; ?>">
                            <button type="submit" class="btn btn-primary w-100"><?php echo $volver_hoyo !== null ? 'Guardar corrección y volver al hoyo ' . $volver_hoyo : (($hoyo_actual == 18) ? ($modo_edicion ? 'Guardar y volver a la tarjeta' : 'Finalizar Partida') : ($modo_edicion ? 'Guardar y siguiente hoyo' : 'Siguiente Hoyo')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmarSalida" tabindex="-1" aria-labelledby="confirmarSalidaTitulo" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="confirmarSalidaTitulo">Salir de la partida</h2>
                </div>
                <div class="modal-body">¿Seguro que quieres salir? Los datos de este hoyo todavía no se guardaron y se perderán.</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="panel.php" class="btn btn-danger">Salir</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('[data-score-step]').forEach(function (button) {
            button.addEventListener('click', function () {
                const input = button.parentElement.querySelector('input');
                const currentValue = parseInt(input.value, 10) || 0;
                input.value = Math.max(0, currentValue + Number(button.dataset.scoreStep));
            });
        });
    </script>
</body>
</html>