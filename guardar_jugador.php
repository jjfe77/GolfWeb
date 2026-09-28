<?php
require 'auth.php'; 
require 'conexion.php';
$nombre = $_POST['nombre'];
$hcp = $_POST['handicap'];
$historial_vacio = json_encode([]); // Historial vacío para empezar

$stmt = $pdo->prepare("INSERT INTO jugadores (nombre, handicap_actual, historial_scores) VALUES (?, ?, ?)");
$stmt->execute([$nombre, $hcp, $historial_vacio]);

header("Location: listar_jugadores.php");
?>