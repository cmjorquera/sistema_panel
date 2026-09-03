<header id="topbar">
  <button id="mobile-menu-btn" onclick="toggleMobileSidebar()">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
  </button>
  <div class="breadcrumb">
    <span>SEDUC</span>
    <span class="sep">›</span>
    <span class="current"><?= htmlspecialchars($breadcrumb_actual ?? 'Panel') ?></span>
  </div>
  <div class="search-wrap">
    <svg class="icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
    <input type="text" placeholder="Buscar usuarios, colegios, módulos..."/>
  </div>
  <div class="topbar-right">
    <button class="notif-btn">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
      <span class="notif-badge">3</span>
    </button>
    <div class="dropdown">
      <button class="user-chip" onclick="toggleDropdown(this)">
        <div class="avatar"><?= htmlspecialchars(Sesion::iniciales()) ?></div>
        <div class="user-info">
          <strong><?= htmlspecialchars(Sesion::get('usuario_nombre') ?? '') ?></strong>
          <span><?= htmlspecialchars(Sesion::get('usuario_perfil') ?? '') ?></span>
        </div>
      </button>
      <div class="dropdown-menu" style="right:0;min-width:180px">
        <a class="dropdown-item" href="perfil.php">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
          Perfil
        </a>
        <a class="dropdown-item" href="liquidaciones.php">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
          Liquidaciones
        </a>
        <a class="dropdown-item" href="documentos.php">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
          Documentos
        </a>
        <div style="height:1px;background:var(--border);margin:4px 8px"></div>
        <a class="dropdown-item danger" href="logout.php">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          Salir
        </a>
      </div>
    </div>
  </div>
</header>
