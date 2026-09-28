<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Cancha</title>
    <style>
        .hoyo-row { margin-bottom: 5px; }
        .hoyo-label { display: inline-block; width: 80px; }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container" style="margin-top: 20px;">
    <h2>Crear Nueva Cancha</h2>
    <form action="guardar_cancha.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre de la Cancha" required><br><br>
        <input type="number" step="0.1" name="slope" placeholder="Slope (opcional)">
        <input type="number" step="0.1" name="rating" placeholder="Rating (opcional)"><br><br>
        
        <h3>Pares de los 18 hoyos</h3>
        <?php for ($i = 1; $i <= 18; $i++): ?>
            <div class="hoyo-row">
                <span class="hoyo-label">Hoyo <?php echo $i; ?>:</span>
                <input type="radio" name="par_<?php echo $i; ?>" value="3" id="p3_<?php echo $i; ?>"> <label for="p3_<?php echo $i; ?>">Par 3</label>
                <input type="radio" name="par_<?php echo $i; ?>" value="4" id="p4_<?php echo $i; ?>" checked> <label for="p4_<?php echo $i; ?>">Par 4</label>
                <input type="radio" name="par_<?php echo $i; ?>" value="5" id="p5_<?php echo $i; ?>"> <label for="p5_<?php echo $i; ?>">Par 5</label>
            </div>
        <?php endfor; ?>
        
        <br>
        <button type="submit">Guardar Cancha</button>
    </form>
    </div>
</body>
</html>