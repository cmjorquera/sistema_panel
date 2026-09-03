<?php
require_once 'class/Sesion.php';
require_once 'class/Conexion.php';
Sesion::requerir();

$titulo_pagina     = 'SEDUC Informa';
$breadcrumb_actual = 'SEDUC Informa';
$pagina_actual     = 'seduc_informa';

// ── Horario institucional ──────────────────────────────────────────
$HORARIO = [
    'lun-jue' => ['entrada'=>'08:30','salida'=>'17:00'],
    'vie'     => ['entrada'=>'08:30','salida'=>'15:30'],
];

$dow        = (int)date('N');
$es_habil   = $dow >= 1 && $dow <= 5;
$horario_hoy = $dow === 5 ? $HORARIO['vie'] : $HORARIO['lun-jue'];
$turno_label = $dow === 5 ? 'Viernes' : 'Lun – Jue';
$dias_es     = ['','Lun','Mar','Mié','Jue','Vie','Sáb','Dom'];

// ── Funcionarios de ejemplo ────────────────────────────────────────
$hoy_md = date('m-d');
$funcionarios = [
    ['id'=>1,'nombres'=>'Ana María', 'apellidos'=>'Rodríguez Vera',  'fecha_nac'=>'1985-'.date('m').'-'.date('d'), 'cargo'=>'Jefa de UTP',               'unidad'=>'seduc_central'],
    ['id'=>2,'nombres'=>'Carlos',    'apellidos'=>'Pérez Muñoz',     'fecha_nac'=>'1990-'.date('m').'-'.sprintf('%02d', min(28, (int)date('d')+2)), 'cargo'=>'Coordinador TIC',           'unidad'=>'equipos_tecnicos'],
    ['id'=>3,'nombres'=>'Valentina', 'apellidos'=>'Soto Araya',      'fecha_nac'=>'1978-05-15',  'cargo'=>'Directora Colegio Los Pinos',  'unidad'=>'consejo_direccion'],
    ['id'=>4,'nombres'=>'Jorge',     'apellidos'=>'Fuentes Lagos',   'fecha_nac'=>'1992-06-22',  'cargo'=>'Administrativo',               'unidad'=>'colegio'],
    ['id'=>5,'nombres'=>'Daniela',   'apellidos'=>'Castillo Rojas',  'fecha_nac'=>'1988-07-04',  'cargo'=>'Paradocente',                  'unidad'=>'paradocente'],
    ['id'=>6,'nombres'=>'Roberto',   'apellidos'=>'Vidal Torres',    'fecha_nac'=>'1975-08-11',  'cargo'=>'Auxiliar',                     'unidad'=>'auxiliar'],
];

function cumplesMd(string $fecha, string $ref): bool {
    return date('m-d', strtotime($fecha)) === $ref;
}
function diasCumple(string $fecha): int {
    $hoy = new DateTime(date('Y-m-d'));
    $c   = new DateTime(date('Y').'-'.date('m-d', strtotime($fecha)));
    if ($c < $hoy) $c->modify('+1 year');
    return (int)$hoy->diff($c)->days;
}

$cumples_hoy  = array_values(array_filter($funcionarios, fn($f) => cumplesMd($f['fecha_nac'], $hoy_md)));
$cumples_prox = array_values(array_filter($funcionarios, fn($f) => !cumplesMd($f['fecha_nac'], $hoy_md) && diasCumple($f['fecha_nac']) <= 30));
usort($cumples_prox, fn($a,$b) => diasCumple($a['fecha_nac']) <=> diasCumple($b['fecha_nac']));

// ── Calendario académico 2026 ──────────────────────────────────────
$calendario = [
    ['tipo'=>'ingreso',   'titulo'=>'Ingreso Seduc Administración Central',                                      'fecha'=>'Lunes 16 febrero 2026',                          'estamento'=>'Seduc Central'],
    ['tipo'=>'ingreso',   'titulo'=>'Ingreso Administrativos y Auxiliares Colegios',                             'fecha'=>'Lunes 16 febrero 2026',                          'estamento'=>'Colegios'],
    ['tipo'=>'ingreso',   'titulo'=>'Ingreso Paradocentes',                                                      'fecha'=>'Con administrativos o docentes (criterio colegio)','estamento'=>'Paradocentes'],
    ['tipo'=>'ingreso',   'titulo'=>'Ingreso Consejos de Dirección',                                             'fecha'=>'Lunes 23 febrero 2026',                          'estamento'=>'Consejos de Dirección'],
    ['tipo'=>'ingreso',   'titulo'=>'Ingreso Equipos Técnicos Seduc',                                            'fecha'=>'Lunes 23 febrero 2026',                          'estamento'=>'Equipos Técnicos'],
    ['tipo'=>'ingreso',   'titulo'=>'Ingreso Profesores (Jornadas iniciales)',                                   'fecha'=>'Miércoles 25 febrero 2026',                      'estamento'=>'Profesores'],
    ['tipo'=>'jornada',   'titulo'=>'Jornada inducción Seduc — profesores nuevos',                               'fecha'=>'Martes 3 marzo (en Seduc)',                       'estamento'=>'Profesores nuevos'],
    ['tipo'=>'ingreso',   'titulo'=>'Inicio año escolar Alumnos',                                                'fecha'=>'Miércoles 4 marzo 2026',                         'estamento'=>'Alumnos'],
    ['tipo'=>'vacaciones','titulo'=>'Vacaciones invierno — Alumnos, Profesores y Consejos Dirección',            'fecha'=>'Lunes 22 junio – viernes 3 julio',                'estamento'=>'Alumnos / Profesores / Dirección'],
    ['tipo'=>'vacaciones','titulo'=>'Vacaciones invierno — Administrativos de Colegio',                         'fecha'=>'Una semana por turnos, entre 22 jun – 3 jul',     'estamento'=>'Administrativos Colegio'],
    ['tipo'=>'vacaciones','titulo'=>'Vacaciones invierno — Seduc Adm. Central + Equipos Técnicos',              'fecha'=>'Lunes 29 junio – viernes 3 julio',                'estamento'=>'Seduc Central / Eq. Técnicos'],
    ['tipo'=>'jornada',   'titulo'=>'Jornada de Reflexión (sin alumnos ni profesores)',                          'fecha'=>'11 septiembre y 9 octubre',                       'estamento'=>'Todos los colegios'],
    ['tipo'=>'feriado',   'titulo'=>'Vacaciones Fiestas Patrias — Alumnos, Dirección y Profesores',             'fecha'=>'Lunes 14 – viernes 18 septiembre',                'estamento'=>'Alumnos / Profesores / Dirección'],
    ['tipo'=>'feriado',   'titulo'=>'Vacaciones Fiestas Patrias — Seduc Central + Eq. Técnicos',               'fecha'=>'Jueves 17 septiembre (adicional a 18 y 19)',      'estamento'=>'Seduc Central / Eq. Técnicos'],
    ['tipo'=>'fin_ano',   'titulo'=>'Finalización año académico — Alumnos',                                     'fecha'=>'Viernes 11 diciembre 2026',                       'estamento'=>'Alumnos'],
    ['tipo'=>'fin_ano',   'titulo'=>'Finalización año académico — Profesores',                                   'fecha'=>'Miércoles 30 diciembre 2026',                    'estamento'=>'Profesores'],
    ['tipo'=>'vacaciones','titulo'=>'Vacaciones verano — Seduc Adm. Central',                                    'fecha'=>'Miércoles 13 enero – viernes 12 febrero (incl.)','estamento'=>'Seduc Central'],
    ['tipo'=>'feriado',   'titulo'=>'Jueves Santo',                                                              'fecha'=>'Jueves 2 abril 2026',                            'estamento'=>'Todos'],
    ['tipo'=>'feriado',   'titulo'=>'Navidad — Seduc Central y Colegios',                                       'fecha'=>'Jueves 24 diciembre 2026',                       'estamento'=>'Todos'],
    ['tipo'=>'feriado',   'titulo'=>'Interferiado',                                                              'fecha'=>'Viernes 22 mayo 2026',                           'estamento'=>'Todos'],
    ['tipo'=>'feriado',   'titulo'=>'Interferiado',                                                              'fecha'=>'Viernes 17 julio 2026',                          'estamento'=>'Todos'],
    ['tipo'=>'feriado',   'titulo'=>'Interferiado',                                                              'fecha'=>'Lunes 7 diciembre 2026',                         'estamento'=>'Todos'],
];

$tipo_config = [
    'ingreso'    => ['label'=>'Ingreso',    'color'=>'var(--blue)','bg'=>'var(--blue-light)'],
    'vacaciones' => ['label'=>'Vacaciones', 'color'=>'var(--green)','bg'=>'var(--green-light)'],
    'feriado'    => ['label'=>'Feriado',    'color'=>'var(--danger)','bg'=>'var(--danger-light)'],
    'jornada'    => ['label'=>'Jornada',    'color'=>'#7e3af2','bg'=>'#ede9fe'],
    'fin_ano'    => ['label'=>'Fin Año',    'color'=>'var(--yellow)','bg'=>'var(--yellow-light)'],
    'otro'       => ['label'=>'Otro',       'color'=>'var(--muted)','bg'=>'var(--bg)'],
];

$avatar_colors = ['#005B96','#7e3af2','#3C8D2F','#d97706','#C0392B','#2563eb'];

include 'componentes/head.php';
?>
<!-- SheetJS para parseo de Excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js" defer></script>

<div id="app">
<?php include 'componentes/sidebar.php'; ?>
<div id="mobile-overlay" onclick="closeMobileSidebar()"></div>
<div id="main">
<?php include 'componentes/topbar.php'; ?>
<div id="content">

  <!-- Stats rápidos -->
  <div class="si-stats-row">
    <div class="stat-card">
      <div class="stat-number" style="color:var(--blue)"><?= count($funcionarios) ?></div>
      <div class="stat-label">Funcionarios</div>
    </div>
    <div class="stat-card">
      <div class="stat-number" style="color:var(--yellow)"><?= count($cumples_hoy) ?></div>
      <div class="stat-label">Cumplen hoy</div>
    </div>
    <div class="stat-card">
      <div class="stat-number" style="color:#7e3af2"><?= count($cumples_prox) ?></div>
      <div class="stat-label">Próximos 30 días</div>
    </div>
    <div class="stat-card">
      <div class="stat-number" style="color:var(--green)"><?= count($calendario) ?></div>
      <div class="stat-label">Eventos en calendario</div>
    </div>
  </div>

  <div class="si-layout">

    <!-- ── Columna principal ─────────────────────────── -->
    <div>

      <!-- Cumpleaños hoy -->
      <?php if (count($cumples_hoy)): ?>
      <div class="si-bday-today card" style="margin-bottom:20px">
        <h2 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--yellow);margin-bottom:12px">🎂 ¡Hoy cumplen años!</h2>
        <div style="display:flex;flex-wrap:wrap;gap:10px">
          <?php foreach($cumples_hoy as $f): ?>
          <div class="si-bday-chip">
            <div class="si-bday-avatar"><?= strtoupper(substr($f['nombres'],0,1).substr($f['apellidos'],0,1)) ?></div>
            <div>
              <strong style="display:block;font-size:14px"><?= htmlspecialchars($f['nombres'].' '.$f['apellidos']) ?></strong>
              <span style="font-size:12px;color:rgba(255,255,255,.65)"><?= htmlspecialchars($f['cargo']) ?></span>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

      <!-- Calendario académico -->
      <div style="margin-bottom:16px">
        <h2 style="font-size:16px;font-weight:700;margin-bottom:4px">Calendario Académico 2026–2027</h2>
        <div class="si-cal-filters">
          <button class="si-cal-btn active" onclick="calFilter(this,'all')">Todos</button>
          <button class="si-cal-btn" onclick="calFilter(this,'ingreso')">Ingresos</button>
          <button class="si-cal-btn" onclick="calFilter(this,'vacaciones')">Vacaciones</button>
          <button class="si-cal-btn" onclick="calFilter(this,'feriado')">Feriados</button>
          <button class="si-cal-btn" onclick="calFilter(this,'jornada')">Jornadas</button>
          <button class="si-cal-btn" onclick="calFilter(this,'fin_ano')">Fin Año</button>
        </div>
      </div>

      <div class="card" style="overflow:hidden;margin-bottom:20px">
        <div style="overflow-x:auto">
          <table class="si-table" id="calTable">
            <thead>
              <tr>
                <th>Tipo</th>
                <th>Evento</th>
                <th>Fecha / Período</th>
                <th>Aplica a</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($calendario as $ev):
                $tc = $tipo_config[$ev['tipo']] ?? $tipo_config['otro'];
              ?>
              <tr data-tipo="<?= $ev['tipo'] ?>">
                <td>
                  <span class="si-badge" style="background:<?= $tc['bg'] ?>;color:<?= $tc['color'] ?>"><?= $tc['label'] ?></span>
                </td>
                <td style="font-weight:500;font-size:13px"><?= htmlspecialchars($ev['titulo']) ?></td>
                <td style="font-size:12px;color:var(--muted);white-space:nowrap"><?= htmlspecialchars($ev['fecha']) ?></td>
                <td style="font-size:12px;color:var(--muted)"><?= htmlspecialchars($ev['estamento']) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Tabla dinámica post-carga Excel -->
      <div id="calDynamic" style="display:none;margin-bottom:20px">
        <h2 style="font-size:15px;font-weight:700;color:var(--blue);margin-bottom:12px">Datos cargados desde Excel <span id="dynCount" style="font-size:12px;color:var(--muted);font-weight:400"></span></h2>
        <div class="card" style="overflow:hidden">
          <div style="overflow-x:auto">
            <table class="si-table" id="dynTable">
              <thead><tr><th style="width:36px">#</th><th>Evento / Descripción</th><th>Fecha / Período</th></tr></thead>
              <tbody id="dynBody"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- ── Sidebar ────────────────────────────────────── -->
    <aside>

      <!-- Horario -->
      <div class="card" style="padding:18px;margin-bottom:16px">
        <h3 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--muted);margin-bottom:14px">Horario de funcionamiento</h3>
        <div class="si-horario-row">
          <span style="font-weight:600;font-size:13px">Lunes a Jueves</span>
          <span style="font-weight:700;font-size:14px;color:var(--blue)">08:30 – 17:00</span>
        </div>
        <div class="si-horario-row" style="border-bottom:none">
          <span style="font-weight:600;font-size:13px">Viernes</span>
          <span style="font-weight:700;font-size:14px;color:var(--blue)">08:30 – 15:30</span>
        </div>
        <div class="si-horario-now <?= $es_habil ? 'si-horario-now--ok' : '' ?>">
          <div class="si-dot <?= $es_habil ? 'si-dot--pulse' : '' ?>"></div>
          <?php if($es_habil): ?>
            Hoy es día hábil · <?= $turno_label ?> · Salida <?= $horario_hoy['salida'] ?>
          <?php else: ?>
            No es día hábil (<?= $dias_es[$dow] ?>)
          <?php endif; ?>
        </div>
      </div>

      <!-- Carga Excel -->
      <div class="card" style="padding:18px;margin-bottom:16px" id="carga-excel">
        <h3 style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--muted);margin-bottom:14px">Cargar Calendario (.xlsx)</h3>
        <div class="si-upload-zone" id="uploadZone" onclick="document.getElementById('fileInput').click()"
             ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)" ondrop="handleDrop(event)">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:6px"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><polyline points="9 15 12 12 15 15"/></svg>
          <p style="font-size:12px;color:var(--muted)">Arrastra aquí o <strong style="color:var(--blue)">selecciona</strong></p>
          <p id="uploadFileName" style="font-size:11px;color:var(--muted);margin-top:4px"></p>
        </div>
        <input type="file" id="fileInput" accept=".xlsx,.xls" onchange="handleFileSelect(event)" style="display:none">
        <button class="btn btn-primary" id="btnCargar" onclick="processExcel()" disabled style="width:100%;margin-top:10px;justify-content:center">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
          Cargar y mostrar
        </button>
        <div class="si-upload-status" id="uploadStatus"></div>
      </div>

      <!-- Próximos cumpleaños -->
      <h2 style="font-size:15px;font-weight:700;margin-bottom:10px">Próximos cumpleaños</h2>
      <div class="card" style="overflow:hidden">
        <?php if(count($cumples_prox)): ?>
        <?php $ci = 0; foreach($cumples_prox as $f):
          $dias = diasCumple($f['fecha_nac']);
          $initials = strtoupper(substr($f['nombres'],0,1).substr($f['apellidos'],0,1));
          $color = $avatar_colors[$ci++ % count($avatar_colors)];
        ?>
        <div class="si-upcoming-item">
          <div class="si-uc-avatar" style="background:<?= $color ?>"><?= $initials ?></div>
          <div style="flex:1">
            <strong style="display:block;font-size:13px"><?= htmlspecialchars($f['nombres'].' '.$f['apellidos']) ?></strong>
            <span style="font-size:12px;color:var(--muted)"><?= htmlspecialchars($f['cargo']) ?></span>
          </div>
          <div style="text-align:right">
            <div class="si-uc-days <?= $dias <= 7 ? 'si-uc-days--soon' : '' ?>"><?= $dias === 0 ? '¡Hoy!' : "en {$dias}d" ?></div>
            <div style="font-size:11px;color:var(--muted)"><?= date('d/m', strtotime($f['fecha_nac'])) ?></div>
          </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <div style="padding:24px;text-align:center;color:var(--muted);font-size:13px">No hay cumpleaños en los próximos 30 días</div>
        <?php endif; ?>
      </div>

    </aside>
  </div>

</div><!-- /content -->
</div><!-- /main -->
</div><!-- /app -->

<style>
.si-stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px}
@media(max-width:700px){.si-stats-row{grid-template-columns:repeat(2,1fr)}}
.si-layout{display:grid;grid-template-columns:1fr 300px;gap:20px}
@media(max-width:900px){.si-layout{grid-template-columns:1fr}}

.si-bday-today{background:linear-gradient(135deg,#1e3a5f,#2d5a8e);border:none;color:#fff;padding:20px;position:relative;overflow:hidden}
.si-bday-today::before{content:'🎂';position:absolute;right:16px;top:50%;transform:translateY(-50%);font-size:56px;opacity:.15;pointer-events:none}
.si-bday-chip{display:flex;align-items:center;gap:10px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);border-radius:40px;padding:7px 14px 7px 7px}
.si-bday-avatar{width:36px;height:36px;border-radius:50%;background:var(--yellow);display:grid;place-items:center;font-weight:800;font-size:14px;color:#1e3a5f;flex-shrink:0}

.si-cal-filters{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:14px}
.si-cal-btn{padding:5px 12px;border:1.5px solid var(--border);border-radius:20px;background:var(--card);font-size:12px;font-weight:500;color:var(--muted);cursor:pointer;transition:all var(--transition)}
.si-cal-btn:hover{border-color:var(--blue);color:var(--blue)}
.si-cal-btn.active{background:var(--blue);border-color:var(--blue);color:#fff}

.si-table{width:100%;border-collapse:collapse;font-size:13px}
.si-table thead th{background:var(--bg);padding:10px 14px;text-align:left;font-weight:600;font-size:11.5px;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);border-bottom:1px solid var(--border);white-space:nowrap}
.si-table tbody tr{border-bottom:1px solid var(--border);transition:background var(--transition)}
.si-table tbody tr:last-child{border-bottom:none}
.si-table tbody tr:hover{background:var(--bg)}
.si-table td{padding:11px 14px;vertical-align:middle}
.si-badge{display:inline-flex;padding:3px 8px;border-radius:12px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;white-space:nowrap}

.si-horario-row{display:flex;align-items:center;justify-content:space-between;padding:8px 0;border-bottom:1px dashed var(--border)}
.si-horario-now{margin-top:12px;padding:9px 12px;border-radius:8px;font-size:12px;background:var(--bg);border:1px solid var(--border);color:var(--muted);display:flex;align-items:center;gap:8px}
.si-horario-now--ok{background:var(--green-light);border-color:#bbf7d0;color:#166534}
.si-dot{width:8px;height:8px;border-radius:50%;background:#9ca3af;flex-shrink:0}
.si-dot--pulse{background:var(--green);animation:si-pulse 2s infinite}
@keyframes si-pulse{0%,100%{opacity:1}50%{opacity:.35}}

.si-upload-zone{border:2px dashed var(--border);border-radius:var(--radius);padding:18px 12px;text-align:center;cursor:pointer;transition:all var(--transition)}
.si-upload-zone:hover,.si-upload-zone.drag{border-color:var(--blue);background:var(--blue-light)}
.si-upload-status{margin-top:8px;padding:8px 10px;border-radius:6px;font-size:12px;font-weight:500;display:none}
.si-upload-status.ok{background:var(--green-light);color:#166534;border:1px solid #bbf7d0;display:block}
.si-upload-status.err{background:var(--danger-light);color:#991b1b;border:1px solid #fecaca;display:block}

.si-upcoming-item{display:flex;align-items:center;gap:12px;padding:11px 16px;border-bottom:1px solid var(--border);transition:background var(--transition)}
.si-upcoming-item:last-child{border-bottom:none}
.si-upcoming-item:hover{background:var(--bg)}
.si-uc-avatar{width:32px;height:32px;border-radius:50%;display:grid;place-items:center;font-weight:700;font-size:12px;color:#fff;flex-shrink:0}
.si-uc-days{font-weight:700;font-size:11px;padding:2px 7px;border-radius:12px;background:var(--bg);color:var(--muted);white-space:nowrap}
.si-uc-days--soon{background:var(--yellow-light);color:#92400e}
</style>

<?php include 'componentes/scripts.php'; ?>
<script>
function calFilter(btn, tipo) {
  document.querySelectorAll('.si-cal-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('#calTable tbody tr').forEach(row => {
    row.style.display = (tipo === 'all' || row.dataset.tipo === tipo) ? '' : 'none';
  });
}

let excelFile = null;
function handleDragOver(e) { e.preventDefault(); document.getElementById('uploadZone').classList.add('drag'); }
function handleDragLeave()  { document.getElementById('uploadZone').classList.remove('drag'); }
function handleDrop(e) { e.preventDefault(); document.getElementById('uploadZone').classList.remove('drag'); const f = e.dataTransfer.files[0]; if (f) setFile(f); }
function handleFileSelect(e) { const f = e.target.files[0]; if (f) setFile(f); }
function setFile(file) {
  excelFile = file;
  document.getElementById('uploadFileName').textContent = '📄 ' + file.name;
  document.getElementById('btnCargar').disabled = false;
  setStatus('', '');
}
function setStatus(msg, type) {
  const el = document.getElementById('uploadStatus');
  el.textContent = msg;
  el.className = 'si-upload-status' + (type ? ' ' + type : '');
}
function processExcel() {
  if (!excelFile || typeof XLSX === 'undefined') { setStatus('Biblioteca SheetJS no disponible todavía. Reintenta en un momento.', 'err'); return; }
  const btn = document.getElementById('btnCargar');
  btn.disabled = true; btn.textContent = 'Procesando…';
  const reader = new FileReader();
  reader.onload = function(e) {
    try {
      const data  = new Uint8Array(e.target.result);
      const wb    = XLSX.read(data, { type: 'array' });
      const sheet = wb.Sheets[wb.SheetNames[0]];
      const rows  = XLSX.utils.sheet_to_json(sheet, { header: 1, defval: '' });
      const valid = rows.filter((r, i) => i > 0 && (r[0] || r[1]) && String(r[0]).trim() !== 'CALENDARIO ACADÉMICO');
      const tbody = document.getElementById('dynBody');
      tbody.innerHTML = '';
      valid.forEach((row, idx) => {
        const c0 = String(row[0] || '').trim(), c1 = String(row[1] || '').trim();
        if (!c0 && !c1) return;
        const tr = document.createElement('tr');
        tr.innerHTML = `<td style="color:var(--muted);font-size:12px">${idx+1}</td><td style="font-weight:500">${escH(c0||'—')}</td><td style="color:var(--muted)">${escH(c1||'—')}</td>`;
        tbody.appendChild(tr);
      });
      document.getElementById('calDynamic').style.display = 'block';
      document.getElementById('dynCount').textContent = `${valid.length} registros`;
      setStatus('✓ ' + valid.length + ' eventos importados.', 'ok');
      document.getElementById('calDynamic').scrollIntoView({ behavior: 'smooth', block: 'start' });
    } catch(err) { setStatus('Error: ' + err.message, 'err'); }
    btn.disabled = false; btn.textContent = 'Cargar y mostrar';
  };
  reader.readAsArrayBuffer(excelFile);
}
function escH(s) { return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }
</script>
</body>
</html>
