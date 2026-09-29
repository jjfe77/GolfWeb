<?php
require 'auth.php';
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['partida_id']) || !ctype_digit((string)$_POST['partida_id'])) {
    header('Location: listar_partidas.php');
    exit();
}

$partida_id = (int)$_POST['partida_id'];
$fecha = $_POST['fecha'] ?? '';
$fecha_valida = false;
if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
    [$anio, $mes, $dia] = array_map('intval', explode('-', $fecha));
    $fecha_valida = checkdate($mes, $dia, $anio);
}
$url_retorno = $fecha_valida ? 'listar_partidas.php?fecha=' . urlencode($fecha) : 'listar_partidas.php';

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare('DELETE FROM scores WHERE partida_id = ?');
    $stmt->execute([$partida_id]);

    $stmt = $pdo->prepare('DELETE FROM partidas WHERE id = ?');
    $stmt->execute([$partida_id]);

    $pdo->commit();
    $_SESSION['aviso_partidas'] = $stmt->rowCount() > 0
        ? 'La partida y sus resultados fueron eliminados.'
        : 'No se encontró la partida seleccionada.';
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['aviso_partidas'] = 'No se pudo eliminar la partida. No se realizaron cambios.';
}

header('Location: ' . $url_retorno);
exit();
?>