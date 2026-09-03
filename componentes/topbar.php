<?php

require_once __DIR__ . '/menu_cabecera.php';

function renderTopbar(array $menus, string $paginaActual): void
{
    renderSeducSidebar($menus, $paginaActual);
}
