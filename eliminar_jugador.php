<?php
require 'auth.php'; 
require 'conexion.php';
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM jugadores WHERE id = ?");

    try {
        $stmt->execute([$_GET['id']]);
    } catch (PDOException $e) {
        if ($e->getCode() !== '23000') {
            throw $e;
        }

        $_SESSION['alerta_jugadores'] = 'No se puede eliminar este jugador porque tiene resultados guardados en una partida. Elimina primero los resultados o las partidas asociadas y vuelve a intentarlo.';
    }
}
header("Location: listar_jugadores.php");
exit();
?>