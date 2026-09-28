<?php
$host = "localhost";
$dbname = "golf_app"; // Asegúrate que este sea el nombre de tu base de datos
$username = "root";
$password = "root"; // Por defecto en XAMPP está vacío

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Configurar el modo de error para que nos avise si algo falla
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
include 'estilos.php';
?>