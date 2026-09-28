<?php
require 'auth.php'; 
require 'conexion.php';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$slope = $_POST['slope'];
$rating = $_POST['rating'];

$pares = [];
for ($i = 1; $i <= 18; $i++) {
    $pares[] = (int)$_POST['par_' . $i];
}
$pares_json = json_encode($pares);

$stmt = $pdo->prepare("UPDATE canchas SET nombre=?, pares=?, slope=?, rating=? WHERE id=?");
$stmt->execute([$nombre, $pares_json, $slope, $rating, $id]);

header("Location: listar_canchas.php");
?>