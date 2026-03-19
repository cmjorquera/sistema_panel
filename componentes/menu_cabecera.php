<?php

function normalizarTextoMenuCabecera(string $texto): string
{
    $texto = trim(function_exists('mb_strtolower') ? mb_strtolower($texto, 'UTF-8') : strtolower($texto));
    $reemplazos = [
        'á' => 'a',
        'é' => 'e',
        'í' => 'i',
        'ó' => 'o',
        'ú' => 'u',
        'ü' => 'u',
        'ñ' => 'n',
    ];

    return strtr($texto, $reemplazos);
}

function obtenerRutaCanonicaMenuCabecera(array $menu): ?string
{
    $alias = normalizarTextoMenuCabecera((string)($menu['menu'] ?? ''));
    $pagina = basename(trim((string)($menu['pagina'] ?? '')));

    $rutasCanonicas = [
        'inicio' => 'index.php',
        'home' => 'index.php',
        'apps' => 'apps.php',
        'aplicaciones' => 'apps.php',
        'contactos' => 'contactos.php',
        'notas' => 'notas.php',
        'recursos' => 'recursos.php',
        'formularios' => 'recursos.php',
        'plantillas' => 'recursos.php',
    ];

    if (isset($rutasCanonicas[$alias])) {
        return $rutasCanonicas[$alias];
    }

    if ($pagina !== '' && is_file(__DIR__ . '/../' . $pagina)) {
        return $pagina;
    }

    return null;
}

function construirHrefMenuCabecera(array $menu): string
{
    $pagina = trim((string)($menu['pagina'] ?? ''));
    $carpeta = trim((string)($menu['carpeta'] ?? ''));

    $rutaCanonica = obtenerRutaCanonicaMenuCabecera($menu);
    if ($rutaCanonica !== null) {
        return $rutaCanonica;
    }

    if ($pagina === '') {
        return '#';
    }

    if (
        preg_match('~^[a-z][a-z0-9+.-]*://~i', $pagina) ||
        str_starts_with($pagina, '//') ||
        str_starts_with($pagina, '#') ||
        str_starts_with($pagina, 'mailto:') ||
        str_starts_with($pagina, 'tel:')
    ) {
        return $pagina;
    }

    if ($carpeta === '' || $carpeta === '/' || $carpeta === '.') {
        return $pagina;
    }

    $rutaCompuesta = rtrim($carpeta, "/\\") . '/' . ltrim($pagina, "/\\");
    $rutaLocal = __DIR__ . '/../' . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $rutaCompuesta);

    if (is_file($rutaLocal)) {
        return $rutaCompuesta;
    }

    $paginaBase = basename($pagina);
    if ($paginaBase !== '' && is_file(__DIR__ . '/../' . $paginaBase)) {
        return $paginaBase;
    }

    return $rutaCompuesta;
}

function asegurarMenusFijosCabecera(array $menus): array
{
    $fijos = [
        ['menu' => 'Recursos', 'href' => 'recursos.php', 'orden' => 999],
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
    $sql = "SELECT menu, pagina, carpeta, orden
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
            'orden' => (int)($fila['orden'] ?? 0),
        ];
    }
    $resultado->free();

    return asegurarMenusFijosCabecera($menus);
}

function renderTopbarUserMenu(array $config = []): void
{
    $avatar = htmlspecialchars((string)($config['avatar'] ?? 'CJ'), ENT_QUOTES, 'UTF-8');
    $nombre = htmlspecialchars((string)($config['nombre'] ?? 'Cristian Jorquera'), ENT_QUOTES, 'UTF-8');
    $rol = htmlspecialchars((string)($config['rol'] ?? 'Tecnico'), ENT_QUOTES, 'UTF-8');
    $editarPerfilHref = htmlspecialchars((string)($config['editar_perfil_href'] ?? '#'), ENT_QUOTES, 'UTF-8');
    $cambiarClaveHref = htmlspecialchars((string)($config['cambiar_clave_href'] ?? '#'), ENT_QUOTES, 'UTF-8');
    $salirHref = htmlspecialchars((string)($config['salir_href'] ?? '#'), ENT_QUOTES, 'UTF-8');
    ?>
    <div class="topbar__right">
      <div class="usermenu">
        <button class="userbtn" type="button" aria-haspopup="menu" aria-expanded="false">
          <span class="userbtn__avatar"><?= $avatar ?></span>
          <span class="userbtn__text">
            <span class="userbtn__name"><?= $nombre ?></span>
            <span class="userbtn__role"><?= $rol ?></span>
          </span>
          <span class="userbtn__chev">▾</span>
        </button>

        <div class="dropdown" role="menu">
          <a class="dropdown__item" href="<?= $editarPerfilHref ?>" role="menuitem">Editar perfil</a>
          <a class="dropdown__item" href="<?= $cambiarClaveHref ?>" role="menuitem">Cambiar contrasena</a>
          <div class="dropdown__sep"></div>
          <a class="dropdown__item dropdown__item--danger" href="<?= $salirHref ?>" role="menuitem">Salir</a>
        </div>
      </div>
    </div>
    <?php
}
