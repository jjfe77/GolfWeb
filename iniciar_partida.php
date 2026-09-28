<?php
require 'auth.php'; 
require 'conexion.php';

$cancha_id = $_POST['cancha_id'];
$bocha = $_POST['bocha'];
$jugadores_ids = json_encode($_POST['jugadores']);

$stmt = $pdo->prepare("INSERT INTO partidas (cancha_id, bocha, jugadores_ids) VALUES (?, ?, ?)");
$stmt->execute([$cancha_id, $bocha, $jugadores_ids]);

$partida_id = $pdo->lastInsertId();

// Redirigir a la pantalla de anotación del hoyo 1
header("Location: jugar.php?partida_id=" . $partida_id . "&hoyo=1");
?>