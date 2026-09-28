<?php
require 'auth.php'; 
require 'conexion.php';
$jugadores = $pdo->query("SELECT * FROM jugadores")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Jugadores</title>
</head>
<body>
    <h2>Jugadores</h2>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Hándicap</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($jugadores as $j): ?>
        <tr>
            <td><?php echo htmlspecialchars($j['nombre']); ?></td>
            <td><?php echo htmlspecialchars($j['handicap_actual']); ?></td>
            <td>
                <a href="editar_jugador.php?id=<?php echo $j['id']; ?>">Editar</a> | 
                <a href="eliminar_jugador.php?id=<?php echo $j['id']; ?>" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="crear_jugador.php">Nuevo Jugador</a> | <a href="panel.php">Volver al Panel</a>
</body>
</html>