<?php
require 'auth.php'; 
require 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $stmt = $pdo->prepare("DELETE FROM canchas WHERE id = ?");

    try {
        $stmt->execute([$id]);
    } catch (PDOException $e) {
        if ($e->getCode() !== '23000') {
            throw $e;
        }

        $_SESSION['alerta_canchas'] = 'No se puede eliminar esta cancha porque ya fue utilizada en una partida. Elimina primero las partidas asociadas y vuelve a intentarlo.';
    }
    
    header("Location: listar_canchas.php");
    exit();
}
?>