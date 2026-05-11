<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../class/Keep.php';

try {
    $keep = new Keep();
    $modo = trim((string)($_POST['modo'] ?? ''));

    if ($modo === 'fijar') {
        $respuesta = $keep->fijarNota($_POST['id'] ?? 0, $_POST['fijada'] ?? 0);
    } else {
        $respuesta = $keep->actualizarNota($_POST);
    }

    echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'message' => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}
