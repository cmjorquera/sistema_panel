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
    $titulo = trim((string)($_POST['titulo'] ?? ''));
    $descripcion = trim((string)($_POST['descripcion'] ?? ''));
    $fechaInicio = trim((string)($_POST['fecha_inicio'] ?? ''));
    $fechaFin = trim((string)($_POST['fecha_fin'] ?? ''));
    $todoElDia = isset($_POST['todo_el_dia']) ? 1 : 0;
    $color = trim((string)($_POST['color'] ?? '#2563eb'));
    $idUsuario = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1],
    ]);

    if ($titulo === '') {
        throw new RuntimeException('El titulo es obligatorio.');
    }
    if ($idUsuario === false || $idUsuario === null) {
        throw new RuntimeException('Debes seleccionar un usuario.');
    }
    if ($fechaInicio === '') {
        throw new RuntimeException('La fecha de inicio es obligatoria.');
    }
    if ($fechaFin === '') {
        $fechaFin = null;
    }
    if ($fechaFin !== null && $fechaFin < $fechaInicio) {
        throw new RuntimeException('La fecha final no puede ser menor a la inicial.');
    }

    $db = new Conexion();
    $conn = $db->getConexion();

    if ($id) {
        $sql = 'UPDATE calendario_eventos
                SET id_usuario = ?, titulo = ?, descripcion = ?, fecha_inicio = ?, fecha_fin = ?, todo_el_dia = ?, color = ?
                WHERE id = ?';
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new RuntimeException('No se pudo preparar la actualizacion del evento.');
        }
        $stmt->bind_param('issssisi', $idUsuario, $titulo, $descripcion, $fechaInicio, $fechaFin, $todoElDia, $color, $id);
        if (!$stmt->execute()) {
            throw new RuntimeException('No se pudo actualizar el evento.');
        }
        $stmt->close();
    } else {
        $sql = 'INSERT INTO calendario_eventos (id_usuario, titulo, descripcion, fecha_inicio, fecha_fin, todo_el_dia, color)
                VALUES (?, ?, ?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new RuntimeException('No se pudo preparar la insercion del evento.');
        }
        $stmt->bind_param('issssis', $idUsuario, $titulo, $descripcion, $fechaInicio, $fechaFin, $todoElDia, $color);
        if (!$stmt->execute()) {
            throw new RuntimeException('No se pudo guardar el evento.');
        }
        $id = $stmt->insert_id;
        $stmt->close();
    }

    $db->cerrar();

    echo json_encode([
        'ok' => true,
        'message' => 'Evento guardado correctamente.',
        'evento' => [
            'id' => $id,
            'id_usuario' => $idUsuario,
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'todo_el_dia' => $todoElDia,
            'color' => $color,
        ],
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'message' => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}
