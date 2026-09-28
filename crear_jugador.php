<!DOCTYPE html>
<html lang="es">
<body>
    <h2>Nuevo Jugador</h2>
    <form action="guardar_jugador.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre" required><br>
        <input type="number" step="0.1" name="handicap" placeholder="Hándicap actual" required><br>
        <button type="submit">Guardar Jugador</button>
    </form>
</body>
</html>