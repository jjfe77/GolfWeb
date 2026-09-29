<?php
session_start();
require 'conexion.php';

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
$usuario = $stmt->fetch();

if ($usuario && password_verify($password, $usuario['password'])) {
    $_SESSION['user_id'] = $usuario['id'];
    $_SESSION['rol'] = $usuario['rol'];
    
    header("Location: panel.php");
    exit();
} else {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error de Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="estilos.css" rel="stylesheet">
    <script src="fondo.js?v=<?php echo filemtime(__DIR__ . '/fondo.js'); ?>" defer></script>
</head>
<body class="bg-light pt-5">
    <div class="container text-center">
        <div class="alert alert-danger" style="max-width: 400px; margin: auto;">
            Credenciales incorrectas. <br><br>
            <a href='index.php' class="btn btn-danger">Volver</a>
        </div>
    </div>
</body>
</html>
<?php
}
?>