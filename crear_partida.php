<?php
require 'auth.php'; 
require 'conexion.php';
$canchas = $pdo->query("SELECT * FROM canchas")->fetchAll();
$jugadores = $pdo->query("SELECT * FROM jugadores")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head><title>Nueva Partida</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="container" style="margin-top: 20px;">
    <h2>Configurar Nueva Partida</h2>
    <form action="iniciar_partida.php" method="POST">
        <label>Seleccionar Cancha:</label><br>
        <select name="cancha_id">
            <?php foreach ($canchas as $c): ?>
                <option value="<?php echo $c['id']; ?>"><?php echo $c['nombre']; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Seleccionar Jugadores:</label><br>
        <?php foreach ($jugadores as $j): ?>
            <input type="checkbox" name="jugadores[]" value="<?php echo $j['id']; ?>"> 
            <?php echo $j['nombre']; ?><br>
        <?php endforeach; ?>
        <br>
        
        <label>Bocha:</label>
        <select name="bocha">
            <option value="blanca">Blanca</option>
            <option value="azul">Azul</option>
            <option value="roja">Roja</option>
        </select><br><br>
        
        <button type="submit">Iniciar Partida</button>
    </form>
    <br>
    <a href="panel.php">Volver al Panel</a>
    </div>
</body>
</html>