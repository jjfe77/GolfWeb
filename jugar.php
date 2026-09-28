<?php
require 'auth.php'; 
require 'conexion.php';

$partida_id = $_GET['partida_id'];
$hoyo_actual = $_GET['hoyo'];

// 1. Obtener datos de la partida
$stmt = $pdo->prepare("SELECT * FROM partidas WHERE id = ?");
$stmt->execute([$partida_id]);
$partida = $stmt->fetch();

// 2. Obtener jugadores (Decodificamos el JSON que guardamos en la tabla partidas)
$jugadores_ids = json_decode($partida['jugadores_ids']);

// Si los IDs están vacíos, evitamos errores
if (!empty($jugadores_ids)) {
    $placeholders = implode(',', array_fill(0, count($jugadores_ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM jugadores WHERE id IN ($placeholders)");
    $stmt->execute($jugadores_ids);
    $jugadores = $stmt->fetchAll();
} else {
    $jugadores = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<body>
    <h2>Hoyo <?php echo $hoyo_actual; ?></h2>
    
    <form action="guardar_golpes.php" method="POST">
        <input type="hidden" name="partida_id" value="<?php echo $partida_id; ?>">
        <input type="hidden" name="hoyo" value="<?php echo $hoyo_actual; ?>">
        
        <table border="1">
            <tr><th>Jugador</th><th>Golpes</th><th>Putts</th></tr>
            <?php foreach ($jugadores as $j): ?>
            <tr>
                <td><?php echo $j['nombre']; ?></td>
                <td>
                    <button type="button" onclick="modificar(this, -1)">-</button>
                    <input type="number" name="golpes[<?php echo $j['id']; ?>]" value="" placeholder="0" required>
                    <button type="button" onclick="modificar(this, 1)">+</button>
                </td>
                <td>
                    <button type="button" onclick="modificar(this, -1)">-</button>
                    <input type="number" name="putts[<?php echo $j['id']; ?>]" value="" placeholder="0" required>
                    <button type="button" onclick="modificar(this, 1)">+</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <button type="submit"><?php echo ($hoyo_actual == 18) ? "Finalizar Partida" : "Siguiente Hoyo"; ?></button>
    </form>

    <script>
    function modificar(btn, cambio) {
        // Busca el input que está en el mismo contenedor (td) que el botón
        let input = btn.parentElement.querySelector('input');
        let valor = parseInt(input.value) || 0;
        let nuevoValor = valor + cambio;
        if (nuevoValor >= 0) {
            input.value = nuevoValor;
        }
    }
    </script>
</body>
</html>