<?php
require_once 'class/Sesion.php';
require_once 'class/Conexion.php';
Sesion::requerir();

$titulo_pagina     = 'Colegios';
$breadcrumb_actual = 'Colegios';
$pagina_actual     = 'colegios';

// ── Datos desde BD con fallback demo ─────────────────────────────
$colegios = [];
try {
    $db = Conexion::obtener();
    $r  = $db->query(
        "SELECT c.id, c.nombre, c.rbd, c.comuna, c.estado,
                (SELECT COUNT(*) FROM usuarios u WHERE u.colegio_id = c.id) AS usuarios,
                (SELECT COUNT(*) FROM colegio_modulos cm WHERE cm.colegio_id = c.id) AS modulos,
                (SELECT COUNT(*) FROM eventos e WHERE e.colegio_id = c.id AND MONTH(e.fecha)=MONTH(CURDATE())) AS eventos
         FROM colegios c ORDER BY c.nombre ASC"
    );
    if ($r) while ($row = $r->fetch_assoc()) $colegios[] = $row;
} catch (Exception $e) {}
if (empty($colegios)) {
    $colegios = [
        ['id'=>1,'nombre'=>'Liceo Bicentenario Santiago',     'rbd'=>'10245-1','comuna'=>'Santiago',    'usuarios'=>84, 'modulos'=>6,'eventos'=>12,'estado'=>'activo'],
        ['id'=>2,'nombre'=>'Escuela San Andrés',               'rbd'=>'20188-3','comuna'=>'Maipú',       'usuarios'=>42, 'modulos'=>4,'eventos'=>5, 'estado'=>'activo'],
        ['id'=>3,'nombre'=>'Liceo Industrial de Concepción',   'rbd'=>'31204-0','comuna'=>'Concepción',  'usuarios'=>128,'modulos'=>6,'eventos'=>9, 'estado'=>'activo'],
        ['id'=>4,'nombre'=>'Escuela Rural Los Aromos',         'rbd'=>'40887-2','comuna'=>'Curacaví',    'usuarios'=>18, 'modulos'=>3,'eventos'=>2, 'estado'=>'inactivo'],
        ['id'=>5,'nombre'=>'Colegio Polivalente Valparaíso',   'rbd'=>'50921-7','comuna'=>'Valparaíso',  'usuarios'=>96, 'modulos'=>5,'eventos'=>7, 'estado'=>'activo'],
        ['id'=>6,'nombre'=>'Liceo Técnico La Serena',          'rbd'=>'60554-4','comuna'=>'La Serena',   'usuarios'=>71, 'modulos'=>5,'eventos'=>4, 'estado'=>'activo'],
    ];
}

function colegioIniciales(string $nombre): string {
    $palabras = array_filter(explode(' ', $nombre), fn($w) => preg_match('/^[A-ZÁÉÍÓÚÑ]/u', $w));
    return implode('', array_map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)), array_slice(array_values($palabras), 0, 2)));
}

include 'componentes/head.php';
?>
<div id="app">
<?php include 'componentes/sidebar.php'; ?>
<div id="mobile-overlay" onclick="closeMobileSidebar()"></div>
<div id="main">
<?php include 'componentes/topbar.php'; ?>
<div id="content">

  <div class="page-header">
    <div>
      <h1>Colegios</h1>
      <p>Establecimientos educacionales bajo dependencia SEDUC.</p>
    </div>
    <button class="btn btn-primary">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Registrar colegio
    </button>
  </div>

  <div class="colegios-grid">
  <?php foreach ($colegios as $c): ?>
    <div class="colegio-card">
      <div class="header">
        <div class="colegio-avatar"><?= colegioIniciales($c['nombre']) ?></div>
        <div class="colegio-name">
          <h3><?= htmlspecialchars($c['nombre']) ?></h3>
          <small>
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <?= htmlspecialchars($c['comuna']) ?> · RBD <?= htmlspecialchars($c['rbd']) ?>
          </small>
          <div style="margin-top:6px">
            <span class="badge badge-<?= htmlspecialchars($c['estado']) ?>"><?= htmlspecialchars($c['estado']) ?></span>
          </div>
        </div>
        <div class="dropdown" style="margin-left:auto;flex-shrink:0">
          <button class="btn-icon" onclick="toggleDropdown(this)">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/></svg>
          </button>
          <div class="dropdown-menu">
            <button class="dropdown-item">Ver detalle</button>
            <button class="dropdown-item">Editar</button>
            <button class="dropdown-item">Asignar usuarios</button>
            <button class="dropdown-item danger">Desactivar</button>
          </div>
        </div>
      </div>
      <div class="colegio-stats">
        <div class="colegio-stat">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
          <div class="val"><?= (int)$c['usuarios'] ?></div>
          <div class="lbl">Usuarios</div>
        </div>
        <div class="colegio-stat">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
          <div class="val"><?= (int)$c['modulos'] ?></div>
          <div class="lbl">Módulos</div>
        </div>
        <div class="colegio-stat">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          <div class="val"><?= (int)$c['eventos'] ?></div>
          <div class="lbl">Eventos</div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
  </div>

</div><!-- /content -->
</div><!-- /main -->
</div><!-- /app -->

<?php include 'componentes/scripts.php'; ?>
</body>
</html>
