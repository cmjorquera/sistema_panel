<?php
require_once 'class/Sesion.php';
require_once 'class/Conexion.php';
Sesion::requerir();

$titulo_pagina     = 'Módulos';
$breadcrumb_actual = 'Módulos';
$pagina_actual     = 'modulos';

// ── Datos desde BD con fallback demo ─────────────────────────────
$modulos = [];
try {
    $db = Conexion::obtener();
    $r  = $db->query("SELECT id, nombre, identificador AS slug, estado, DATE_FORMAT(updated_at,'%d-%m-%Y') AS actualizado FROM menu_h ORDER BY nombre ASC");
    if ($r) while ($row = $r->fetch_assoc()) $modulos[] = $row;
} catch (Exception $e) {}
if (empty($modulos)) {
    $modulos = [
        ['id'=>1,'nombre'=>'Gestión Académica',        'slug'=>'academico',         'estado'=>'activo',   'actualizado'=>'12-05-2026'],
        ['id'=>2,'nombre'=>'Recursos Humanos',          'slug'=>'rrhh',              'estado'=>'activo',   'actualizado'=>'10-05-2026'],
        ['id'=>3,'nombre'=>'Finanzas y Presupuesto',    'slug'=>'finanzas',          'estado'=>'activo',   'actualizado'=>'08-05-2026'],
        ['id'=>4,'nombre'=>'Convivencia Escolar',       'slug'=>'convivencia',       'estado'=>'inactivo', 'actualizado'=>'01-04-2026'],
        ['id'=>5,'nombre'=>'Bienestar Estudiantil',     'slug'=>'bienestar',         'estado'=>'activo',   'actualizado'=>'05-05-2026'],
        ['id'=>6,'nombre'=>'Reportes Ministeriales',    'slug'=>'reportes-mineduc',  'estado'=>'activo',   'actualizado'=>'11-05-2026'],
    ];
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
      <h1>Gestión de módulos</h1>
      <p>Habilita o deshabilita módulos del sistema institucional.</p>
    </div>
    <button class="btn btn-primary" onclick="openModal('modal-modulo')">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Agregar módulo
    </button>
  </div>

  <div class="card">
    <div class="toolbar">
      <div class="input-icon-wrap" style="max-width:320px;flex:1">
        <svg class="icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        <input type="text" class="input" id="modulos-search" placeholder="Buscar módulo..." oninput="filterTable()"/>
      </div>
      <span class="toolbar-count" id="modulos-count"><?= count($modulos) ?> resultados</span>
    </div>
    <div class="table-wrap">
      <table id="modulos-table">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Identificador</th>
            <th>Estado</th>
            <th>Actualizado</th>
            <th style="text-align:right">Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($modulos as $m): ?>
          <tr>
            <td class="font-medium"><?= htmlspecialchars($m['nombre']) ?></td>
            <td class="mono text-muted"><?= htmlspecialchars($m['slug']) ?></td>
            <td><span class="badge badge-<?= htmlspecialchars($m['estado']) ?>"><?= htmlspecialchars($m['estado']) ?></span></td>
            <td class="text-muted"><?= htmlspecialchars($m['actualizado']) ?></td>
            <td style="text-align:right">
              <button class="btn-icon" title="Ver">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
              <button class="btn-icon" title="Editar">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
              </button>
              <button class="btn-danger-ghost" title="Eliminar">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
              </button>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</div><!-- /content -->
</div><!-- /main -->
</div><!-- /app -->

<!-- Modal: Nuevo módulo -->
<div class="modal-overlay" id="modal-modulo" onclick="closeModalOutside(event,'modal-modulo')">
  <div class="modal">
    <div class="modal-header"><h3>Nuevo módulo</h3><p>Define los datos del módulo que se integrará al panel central.</p></div>
    <div class="modal-body">
      <form method="POST" action="modulos.php">
        <div style="margin-bottom:16px">
          <label class="field-label">Nombre del módulo</label>
          <input class="input" name="nombre" placeholder="Ej: Gestión académica" required/>
        </div>
        <div style="margin-bottom:16px">
          <label class="field-label">Identificador</label>
          <input class="input" name="identificador" placeholder="academico" required/>
        </div>
        <div style="display:flex;align-items:center;justify-content:space-between;border:1px solid var(--border);border-radius:var(--radius);padding:12px 14px">
          <div><p style="font-size:13px;font-weight:500">Activo al crear</p><p style="font-size:11px;color:var(--muted)">Disponible inmediatamente en el menú principal.</p></div>
          <label class="switch"><input type="checkbox" name="activo" checked/><div class="switch-track"></div><div class="switch-thumb"></div></label>
        </div>
        <div class="modal-footer" style="padding:16px 0 0">
          <button class="btn btn-outline" type="button" onclick="closeModal('modal-modulo')">Cancelar</button>
          <button class="btn btn-primary" type="submit">Guardar módulo</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'componentes/scripts.php'; ?>
<script>
function filterTable() {
  const q = document.getElementById('modulos-search').value.toLowerCase();
  const rows = document.querySelectorAll('#modulos-table tbody tr');
  let visible = 0;
  rows.forEach(tr => {
    const match = tr.textContent.toLowerCase().includes(q);
    tr.style.display = match ? '' : 'none';
    if (match) visible++;
  });
  document.getElementById('modulos-count').textContent = visible + ' resultados';
}
</script>
</body>
</html>
