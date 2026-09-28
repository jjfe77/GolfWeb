<?php
require 'auth.php'; 
require 'conexion.php';
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM jugadores WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}
header("Location: listar_jugadores.php");
?>