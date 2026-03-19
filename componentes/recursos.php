<?php
require_once __DIR__ . '/class/conexion.php';
require_once __DIR__ . '/menu_cabecera.php';
require_once __DIR__ . '/auth.php';

$db = new Conexion();
$conn = $db->getConexion();
$menusCabecera = menus_cabezera($conn);
$paginaActual = basename($_SERVER['PHP_SELF'] ?? 'recursos.php');
$db->cerrar();
$usuarioSesion = obtenerUsuarioPanel();
$nombreUsuario = trim((string)(($usuarioSesion['nombre'] ?? '') !== '' ? $usuarioSesion['nombre'] : 'Cristian'));
$apellidoUsuario = trim((string)($usuarioSesion['apellido_paterno'] ?? ''));
$nombreCompletoUsuario = trim($nombreUsuario . ' ' . $apellidoUsuario);
$cargoUsuario = trim((string)(($usuarioSesion['cargo'] ?? '') !== '' ? $usuarioSesion['cargo'] : 'Equipo'));
$avatarUsuario = strtoupper(substr($nombreUsuario, 0, 1));

$dock = [
    ['icono' => '＋', 'titulo' => 'Agregar contenedor'],
    ['icono' => '📅', 'titulo' => 'Calendario'],
    ['icono' => '👥', 'titulo' => 'Contactos'],
    ['icono' => '📝', 'titulo' => 'Notas'],
];

$contenedores = [
    ['icono' => '🛟', 'titulo' => 'Mesa de ayuda', 'color' => '#7ee146'],
    ['icono' => '📇', 'titulo' => 'Directorio', 'color' => '#c6df5a'],
    ['icono' => '🕒', 'titulo' => 'Horarios', 'color' => '#6cdd56'],
    ['icono' => '📊', 'titulo' => 'Reportes', 'color' => '#f4c52d'],
    ['icono' => '✉️', 'titulo' => 'Boletines', 'color' => '#d5db54'],
    ['icono' => '❤️', 'titulo' => 'Beneficios', 'color' => '#ef6f7b'],
    ['icono' => '❓', 'titulo' => 'Preguntas', 'color' => '#f5a623'],
    ['icono' => '⭐', 'titulo' => 'Capacitacion', 'color' => '#7fe34c'],
];

$cards = [
    ['titulo' => 'Onboarding', 'texto' => 'Espacio provisional para definir recursos de bienvenida, manuales y pasos iniciales.'],
    ['titulo' => 'Beneficios', 'texto' => 'Aqui podriamos ordenar convenios, formularios internos y solicitudes frecuentes.'],
    ['titulo' => 'Apps y Herramientas', 'texto' => 'Zona para reunir accesos operativos, sistemas internos y material de trabajo diario.'],
    ['titulo' => 'Directorio Staff', 'texto' => 'Bloque tentativo para fichas, anexos, canales y responsables por area.'],
    ['titulo' => 'Formularios', 'texto' => 'Seccion reservada para ordenar formularios, plantillas y documentos recurrentes.'],
];
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Seduc Hub | Recursos</title>
  <style>
    :root{
      --primary:#2f57b7;
      --primary-700:#23449a;
      --bg:#eef2f5;
      --text:#0f172a;
      --muted:#64748b;
      --border:#dde5ef;
      --shadow:0 12px 30px rgba(15,23,42,.08);
      --container:1280px;
      --hero:#072f46;
      --hero-2:#083d57;
      --soft:#62788a;
      --soft-2:#70859a;
      --green:#86c33a;
      --mint:#7fcab2;
    }
    *{box-sizing:border-box}
    body{margin:0;font-family:ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Arial;background:var(--bg);color:var(--text)}
    .container{width:min(var(--container), calc(100% - 32px));margin-inline:auto}
    .topbar{position:sticky;top:0;z-index:80;background:#fff;border-bottom:1px solid var(--border)}
    .topbar__inner{display:flex;align-items:center;justify-content:space-between;gap:14px;padding:14px 0}
    .brand{display:flex;align-items:center;gap:12px}
    .brand__logo{width:42px;height:42px;border-radius:14px;background:linear-gradient(135deg,var(--primary),var(--primary-700));color:#fff;display:grid;place-items:center;font-weight:900}
    .brand__name{font-weight:900;line-height:1}
    .brand__tag{font-size:12px;color:var(--muted);margin-top:2px}
    .topbar__nav{display:flex;align-items:center;gap:14px}
    .navlink{font-weight:700;color:var(--muted);padding:10px 12px;border-radius:12px;text-decoration:none}
    .navlink:hover{background:#eef2ff;color:var(--text)}
    .navlink.is-active{background:#eef2ff;color:var(--primary)}
    .topbar__right{display:flex;gap:10px}
    .usermenu{position:relative}
    .userbtn{display:flex;align-items:center;gap:10px;padding:8px 10px;border-radius:18px;border:1px solid var(--border);background:rgba(255,255,255,.92);cursor:pointer;box-shadow:var(--shadow);transition:.15s ease}
    .userbtn:hover{background:#fff}
    .userbtn__avatar{width:36px;height:36px;border-radius:14px;display:grid;place-items:center;background:#eef2ff;color:var(--primary);font-weight:900}
    .userbtn__text{display:flex;flex-direction:column;line-height:1.05;text-align:left}
    .userbtn__name{font-weight:900;font-size:13px}
    .userbtn__role{font-weight:800;font-size:12px;color:var(--muted);margin-top:2px}
    .userbtn__chev{margin-left:6px;color:var(--muted);font-weight:900}
    .dropdown{position:absolute;right:0;top:calc(100% + 10px);width:220px;border-radius:16px;border:1px solid var(--border);background:rgba(255,255,255,.98);box-shadow:var(--shadow);padding:8px;display:none;z-index:120}
    .usermenu:hover .dropdown{display:block}
    .dropdown__item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:12px;font-weight:800;color:var(--text);text-decoration:none}
    .dropdown__item:hover{background:#eef2ff;color:var(--primary)}
    .dropdown__sep{height:1px;background:var(--border);margin:8px 6px}
    .dropdown__item--danger{color:#b91c1c}
    .dropdown__item--danger:hover{background:#fff1f2;color:#b91c1c}

    .resources-layout{
      min-height:calc(100vh - 73px);
      display:grid;
      grid-template-columns:68px minmax(0, 1fr);
    }
    .dock{
      background:#f4f6f8;
      border-right:1px solid var(--border);
      padding:14px 10px;
      display:flex;
      flex-direction:column;
      align-items:center;
      gap:10px;
    }
    .dock__btn{
      width:38px;
      height:38px;
      border:none;
      border-radius:12px;
      background:#fff;
      color:#475569;
      box-shadow:0 8px 18px rgba(15,23,42,.08);
      cursor:pointer;
      font-size:18px;
    }

    .resources-main{
      display:grid;
      grid-template-rows:auto 1fr;
    }
    .hero{
      position:relative;
      overflow:hidden;
      padding:24px 26px 34px;
      background:
        radial-gradient(circle at 0% 0%, rgba(134,195,58,.95) 0 58px, transparent 59px),
        linear-gradient(90deg, rgba(127,202,178,.22) 0 108px, transparent 108px),
        linear-gradient(180deg, rgba(127,202,178,.18) 0 86px, transparent 86px),
        linear-gradient(135deg, var(--hero), var(--hero-2));
    }
    .hero::before{
      content:"";
      position:absolute;
      left:0;
      top:0;
      width:116px;
      height:170px;
      background:
        radial-gradient(circle at 0 0, rgba(134,195,58,.92) 0 56px, transparent 57px),
        radial-gradient(circle at 100% 100%, rgba(127,202,178,.92) 0 54px, transparent 55px),
        linear-gradient(90deg, rgba(127,202,178,.25) 50%, rgba(127,202,178,.38) 50%);
      opacity:.95;
    }
    .hero::after{
      content:"";
      position:absolute;
      right:0;
      top:0;
      width:190px;
      height:100%;
      background:
        radial-gradient(circle at 100% 0, rgba(134,195,58,.95) 0 70px, transparent 71px),
        radial-gradient(circle at 34% 27%, rgba(127,202,178,.44) 0 38px, transparent 39px),
        radial-gradient(circle at 64% 47%, rgba(127,202,178,.88) 0 18px, transparent 19px),
        linear-gradient(180deg, transparent 0 150px, rgba(127,202,178,.72) 150px 52%, rgba(11,96,86,.72) 52% 100%);
      opacity:.98;
    }
    .hero__inner{
      position:relative;
      z-index:1;
      max-width:920px;
      margin:0 auto;
      display:flex;
      flex-direction:column;
      align-items:center;
      text-align:center;
      gap:24px;
      padding-top:18px;
    }
    .hero__title{
      margin:0;
      color:#fff8ef;
      font-size:clamp(30px, 5vw, 54px);
      line-height:1;
      font-weight:900;
      letter-spacing:-.03em;
    }
    .hero__search{
      width:min(640px, 100%);
      background:#fff;
      border-radius:999px;
      box-shadow:0 16px 34px rgba(0,0,0,.18);
      padding:12px 16px;
      display:flex;
      align-items:center;
      gap:10px;
    }
    .hero__search input{
      flex:1;
      border:none;
      outline:none;
      background:transparent;
      font-size:14px;
      font-weight:700;
      color:#475569;
    }
    .hero__circles{
      display:grid;
      grid-template-columns:repeat(8, minmax(0, 1fr));
      gap:18px;
      width:100%;
      margin-top:10px;
    }
    .circle-link{
      display:flex;
      flex-direction:column;
      align-items:center;
      gap:10px;
      text-decoration:none;
      color:#fff;
    }
    .circle-link__bubble{
      width:76px;
      height:76px;
      border-radius:999px;
      background:linear-gradient(180deg, var(--soft-2), var(--soft));
      border:2px solid rgba(255,255,255,.22);
      box-shadow:inset 0 0 0 1px rgba(255,255,255,.08);
      display:grid;
      place-items:center;
      position:relative;
    }
    .circle-link__bubble::after{
      content:"";
      position:absolute;
      inset:13px;
      border-radius:999px;
      background:var(--circle-color, #7ee146);
      opacity:.18;
    }
    .circle-link__icon{
      position:relative;
      z-index:1;
      font-size:32px;
      line-height:1;
    }
    .circle-link__title{
      margin:0;
      font-size:13px;
      font-weight:900;
      line-height:1.15;
      text-align:center;
      text-shadow:0 8px 16px rgba(0,0,0,.2);
    }

    .lower{
      background:#f4f5f7;
      padding:16px 18px 22px;
      border-top:1px solid #d7dee7;
    }
    .lower__tabs{
      display:flex;
      justify-content:center;
      gap:26px;
      flex-wrap:wrap;
      margin-bottom:18px;
    }
    .lower__tab{
      color:#475569;
      font-size:11px;
      font-weight:900;
      text-transform:none;
      text-decoration:none;
      padding-bottom:6px;
      border-bottom:2px solid transparent;
    }
    .lower__tab.is-active{
      color:#2f57b7;
      border-bottom-color:#2f57b7;
    }
    .lower__cards{
      display:grid;
      grid-template-columns:repeat(5, minmax(0, 1fr));
      gap:14px;
    }
    .lower-card{
      background:#fff;
      border:1px solid #dce3eb;
      border-radius:4px;
      overflow:hidden;
      box-shadow:0 8px 20px rgba(15,23,42,.06);
    }
    .lower-card__media{
      height:118px;
      background:
        linear-gradient(135deg, rgba(47,87,183,.2), rgba(134,195,58,.25)),
        url("https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=640&q=60");
      background-size:cover;
      background-position:center;
    }
    .lower-card:nth-child(2) .lower-card__media{background-image:linear-gradient(135deg, rgba(47,87,183,.18), rgba(134,195,58,.24)), url("https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=640&q=60")}
    .lower-card:nth-child(3) .lower-card__media{background-image:linear-gradient(135deg, rgba(47,87,183,.18), rgba(134,195,58,.24)), url("https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=640&q=60")}
    .lower-card:nth-child(4) .lower-card__media{background-image:linear-gradient(135deg, rgba(47,87,183,.18), rgba(134,195,58,.24)), url("https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=640&q=60")}
    .lower-card:nth-child(5) .lower-card__media{background-image:linear-gradient(135deg, rgba(47,87,183,.18), rgba(134,195,58,.24)), url("https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=640&q=60")}
    .lower-card__body{
      padding:12px 12px 14px;
    }
    .lower-card__title{
      margin:0 0 8px;
      font-size:13px;
      font-weight:900;
      color:#1e293b;
    }
    .lower-card__text{
      margin:0 0 12px;
      font-size:11px;
      line-height:1.45;
      color:#64748b;
      font-weight:700;
      min-height:64px;
    }
    .lower-card__link{
      color:#1e3a8a;
      font-size:11px;
      font-weight:900;
      text-decoration:none;
    }
    @media (max-width: 1180px){
      .hero__circles{grid-template-columns:repeat(4, minmax(0, 1fr))}
      .lower__cards{grid-template-columns:repeat(3, minmax(0, 1fr))}
    }
    @media (max-width: 860px){
      .topbar__nav{display:none}
      .resources-layout{grid-template-columns:1fr}
      .dock{
        flex-direction:row;
        justify-content:center;
        border-right:none;
        border-bottom:1px solid var(--border);
      }
      .hero{padding-inline:16px}
      .hero__circles{grid-template-columns:repeat(3, minmax(0, 1fr));gap:14px}
      .lower__cards{grid-template-columns:repeat(2, minmax(0, 1fr))}
    }
    @media (max-width: 560px){
      .hero__circles{grid-template-columns:repeat(2, minmax(0, 1fr))}
      .lower__cards{grid-template-columns:1fr}
      .hero__title{font-size:36px}
    }
  </style>
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
          <a class="navlink" href="index_2.php">Inicio</a>
          <a class="navlink" href="apps.php">Apps</a>
          <a class="navlink" href="contactos.php">Contactos</a>
          <a class="navlink" href="notas.php">Notas</a>
          <a class="navlink is-active" href="recursos.php">Recursos</a>
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
      <?php renderTopbarUserMenu([
          'avatar' => $avatarUsuario,
          'nombre' => $nombreCompletoUsuario !== '' ? $nombreCompletoUsuario : $nombreUsuario,
          'rol' => $cargoUsuario,
          'salir_href' => 'logout.php',
      ]); ?>
    </div>
  </header>

  <main class="resources-layout">
    <aside class="dock" aria-label="Acciones laterales">
      <?php foreach ($dock as $item): ?>
        <button class="dock__btn" type="button" title="<?= htmlspecialchars($item['titulo'], ENT_QUOTES, 'UTF-8') ?>">
          <?= htmlspecialchars($item['icono'], ENT_QUOTES, 'UTF-8') ?>
        </button>
      <?php endforeach; ?>
    </aside>

    <section class="resources-main">
      <section class="hero">
        <div class="hero__inner">
          <h1 class="hero__title">Bienvenido, <?= htmlspecialchars($nombreUsuario, ENT_QUOTES, 'UTF-8') ?></h1>

          <div class="hero__search" aria-label="Buscar recursos">
            <span>🔎</span>
            <input type="text" placeholder="Buscar formularios y plantillas" />
            <span style="color:#cbd5e1;font-weight:900;">×</span>
          </div>

          <div class="hero__circles" aria-label="Contenedores principales">
            <?php foreach ($contenedores as $item): ?>
              <a class="circle-link" href="#" style="--circle-color:<?= htmlspecialchars($item['color'], ENT_QUOTES, 'UTF-8') ?>;">
                <div class="circle-link__bubble">
                  <span class="circle-link__icon"><?= htmlspecialchars($item['icono'], ENT_QUOTES, 'UTF-8') ?></span>
                </div>
                <p class="circle-link__title"><?= htmlspecialchars($item['titulo'], ENT_QUOTES, 'UTF-8') ?></p>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section class="lower">
        <div class="lower__tabs" aria-label="Secciones secundarias">
          <a class="lower__tab is-active" href="#">Recursos del negocio</a>
          <a class="lower__tab" href="#">Centro del empleado</a>
          <a class="lower__tab" href="#">Departamentos y equipos</a>
          <a class="lower__tab" href="#">Comunidad y noticias</a>
        </div>

        <div class="lower__cards">
          <?php foreach ($cards as $card): ?>
            <article class="lower-card">
              <div class="lower-card__media"></div>
              <div class="lower-card__body">
                <h3 class="lower-card__title"><?= htmlspecialchars($card['titulo'], ENT_QUOTES, 'UTF-8') ?></h3>
                <p class="lower-card__text"><?= htmlspecialchars($card['texto'], ENT_QUOTES, 'UTF-8') ?></p>
                <a class="lower-card__link" href="#">Ver mas →</a>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </section>
    </section>
  </main>
</body>
</html>
