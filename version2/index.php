<?php
require_once 'class/Sesion.php';
require_once 'class/Conexion.php';
Sesion::requerir();

$titulo_pagina    = 'Dashboard';
$breadcrumb_actual = 'Dashboard';
$pagina_actual    = 'dashboard';
$con_charts       = true;

// ── Stats desde BD con fallback demo ─────────────────────────────
$stats = ['usuarios' => 0, 'colegios' => 0, 'eventos' => 0, 'modulos' => 0];
try {
    $db = Conexion::obtener();
    $r  = $db->query("SELECT
        (SELECT COUNT(*) FROM usuarios WHERE estado='activo') AS usuarios,
        (SELECT COUNT(*) FROM colegios)                       AS colegios,
        (SELECT COUNT(*) FROM eventos WHERE MONTH(fecha)=MONTH(CURDATE())) AS eventos,
        (SELECT COUNT(*) FROM menu_h WHERE estado='activo')   AS modulos");
    if ($r && $row = $r->fetch_assoc()) $stats = $row;
} catch (Exception $e) {
    // fallback demo
    $stats = ['usuarios' => 1284, 'colegios' => 312, 'eventos' => 47, 'modulos' => 6];
}

// ── Actividad reciente ────────────────────────────────────────────
$actividad = [];
try {
    $db = Conexion::obtener();
    $r  = $db->query("SELECT usuario, accion, target, created_at FROM actividad ORDER BY id DESC LIMIT 5");
    if ($r) while ($row = $r->fetch_assoc()) $actividad[] = $row;
} catch (Exception $e) {}
if (empty($actividad)) {
    $actividad = [
        ['usuario' => 'M. Soto',      'accion' => 'creó el módulo',         'target' => 'Bienestar Estudiantil',     'created_at' => 'hace 5 min'],
        ['usuario' => 'C. Pérez',     'accion' => 'actualizó el colegio',   'target' => 'Liceo Bicentenario',         'created_at' => 'hace 22 min'],
        ['usuario' => 'Sistema',      'accion' => 'respaldo automático',     'target' => 'qaseduc_panel',              'created_at' => 'hace 1 h'],
        ['usuario' => 'P. Vargas',    'accion' => 'asignó permisos a',      'target' => 'J. Riquelme',                'created_at' => 'hace 2 h'],
        ['usuario' => 'A. Bustamante','accion' => 'cerró el ticket',        'target' => '#1284 — Acceso SIGE',        'created_at' => 'hace 3 h'],
    ];
}

// ── Próximos eventos ──────────────────────────────────────────────
$proximos = [];
try {
    $db = Conexion::obtener();
    $r  = $db->query("SELECT titulo, fecha, hora, lugar, estado FROM eventos WHERE fecha >= CURDATE() ORDER BY fecha ASC LIMIT 4");
    if ($r) while ($row = $r->fetch_assoc()) $proximos[] = $row;
} catch (Exception $e) {}
if (empty($proximos)) {
    $meses = ['Jan'=>'Ene','Feb'=>'Feb','Mar'=>'Mar','Apr'=>'Abr','May'=>'May','Jun'=>'Jun','Jul'=>'Jul','Aug'=>'Ago','Sep'=>'Sep','Oct'=>'Oct','Nov'=>'Nov','Dec'=>'Dic'];
    $proximos = [
        ['titulo' => 'Consejo de Directores Regionales', 'fecha' => '2026-05-15', 'hora' => '10:00', 'lugar' => 'DEPROV Central',    'estado' => 'confirmado'],
        ['titulo' => 'Capacitación Plataforma SIGE',     'fecha' => '2026-05-18', 'hora' => '15:30', 'lugar' => 'Sala B-2',           'estado' => 'pendiente'],
        ['titulo' => 'Cierre de período académico',      'fecha' => '2026-05-22', 'hora' => '09:00', 'lugar' => 'Online',             'estado' => 'pendiente'],
        ['titulo' => 'Auditoría interna de finanzas',    'fecha' => '2026-06-08', 'hora' => '11:00', 'lugar' => 'Oficina central',    'estado' => 'confirmado'],
    ];
}

$mesesEs = ['01'=>'Ene','02'=>'Feb','03'=>'Mar','04'=>'Abr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Ago','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dic'];

function badgeClass(string $estado): string {
    return 'badge badge-' . htmlspecialchars($estado);
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
      <h1>Resumen general</h1>
      <p>Vista consolidada del Sistema Panel Central — SEDUC Chile.</p>
    </div>
    <div class="page-header-actions">
      <button class="btn btn-outline">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        Exportar reporte
      </button>
      <button class="btn btn-primary">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Nuevo registro
      </button>
    </div>
  </div>

  <!-- Stats -->
  <div class="stat-grid">
    <div class="stat-card">
      <div class="row">
        <div>
          <div class="label">Usuarios activos</div>
          <div class="value"><?= number_format((int)$stats['usuarios'], 0, ',', '.') ?></div>
          <div class="delta delta-up">+4,2% vs mes anterior</div>
        </div>
        <div class="stat-icon icon-blue">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
      </div>
    </div>
    <div class="stat-card">
      <div class="row">
        <div>
          <div class="label">Colegios registrados</div>
          <div class="value"><?= number_format((int)$stats['colegios'], 0, ',', '.') ?></div>
          <div class="delta delta-up">+1,8% vs mes anterior</div>
        </div>
        <div class="stat-icon icon-green">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
        </div>
      </div>
    </div>
    <div class="stat-card">
      <div class="row">
        <div>
          <div class="label">Eventos del mes</div>
          <div class="value"><?= (int)$stats['eventos'] ?></div>
          <div class="delta delta-up">+12 vs mes anterior</div>
        </div>
        <div class="stat-icon icon-yellow">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
      </div>
    </div>
    <div class="stat-card">
      <div class="row">
        <div>
          <div class="label">Módulos activos</div>
          <div class="value"><?= (int)$stats['modulos'] ?></div>
          <div class="delta delta-up">Sin cambios</div>
        </div>
        <div class="stat-icon icon-graphite">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
        </div>
      </div>
    </div>
  </div>

  <!-- Charts -->
  <div class="chart-grid mt-3">
    <div class="card">
      <div class="card-header">
        <div><div class="card-title">Crecimiento de usuarios</div><div class="card-desc">Últimos 6 meses</div></div>
        <span class="text-xs text-muted">Datos demostrativos</span>
      </div>
      <div class="card-body" style="height:260px"><canvas id="chart-usuarios"></canvas></div>
    </div>
    <div class="card">
      <div class="card-header">
        <div><div class="card-title">Eventos por mes</div><div class="card-desc">Calendario institucional</div></div>
      </div>
      <div class="card-body" style="height:260px"><canvas id="chart-eventos"></canvas></div>
    </div>
  </div>

  <!-- Acceso rápido -->
  <div class="quick-grid mt-3">
    <a href="usuarios.php" class="quick-card">
      <div class="top">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
      </div>
      <p>Gestionar usuarios</p><small>Acceso rápido</small>
    </a>
    <a href="colegios.php" class="quick-card">
      <div class="top">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
      </div>
      <p>Ver colegios</p><small>Acceso rápido</small>
    </a>
    <a href="eventos.php" class="quick-card">
      <div class="top">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#B8860B" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
      </div>
      <p>Crear evento</p><small>Acceso rápido</small>
    </a>
    <a href="permisos.php" class="quick-card">
      <div class="top">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--graphite)" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
      </div>
      <p>Permisos</p><small>Acceso rápido</small>
    </a>
  </div>

  <!-- Actividad + Próximos eventos -->
  <div class="bottom-grid mt-3">
    <div class="card">
      <div class="card-header"><div class="card-title">Actividad reciente</div><div class="card-desc">Últimas acciones del sistema</div></div>
      <div class="table-wrap">
        <table>
          <thead><tr><th>Usuario</th><th>Acción</th><th style="text-align:right">Cuándo</th></tr></thead>
          <tbody>
          <?php foreach ($actividad as $a): ?>
            <tr>
              <td class="font-medium"><?= htmlspecialchars($a['usuario']) ?></td>
              <td class="text-muted"><?= htmlspecialchars($a['accion']) ?> <span style="color:var(--fg)"><?= htmlspecialchars($a['target']) ?></span></td>
              <td style="text-align:right" class="text-xs text-muted"><?= htmlspecialchars($a['created_at']) ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card">
      <div class="card-header"><div class="card-title">Próximos eventos</div><div class="card-desc">Avisos institucionales</div></div>
      <div class="card-body">
        <?php foreach ($proximos as $ev):
          $partes = explode('-', $ev['fecha']);
          $dia = $partes[2] ?? '--';
          $mes = $mesesEs[$partes[1] ?? ''] ?? '---';
        ?>
        <div class="event-item">
          <div class="event-day">
            <span class="mon"><?= $mes ?></span>
            <span class="num"><?= $dia ?></span>
          </div>
          <div class="event-info">
            <p><?= htmlspecialchars($ev['titulo']) ?></p>
            <small><?= htmlspecialchars($ev['hora'] . ' · ' . $ev['lugar']) ?></small>
            <div style="margin-top:4px"><span class="<?= badgeClass($ev['estado']) ?>"><?= htmlspecialchars($ev['estado']) ?></span></div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

</div><!-- /content -->
</div><!-- /main -->
</div><!-- /app -->

<?php include 'componentes/scripts.php'; ?>
<script>
(function(){
  const labels = ['Dic','Ene','Feb','Mar','Abr','May'];
  const grid   = {color:'rgba(0,0,0,.06)',drawTicks:false};
  const ticks  = {color:'#9CA3AF',font:{family:'DM Sans',size:11}};
  const tip    = {backgroundColor:'#fff',titleColor:'#3F424A',bodyColor:'#6B7280',borderColor:'#E5E7EB',borderWidth:1,cornerRadius:8,padding:10};

  new Chart(document.getElementById('chart-usuarios'),{
    type:'line',
    data:{labels,datasets:[{label:'Usuarios',data:[980,1040,1080,1150,1220,<?= (int)$stats['usuarios'] ?>],
      borderColor:'#005B96',backgroundColor:'rgba(0,91,150,.1)',fill:true,tension:.4,borderWidth:2,pointRadius:3,pointBackgroundColor:'#005B96'}]},
    options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false},tooltip:tip},scales:{x:{grid,ticks},y:{grid,ticks}}}
  });

  new Chart(document.getElementById('chart-eventos'),{
    type:'bar',
    data:{labels,datasets:[{label:'Eventos',data:[28,32,30,41,39,<?= (int)$stats['eventos'] ?>],
      backgroundColor:'#3C8D2F',borderRadius:4}]},
    options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false},tooltip:tip},scales:{x:{grid:{display:false},ticks},y:{grid,ticks}}}
  });
})();
</script>
</body>
</html>
