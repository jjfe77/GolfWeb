<?php
$file = 'test.txt';
if (file_put_contents($file, 'Hola Mundo')) {
    echo "PHP puede escribir archivos. El problema no es de permisos.";
} else {
    echo "¡ERROR! PHP NO tiene permiso para escribir archivos en esta carpeta.";
}
?>