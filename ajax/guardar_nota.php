<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../class/Keep.php';

try {
    $keep = new Keep();
    $respuesta = $keep->crearNota($_POST);

    echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'message' => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}
