<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Golf</title>
</head>
<body>
    <h1>Bienvenido al Panel de Golf</h1>
    <p>Has iniciado sesión correctamente.</p>
    
    <!-- Estos son tus enlaces para navegar, no borres nada de esto -->
    <ul>
        <li><a href="crear_partida.php">Nueva Partida</a></li>
        <li><a href="listar_canchas.php">Gestionar Canchas</a></li>
        <li><a href="listar_jugadores.php">Gestionar Jugadores</a></li>
    </ul>

    <a href="logout.php">Cerrar sesión</a>
</body>
</html>