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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cancha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="estilos.css" rel="stylesheet">
    <script src="fondo.js?v=<?php echo filemtime(__DIR__ . '/fondo.js'); ?>" defer></script>
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card shadow mx-auto" style="max-width: 720px;">
            <div class="card-body p-5">
                <h1 class="h4 mb-2">Editar: <?php echo htmlspecialchars($cancha['nombre']); ?></h1>
                <form action="actualizar_cancha.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $cancha['id']; ?>">
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">Nombre de la cancha</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($cancha['nombre']); ?>" required>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="slope" class="form-label fw-bold">Slope</label>
                            <input type="number" step="0.1" class="form-control" id="slope" name="slope" value="<?php echo htmlspecialchars($cancha['slope']); ?>">
                        </div>
                        <div class="col-sm-6">
                            <label for="rating" class="form-label fw-bold">Rating</label>
                            <input type="number" step="0.1" class="form-control" id="rating" name="rating" value="<?php echo htmlspecialchars($cancha['rating']); ?>">
                        </div>
                    </div>

                    <h5 class="mb-3">Pares de los 18 hoyos</h5>
                    <div class="row g-4 mb-4">
                        <?php for ($columna = 0; $columna < 2; $columna++): ?>
                            <div class="col-12 col-md-6">
                                <div class="row g-2">
                                    <?php for ($i = $columna * 9 + 1; $i <= ($columna + 1) * 9; $i++):
                                        $p = $pares[$i - 1]; ?>
                                        <div class="col-12">
                                            <div class="border rounded p-2 d-flex align-items-center justify-content-between gap-3">
                                                <span class="fw-bold small text-nowrap flex-shrink-0">Hoyo <?php echo $i; ?></span>
                                                <div class="d-flex gap-2 flex-shrink-0">
                                                    <?php foreach ([3, 4, 5] as $par): ?>
                                                        <div class="form-check form-check-inline me-0 small">
                                                            <input class="form-check-input" type="radio" name="par_<?php echo $i; ?>" value="<?php echo $par; ?>" id="p<?php echo $par; ?>_<?php echo $i; ?>" <?php echo $p == $par ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="p<?php echo $par; ?>_<?php echo $i; ?>"><?php echo $par; ?></label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Actualizar Cancha</button>
                </form>
                <a href="listar_canchas.php" class="btn btn-secondary w-100 mt-3">Volver a Canchas</a>
            </div>
        </div>
    </div>
</body>
</html>