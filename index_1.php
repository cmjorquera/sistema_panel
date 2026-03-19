<?php

require_once __DIR__ . '/class/conexion.php';
require_once __DIR__ . '/componentes/rail_acciones.php';
require_once __DIR__ . '/componentes/panel_contactos.php';
require_once __DIR__ . '/componentes/keep_widget.php';
$menuCabeceraCandidates = [
    __DIR__ . '/componentes/menu_cabecera.php',
    dirname(__DIR__) . '/componentes/menu_cabecera.php',
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

function normalizarUrl(string $url): string
{
    $url = trim($url);
    if ($url === '') {
        return '#';
    }

    // Si no trae esquema, asumimos https para que abra correctamente.
    if (!preg_match('~^[a-z][a-z0-9+.-]*://~i', $url)) {
        return 'https://' . ltrim($url, '/');
    }

    return $url;
}

function construirSrcImagen(string $imagen): string
{
    $imagen = trim($imagen);
    if ($imagen === '') {
        return 'imagenes/google.png';
    }

    // Evita rutas externas o traversal y usa solo el nombre del archivo.
    $archivo = basename($imagen);
    $rutaFisica = __DIR__ . '/imagenes/' . $archivo;

    if (!is_file($rutaFisica)) {
        return 'imagenes/google.png';
    }

    // Soporta nombres con espacios.
    return 'imagenes/' . rawurlencode($archivo);
}

function obtenerContenedores(mysqli $conn): array
{
    $sql = "SELECT id, nombre, url_, imagen
            FROM contenedor
            WHERE id_usuario = 1
            ORDER BY id ASC";
    $resultado = $conn->query($sql);

    if (!$resultado) {
        return [];
    }

    $contenedores = [];
    while ($fila = $resultado->fetch_assoc()) {
        $contenedores[] = $fila;
    }
    $resultado->free();

    return $contenedores;
}

$db = new Conexion();
$conn = $db->getConexion();
$menusCabecera = menus_cabezera($conn);
$paginaActual = basename($_SERVER['PHP_SELF'] ?? 'index.php');
$contenedores = obtenerContenedores($conn);
$db->cerrar();
?>


<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Seduc Hub | Launcher</title>
  <link rel="stylesheet" href="css/index_2.css" />
</head>
<style>

/* =========================
   TOKENS (mismo estilo elegante)
   ========================= */
:root{
  --primary:#2f57b7; --primary-700:#23449a;
  --accent:#f5b338;  --accent-700:#e7a423;

  --bg:#f6f8fe;
  --surface:#ffffff;
  --text:#0f172a;
  --muted:#64748b;
  --border:#e5eaf6;

  --radius:16px;
  --shadow:0 10px 30px rgba(15,23,42,.10);
  --shadow-soft:0 8px 20px rgba(15,23,42,.08);

  --container:1200px;
}

*{box-sizing:border-box}
html,body{height:100%}
body{
  margin:0;
  font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial;
  color:var(--text);
  background: var(--bg);
}
a{color:inherit;text-decoration:none}
.container{width:min(var(--container), calc(100% - 36px)); margin-inline:auto}

/* =========================
   HEADER (igual al que te gustó)
   ========================= */
.topbar{
  position:sticky; top:0; z-index:80;
  background: rgba(255,255,255,.88);
  backdrop-filter: blur(10px);
  border-bottom:1px solid var(--border);
}
.topbar__inner{
  display:flex; align-items:center; justify-content:space-between;
  gap:14px;
  padding:14px 0;
}
.brand{display:flex;align-items:center;gap:12px}
.brand__logo{
  width:42px;height:42px;border-radius:14px;
  background: linear-gradient(135deg, var(--primary), var(--primary-700));
  color:#fff; display:grid; place-items:center;
  font-weight:900; letter-spacing:.4px;
  box-shadow: var(--shadow-soft);
}
.brand__name{font-weight:900;line-height:1}
.brand__tag{font-size:12px;color:var(--muted);margin-top:2px}

.topbar__nav{display:flex;align-items:center;gap:18px}
.navlink{
  font-weight:700; color:var(--muted);
  padding:10px 12px; border-radius:12px;
}
.navlink:hover{background:#eef2ff;color:var(--text)}
.navlink.is-active{background:#eef2ff;color:var(--primary)}

.topbar__right{display:flex;gap:10px}

/* Buttons */
.btn{
  border:1px solid transparent;
  border-radius:14px;
  padding:10px 14px;
  font-weight:800;
  cursor:pointer;
  transition:.15s ease;
}
.btn:active{transform:translateY(1px)}
.btn--primary{background:var(--primary);color:#fff;box-shadow:var(--shadow-soft)}
.btn--primary:hover{background:var(--primary-700)}
.btn--ghost{background:transparent;border-color:var(--border);color:var(--text)}
.btn--ghost:hover{background:#fff;box-shadow:var(--shadow-soft)}

/* =========================
   STAGE (fondo + grid)
   ========================= */
.stage{
  position:relative;
  min-height: calc(100vh - 74px);
  padding: 18px 0 30px;
  overflow:hidden;
}

/* Fondo tipo foto + velo */
.stage__bg{
  position:absolute; inset:0;
  /* Cambia esta imagen por una tuya local */
  background:
    linear-gradient(180deg, rgba(0,0,0,.20), rgba(0,0,0,.20)),
    url("https://images.unsplash.com/photo-1500375592092-40eb2168fd21?auto=format&fit=crop&w=1800&q=60");
  background-size: cover;
  background-position:center;
  transform: scale(1.02);
  filter: saturate(1.05);
}

/* Contenido por encima del fondo */
.stage__inner{
  position:relative;
  z-index:2;
}

/* =========================
   SEARCHBAR (arriba)
   ========================= */
.searchbar{
  width:100%;
  display:flex;
  align-items:center;
  gap:10px;
  padding:12px 14px;
  border-radius:16px;
  background: rgba(255,255,255,.92);
  border:1px solid rgba(229,234,246,.8);
  box-shadow: var(--shadow);
  margin-bottom: 18px;
}
.searchbar__icon{
  width:38px;height:38px;border-radius:14px;
  display:grid;place-items:center;
  background:#eef2ff;color:var(--primary);
  font-weight:900;
}
.searchbar__input{
  flex:1;
  border:none;
  outline:none;
  background:transparent;
  font-size:14px;
  font-weight:700;
  color:var(--text);
}

/* =========================
   TILES GRID (idéntico a tu captura)
   ========================= */
.tiles{
  display:grid;
  grid-template-columns: repeat(6, 1fr);
  gap: 18px;
  padding-right: 86px; /* espacio para la rail derecha */
}

/* Tile grande y “glass” */
.tile{
  position:relative;
  border-radius: 16px;
  background: rgba(255,255,255,.18);
  border:1px solid rgba(255,255,255,.24);
  box-shadow: 0 14px 35px rgba(0,0,0,.18);
  overflow:visible;
  min-height: 120px;
  backdrop-filter: blur(8px);
  transition: .15s ease;
}
.tile:hover{
  transform: translateY(-2px);
  box-shadow: 0 18px 45px rgba(0,0,0,.22);
}
.tile__link{
  position:absolute;
  inset:0;
  display:block;
  z-index:1;
}
.tile__actions{
  position:absolute;
  top:10px;
  right:10px;
  z-index:4;
  opacity:0;
  transform:translateY(-4px);
  transition:opacity .15s ease, transform .15s ease;
}
.tile:hover .tile__actions,
.tile__actions.is-open{
  opacity:1;
  transform:translateY(0);
}
.tile__menu-btn{
  width:32px;
  height:32px;
  border:none;
  border-radius:999px;
  background:rgba(15,23,42,.56);
  color:#fff;
  cursor:pointer;
  font-size:18px;
  font-weight:900;
  display:grid;
  place-items:center;
  box-shadow:0 10px 24px rgba(15,23,42,.22);
  backdrop-filter:blur(8px);
}
.tile__menu-btn:hover{ background:rgba(15,23,42,.72); }
.tile__menu{
  position:absolute;
  top:calc(100% + 8px);
  right:0;
  min-width:112px;
  padding:6px;
  border-radius:12px;
  border:1px solid rgba(255,255,255,.5);
  background:rgba(255,255,255,.96);
  box-shadow:0 18px 40px rgba(15,23,42,.22);
  display:none;
}
.tile__actions.is-open .tile__menu{
  display:grid;
  gap:6px;
}
.tile__menu-item{
  border:none;
  border-radius:8px;
  padding:8px 10px;
  text-align:left;
  background:transparent;
  color:#0f172a;
  font-size:13px;
  font-weight:800;
  cursor:pointer;
}
.tile__menu-item:hover{
  background:#eef2ff;
  color:#2f57b7;
}
.tile__menu-item--danger{
  color:#b91c1c;
}
.tile__menu-item--danger:hover{
  background:#fff1f2;
  color:#b91c1c;
}

/* “Tarjeta interior” clara como en la captura */
.tile__media{
  position:absolute; inset:10px;
  border-radius: 12px;
  background: rgba(255,255,255,.68);
  border:1px solid rgba(255,255,255,.55);
  overflow:hidden;
  display:grid;
  place-items:center;
}

/* Imagen del logo */
.tile__media img{
  width:100%;
  height:100%;
  object-fit: cover;
  display:block;
}

/* =========================
   RESPONSIVE
   ========================= */
@media (max-width: 1200px){
  .tiles{ grid-template-columns: repeat(4, 1fr); }
}
@media (max-width: 820px){
  .topbar__nav{ display:none; }
  .tiles{ grid-template-columns: repeat(2, 1fr); padding-right: 0; }
  .tile__actions{ opacity:1; transform:none; }
}
@media (max-width: 520px){
  .tiles{ grid-template-columns: 1fr; }
}
/* ===== User menu (header) ===== */
.usermenu{
  position: relative;
}

.userbtn{
  display:flex;
  align-items:center;
  gap:10px;
  padding:8px 10px;
  border-radius:18px;
  border:1px solid var(--border);
  background: rgba(255,255,255,.82);
  backdrop-filter: blur(10px);
  cursor:pointer;
  box-shadow: var(--shadow-soft);
  transition:.15s ease;
}
.userbtn:hover{
  background:#fff;
  box-shadow: var(--shadow);
}

.userbtn__avatar{
  width:36px;height:36px;
  border-radius:14px;
  display:grid;place-items:center;
  background:#eef2ff;
  color: var(--primary);
  font-weight:900;
}
.userbtn__text{
  display:flex;
  flex-direction:column;
  line-height:1.05;
  text-align:left;
}
.userbtn__name{
  font-weight:900;
  font-size:13px;
}
.userbtn__role{
  font-weight:800;
  font-size:12px;
  color: var(--muted);
  margin-top:2px;
}
.userbtn__chev{
  margin-left:6px;
  color: var(--muted);
  font-weight:900;
}

/* Dropdown */
.dropdown{
  position:absolute;
  right:0;
  top: calc(100% + 10px);
  width: 220px;
  border-radius: 16px;
  border: 1px solid var(--border);
  background: rgba(255,255,255,.96);
  backdrop-filter: blur(10px);
  box-shadow: var(--shadow);
  padding:8px;
  display:none;
  z-index:120;
}

.usermenu:hover .dropdown{
  display:block; /* simple y efectivo */
}

.dropdown__item{
  display:flex;
  align-items:center;
  gap:10px;
  padding:10px 12px;
  border-radius: 12px;
  font-weight:800;
  color: var(--text);
}
.dropdown__item:hover{
  background:#eef2ff;
  color: var(--primary);
}
.dropdown__sep{
  height:1px;
  background: var(--border);
  margin:8px 6px;
}
.dropdown__item--danger{
  color:#b91c1c;
}
.dropdown__item--danger:hover{
  background:#fff1f2;
  color:#b91c1c;
}

/* =========================
   NEWSBAR (barra inferior elegante)
   ========================= */

.newsbar{
  position: fixed;
  bottom: 16px;
  left: 50%;
  transform: translateX(-50%);
  width: min(900px, calc(100% - 32px));
  z-index: 95;
}

.newsbar__inner{
  display:flex;
  align-items:center;
  gap:14px;
  padding:14px 18px;
  border-radius: 18px;
  background: rgba(255,255,255,.92);
  backdrop-filter: blur(10px);
  border: 1px solid var(--border);
  box-shadow: 0 20px 45px rgba(15,23,42,.18);
  font-weight: 700;
}

.newsbar__icon{
  width:40px;
  height:40px;
  border-radius: 14px;
  display:grid;
  place-items:center;
  background: #fff7ed;
  border:1px solid #fed7aa;
  font-size:18px;
}

.newsbar__text{
  flex:1;
  font-size:14px;
  color: var(--text);
}

.newsbar__highlight{
  color: var(--primary);
  font-weight:900;
}

.newsbar__close{
  border:none;
  background:transparent;
  font-size:16px;
  cursor:pointer;
  color: var(--muted);
  font-weight:900;
}

.newsbar__close:hover{
  color: var(--text);
}
</style>
<?php renderRailAccionesStyles(); ?>
<?php renderPanelContactosStyles(); ?>
<?php renderKeepWidgetHead(); ?>


<body class="launcher">

  <!-- HEADER (el que te gustó) -->
  <header class="topbar">
    <div class="container topbar__inner">
      <div class="brand">
        <div class="brand__logo">SH</div>
        <div class="brand__text">
          <div class="brand__name">Seduc Hub</div>
          <div class="brand__tag">Portal Operativo</div>
        </div>
      </div>

      <nav class="topbar__nav">
        <?php if (empty($menusCabecera)): ?>
          <a class="navlink is-active" href="index.php">Inicio</a>
          <a class="navlink" href="apps.php">Apps</a>
          <a class="navlink" href="contactos.php">Contactos</a>
          <a class="navlink" href="notas.php">Notas</a>
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

      <?php renderTopbarUserMenu(['rol' => 'Técnico']); ?>
    </div>
  </header>

  <!-- MAIN (fondo + buscador + mosaicos) -->
  <main class="stage">
    <div class="stage__bg"></div>

    <div class="container stage__inner">

      <!-- Barra de búsqueda (como tu captura) -->
      <div class="searchbar">
        <span class="searchbar__icon">🔎</span>
        <input class="searchbar__input" placeholder="Buscar acceso..." />
      </div>

      <!-- GRID de accesos grandes -->
      <section class="tiles" aria-label="Accesos directos">
        <?php if (empty($contenedores)): ?>
          <p style="color:#fff;font-weight:800;">No hay accesos en la tabla contenedor.</p>
        <?php else: ?>
          <?php foreach ($contenedores as $item): ?>
            <?php
              $idContenedor = (int)($item['id'] ?? 0);
              $nombrePlano = (string)($item['nombre'] ?? 'Sin nombre');
              $urlPlano = (string)($item['url_'] ?? '');
              $imagenPlano = (string)($item['imagen'] ?? '');
              $nombre = htmlspecialchars($item['nombre'] ?? 'Sin nombre', ENT_QUOTES, 'UTF-8');
              $href = htmlspecialchars(normalizarUrl($item['url_'] ?? ''), ENT_QUOTES, 'UTF-8');
              $src = construirSrcImagen($imagenPlano);
              $src = htmlspecialchars($src, ENT_QUOTES, 'UTF-8');
              $nombreData = htmlspecialchars($nombrePlano, ENT_QUOTES, 'UTF-8');
              $urlData = htmlspecialchars($urlPlano, ENT_QUOTES, 'UTF-8');
              $imagenData = htmlspecialchars($imagenPlano, ENT_QUOTES, 'UTF-8');
            ?>
            <article class="tile" data-tile-id="<?= $idContenedor ?>" data-tile-nombre="<?= $nombreData ?>" data-tile-url="<?= $urlData ?>" data-tile-imagen="<?= $imagenData ?>">
              <a class="tile__link" href="<?= $href ?>" title="<?= $nombre ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= $nombre ?>"></a>
              <div class="tile__actions">
                <button class="tile__menu-btn" type="button" aria-label="Abrir acciones del contenedor" data-tile-menu-toggle>⋯</button>
                <div class="tile__menu" role="menu">
                  <button class="tile__menu-item" type="button" data-tile-edit>Editar</button>
                  <button class="tile__menu-item tile__menu-item--danger" type="button" data-tile-delete>Eliminar</button>
                </div>
              </div>
              <div class="tile__media">
                <img src="<?= $src ?>" alt="<?= $nombre ?>" onerror="this.onerror=null;this.src='imagenes/google.png';" />
              </div>
            </article>
          <?php endforeach; ?>
        <?php endif; ?>

      </section>
    </div>

    <?php renderRailAcciones(true); ?>
    <?php renderPanelContactos(); ?>
    <?php renderKeepModalOnly(); ?>

  </main>
<!-- Barra informativa inferior -->

</body>
</html>