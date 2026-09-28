<?php
require 'auth.php'; 
require 'conexion.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM canchas WHERE id = ?");
$stmt->execute([$id]);
$cancha = $stmt->fetch();
$pares = json_decode($cancha['pares']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cancha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container" style="margin-top: 20px;">
    <h2>Editar: <?php echo $cancha['nombre']; ?></h2>
    <form action="actualizar_cancha.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $cancha['id']; ?>">
        <input type="text" name="nombre" value="<?php echo $cancha['nombre']; ?>" required><br><br>
        <input type="number" step="0.1" name="slope" value="<?php echo $cancha['slope']; ?>">
        <input type="number" step="0.1" name="rating" value="<?php echo $cancha['rating']; ?>"><br><br>
        
        <?php for ($i = 1; $i <= 18; $i++): 
            $p = $pares[$i-1]; ?>
            <div>
                Hoyo <?php echo $i; ?>:
                <input type="radio" name="par_<?php echo $i; ?>" value="3" <?php echo ($p==3)?'checked':''; ?>> 3
                <input type="radio" name="par_<?php echo $i; ?>" value="4" <?php echo ($p==4)?'checked':''; ?>> 4
                <input type="radio" name="par_<?php echo $i; ?>" value="5" <?php echo ($p==5)?'checked':''; ?>> 5
            </div>
        <?php endfor; ?>
        <button type="submit">Actualizar</button>
    </form>

    </div>
</body>
</html>