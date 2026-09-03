<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../class/Conexion.php';
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';
require_once __DIR__ . '/../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/** Genera un token aleatorio seguro de 64 caracteres. */
function generarToken(): string
{
    return bin2hex(random_bytes(32));
}

/** Envía el correo de bienvenida con el enlace para establecer contraseña. */
function enviarEmailBienvenida(string $email, string $nombre, string $token): void
{
    $enlace = 'https://qa.seduc.cl/jorquera/sistema_panel_qa/version2/restablecer.php?token=' . $token;

    $mail = new PHPMailer(true);
    $mail->IsSMTP();
    $mail->SMTPDebug  = SMTP::DEBUG_OFF;
    $mail->Host       = 'smtp.itdchile.cl';
    $mail->Port       = 46500;
    $mail->SMTPAuth   = true;
    $mail->Username   = 'm.gutierrez';
    $mail->Password   = 'Seduc2024.,';
    $mail->SMTPSecure = 'tcp';
    $mail->CharSet    = 'UTF-8';
    $mail->setFrom('seduc.informa@seduc.cl', 'SeducSPA');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Bienvenido/a a Seduc Hub – Configura tu contraseña';
    $nombreHtml    = htmlspecialchars($nombre, ENT_QUOTES);
    $mail->Body    = <<<HTML
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><style>
body{font-family:Arial,sans-serif;background:#f4f5f7;margin:0;padding:0}
.wrap{max-width:560px;margin:32px auto;background:#fff;border-radius:10px;overflow:hidden;border:1px solid #e5e7eb}
.hd{background:#005B96;padding:28px 32px;text-align:center}
.hd h1{color:#fff;font-size:20px;margin:0}
.hd p{color:rgba(255,255,255,.75);font-size:13px;margin:6px 0 0}
.bd{padding:32px}
.bd p{color:#3f424a;font-size:14px;line-height:1.6;margin:0 0 16px}
.btn{display:inline-block;background:#005B96;color:#fff;text-decoration:none;padding:12px 28px;border-radius:8px;font-size:14px;font-weight:600;margin:8px 0 20px}
.note{font-size:12px;color:#6b7280;background:#f9fafb;border-radius:6px;padding:12px 16px;border:1px solid #e5e7eb}
.ft{text-align:center;padding:16px 32px;border-top:1px solid #f3f4f6;font-size:11px;color:#9ca3af}
</style></head>
<body>
<div class="wrap">
  <div class="hd"><h1>Seduc Hub</h1><p>Portal Operativo SEDUC Chile</p></div>
  <div class="bd">
    <p>Hola <strong>{$nombreHtml}</strong>,</p>
    <p>Tu cuenta en <strong>Seduc Hub</strong> ha sido creada exitosamente. Para acceder al sistema, primero debes establecer tu contraseña:</p>
    <a href="{$enlace}" class="btn">Establecer mi contraseña</a>
    <div class="note">
      <strong>Importante:</strong> Este enlace es personal e intransferible. Expira en 48&nbsp;horas.<br>
      Si no solicitaste esta cuenta, puedes ignorar este mensaje.
    </div>
  </div>
  <div class="ft">SEDUC Chile &middot; Secretaría de Educación</div>
</div>
</body></html>
HTML;
    $mail->AltBody = "Hola {$nombre}, bienvenido/a a Seduc Hub. Establece tu contraseña en: {$enlace}";
    $mail->send();
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new RuntimeException('Método no permitido.');
    }

    $nombre    = trim((string)($_POST['nombre']           ?? ''));
    $apPat     = trim((string)($_POST['apellido_paterno'] ?? ''));
    $apMat     = trim((string)($_POST['apellido_materno'] ?? ''));
    $email     = trim((string)($_POST['email']            ?? ''));
    $cargo     = trim((string)($_POST['cargo']            ?? ''));
    $telefono  = trim((string)($_POST['telefono']         ?? ''));
    $sexo      = trim((string)($_POST['sexo']             ?? ''));
    $fechaNac  = trim((string)($_POST['fecha_nacimiento'] ?? ''));
    $anexo     = trim((string)($_POST['anexo']            ?? ''));
    $idArea    = (int)($_POST['id_area_trabajo']          ?? 0);
    $identif   = trim((string)($_POST['identificador']    ?? ''));

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

    $db = Conexion::obtener();

    $chk = $db->prepare('SELECT id FROM usuarios WHERE email = ?');
    $chk->bind_param('s', $email);
    $chk->execute();
    $chk->store_result();
    if ($chk->num_rows > 0) {
        $chk->close();
        throw new RuntimeException('Ya existe un usuario con ese correo electrónico.');
    }
    $chk->close();

    $token = generarToken();
    $clave = password_hash(bin2hex(random_bytes(16)), PASSWORD_BCRYPT);
    $fechaNacVal = $fechaNac !== '' ? $fechaNac : null;

    // 13 params: s×10, i×1, s×2
    $stmt = $db->prepare(
        'INSERT INTO usuarios
            (nombre, apellido_paterno, apellido_materno, email, clave,
             cargo, telefono, sexo, fecha_nacimiento, anexo,
             id_area_trabajo, identificador, estado, token_reinicio, fecha_creacion)
         VALUES (?,?,?,?,?, ?,?,?,?,?, ?,?,\'Pendiente\',?, NOW())'
    );
    $stmt->bind_param(
        'ssssssssssiss',
        $nombre, $apPat, $apMat, $email, $clave,
        $cargo, $telefono, $sexo, $fechaNacVal, $anexo,
        $idArea, $identif, $token
    );
    $stmt->execute();
    $nuevoId = $db->insert_id;
    $stmt->close();

    enviarEmailBienvenida($email, $nombre . ' ' . $apPat, $token);

    echo json_encode([
        'ok'      => true,
        'message' => 'Usuario creado. Correo de bienvenida enviado a ' . $email . '.',
        'usuario' => [
            'id'              => $nuevoId,
            'nombre'          => $nombre,
            'apellido_paterno' => $apPat,
            'apellido_materno' => $apMat,
            'email'           => $email,
            'cargo'           => $cargo,
            'telefono'        => $telefono,
            'sexo'            => $sexo,
            'estado'          => 'Pendiente',
            'anexo'           => $anexo,
            'id_area_trabajo' => $idArea,
            'identificador'   => $identif,
            'nombre_area'     => '',
            'fecha_creacion'  => date('d/m/Y'),
        ],
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode([
        'ok'      => false,
        'message' => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}
