<?php

if (session_status() !== PHP_SESSION_ACTIVE && !headers_sent()) {
    session_start();
}

function construirHrefMenuCabecera(array $menu): string
{
    $pagina = trim((string)($menu['pagina'] ?? ''));

    if ($pagina === '') {
        return '#';
    }

    return $pagina;
}

function asegurarMenusFijosCabecera(array $menus): array
{
    $fijos = [
        ['menu' => 'Recursos', 'href' => 'recursos.php', 'icono' => 'bi bi-folder2-open', 'orden' => 999],
    ];

    $hrefsExistentes = [];
    foreach ($menus as $menu) {
        $hrefsExistentes[] = basename((string)($menu['href'] ?? ''));
    }

    foreach ($fijos as $menuFijo) {
        if (!in_array(basename($menuFijo['href']), $hrefsExistentes, true)) {
            $menus[] = $menuFijo;
        }
    }

    usort($menus, static function (array $a, array $b): int {
        return ((int)($a['orden'] ?? 0)) <=> ((int)($b['orden'] ?? 0));
    });

    return $menus;
}

function menus_cabezera(mysqli $conn): array
{
    $sql = "SELECT menu, pagina, carpeta, icono, orden
            FROM menu_h
            ORDER BY orden ASC";

    $resultado = $conn->query($sql);
    if (!$resultado) {
        return [];
    }

    $menus = [];
    while ($fila = $resultado->fetch_assoc()) {
        $menus[] = [
            'menu' => trim((string)($fila['menu'] ?? '')),
            'href' => construirHrefMenuCabecera($fila),
            'icono' => trim((string)($fila['icono'] ?? '')),
            'orden' => (int)($fila['orden'] ?? 0),
        ];
    }
    $resultado->free();

    return asegurarMenusFijosCabecera($menus);
}

function obtenerClaseIconoMenuCabecera(array $menu): string
{
    $icono = trim((string)($menu['icono'] ?? ''));

    if ($icono === '') {
        return 'bi bi-grid';
    }

    if (preg_match('/class=["\']([^"\']+)["\']/i', $icono, $coincidencias)) {
        $icono = $coincidencias[1];
    }

    $icono = strip_tags($icono);
    $icono = preg_replace('/[^a-zA-Z0-9_:\-\s]/', '', $icono);
    $icono = trim((string)$icono);

    return $icono !== '' ? $icono : 'bi bi-grid';
}

function renderSeducSidebar(array $menus, string $paginaActual): void
{
    ?>
    <aside class="seduc-sidebar" aria-label="Menu principal SEDUC">
      <div class="seduc-sidebar__brand">
        <div class="seduc-sidebar__logo" aria-hidden="true">
          <i class="bi bi-mortarboard-fill"></i>
        </div>
        <div class="seduc-sidebar__brand-text">
          <span class="seduc-sidebar__title">SEDUC Chile</span>
          <span class="seduc-sidebar__subtitle">Panel Central</span>
        </div>
      </div>

      <nav class="seduc-sidebar__nav">
        <div class="seduc-sidebar__group">
          <div class="seduc-sidebar__group-label">Principal</div>
          <ul class="seduc-sidebar__list">
            <?php foreach ($menus as $menu): ?>
              <?php
                $hrefPlano = (string)($menu['href'] ?? '#');
                $hrefMenu = htmlspecialchars($hrefPlano, ENT_QUOTES, 'UTF-8');
                $textoPlano = trim((string)($menu['menu'] ?? ''));
                $textoMenu = htmlspecialchars($textoPlano !== '' ? $textoPlano : 'Menu', ENT_QUOTES, 'UTF-8');
                $archivoMenu = basename(parse_url($hrefPlano, PHP_URL_PATH) ?: $hrefPlano);
                $claseActiva = $archivoMenu === $paginaActual ? ' is-active' : '';
                $icono = htmlspecialchars(obtenerClaseIconoMenuCabecera($menu), ENT_QUOTES, 'UTF-8');
              ?>
              <li class="seduc-sidebar__item">
                <a class="seduc-sidebar__link<?= $claseActiva ?>" href="<?= $hrefMenu ?>" title="<?= $textoMenu ?>">
                  <i class="seduc-sidebar__icon <?= $icono ?>" aria-hidden="true"></i>
                  <span class="seduc-sidebar__label"><?= $textoMenu ?></span>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </nav>

      <div class="seduc-sidebar__footer">
        <?php renderTopbarUserMenu(); ?>
      </div>
    </aside>
    <?php
}

function renderTopbarUserMenu(array $config = []): void
{
    $usuarioSesion = isset($_SESSION['panel_usuario']) && is_array($_SESSION['panel_usuario'])
        ? $_SESSION['panel_usuario']
        : [];

    $nombreSesion = trim((string)($_SESSION['nombre'] ?? $usuarioSesion['nombre'] ?? ''));
    $apellidoSesion = trim((string)($_SESSION['apellido_paterno'] ?? $usuarioSesion['apellido_paterno'] ?? ''));
    $cargoSesion = trim((string)($_SESSION['cargo'] ?? $usuarioSesion['cargo'] ?? ''));
    $fotoSesion = trim((string)($_SESSION['foto'] ?? $usuarioSesion['foto'] ?? ''));

    $nombreCompleto = trim($nombreSesion . ' ' . $apellidoSesion);
    $iniciales = '';
    if ($nombreSesion !== '') {
        $iniciales .= function_exists('mb_substr') ? mb_substr($nombreSesion, 0, 1, 'UTF-8') : substr($nombreSesion, 0, 1);
    }
    if ($apellidoSesion !== '') {
        $iniciales .= function_exists('mb_substr') ? mb_substr($apellidoSesion, 0, 1, 'UTF-8') : substr($apellidoSesion, 0, 1);
    }

    $iniciales = $iniciales !== ''
        ? (function_exists('mb_strtoupper') ? mb_strtoupper($iniciales, 'UTF-8') : strtoupper($iniciales))
        : '';

    $avatar = htmlspecialchars((string)($config['avatar'] ?? $iniciales), ENT_QUOTES, 'UTF-8');
    $nombre = htmlspecialchars((string)($config['nombre'] ?? ($nombreCompleto !== '' ? $nombreCompleto : 'Usuario')), ENT_QUOTES, 'UTF-8');
    $rol = htmlspecialchars((string)($config['rol'] ?? ($cargoSesion !== '' ? $cargoSesion : '')), ENT_QUOTES, 'UTF-8');
    $foto = htmlspecialchars((string)($config['foto'] ?? $fotoSesion), ENT_QUOTES, 'UTF-8');
    $perfilHref = htmlspecialchars((string)($config['perfil_href'] ?? 'perfil.php'), ENT_QUOTES, 'UTF-8');
    $liquidacionesHref = htmlspecialchars((string)($config['liquidaciones_href'] ?? 'liquidaciones.php'), ENT_QUOTES, 'UTF-8');
    $documentosHref = htmlspecialchars((string)($config['documentos_href'] ?? 'documentos.php'), ENT_QUOTES, 'UTF-8');
    $salirHref = htmlspecialchars((string)($config['salir_href'] ?? 'logout.php'), ENT_QUOTES, 'UTF-8');
    ?>
    <div class="topbar__right">
      <div class="usermenu">
        <button class="userbtn" type="button" aria-haspopup="menu" aria-expanded="false">
          <span class="userbtn__avatar" data-user-photo="<?= $foto ?>"><?= $avatar ?></span>
          <span class="userbtn__text">
            <span class="userbtn__name"><?= $nombre ?></span>
            <span class="userbtn__role"><?= $rol ?></span>
          </span>
          <span class="userbtn__chev">▾</span>
        </button>

        <div class="dropdown" role="menu">
          <a class="dropdown__item" href="<?= $perfilHref ?>" role="menuitem">
            <span class="dropdown__icon">👤</span> Perfil
          </a>
          <a class="dropdown__item" href="<?= $liquidacionesHref ?>" role="menuitem">
            <span class="dropdown__icon">💰</span> Liquidaciones
          </a>
          <a class="dropdown__item" href="<?= $documentosHref ?>" role="menuitem">
            <span class="dropdown__icon">📄</span> Documentos
          </a>
          <div class="dropdown__sep"></div>
          <a class="dropdown__item dropdown__item--danger" href="<?= $salirHref ?>" role="menuitem">
            <span class="dropdown__icon">🔓</span> Cerrar sesión
          </a>
        </div>
      </div>
    </div>
    <?php
}
