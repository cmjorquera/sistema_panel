<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../class/conexion.php';
require_once __DIR__ . '/../modelos/ContenedorModelo.php';

function borrarImagenContenedor(string $imagen): void
{
    $imagen = basename(trim($imagen));
    if ($imagen === '') {
        return;
    }

    $rutaImagen = dirname(__DIR__) . '/imagenes/' . $imagen;
    if (is_file($rutaImagen)) {
        @unlink($rutaImagen);
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

    $db = new Conexion();
    $modelo = new ContenedorModelo($db->getConexion());
    $imagen = $modelo->eliminar($id);
    borrarImagenContenedor($imagen);
    $db->cerrar();

    echo json_encode([
        'ok' => true,
        'message' => 'Contenedor eliminado correctamente.',
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'message' => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}
