<?php
require 'auth.php'; 
require 'conexion.php';
$partida_id = $_GET['partida_id'];

// Obtenemos todos los scores de esta partida
$stmt = $pdo->prepare("SELECT * FROM scores WHERE partida_id = ? ORDER BY hoyo ASC");
$stmt->execute([$partida_id]);
$todos_los_scores = $stmt->fetchAll();

// Obtenemos los jugadores
// Reemplaza la consulta de jugadores actual en finalizar_partida.php por esta:
$stmt = $pdo->prepare("SELECT j.id, j.nombre, j.handicap_actual 
                       FROM jugadores j 
                       JOIN scores s ON j.id = s.jugador_id 
                       WHERE s.partida_id = ? 
                       GROUP BY j.id");
$stmt->execute([$partida_id]);
$jugadores = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<body>
    <div class="container" style="margin-top: 20px;">
    <h2>Tarjeta Final</h2>
    <table border="1">
        <tr>
            <th>Jugador</th>
            <?php for($i=1; $i<=18; $i++) echo "<th>$i</th>"; ?>
            <th>Gross</th>
            <th>HCP</th>
            <th>Neto</th>
        </tr>
        <?php foreach ($jugadores as $j): ?>
    <tr>
        <td><?php echo htmlspecialchars($j['nombre']); ?></td>
        <?php 
        $gross = 0;
        // Dibujamos los 18 hoyos
        for($i=1; $i<=18; $i++): 
            $golpes_hoyo = 0;
            foreach($todos_los_scores as $s) {
                if($s['jugador_id'] == $j['id'] && $s['hoyo'] == $i) {
                    $golpes_hoyo = $s['golpes'];
                }
            }
            $gross += $golpes_hoyo;
            echo "<td>$golpes_hoyo</td>";
        endfor; 
        
        // Calculamos aquí mismo para asegurar que la variable exista
        $hcp_actual = $j['handicap_actual']; 
        $neto = $gross - $hcp_actual;
        ?>
        <td><?php echo $gross; ?></td>
        <td><?php echo $hcp_actual; ?></td>
        <td><?php echo $neto; ?></td>
    </tr>
<?php endforeach; ?>
    </table>
    <br>
    <a href="panel.php">Volver al Panel</a>
    </div>
</body>
</html>