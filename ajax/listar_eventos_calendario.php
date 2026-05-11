<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../sistema_ticket/conexion.php';

try {
    $db = new Conexion();
    $conn = $db->getConexion();

    $start = trim((string)($_GET['start'] ?? ''));
    $end = trim((string)($_GET['end'] ?? ''));

    if ($start === '' || $end === '') {
        echo json_encode([], JSON_UNESCAPED_UNICODE);
        $db->cerrar();
        exit;
    }

    $sql = 'SELECT id, id_usuario, titulo, descripcion, fecha_inicio, fecha_fin, todo_el_dia, color
            FROM calendario_eventos
            WHERE fecha_inicio < ?
              AND (fecha_fin IS NULL OR fecha_fin >= ?)
            ORDER BY fecha_inicio ASC';
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new RuntimeException('No se pudo preparar la consulta del calendario.');
    }

    $stmt->bind_param('ss', $end, $start);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $eventos = [];
    while ($fila = $resultado->fetch_assoc()) {
        $eventos[] = [
            'id' => (int)$fila['id'],
            'title' => (string)$fila['titulo'],
            'start' => (string)$fila['fecha_inicio'],
            'end' => $fila['fecha_fin'] !== null ? (string)$fila['fecha_fin'] : null,
            'allDay' => (int)$fila['todo_el_dia'] === 1,
            'backgroundColor' => (string)($fila['color'] ?? '#2563eb'),
            'borderColor' => (string)($fila['color'] ?? '#2563eb'),
            'descripcion' => (string)($fila['descripcion'] ?? ''),
            'id_usuario' => (int)($fila['id_usuario'] ?? 1),
        ];
    }

    $stmt->close();
    $db->cerrar();

    echo json_encode($eventos, JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'message' => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}
