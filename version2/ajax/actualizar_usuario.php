<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../class/Conexion.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new RuntimeException('Método no permitido.');
    }

    $id       = (int)($_POST['id']               ?? 0);
    $nombre   = trim((string)($_POST['nombre']           ?? ''));
    $apPat    = trim((string)($_POST['apellido_paterno'] ?? ''));
    $apMat    = trim((string)($_POST['apellido_materno'] ?? ''));
    $email    = trim((string)($_POST['email']            ?? ''));
    $cargo    = trim((string)($_POST['cargo']            ?? ''));
    $telefono = trim((string)($_POST['telefono']         ?? ''));
    $sexo     = trim((string)($_POST['sexo']             ?? ''));
    $fechaNac = trim((string)($_POST['fecha_nacimiento'] ?? ''));
    $anexo    = trim((string)($_POST['anexo']            ?? ''));
    $idArea   = (int)($_POST['id_area_trabajo']          ?? 0);
    $identif  = trim((string)($_POST['identificador']    ?? ''));
    $estado   = trim((string)($_POST['estado']           ?? ''));

    if ($id <= 0) {
        throw new RuntimeException('Identificador de usuario inválido.');
    }
    if ($nombre === '') {
        throw new RuntimeException('El nombre es obligatorio.');
    }
    if ($apPat === '') {
        throw new RuntimeException('El apellido paterno es obligatorio.');
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new RuntimeException('El correo electrónico no es válido.');
    }
    if ($idArea <= 0) {
        throw new RuntimeException('Debe seleccionar un área de trabajo.');
    }

    $estadosValidos = ['Activo', 'Inactivo', 'Pendiente', 'Bloqueado'];
    if (!in_array($estado, $estadosValidos, true)) {
        $estado = 'Activo';
    }

    $db = Conexion::obtener();

    $chk = $db->prepare('SELECT id FROM usuarios WHERE email = ? AND id != ?');
    $chk->bind_param('si', $email, $id);
    $chk->execute();
    $chk->store_result();
    if ($chk->num_rows > 0) {
        $chk->close();
        throw new RuntimeException('Ese correo electrónico ya lo usa otro usuario.');
    }
    $chk->close();

    $fechaNacVal = $fechaNac !== '' ? $fechaNac : null;

    // 12 params: s×10, i×2 (id_area, id)
    $stmt = $db->prepare(
        'UPDATE usuarios
         SET nombre=?, apellido_paterno=?, apellido_materno=?, email=?,
             cargo=?, telefono=?, sexo=?, fecha_nacimiento=?, anexo=?,
             id_area_trabajo=?, identificador=?, estado=?
         WHERE id=?'
    );
    $stmt->bind_param(
        'sssssssssissi',
        $nombre, $apPat, $apMat, $email,
        $cargo, $telefono, $sexo, $fechaNacVal, $anexo,
        $idArea, $identif, $estado,
        $id
    );
    $stmt->execute();
    $stmt->close();

    /* Obtener nombre_area para devolver al frontend */
    $r = $db->prepare('SELECT nombre_area FROM area_trabajo WHERE id_area=?');
    $r->bind_param('i', $idArea);
    $r->execute();
    $res = $r->get_result()->fetch_assoc();
    $r->close();
    $nombreArea = $res['nombre_area'] ?? '—';

    echo json_encode([
        'ok'      => true,
        'message' => 'Usuario actualizado correctamente.',
        'usuario' => [
            'id'               => $id,
            'nombre'           => $nombre,
            'apellido_paterno' => $apPat,
            'apellido_materno' => $apMat,
            'email'            => $email,
            'cargo'            => $cargo,
            'telefono'         => $telefono,
            'sexo'             => $sexo,
            'estado'           => $estado,
            'anexo'            => $anexo,
            'id_area_trabajo'  => $idArea,
            'identificador'    => $identif,
            'nombre_area'      => $nombreArea,
        ],
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode([
        'ok'      => false,
        'message' => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}
