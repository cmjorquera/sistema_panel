<?php

require_once __DIR__ . '/menu_cabecera.php';

function renderTopbar(array $menus, string $paginaActual): void
{
    ?>
    <header class="topbar">
      <div class="topbar__inner">
        <div class="brand">
          <div class="brand__logo">SH</div>
          <div class="brand__text">
            <div class="brand__name">Seduc Hub</div>
            <div class="brand__tag">Portal Operativo</div>
          </div>
        </div>

        <nav class="topbar__nav">
          <?php if (empty($menus)): ?>
            <a class="navlink is-active" href="index_1.php">Inicio</a>
            <a class="navlink" href="apps.php">Apps</a>
            <a class="navlink" href="contactos.php">Contactos</a>
            <a class="navlink" href="notas.php">Notas</a>
          <?php else: ?>
            <?php foreach ($menus as $menu): ?>
              <?php
                $hrefPlano = (string)($menu['href'] ?? '#');
                $hrefMenu = htmlspecialchars($hrefPlano, ENT_QUOTES, 'UTF-8');
                $menuTextoPlano = trim((string)($menu['menu'] ?? ''));
                $textoMenu = htmlspecialchars($menuTextoPlano !== '' ? $menuTextoPlano : 'Menu', ENT_QUOTES, 'UTF-8');
                $archivoMenu = basename(parse_url($hrefPlano, PHP_URL_PATH) ?: $hrefPlano);
                $claseActiva = $archivoMenu === $paginaActual ? ' is-active' : '';
              ?>
              <a class="navlink<?= $claseActiva ?>" href="<?= $hrefMenu ?>"><?= $textoMenu ?></a>
            <?php endforeach; ?>
          <?php endif; ?>
        </nav>

        <?php renderTopbarUserMenu(); ?>
      </div>
    </header>
    <?php
}
