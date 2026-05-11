<?php
require_once __DIR__ . '/componentes/auth.php';
require_once __DIR__ . '/sistema_ticket/conexion.php';

iniciarSesionPanel();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$email = trim((string)($_POST['email'] ?? ''));
$claveIngresada = (string)($_POST['clave'] ?? '');

if ($email === '' || $claveIngresada === '') {
    header('Location: login.php?error=' . urlencode('Debes ingresar correo y clave.'));
    exit;
}

try {
    $db = new Conexion();
    $conn = $db->getConexion();

    $stmt = $conn->prepare('SELECT id, nombre, apellido_paterno, apellido_materno, email, clave, cargo, intentos_fallidos, estado, foto FROM usuarios WHERE email = ? LIMIT 1');
    if (!$stmt) {
        throw new RuntimeException('No se pudo preparar la consulta de acceso.');
    }

    $stmt->bind_param('s', $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado ? $resultado->fetch_assoc() : null;
    $stmt->close();

    if (!$usuario) {
        $db->cerrar();
        header('Location: login.php?error=' . urlencode('Usuario no válido.'));
        exit;
    }

    $intentos = (int)($usuario['intentos_fallidos'] ?? 0);
    if ($intentos >= 3) {
        $db->cerrar();
        header('Location: login.php?error=' . urlencode('Usuario bloqueado por 3 intentos fallidos.'));
        exit;
    }

    $claveGuardada = (string)($usuario['clave'] ?? '');
    $claveCorrecta = hash_equals($claveGuardada, $claveIngresada);

    if (!$claveCorrecta && str_starts_with($claveGuardada, '$2y$')) {
        $claveCorrecta = password_verify($claveIngresada, $claveGuardada);
    }

    if (!$claveCorrecta) {
        $nuevoIntento = $intentos + 1;
        $idUsuario = (int)$usuario['id'];
        $stmtError = $conn->prepare('UPDATE usuarios SET intentos_fallidos = ? WHERE id = ?');
        if ($stmtError) {
            $stmtError->bind_param('ii', $nuevoIntento, $idUsuario);
            $stmtError->execute();
            $stmtError->close();
        }
        $db->cerrar();

        $mensaje = $nuevoIntento >= 3
            ? 'Clave incorrecta. Usuario bloqueado por 3 intentos fallidos.'
            : 'Clave incorrecta. Intento ' . $nuevoIntento . ' de 3.';

        header('Location: login.php?error=' . urlencode($mensaje));
        exit;
    }

    $idUsuario = (int)$usuario['id'];
    $stmtReset = $conn->prepare('UPDATE usuarios SET intentos_fallidos = 0 WHERE id = ?');
    if ($stmtReset) {
        $stmtReset->bind_param('i', $idUsuario);
        $stmtReset->execute();
        $stmtReset->close();
    }

    guardarUsuarioPanel([
        'id' => $idUsuario,
        'nombre' => trim((string)($usuario['nombre'] ?? '')),
        'apellido_paterno' => trim((string)($usuario['apellido_paterno'] ?? '')),
        'apellido_materno' => trim((string)($usuario['apellido_materno'] ?? '')),
        'email' => (string)($usuario['email'] ?? ''),
        'cargo' => trim((string)($usuario['cargo'] ?? '')),
        'foto' => trim((string)($usuario['foto'] ?? '')),
    ]);

    $db->cerrar();
    header('Location: recursos.php');
    exit;
} catch (Throwable $e) {
    header('Location: login.php?error=' . urlencode('No fue posible validar el acceso.'));
    exit;
}
