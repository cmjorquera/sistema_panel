<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../class/Conexion.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new RuntimeException('Método no permitido.');
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1],
    ]);

    if ($id === false || $id === null) {
        throw new RuntimeException('Identificador de usuario inválido.');
    }

    $db   = Conexion::obtener();
    $stmt = $db->prepare('DELETE FROM usuarios WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        $stmt->close();
        throw new RuntimeException('No se encontró el usuario o ya fue eliminado.');
    }
    $stmt->close();

    echo json_encode([
        'ok'      => true,
        'message' => 'Usuario eliminado correctamente.',
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode([
        'ok'      => false,
        'message' => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}
