<?php
require_once 'class/Sesion.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (!empty($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

// TODO: quitar modo demo y restaurar autenticación real
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Sesion::crear([
        'id'     => 1,
        'nombre' => 'Cristian Jorquera',
        'perfil' => 'Administrador',
    ]);
    header('Location: index.php');
    exit;
}

$error = '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Iniciar sesión — SEDUC Chile</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="css/tokens.css"/>
<link rel="stylesheet" href="css/login.css"/>
</head>
<body>

<div class="login-page">

  <!-- Panel de marca (izquierda) -->
  <div class="login-brand">
    <div class="login-brand-bg"></div>
    <div class="login-brand-dot"></div>
    <div class="logo">
      <div class="logo-icon">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
      </div>
      <div class="logo-text"><strong>SEDUC Chile</strong><span>Servicio de Educación</span></div>
    </div>
    <div class="tagline">
      <div class="line"></div>
      <h1>Sistema Panel Central</h1>
      <p>Plataforma institucional para la gestión administrativa, académica y operacional de los establecimientos educacionales bajo dependencia SEDUC.</p>
      <p class="quote">"Educar para servir."</p>
    </div>
    <footer>© 2026 Servicio Local de Educación Pública</footer>
  </div>

  <!-- Formulario de login (derecha) -->
  <div class="login-form-wrap">
    <div class="login-box">
      <h2>Iniciar sesión</h2>
      <p class="sub">Acceso restringido a personal autorizado.</p>

      <?php if ($error !== ''): ?>
      <div class="login-error visible"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" action="login.php" autocomplete="off">
        <div class="form-group">
          <label class="field-label">Correo institucional</label>
          <input class="input" type="email" name="usuario"
                 value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>"
                 placeholder="usuario@seduc.cl" required/>
        </div>
        <div class="form-group">
          <div class="form-group-row">
            <label class="field-label" style="margin:0">Contraseña</label>
            <a href="#">¿Olvidaste tu clave?</a>
          </div>
          <input class="input" type="password" name="password"
                 placeholder="••••••••" style="margin-top:6px" required/>
        </div>
        <label class="login-check">
          <input type="checkbox" name="recordar" checked/> Mantener sesión iniciada
        </label>
        <button class="login-submit" type="submit">Ingresar al panel</button>
      </form>

      <p class="login-footer">Al continuar aceptas los términos de uso y la política de privacidad institucional.</p>
    </div>
  </div>

</div>

</body>
</html>
