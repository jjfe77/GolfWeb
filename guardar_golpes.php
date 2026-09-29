<?php
require 'auth.php'; 
require 'conexion.php';

$partida_id = $_POST['partida_id'];
$hoyo = (int)$_POST['hoyo'];
$golpes = $_POST['golpes'];
$putts = $_POST['putts'];
$modo_edicion = ($_POST['modo'] ?? '') === 'editar';
$volver_hoyo = isset($_POST['volver_hoyo']) ? (int)$_POST['volver_hoyo'] : null;

foreach ($golpes as $jugador_id => $cantidad) {
    $p = $putts[$jugador_id];

    if ($modo_edicion) {
        $stmt = $pdo->prepare("SELECT id FROM scores WHERE partida_id = ? AND jugador_id = ? AND hoyo = ? LIMIT 1");
        $stmt->execute([$partida_id, $jugador_id, $hoyo]);
        $score_id = $stmt->fetchColumn();

        if ($score_id) {
            $stmt = $pdo->prepare("UPDATE scores SET golpes = ?, putts = ? WHERE id = ?");
            $stmt->execute([$cantidad, $p, $score_id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO scores (partida_id, jugador_id, hoyo, golpes, putts) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$partida_id, $jugador_id, $hoyo, $cantidad, $p]);
        }
    } else {
        $stmt = $pdo->prepare("INSERT INTO scores (partida_id, jugador_id, hoyo, golpes, putts) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$partida_id, $jugador_id, $hoyo, $cantidad, $p]);
    }
}

if ($modo_edicion && $volver_hoyo !== null && $volver_hoyo >= 1 && $volver_hoyo <= 18) {
    header("Location: jugar.php?partida_id=$partida_id&hoyo=$volver_hoyo");
    exit();
}

if ($hoyo < 18) {
    $siguiente = $hoyo + 1;
    $modo = $modo_edicion ? '&modo=editar' : '';
    header("Location: jugar.php?partida_id=$partida_id&hoyo=$siguiente$modo");
} else {
    header("Location: finalizar_partida.php?partida_id=$partida_id");
}
exit();
?>