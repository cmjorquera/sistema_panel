<?php
require_once __DIR__ . '/class/conexion.php';
require_once __DIR__ . '/rail_acciones.php';
require_once __DIR__ . '/panel_contactos.php';
require_once __DIR__ . '/keep_widget.php';
$menuCabeceraCandidates = [
    __DIR__ . '/menu_cabecera.php',
    dirname(__DIR__) . '/componentes/menu_cabecera.php',
    __DIR__ . '/../sistema_ticket/menu_cabecera.php',
    dirname(__DIR__) . '/sistema_ticket/menu_cabecera.php',
];

$menuCabeceraPath = null;
foreach ($menuCabeceraCandidates as $candidate) {
    if (is_file($candidate)) {
        $menuCabeceraPath = $candidate;
        break;
    }
}

if ($menuCabeceraPath === null) {
    throw new RuntimeException('No se encontro menu_cabecera.php en rutas esperadas.');
}

require_once $menuCabeceraPath;

$db = new Conexion();
$conn = $db->getConexion();
$menusCabecera = menus_cabezera($conn);
$paginaActual = basename($_SERVER['PHP_SELF'] ?? 'notas.php');
$db->cerrar();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Seduc Hub | Notas</title>
  <style>
    :root{
      --primary:#2f57b7; --primary-700:#23449a;
      --bg:#f6f8fe; --text:#0f172a; --muted:#64748b; --border:#e5eaf6;
      --shadow:0 10px 30px rgba(15,23,42,.10);
      --container:1200px;
    }
    *{box-sizing:border-box}
    body{margin:0;font-family:ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Arial;color:var(--text);background:var(--bg)}
    .container{width:min(var(--container), calc(100% - 36px)); margin-inline:auto}
    .topbar{position:sticky;top:0;z-index:80;background:rgba(255,255,255,.88);backdrop-filter:blur(10px);border-bottom:1px solid var(--border)}
    .topbar__inner{display:flex;align-items:center;justify-content:space-between;gap:14px;padding:14px 0}
    .brand{display:flex;align-items:center;gap:12px}
    .brand__logo{width:42px;height:42px;border-radius:14px;background:linear-gradient(135deg,var(--primary),var(--primary-700));color:#fff;display:grid;place-items:center;font-weight:900}
    .brand__name{font-weight:900;line-height:1}
    .brand__tag{font-size:12px;color:var(--muted);margin-top:2px}
    .topbar__nav{display:flex;align-items:center;gap:18px}
    .navlink{font-weight:700;color:var(--muted);padding:10px 12px;border-radius:12px;text-decoration:none}
    .navlink:hover{background:#eef2ff;color:var(--text)}
    .navlink.is-active{background:#eef2ff;color:var(--primary)}
    .topbar__right{display:flex;gap:10px}
    .usermenu{position:relative}
    .userbtn{display:flex;align-items:center;gap:10px;padding:8px 10px;border-radius:18px;border:1px solid var(--border);background:rgba(255,255,255,.82);backdrop-filter:blur(10px);cursor:pointer;box-shadow:var(--shadow);transition:.15s ease}
    .userbtn:hover{background:#fff}
    .userbtn__avatar{width:36px;height:36px;border-radius:14px;display:grid;place-items:center;background:#eef2ff;color:var(--primary);font-weight:900}
    .userbtn__text{display:flex;flex-direction:column;line-height:1.05;text-align:left}
    .userbtn__name{font-weight:900;font-size:13px}
    .userbtn__role{font-weight:800;font-size:12px;color:var(--muted);margin-top:2px}
    .userbtn__chev{margin-left:6px;color:var(--muted);font-weight:900}
    .dropdown{position:absolute;right:0;top:calc(100% + 10px);width:220px;border-radius:16px;border:1px solid var(--border);background:rgba(255,255,255,.96);backdrop-filter:blur(10px);box-shadow:var(--shadow);padding:8px;display:none;z-index:120}
    .usermenu:hover .dropdown{display:block}
    .dropdown__item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:12px;font-weight:800;color:var(--text);text-decoration:none}
    .dropdown__item:hover{background:#eef2ff;color:var(--primary)}
    .dropdown__sep{height:1px;background:var(--border);margin:8px 6px}
    .dropdown__item--danger{color:#b91c1c}
    .dropdown__item--danger:hover{background:#fff1f2;color:#b91c1c}
    .panel{margin:32px auto;padding:24px;border:1px solid var(--border);border-radius:16px;background:#fff;box-shadow:var(--shadow)}
    h1{margin:0 0 10px}
    p{margin:0;color:var(--muted)}
  </style>
  <?php renderRailAccionesStyles(); ?>
  <?php renderPanelContactosStyles(); ?>
  <?php renderKeepWidgetHead(); ?>
</head>
<body>
  <header class="topbar">
    <div class="container topbar__inner">
      <div class="brand">
        <div class="brand__logo">SH</div>
        <div>
          <div class="brand__name">Seduc Hub</div>
          <div class="brand__tag">Portal Operativo</div>
        </div>
      </div>
      <nav class="topbar__nav">
        <?php if (empty($menusCabecera)): ?>
          <a class="navlink" href="index.php">Inicio</a>
          <a class="navlink" href="apps.php">Apps</a>
          <a class="navlink" href="contactos.php">Contactos</a>
          <a class="navlink is-active" href="notas.php">Notas</a>
        <?php else: ?>
          <?php foreach ($menusCabecera as $menu): ?>
            <?php
              $hrefMenu = htmlspecialchars($menu['href'], ENT_QUOTES, 'UTF-8');
              $textoMenu = htmlspecialchars($menu['menu'] !== '' ? $menu['menu'] : 'Menu', ENT_QUOTES, 'UTF-8');
              $archivoMenu = basename($menu['href']);
              $claseActiva = $archivoMenu === $paginaActual ? ' is-active' : '';
            ?>
            <a class="navlink<?= $claseActiva ?>" href="<?= $hrefMenu ?>"><?= $textoMenu ?></a>
          <?php endforeach; ?>
        <?php endif; ?>
      </nav>
      <?php renderTopbarUserMenu(); ?>
    </div>
  </header>

  <main class="container">
    <section class="panel">
      <!-- <h1>Notas</h1>
      <p>Aqui puedes gestionar notas, recordatorios y pendientes.</p> -->
    </section>
    <?php renderKeepWidget(); ?>
  </main>
  <?php renderRailAcciones(true); ?>
  <?php renderPanelContactos(); ?>
</body>
</html>
