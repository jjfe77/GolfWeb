<?php
require 'auth.php'; 
require 'conexion.php';

if ($pdo) {
    echo "¡Conexión exitosa a la base de datos!";
} else {
    echo "Algo salió mal.";
}
?>
