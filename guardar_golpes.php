<?php
require 'auth.php'; 
require 'conexion.php';

$partida_id = $_POST['partida_id'];
$hoyo = (int)$_POST['hoyo'];
$golpes = $_POST['golpes'];
$putts = $_POST['putts'];

// Guardamos los golpes de cada jugador en la base de datos
foreach ($golpes as $jugador_id => $cantidad) {
    $p = $putts[$jugador_id];
    $stmt = $pdo->prepare("INSERT INTO scores (partida_id, jugador_id, hoyo, golpes, putts) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$partida_id, $jugador_id, $hoyo, $cantidad, $p]);
}

// Lógica de navegación
if ($hoyo < 18) {
    $siguiente = $hoyo + 1;
    header("Location: jugar.php?partida_id=$partida_id&hoyo=$siguiente");
} else {
    // Si es el hoyo 18, terminamos
    header("Location: finalizar_partida.php?partida_id=$partida_id");
}
?>