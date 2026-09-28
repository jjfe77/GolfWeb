<?php
require 'auth.php'; 
require 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $stmt = $pdo->prepare("DELETE FROM canchas WHERE id = ?");
    $stmt->execute([$id]);
    
    header("Location: listar_canchas.php");
    exit();
}
?>