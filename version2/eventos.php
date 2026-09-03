<?php
require_once 'class/Sesion.php';
require_once 'class/Conexion.php';
Sesion::requerir();

$titulo_pagina     = 'Eventos';
$breadcrumb_actual = 'Eventos';
$pagina_actual     = 'eventos';

// ── Datos desde BD con fallback demo ─────────────────────────────
$eventos = [];
try {
    $db = Conexion::obtener();
    $r  = $db->query("SELECT id, titulo, DATE_FORMAT(fecha,'%d-%m-%Y') AS fecha, hora, lugar, estado FROM eventos ORDER BY fecha ASC");
    if ($r) while ($row = $r->fetch_assoc()) $eventos[] = $row;
} catch (Exception $e) {}
if (empty($eventos)) {
    $eventos = [
        ['id'=>1,'titulo'=>'Consejo de Directores Regionales','fecha'=>'15-05-2026','hora'=>'10:00','lugar'=>'DEPROV Central',  'estado'=>'confirmado'],
        ['id'=>2,'titulo'=>'Capacitación Plataforma SIGE',    'fecha'=>'18-05-2026','hora'=>'15:30','lugar'=>'Sala B-2',         'estado'=>'pendiente'],
        ['id'=>3,'titulo'=>'Cierre de período académico',     'fecha'=>'22-05-2026','hora'=>'09:00','lugar'=>'Online',            'estado'=>'pendiente'],
        ['id'=>4,'titulo'=>'Auditoría interna de finanzas',   'fecha'=>'08-05-2026','hora'=>'11:00','lugar'=>'Oficina central',   'estado'=>'realizado'],
        ['id'=>5,'titulo'=>'Visita inspectiva Liceo Industrial','fecha'=>'02-05-2026','hora'=>'08:30','lugar'=>'Concepción',      'estado'=>'cancelado'],
    ];
}

// Construir mapa de eventos por día (mes actual = mayo 2026)
$eventMap = [];
foreach ($eventos as $ev) {
    $partes = explode('-', $ev['fecha']);
    $dia = (int)$partes[0];
    $eventMap[$dia][] = $ev;
}

// Mayo 2026: empieza en viernes (offset=4 desde lunes=0)
$startOffset = 4;
$totalDays   = 31;
$today       = 13; // 2026-05-13

$diasSemana = ['Lun','Mar','Mié','Jue','Vie','Sáb','Dom'];
$mesesEs    = ['01'=>'Ene','02'=>'Feb','03'=>'Mar','04'=>'Abr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Ago','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dic'];

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
      <h1>Eventos y calendario</h1>
      <p>Agenda institucional SEDUC.</p>
    </div>
    <button class="btn btn-primary">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Nuevo evento
    </button>
  </div>

  <div class="cal-grid">

    <!-- Calendario -->
    <div class="card">
      <div class="card-header">
        <div class="card-title">Mayo 2026</div>
        <div class="flex gap-2">
          <button class="btn btn-outline btn-sm">‹</button>
          <button class="btn btn-outline btn-sm">›</button>
        </div>
      </div>
      <div class="card-body" style="padding:16px">
        <div class="calendar-wrap">

          <!-- Cabecera días -->
          <div class="cal-days-header">
            <?php foreach ($diasSemana as $d): ?>
            <div class="cal-day-header"><?= $d ?></div>
            <?php endforeach; ?>
          </div>

          <!-- Celdas -->
          <div class="cal-body">
            <?php
            for ($i = 0; $i < $startOffset; $i++): ?>
              <div class="cal-cell empty"></div>
            <?php endfor;
            for ($d = 1; $d <= $totalDays; $d++):
              $isToday = $d === $today ? 'today' : '';
              $evs = $eventMap[$d] ?? [];
            ?>
              <div class="cal-cell <?= $isToday ?>">
                <span class="cal-num"><?= $d ?></span>
                <?php foreach ($evs as $ev): ?>
                  <div class="cal-ev cal-ev-<?= htmlspecialchars($ev['estado']) ?>"><?= htmlspecialchars($ev['titulo']) ?></div>
                <?php endforeach; ?>
              </div>
            <?php endfor; ?>
          </div>

        </div>
      </div>
    </div>

    <!-- Lista de eventos -->
    <div class="card">
      <div class="card-header"><div class="card-title">Lista de eventos</div></div>
      <div class="card-body" style="padding:16px">
        <?php foreach ($eventos as $ev):
          $partes = explode('-', $ev['fecha']);
          $dia = $partes[0] ?? '--';
          $mes = $mesesEs[$partes[1] ?? ''] ?? '---';
        ?>
        <div style="border:1px solid var(--border);border-radius:var(--radius);padding:12px;margin-bottom:8px;transition:background .15s" onmouseenter="this.style.background='var(--bg)'" onmouseleave="this.style.background=''">
          <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:8px">
            <div style="min-width:0">
              <p class="font-medium truncate text-sm"><?= htmlspecialchars($ev['titulo']) ?></p>
              <p class="text-xs text-muted"><?= htmlspecialchars($ev['fecha'] . ' · ' . $ev['hora'] . ' · ' . $ev['lugar']) ?></p>
            </div>
            <span class="badge badge-<?= htmlspecialchars($ev['estado']) ?>"><?= htmlspecialchars($ev['estado']) ?></span>
          </div>
          <div style="margin-top:8px;display:flex;gap:4px">
            <button class="btn btn-ghost btn-sm">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              Revisar
            </button>
            <button class="btn btn-ghost btn-sm">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
              Editar
            </button>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

  </div><!-- /cal-grid -->

</div><!-- /content -->
</div><!-- /main -->
</div><!-- /app -->

<?php include 'componentes/scripts.php'; ?>
</body>
</html>
