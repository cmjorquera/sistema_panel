<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../class/Keep.php';

try {
    $idUsuario = (int)($_GET['id_usuario'] ?? $_POST['id_usuario'] ?? 1);
    $keep = new Keep();
    $notas = $keep->listarNotas($idUsuario);

    echo json_encode([
        'ok' => true,
        'notas' => $notas,
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'message' => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}
