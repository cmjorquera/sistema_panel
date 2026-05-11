<?php
require_once __DIR__ . '/class/conexion.php';
require_once __DIR__ . '/componentes/rail_acciones.php';
require_once __DIR__ . '/componentes/panel_contactos.php';
require_once __DIR__ . '/componentes/keep_widget.php';

$menuCabeceraCandidates = [__DIR__ . '/componentes/menu_cabecera.php'];
$menuCabeceraPath = null;
foreach ($menuCabeceraCandidates as $c) { if (is_file($c)) { $menuCabeceraPath = $c; break; } }
if ($menuCabeceraPath === null) throw new RuntimeException('No se encontro menu_cabecera.php');
require_once $menuCabeceraPath;

$db = new Conexion();
$conn = $db->getConexion();
$menusCabecera = menus_cabezera($conn);
$paginaActual = basename($_SERVER['PHP_SELF'] ?? 'perfil.php');
$db->cerrar();

// Datos del perfil — conectar a tabla de usuarios cuando esté disponible
$perfil = [
    ['label' => 'Cargo',                           'valor' => 'Analista Programador'],
    ['label' => 'SEDES/Colegio',                   'valor' => 'SEDUC'],
    ['label' => 'Sub-Dirección',                   'valor' => 'Dirección General (Desarrollo de Sistemas)'],
    ['label' => 'Dirección',                        'valor' => 'SEDUC'],
    ['label' => 'Colegio',                          'valor' => 'SEDUC SPA'],
    ['label' => 'Centro de Costos',                'valor' => '7206 - Dir Gral. de Informática'],
    ['label' => 'Supervisor',                       'valor' => 'Ureta, Francisco Javier'],
    ['label' => 'Tipo Contrato',                   'valor' => 'Indefinido'],
    ['label' => 'Fecha Ingreso Compañía',          'valor' => '3 de mayo de 2021 (alrededor de 5 años)'],
    ['label' => 'Fecha Reconocimiento de Antigüedad', 'valor' => '3 de mayo de 2021 (alrededor de 5 años)'],
];
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Seduc Hub | Mi Perfil</title>
  <style>
    :root{
      --primary:#2f57b7; --primary-700:#23449a;
      --bg:#f6f8fe; --text:#0f172a; --muted:#64748b; --border:#e5eaf6;
      --shadow:0 10px 30px rgba(15,23,42,.10); --shadow-soft:0 8px 20px rgba(15,23,42,.08);
      --container:1280px;
    }
    *{box-sizing:border-box} body{margin:0;font-family:ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Arial;color:var(--text);background:var(--bg)}
    a{color:inherit;text-decoration:none}
    .container{width:min(var(--container),calc(100% - 36px));margin-inline:auto}
    .topbar{position:sticky;top:0;z-index:80;background:rgba(255,255,255,.92);backdrop-filter:blur(10px);border-bottom:1px solid var(--border)}
    .topbar__inner{display:flex;align-items:center;justify-content:space-between;gap:14px;padding:14px 0}
    .brand{display:flex;align-items:center;gap:12px}
    .brand__logo{width:42px;height:42px;border-radius:14px;background:linear-gradient(135deg,var(--primary),var(--primary-700));color:#fff;display:grid;place-items:center;font-weight:900;font-size:14px}
    .brand__name{font-weight:900;line-height:1} .brand__tag{font-size:12px;color:var(--muted);margin-top:2px}
    .topbar__nav{display:flex;align-items:center;gap:18px}
    .navlink{font-weight:700;color:var(--muted);padding:10px 12px;border-radius:12px}
    .navlink:hover{background:#eef2ff;color:var(--text)} .navlink.is-active{background:#eef2ff;color:var(--primary)}
    .usermenu{position:relative}
    .userbtn{display:flex;align-items:center;gap:10px;padding:8px 10px;border-radius:18px;border:1px solid var(--border);background:rgba(255,255,255,.82);backdrop-filter:blur(10px);cursor:pointer;box-shadow:var(--shadow-soft);transition:.15s ease}
    .userbtn:hover{background:#fff}
    .userbtn__avatar{width:36px;height:36px;border-radius:14px;display:grid;place-items:center;background:#eef2ff;color:var(--primary);font-weight:900}
    .userbtn__text{display:flex;flex-direction:column;line-height:1.05;text-align:left}
    .userbtn__name{font-weight:900;font-size:13px} .userbtn__role{font-weight:800;font-size:12px;color:var(--muted);margin-top:2px} .userbtn__chev{margin-left:6px;color:var(--muted);font-weight:900}
    .dropdown{position:absolute;right:0;top:calc(100% + 10px);width:220px;border-radius:16px;border:1px solid var(--border);background:rgba(255,255,255,.96);backdrop-filter:blur(10px);box-shadow:var(--shadow);padding:8px;display:none;z-index:120}
    .usermenu:hover .dropdown{display:block}
    .dropdown__item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:12px;font-weight:800;color:var(--text)}
    .dropdown__item:hover{background:#eef2ff;color:var(--primary)} .dropdown__sep{height:1px;background:var(--border);margin:8px 6px}
    .dropdown__item--danger{color:#b91c1c} .dropdown__item--danger:hover{background:#fff1f2;color:#b91c1c}

    /* PERFIL */
    .profile-hero{background:linear-gradient(135deg,var(--primary) 0%,var(--primary-700) 100%);padding:32px 0;color:#fff}
    .profile-hero__inner{display:flex;align-items:center;gap:20px}
    .profile-hero__avatar{width:72px;height:72px;border-radius:999px;background:rgba(255,255,255,.22);border:3px solid rgba(255,255,255,.5);display:grid;place-items:center;font-size:26px;font-weight:900}
    .profile-hero__name{margin:0 0 4px;font-size:22px;font-weight:900}
    .profile-hero__cargo{margin:0;font-size:14px;color:rgba(255,255,255,.8);font-weight:700}

    .profile-tabs{background:#fff;border-bottom:1px solid var(--border)}
    .tabs{display:flex;gap:0;padding:0;margin:0;list-style:none}
    .tab{display:block;padding:14px 20px;font-size:14px;font-weight:800;color:var(--muted);border-bottom:3px solid transparent;transition:.15s ease;white-space:nowrap}
    .tab:hover{color:var(--primary);border-bottom-color:rgba(47,87,183,.3)}
    .tab.is-active{color:var(--primary);border-bottom-color:var(--primary)}

    .profile-body{padding:32px 0 60px}
    .profile-card{background:#fff;border:1px solid var(--border);border-radius:18px;box-shadow:var(--shadow-soft);overflow:hidden}
    .profile-table{width:100%;border-collapse:collapse}
    .profile-table tr:not(:last-child) td{border-bottom:1px solid var(--border)}
    .profile-table td{padding:14px 20px;font-size:14px}
    .profile-table td:first-child{color:var(--muted);font-weight:800;width:42%;background:#fafbfd}
    .profile-table td:last-child{font-weight:700;color:var(--text)}

    @media(max-width:820px){.topbar__nav{display:none}.tabs{overflow-x:auto}.tab{padding:12px 14px;font-size:13px}}
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
      <div><div class="brand__name">Seduc Hub</div><div class="brand__tag">Portal Operativo</div></div>
    </div>
    <nav class="topbar__nav">
      <?php if (empty($menusCabecera)): ?>
        <a class="navlink" href="index_1.php">Inicio</a>
        <a class="navlink" href="beneficios.php">Beneficios</a>
      <?php else: ?>
        <?php foreach ($menusCabecera as $menu): ?>
          <?php $claseActiva = basename($menu['href']) === $paginaActual ? ' is-active' : ''; ?>
          <a class="navlink<?= $claseActiva ?>" href="<?= htmlspecialchars($menu['href'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($menu['menu'] ?: 'Menu', ENT_QUOTES, 'UTF-8') ?></a>
        <?php endforeach; ?>
      <?php endif; ?>
    </nav>
    <?php renderTopbarUserMenu(['editar_perfil_href' => 'perfil.php']); ?>
  </div>
</header>

<div class="profile-hero">
  <div class="container">
    <div class="profile-hero__inner">
      <div class="profile-hero__avatar">CJ</div>
      <div>
        <h1 class="profile-hero__name">Cristian Jorquera</h1>
        <p class="profile-hero__cargo">Analista Programador · SEDUC</p>
      </div>
    </div>
  </div>
</div>

<div class="profile-tabs">
  <div class="container">
    <nav class="tabs">
      <a class="tab is-active" href="perfil.php">Resumen</a>
      <a class="tab" href="liquidaciones.php">Liquidaciones</a>
      <a class="tab" href="documentos.php">Documentos</a>
      <a class="tab" href="#">Bitácora</a>
    </nav>
  </div>
</div>

<main class="profile-body">
  <div class="container">
    <div class="profile-card">
      <table class="profile-table">
        <?php foreach ($perfil as $fila): ?>
          <tr>
            <td><?= htmlspecialchars($fila['label'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($fila['valor'], ENT_QUOTES, 'UTF-8') ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
</main>

<?php renderRailAcciones(true); ?>
<?php renderPanelContactos(); ?>
</body>
</html>
