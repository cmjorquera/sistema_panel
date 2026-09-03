<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../class/conexion.php';
require_once __DIR__ . '/../modelos/ContenedorModelo.php';

/**
 * Elimina la imagen del disco. Acepta rutas relativas a imagenes/ (con o sin subcarpetas).
 */
function borrarImagenContenedor(string $imagen): void
{
    $imagen = trim($imagen);
    if ($imagen === '' || strpos($imagen, '..') !== false) {
        return;
    }

    $imagen       = ltrim($imagen, '/');
    $rutaCompleta = dirname(__DIR__) . '/imagenes/' . $imagen;
    if (is_file($rutaCompleta)) {
        @unlink($rutaCompleta);
    }
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new RuntimeException('Metodo no permitido.');
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1],
    ]);

    if ($id === false || $id === null) {
        throw new RuntimeException('El identificador del contenedor es invalido.');
    }

    $db     = new Conexion();
    $modelo = new ContenedorModelo($db->getConexion());
    $imagen = $modelo->eliminar($id);
    borrarImagenContenedor($imagen);
    $db->cerrar();

    echo json_encode([
        'ok'      => true,
        'message' => 'Contenedor eliminado correctamente.',
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode([
        'ok'      => false,
        'message' => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}
