<?php
require 'auth.php'; 
require 'conexion.php';

$nombre = $_POST['nombre'];
$slope = !empty($_POST['slope']) ? $_POST['slope'] : 126;
$rating = !empty($_POST['rating']) ? $_POST['rating'] : 71.5;

// Recogemos los 18 valores de los radios
$pares = [];
for ($i = 1; $i <= 18; $i++) {
    $pares[] = (int)$_POST['par_' . $i];
}
$pares_json = json_encode($pares);

$stmt = $pdo->prepare("INSERT INTO canchas (nombre, pares, slope, rating) VALUES (?, ?, ?, ?)");
$stmt->execute([$nombre, $pares_json, $slope, $rating]);

echo "Cancha guardada correctamente. <a href='listar_canchas.php'>Ver Listado</a>";
?>