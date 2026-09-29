<?php
require 'auth.php'; 
require 'conexion.php';

try {
    $nombre = trim($_POST['nombre'] ?? '');
    if ($nombre === '') {
        throw new InvalidArgumentException('El nombre de la cancha es obligatorio.');
    }

    $slope = !empty($_POST['slope']) ? $_POST['slope'] : 126;
    $rating = !empty($_POST['rating']) ? $_POST['rating'] : 71.5;

    $pares = [];
    for ($i = 1; $i <= 18; $i++) {
        $par = $_POST['par_' . $i] ?? null;
        if (!in_array((string)$par, ['3', '4', '5'], true)) {
            throw new InvalidArgumentException('Revisa la selección de pares para los 18 hoyos.');
        }
        $pares[] = (int)$par;
    }

    $stmt = $pdo->prepare("INSERT INTO canchas (nombre, pares, slope, rating) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nombre, json_encode($pares), $slope, $rating]);

    $_SESSION['resultado_guardar_cancha'] = [
        'exito' => true,
        'mensaje' => 'La cancha se guardó correctamente.'
    ];
} catch (Throwable $e) {
    error_log('Error al guardar cancha: ' . $e->getMessage());
    $_SESSION['resultado_guardar_cancha'] = [
        'exito' => false,
        'mensaje' => 'No se pudo guardar la cancha. Revisa los datos e inténtalo nuevamente.'
    ];
}

header('Location: listar_canchas.php');
exit();
?>