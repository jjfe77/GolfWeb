<?php
require 'auth.php'; 
require 'conexion.php';
$canchas = $pdo->query("SELECT * FROM canchas")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Canchas</title>
</head>
<body>
    <h2>Canchas Registradas</h2>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($canchas as $c): ?>
        <tr>
            <td><?php echo $c['nombre']; ?></td>
            <td>
                <a href="editar_cancha.php?id=<?php echo $c['id']; ?>">Editar</a>
                <a href="eliminar_cancha.php?id=<?php echo $c['id']; ?>">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="panel.php">Volver al Panel</a>
</body>
</html>