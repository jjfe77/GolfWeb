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
    
    // Redirigir al panel
    header("Location: panel.php");
    exit();
} else {
    echo "Credenciales incorrectas. <a href='index.php'>Volver</a>";
}
?>