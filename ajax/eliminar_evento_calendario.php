<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../sistema_ticket/conexion.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new RuntimeException('Metodo no permitido.');
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1],
    ]);
    if ($id === false || $id === null) {
        throw new RuntimeException('El identificador del evento es invalido.');
    }

    $db = new Conexion();
    $conn = $db->getConexion();

    $stmt = $conn->prepare('DELETE FROM calendario_eventos WHERE id = ?');
    if (!$stmt) {
        throw new RuntimeException('No se pudo preparar la eliminacion.');
    }
    $stmt->bind_param('i', $id);
    if (!$stmt->execute()) {
        throw new RuntimeException('No se pudo eliminar el evento.');
    }
    $stmt->close();
    $db->cerrar();

    echo json_encode([
        'ok' => true,
        'message' => 'Evento eliminado correctamente.',
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'message' => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}
