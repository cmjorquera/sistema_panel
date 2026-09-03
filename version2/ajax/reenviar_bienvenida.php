<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../class/Conexion.php';
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';
require_once __DIR__ . '/../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/** Genera o reutiliza el token de reinicio para el usuario. */
function obtenerOGenerarToken(mysqli $db, int $id): string
{
    $r = $db->prepare('SELECT token_reinicio FROM usuarios WHERE id = ?');
    $r->bind_param('i', $id);
    $r->execute();
    $row   = $r->get_result()->fetch_assoc();
    $r->close();

    if (!empty($row['token_reinicio'])) {
        return $row['token_reinicio'];
    }

    $token = bin2hex(random_bytes(32));
    $u = $db->prepare('UPDATE usuarios SET token_reinicio = ? WHERE id = ?');
    $u->bind_param('si', $token, $id);
    $u->execute();
    $u->close();

    return $token;
}

/** Envía el correo de bienvenida con el enlace para establecer contraseña. */
function enviarEmailBienvenida(string $email, string $nombre, string $token): void
{
    $enlace     = 'https://qa.seduc.cl/jorquera/sistema_panel_qa/version2/restablecer.php?token=' . $token;
    $nombreHtml = htmlspecialchars($nombre, ENT_QUOTES);

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
    <p>Se te ha enviado nuevamente el enlace para configurar tu acceso a <strong>Seduc Hub</strong>. Haz clic a continuación para establecer tu contraseña:</p>
    <a href="{$enlace}" class="btn">Establecer mi contraseña</a>
    <div class="note">
      <strong>Importante:</strong> Este enlace es personal e intransferible. Expira en 48&nbsp;horas.<br>
      Si no solicitaste este acceso, puedes ignorar este mensaje.
    </div>
  </div>
  <div class="ft">SEDUC Chile &middot; Secretaría de Educación</div>
</div>
</body></html>
HTML;
    $mail->AltBody = "Hola {$nombre}, establece tu contraseña en Seduc Hub: {$enlace}";
    $mail->send();
}

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

    $db  = Conexion::obtener();
    $r   = $db->prepare('SELECT nombre, apellido_paterno, email FROM usuarios WHERE id = ?');
    $r->bind_param('i', $id);
    $r->execute();
    $usuario = $r->get_result()->fetch_assoc();
    $r->close();

    if (!$usuario) {
        throw new RuntimeException('No se encontró el usuario.');
    }

    $token  = obtenerOGenerarToken($db, $id);
    $nombre = $usuario['nombre'] . ' ' . $usuario['apellido_paterno'];

    enviarEmailBienvenida($usuario['email'], $nombre, $token);

    echo json_encode([
        'ok'      => true,
        'message' => 'Correo de bienvenida reenviado a ' . $usuario['email'] . '.',
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode([
        'ok'      => false,
        'message' => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}
