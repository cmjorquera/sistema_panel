<?php
require_once __DIR__ . '/class/conexion.php';
require_once __DIR__ . '/componentes/rail_acciones.php';
require_once __DIR__ . '/componentes/panel_contactos.php';
require_once __DIR__ . '/componentes/keep_widget.php';

$menuCabeceraCandidates = [
    __DIR__ . '/componentes/menu_cabecera.php',
];
$menuCabeceraPath = null;
foreach ($menuCabeceraCandidates as $candidate) {
    if (is_file($candidate)) { $menuCabeceraPath = $candidate; break; }
}
if ($menuCabeceraPath === null) {
    throw new RuntimeException('No se encontro menu_cabecera.php en rutas esperadas.');
}
require_once $menuCabeceraPath;

$db = new Conexion();
$conn = $db->getConexion();
$menusCabecera = menus_cabezera($conn);
$paginaActual = basename($_SERVER['PHP_SELF'] ?? 'beneficios.php');

$tipos = [];
$resT = $conn->query("SELECT id_tipo, nombre, icono FROM tipo_convenio ORDER BY orden ASC");
if ($resT) {
    while ($t = $resT->fetch_assoc()) $tipos[] = $t;
    $resT->free();
}

$convenios = [];
$resC = $conn->query("
    SELECT c.*, t.nombre AS tipo_nombre, t.icono AS tipo_icono
    FROM convenios c
    LEFT JOIN tipo_convenio t ON c.id_tipo = t.id_tipo
    WHERE c.activo = 1
    ORDER BY c.destacado DESC, c.id_convenio ASC
");
if ($resC) {
    while ($row = $resC->fetch_assoc()) $convenios[] = $row;
    $resC->free();
}

$destacados = array_values(array_filter($convenios, fn($c) => (int)($c['destacado'] ?? 0) === 1));

$db->cerrar();

function srcConvenio(string $img): string {
    $img = trim($img);
    if ($img === '') return '';
    $f = basename($img);
    $ruta = __DIR__ . '/imagenes/' . $f;
    return is_file($ruta) ? 'imagenes/' . rawurlencode($f) : '';
}

$placeholderColors = ['#3B6D11', '#c8a84b', '#5F5E5A', '#2f57b7', '#1d4ed8'];
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Seduc Hub | Beneficios y Convenios</title>
  <style>
    :root{
      --primary:#2f57b7; --primary-700:#23449a;
      --green:#3B6D11; --green-light:#4a8a16;
      --gold:#c8a84b; --gold-light:#d4b86a;
      --gray:#5F5E5A;
      --bg:#f6f8fe; --text:#0f172a; --muted:#64748b; --border:#e5eaf6;
      --shadow:0 10px 30px rgba(15,23,42,.10);
      --shadow-soft:0 8px 20px rgba(15,23,42,.08);
      --container:1280px;
    }
    *{box-sizing:border-box}
    body{margin:0;font-family:ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Arial;color:var(--text);background:var(--bg)}
    a{color:inherit;text-decoration:none}
    .container{width:min(var(--container),calc(100% - 36px));margin-inline:auto}

    /* TOPBAR */
    .topbar{position:sticky;top:0;z-index:80;background:rgba(255,255,255,.92);backdrop-filter:blur(10px);border-bottom:1px solid var(--border)}
    .topbar__inner{display:flex;align-items:center;justify-content:space-between;gap:14px;padding:14px 0}
    .brand{display:flex;align-items:center;gap:12px}
    .brand__logo{width:42px;height:42px;border-radius:14px;background:linear-gradient(135deg,var(--primary),var(--primary-700));color:#fff;display:grid;place-items:center;font-weight:900;font-size:14px}
    .brand__name{font-weight:900;line-height:1}
    .brand__tag{font-size:12px;color:var(--muted);margin-top:2px}
    .topbar__nav{display:flex;align-items:center;gap:18px}
    .navlink{font-weight:700;color:var(--muted);padding:10px 12px;border-radius:12px}
    .navlink:hover{background:#eef2ff;color:var(--text)}
    .navlink.is-active{background:#eef2ff;color:var(--primary)}
    .topbar__right{display:flex;gap:10px}
    .usermenu{position:relative}
    .userbtn{display:flex;align-items:center;gap:10px;padding:8px 10px;border-radius:18px;border:1px solid var(--border);background:rgba(255,255,255,.82);backdrop-filter:blur(10px);cursor:pointer;box-shadow:var(--shadow-soft);transition:.15s ease}
    .userbtn:hover{background:#fff}
    .userbtn__avatar{width:36px;height:36px;border-radius:14px;display:grid;place-items:center;background:#eef2ff;color:var(--primary);font-weight:900}
    .userbtn__text{display:flex;flex-direction:column;line-height:1.05;text-align:left}
    .userbtn__name{font-weight:900;font-size:13px}
    .userbtn__role{font-weight:800;font-size:12px;color:var(--muted);margin-top:2px}
    .userbtn__chev{margin-left:6px;color:var(--muted);font-weight:900}
    .dropdown{position:absolute;right:0;top:calc(100% + 10px);width:220px;border-radius:16px;border:1px solid var(--border);background:rgba(255,255,255,.96);backdrop-filter:blur(10px);box-shadow:var(--shadow);padding:8px;display:none;z-index:120}
    .usermenu:hover .dropdown{display:block}
    .dropdown__item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:12px;font-weight:800;color:var(--text)}
    .dropdown__item:hover{background:#eef2ff;color:var(--primary)}
    .dropdown__sep{height:1px;background:var(--border);margin:8px 6px}
    .dropdown__item--danger{color:#b91c1c}
    .dropdown__item--danger:hover{background:#fff1f2;color:#b91c1c}

    /* HERO / BUSCADOR */
    .hero{
      background:linear-gradient(135deg,var(--green) 0%,#2a5009 60%,#1a3506 100%);
      padding:40px 0 32px;
      color:#fff;
    }
    .hero__title{margin:0 0 6px;font-size:28px;font-weight:900}
    .hero__sub{margin:0 0 24px;color:rgba(255,255,255,.78);font-size:15px;font-weight:700}
    .hero__search{
      display:flex;align-items:center;gap:12px;
      background:rgba(255,255,255,.12);backdrop-filter:blur(8px);
      border:1px solid rgba(255,255,255,.25);border-radius:16px;
      padding:12px 16px;max-width:560px;
    }
    .hero__search-icon{font-size:20px;opacity:.8}
    .hero__search-input{
      flex:1;border:none;outline:none;background:transparent;
      color:#fff;font-size:15px;font-weight:700;
    }
    .hero__search-input::placeholder{color:rgba(255,255,255,.55)}

    /* CAROUSEL */
    .carousel-wrap{padding:28px 0 0}
    .carousel-wrap__label{font-size:12px;font-weight:900;text-transform:uppercase;letter-spacing:.08em;color:var(--gold);margin-bottom:12px}
    .carousel{position:relative;border-radius:22px;overflow:hidden;box-shadow:0 20px 50px rgba(15,23,42,.18)}
    .carousel__track{display:flex;transition:transform .45s cubic-bezier(.4,0,.2,1)}
    .carousel__slide{
      min-width:100%;height:260px;position:relative;
      display:flex;align-items:flex-end;
      flex-shrink:0;
    }
    .carousel__slide-bg{
      position:absolute;inset:0;
      background-size:cover;background-position:center;
    }
    .carousel__slide-overlay{
      position:absolute;inset:0;
      background:linear-gradient(180deg,transparent 30%,rgba(0,0,0,.72) 100%);
    }
    .carousel__slide-content{
      position:relative;z-index:2;padding:24px 28px;width:100%;
      display:flex;align-items:flex-end;justify-content:space-between;gap:16px;
    }
    .carousel__slide-empresa{margin:0 0 4px;font-size:22px;font-weight:900;color:#fff}
    .carousel__slide-desc{margin:0;font-size:14px;color:rgba(255,255,255,.82);font-weight:700;max-width:520px}
    .carousel__slide-badge{
      flex-shrink:0;
      background:var(--gold);color:#0f172a;
      font-size:18px;font-weight:900;
      border-radius:14px;padding:10px 16px;white-space:nowrap;
      box-shadow:0 8px 20px rgba(0,0,0,.22);
    }
    .carousel__btn{
      position:absolute;top:50%;transform:translateY(-50%);
      width:44px;height:44px;border-radius:999px;
      border:2px solid rgba(255,255,255,.4);
      background:rgba(0,0,0,.35);backdrop-filter:blur(6px);
      color:#fff;font-size:22px;font-weight:900;
      cursor:pointer;z-index:5;display:grid;place-items:center;
      transition:.15s ease;
    }
    .carousel__btn:hover{background:rgba(0,0,0,.55)}
    .carousel__btn--prev{left:14px}
    .carousel__btn--next{right:14px}
    .carousel__dots{
      position:absolute;bottom:12px;left:50%;transform:translateX(-50%);
      display:flex;gap:6px;z-index:5;
    }
    .carousel__dot{
      width:8px;height:8px;border-radius:999px;
      background:rgba(255,255,255,.45);border:none;cursor:pointer;
      transition:.15s ease;padding:0;
    }
    .carousel__dot.is-active{background:#fff;width:20px}

    /* FILTROS */
    .filters-bar{
      padding:24px 0 0;
      display:flex;gap:10px;flex-wrap:wrap;align-items:center;
    }
    .filter-pill{
      border:1px solid var(--border);border-radius:999px;
      padding:8px 16px;font-size:13px;font-weight:800;
      background:#fff;color:var(--muted);cursor:pointer;
      transition:.15s ease;
    }
    .filter-pill:hover{border-color:var(--green);color:var(--green)}
    .filter-pill.is-active{
      background:var(--green);border-color:var(--green);color:#fff;
    }

    /* GRID DE CARDS */
    .cards-section{padding:20px 0 60px}
    .cards-empty{
      padding:40px;text-align:center;color:var(--muted);
      font-weight:800;font-size:15px;display:none;
    }
    .cards-grid{
      display:grid;
      grid-template-columns:repeat(5,minmax(0,1fr));
      gap:18px;margin-top:20px;
    }
    .bcard{
      border-radius:18px;background:#fff;
      border:1px solid var(--border);
      box-shadow:var(--shadow-soft);
      overflow:hidden;
      transition:.15s ease;
      display:flex;flex-direction:column;
    }
    .bcard:hover{transform:translateY(-3px);box-shadow:var(--shadow)}
    .bcard__media{
      position:relative;height:140px;overflow:hidden;
      background:#f1f5f9;
      display:grid;place-items:center;
    }
    .bcard__media img{width:100%;height:100%;object-fit:cover;display:block}
    .bcard__placeholder{
      width:100%;height:100%;
      display:grid;place-items:center;
      font-size:28px;font-weight:900;color:rgba(255,255,255,.9);
      letter-spacing:-.5px;
    }
    .bcard__badge{
      position:absolute;top:10px;right:10px;
      background:var(--gold);color:#0f172a;
      font-size:11px;font-weight:900;
      border-radius:8px;padding:4px 8px;
      box-shadow:0 4px 12px rgba(0,0,0,.18);
    }
    .bcard__body{padding:14px 16px 16px;display:flex;flex-direction:column;flex:1;gap:8px}
    .bcard__tipo{
      display:inline-flex;align-items:center;gap:5px;
      background:#f0fdf4;color:var(--green);
      border:1px solid #bbf7d0;border-radius:999px;
      font-size:11px;font-weight:800;padding:3px 10px;width:fit-content;
    }
    .bcard__empresa{margin:0;font-size:15px;font-weight:900;color:var(--text);line-height:1.2}
    .bcard__desc{
      margin:0;font-size:13px;color:var(--muted);font-weight:700;
      line-height:1.5;
      display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;
      flex:1;
    }
    .bcard__btn{
      display:block;text-align:center;
      background:linear-gradient(135deg,var(--green),var(--green-light));
      color:#fff;font-size:13px;font-weight:900;
      border-radius:12px;padding:9px 14px;
      transition:.15s ease;margin-top:auto;
    }
    .bcard__btn:hover{opacity:.88;transform:translateY(-1px)}

    @media(max-width:1100px){.cards-grid{grid-template-columns:repeat(4,1fr)}}
    @media(max-width:820px){
      .topbar__nav{display:none}
      .cards-grid{grid-template-columns:repeat(3,1fr)}
      .hero{padding:28px 0 24px}
    }
    @media(max-width:560px){.cards-grid{grid-template-columns:repeat(2,1fr)}}
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
        <a class="navlink" href="../index_1.php">Inicio</a>
        <a class="navlink" href="apps.php">Apps</a>
        <a class="navlink" href="contactos.php">Contactos</a>
        <a class="navlink is-active" href="beneficios.php">Beneficios</a>
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

<!-- HERO + BUSCADOR -->
<section class="hero">
  <div class="container">
    <h1 class="hero__title">Beneficios y Convenios</h1>
    <p class="hero__sub">Descuentos exclusivos para funcionarios de Seduc</p>
    <div class="hero__search">
      <span class="hero__search-icon">🔎</span>
      <input class="hero__search-input" id="buscarConvenio" placeholder="Buscar empresa o beneficio..." autocomplete="off" />
    </div>
  </div>
</section>

<main class="container">

  <!-- CARRUSEL DE DESTACADOS -->
  <?php if (!empty($destacados)): ?>
  <div class="carousel-wrap">
    <div class="carousel-wrap__label">⭐ Destacados del mes</div>
    <div class="carousel" id="carousel">
      <div class="carousel__track" id="carouselTrack">
        <?php foreach ($destacados as $i => $d):
          $src = srcConvenio((string)($d['imagen'] ?? ''));
          $empresa = htmlspecialchars($d['empresa'] ?? '', ENT_QUOTES, 'UTF-8');
          $desc = htmlspecialchars($d['descripcion'] ?? '', ENT_QUOTES, 'UTF-8');
          $descuento = htmlspecialchars($d['descuento'] ?? '', ENT_QUOTES, 'UTF-8');
          $color = $placeholderColors[$i % count($placeholderColors)];
        ?>
          <div class="carousel__slide">
            <?php if ($src): ?>
              <div class="carousel__slide-bg" style="background-image:url('<?= $src ?>')"></div>
            <?php else: ?>
              <div class="carousel__slide-bg" style="background:<?= $color ?>"></div>
            <?php endif; ?>
            <div class="carousel__slide-overlay"></div>
            <div class="carousel__slide-content">
              <div>
                <h2 class="carousel__slide-empresa"><?= $empresa ?></h2>
                <p class="carousel__slide-desc"><?= $desc ?></p>
              </div>
              <?php if ($descuento): ?>
                <div class="carousel__slide-badge"><?= $descuento ?></div>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <?php if (count($destacados) > 1): ?>
        <button class="carousel__btn carousel__btn--prev" id="carouselPrev" aria-label="Anterior">‹</button>
        <button class="carousel__btn carousel__btn--next" id="carouselNext" aria-label="Siguiente">›</button>
        <div class="carousel__dots" id="carouselDots">
          <?php foreach ($destacados as $i => $_): ?>
            <button class="carousel__dot <?= $i === 0 ? 'is-active' : '' ?>" data-index="<?= $i ?>" aria-label="Ir a slide <?= $i + 1 ?>"></button>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <?php endif; ?>

  <!-- FILTROS -->
  <?php if (!empty($tipos)): ?>
  <div class="filters-bar" id="filterBar">
    <button class="filter-pill is-active" data-tipo="0">Todos</button>
    <?php foreach ($tipos as $tipo): ?>
      <button class="filter-pill" data-tipo="<?= (int)$tipo['id_tipo'] ?>">
        <?php if (!empty($tipo['icono'])): ?><?= htmlspecialchars($tipo['icono'], ENT_QUOTES, 'UTF-8') ?>&nbsp;<?php endif; ?>
        <?= htmlspecialchars($tipo['nombre'], ENT_QUOTES, 'UTF-8') ?>
      </button>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <!-- GRID -->
  <section class="cards-section">
    <p class="cards-empty" id="cardsEmpty">No se encontraron beneficios con ese criterio.</p>
    <div class="cards-grid" id="cardsGrid">
      <?php foreach ($convenios as $i => $c):
        $src = srcConvenio((string)($c['imagen'] ?? ''));
        $empresa = htmlspecialchars($c['empresa'] ?? '', ENT_QUOTES, 'UTF-8');
        $desc = htmlspecialchars($c['descripcion'] ?? '', ENT_QUOTES, 'UTF-8');
        $descuento = htmlspecialchars($c['descuento'] ?? '', ENT_QUOTES, 'UTF-8');
        $url = htmlspecialchars($c['url'] ?? '#', ENT_QUOTES, 'UTF-8');
        $tipoNombre = htmlspecialchars($c['tipo_nombre'] ?? '', ENT_QUOTES, 'UTF-8');
        $tipoIcono = htmlspecialchars($c['tipo_icono'] ?? '', ENT_QUOTES, 'UTF-8');
        $tipoId = (int)($c['id_tipo'] ?? 0);
        $color = $placeholderColors[$i % count($placeholderColors)];
        $inicialEmpresa = mb_strtoupper(mb_substr(strip_tags($c['empresa'] ?? '?'), 0, 2, 'UTF-8'), 'UTF-8');
      ?>
        <article class="bcard" data-empresa="<?= mb_strtolower($c['empresa'] ?? '', 'UTF-8') ?>" data-tipo="<?= $tipoId ?>">
          <div class="bcard__media">
            <?php if ($src): ?>
              <img src="<?= $src ?>" alt="<?= $empresa ?>" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.style.display='grid'" />
              <div class="bcard__placeholder" style="background:<?= $color ?>;display:none"><?= $inicialEmpresa ?></div>
            <?php else: ?>
              <div class="bcard__placeholder" style="background:<?= $color ?>"><?= $inicialEmpresa ?></div>
            <?php endif; ?>
            <?php if ($descuento): ?>
              <span class="bcard__badge"><?= $descuento ?></span>
            <?php endif; ?>
          </div>
          <div class="bcard__body">
            <?php if ($tipoNombre): ?>
              <span class="bcard__tipo"><?= $tipoIcono ? $tipoIcono . ' ' : '' ?><?= $tipoNombre ?></span>
            <?php endif; ?>
            <h3 class="bcard__empresa"><?= $empresa ?></h3>
            <p class="bcard__desc"><?= $desc ?></p>
            <?php if ($url && $url !== '#'): ?>
              <a class="bcard__btn" href="<?= $url ?>" target="_blank" rel="noopener noreferrer">Ver beneficio →</a>
            <?php endif; ?>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

</main>

<?php renderRailAcciones(true); ?>
<?php renderPanelContactos(); ?>
<?php renderKeepModalOnly(); ?>

<script>
/* ---- CAROUSEL ---- */
(function() {
    const track = document.getElementById('carouselTrack');
    if (!track) return;
    const total = track.children.length;
    if (total <= 1) return;

    let current = 0;
    const dots = document.querySelectorAll('.carousel__dot');

    function goTo(n) {
        current = (n + total) % total;
        track.style.transform = `translateX(-${current * 100}%)`;
        dots.forEach((d, i) => d.classList.toggle('is-active', i === current));
    }

    document.getElementById('carouselPrev')?.addEventListener('click', () => goTo(current - 1));
    document.getElementById('carouselNext')?.addEventListener('click', () => goTo(current + 1));
    dots.forEach(d => d.addEventListener('click', () => goTo(+d.dataset.index)));

    let timer = setInterval(() => goTo(current + 1), 4000);
    document.getElementById('carousel').addEventListener('mouseenter', () => clearInterval(timer));
    document.getElementById('carousel').addEventListener('mouseleave', () => { timer = setInterval(() => goTo(current + 1), 4000); });
})();

/* ---- FILTROS ---- */
let filtroTipo = 0;
let filtroTexto = '';

function aplicarFiltros() {
    const cards = document.querySelectorAll('.bcard');
    let visibles = 0;
    cards.forEach(card => {
        const empresa = (card.dataset.empresa || '').toLowerCase();
        const tipo = parseInt(card.dataset.tipo || '0');
        const matchTexto = !filtroTexto || empresa.includes(filtroTexto);
        const matchTipo = filtroTipo === 0 || tipo === filtroTipo;
        const visible = matchTexto && matchTipo;
        card.style.display = visible ? '' : 'none';
        if (visible) visibles++;
    });
    const empty = document.getElementById('cardsEmpty');
    if (empty) empty.style.display = visibles === 0 ? 'block' : 'none';
}

document.getElementById('buscarConvenio')?.addEventListener('input', function() {
    filtroTexto = this.value.toLowerCase().trim();
    aplicarFiltros();
});

document.querySelectorAll('.filter-pill').forEach(pill => {
    pill.addEventListener('click', function() {
        document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('is-active'));
        this.classList.add('is-active');
        filtroTipo = parseInt(this.dataset.tipo || '0');
        aplicarFiltros();
    });
});
</script>

</body>
</html>
