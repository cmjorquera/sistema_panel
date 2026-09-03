<?php
require_once 'class/Sesion.php';
require_once 'class/Conexion.php';
Sesion::requerir();

$titulo_pagina     = 'Permisos';
$breadcrumb_actual = 'Permisos';
$pagina_actual     = 'permisos';

// ── Datos desde BD con fallback demo ─────────────────────────────
$grupos = [];
try {
    $db = Conexion::obtener();
    $r  = $db->query(
        "SELECT g.nombre AS grupo, m.nombre, p.ver, p.crear, p.editar, p.eliminar
         FROM permisos p
         JOIN menu_h m ON m.id = p.menu_id
         JOIN menu_grupos g ON g.id = m.grupo_id
         WHERE p.perfil = 'Administrador'
         ORDER BY g.nombre, m.nombre"
    );
    if ($r) {
        while ($row = $r->fetch_assoc()) {
            $grupos[$row['grupo']][] = $row;
        }
    }
} catch (Exception $e) {}
if (empty($grupos)) {
    $grupos = [
        'Administración' => [
            ['nombre'=>'Dashboard',  'ver'=>1,'crear'=>0,'editar'=>0,'eliminar'=>0],
            ['nombre'=>'Usuarios',   'ver'=>1,'crear'=>1,'editar'=>1,'eliminar'=>0],
            ['nombre'=>'Permisos',   'ver'=>1,'crear'=>1,'editar'=>1,'eliminar'=>1],
        ],
        'Operación' => [
            ['nombre'=>'Colegios',   'ver'=>1,'crear'=>1,'editar'=>1,'eliminar'=>0],
            ['nombre'=>'Módulos',    'ver'=>1,'crear'=>0,'editar'=>1,'eliminar'=>0],
            ['nombre'=>'Eventos',    'ver'=>1,'crear'=>1,'editar'=>1,'eliminar'=>1],
        ],
        'Reportes' => [
            ['nombre'=>'Reportes ministeriales','ver'=>1,'crear'=>0,'editar'=>0,'eliminar'=>0],
            ['nombre'=>'Auditoría',             'ver'=>0,'crear'=>0,'editar'=>0,'eliminar'=>0],
        ],
    ];
}

$acciones = ['ver','crear','editar','eliminar'];

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
      <h1>Sistema de permisos</h1>
      <p>Configura accesos por menú y submenú según el perfil.</p>
    </div>
    <div class="page-header-actions">
      <select class="input" style="width:220px">
        <option>Perfil: Administrador</option>
        <option>Perfil: Coordinador</option>
        <option>Perfil: Docente</option>
        <option>Perfil: Soporte TI</option>
      </select>
      <button class="btn btn-primary">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        Guardar cambios
      </button>
    </div>
  </div>

  <div class="permisos-grid">
  <?php foreach ($grupos as $grupoNombre => $items): ?>
    <div class="card">
      <div class="card-header">
        <div>
          <div style="display:flex;align-items:center;gap:8px">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            <span class="card-title"><?= htmlspecialchars($grupoNombre) ?></span>
          </div>
          <div class="card-desc">Permisos de menú</div>
        </div>
      </div>
      <div class="card-body">
        <?php foreach ($items as $item): ?>
        <div class="perm-item">
          <div class="perm-item-name"><?= htmlspecialchars($item['nombre']) ?></div>
          <div class="perm-checks">
            <?php foreach ($acciones as $accion): ?>
            <div class="perm-check">
              <span style="text-transform:capitalize"><?= $accion ?></span>
              <label class="switch">
                <input type="checkbox" <?= $item[$accion] ? 'checked' : '' ?>/>
                <div class="switch-track"></div>
                <div class="switch-thumb"></div>
              </label>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endforeach; ?>
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
