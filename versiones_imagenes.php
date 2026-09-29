<?php
header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

$archivos = [
    'imagenes' => [
        'images/golf1.jpg',
        'images/golf2.jpg',
        'images/golf3.jpg',
        'images/golf4.jpg',
        'images/golf5.jpg',
    ],
    'anuncios' => [
        'apaisadas' => ['images/hotel.jpg', 'images/bar.jpg'],
        'verticales' => ['images/hotel_vertical.jpg', 'images/bar_vertical.jpg'],
    ],
];

$versionar = static function (string $ruta): string {
    $archivo = __DIR__ . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $ruta);
    clearstatcache(true, $archivo);

    if (!is_file($archivo)) {
        return $ruta . '?v=missing';
    }

    return $ruta . '?v=' . filemtime($archivo) . '-' . filesize($archivo);
};

$respuesta = [
    'imagenes' => array_map($versionar, $archivos['imagenes']),
    'imagenesAnuncios' => [
        'apaisadas' => array_map($versionar, $archivos['anuncios']['apaisadas']),
        'verticales' => array_map($versionar, $archivos['anuncios']['verticales']),
    ],
];

echo json_encode($respuesta, JSON_UNESCAPED_SLASHES);
?>