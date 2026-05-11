<?php

require_once __DIR__ . '/class/conexion.php';
require_once __DIR__ . '/componentes/rail_acciones.php';
require_once __DIR__ . '/componentes/panel_contactos.php';
require_once __DIR__ . '/componentes/keep_widget.php';
require_once __DIR__ . '/componentes/topbar.php';
require_once __DIR__ . '/modelos/ContenedorModelo.php';

function normalizarUrl(string $url): string
{
    $url = trim($url);
    if ($url === '') {
        return '#';
    }
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
    $archivo = basename($imagen);
    $rutaFisica = __DIR__ . '/imagenes/' . $archivo;
    if (!is_file($rutaFisica)) {
        return 'imagenes/google.png';
    }
    return 'imagenes/' . rawurlencode($archivo);
}

$db = new Conexion();
$conn = $db->getConexion();
$contenedorModelo = new ContenedorModelo($conn);
$menusCabecera = menus_cabezera($conn);
$paginaActual = basename($_SERVER['PHP_SELF'] ?? 'index.php');
$contenedores = $contenedorModelo->obtener(1);
$db->cerrar();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Seduc Hub | Launcher</title>
  <link rel="stylesheet" href="css/index.css" />
  <link rel="stylesheet" href="css/topbar.css" />
  <link rel="stylesheet" href="css/rail.css" />
  <link rel="stylesheet" href="css/keep.css" />
  <link rel="stylesheet" href="css/contactos.css" />
</head>
<?php renderRailAccionesStyles(); ?>
<?php renderPanelContactosStyles(); ?>
<?php renderKeepWidgetHead(); ?>

<body class="launcher">

  <?php renderTopbar($menusCabecera, $paginaActual); ?>

  <main class="stage">
    <div class="stage__bg"></div>

    <div class="container stage__inner">

      <!-- Barra de búsqueda -->
      <div class="searchbar">
        <span class="searchbar__icon">🔎</span>
        <input class="searchbar__input"
               placeholder="Buscar acceso..."
               oninput="filtrarTiles(this.value)" />
      </div>

      <!-- Grid de accesos directos -->
      <section class="tiles" aria-label="Accesos directos">
        <?php if (empty($contenedores)): ?>
          <p style="color:#fff;font-weight:800;">No hay accesos en la tabla contenedor.</p>
        <?php else: ?>
          <?php foreach ($contenedores as $item): ?>
            <?php
              $idContenedor = (int)($item['id'] ?? 0);
              $nombrePlano  = (string)($item['nombre'] ?? 'Sin nombre');
              $urlPlano     = (string)($item['url_']   ?? '');
              $imagenPlano  = (string)($item['imagen'] ?? '');
              $nombre       = htmlspecialchars($item['nombre'] ?? 'Sin nombre', ENT_QUOTES, 'UTF-8');
              $href         = htmlspecialchars(normalizarUrl($item['url_'] ?? ''), ENT_QUOTES, 'UTF-8');
              $src          = htmlspecialchars(construirSrcImagen($imagenPlano), ENT_QUOTES, 'UTF-8');
              $nombreData   = htmlspecialchars($nombrePlano, ENT_QUOTES, 'UTF-8');
              $urlData      = htmlspecialchars($urlPlano,    ENT_QUOTES, 'UTF-8');
              $imagenData   = htmlspecialchars($imagenPlano, ENT_QUOTES, 'UTF-8');
            ?>
            <article class="tile"
                     data-tile-id="<?= $idContenedor ?>"
                     data-tile-nombre="<?= $nombreData ?>"
                     data-tile-url="<?= $urlData ?>"
                     data-tile-imagen="<?= $imagenData ?>">

              <a class="tile__link"
                 href="<?= $href ?>"
                 title="<?= $nombre ?>"
                 target="_blank"
                 rel="noopener noreferrer"
                 aria-label="<?= $nombre ?>"></a>

              <!-- Menú de 3 puntos: visible solo al pasar el cursor (ver css/index.css) -->
              <div class="tile__actions">
                <button class="tile__menu-btn"
                        type="button"
                        aria-label="Opciones"
                        onclick="toggleMenuTile(this)">⋯</button>
                <div class="tile__menu" role="menu">
                  <button class="tile__menu-item"
                          type="button"
                          data-tile-edit>Editar</button>
                  <button class="tile__menu-item tile__menu-item--danger"
                          type="button"
                          data-tile-delete>Eliminar</button>
                </div>
              </div>

              <div class="tile__media">
                <img src="<?= $src ?>"
                     alt="<?= $nombre ?>"
                     onerror="this.onerror=null;this.src='imagenes/google.png';" />
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

  <!-- Rail: botón de abrir calendario usa onclick definido en js/calendario_panel.js -->
  <!-- Rail: botón de abrir contactos usa onclick definido en js/contactos_panel.js  -->
  <!-- Rail: botón de nuevo contenedor usa onclick definido en js/contenedor_modal.js -->

  <script src="js/contactos_panel.js"></script>
  <script src="js/launcher.js"></script>
  <script src="js/contenedor_modal.js"></script>

</body>
</html>
