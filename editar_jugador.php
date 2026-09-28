<?php
require 'auth.php'; 
require 'conexion.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM jugadores WHERE id = ?");
$stmt->execute([$id]);
$jugador = $stmt->fetch();
?>
<form action="actualizar_jugador.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $jugador['id']; ?>">
    Nombre: <input type="text" name="nombre" value="<?php echo $jugador['nombre']; ?>"><br>
    Handicap: <input type="number" step="0.1" name="handicap" value="<?php echo $jugador['handicap_actual']; ?>"><br>
    <button type="submit">Guardar Cambios</button>
</form>