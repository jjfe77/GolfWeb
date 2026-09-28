<?php
require 'auth.php'; 
require 'conexion.php';
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$hcp = $_POST['handicap'];

$stmt = $pdo->prepare("UPDATE jugadores SET nombre = ?, handicap_actual = ? WHERE id = ?");
$stmt->execute([$nombre, $hcp, $id]);

header("Location: listar_jugadores.php");
?>