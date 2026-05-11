<?php
require_once __DIR__ . '/class/conexion.php';
require_once __DIR__ . '/componentes/rail_acciones.php';
require_once __DIR__ . '/componentes/panel_contactos.php';
require_once __DIR__ . '/componentes/keep_widget.php';
require_once __DIR__ . '/componentes/menu_cabecera.php';

$db = new Conexion();
$conn = $db->getConexion();
$menusCabecera = menus_cabezera($conn);
$db->cerrar();
$paginaActual = basename($_SERVER['PHP_SELF'] ?? 'seduc_informa.php');

/**
 * seduc_informa.php
 * Portal informativo interno SEDUC — Cumpleaños + Calendario Académico
 *
 * ══════════════════════════════════════════════════════════════════
 *  TABLAS SQL NECESARIAS
 * ══════════════════════════════════════════════════════════════════
 *
 * -- 1. Funcionarios (para cumpleaños y directorio interno)
 * CREATE TABLE seduc_funcionarios (
 *   id            INT AUTO_INCREMENT PRIMARY KEY,
 *   nombres       VARCHAR(120) NOT NULL,
 *   apellidos     VARCHAR(120) NOT NULL,
 *   fecha_nac     DATE         NOT NULL,          -- solo día/mes importa; el año es opcional
 *   cargo         VARCHAR(150),
 *   unidad        ENUM('seduc_central','colegio','equipos_tecnicos','consejo_direccion','paradocente','auxiliar') DEFAULT 'seduc_central',
 *   email         VARCHAR(150),
 *   foto          VARCHAR(255),                   -- ruta a imagen
 *   activo        TINYINT(1)   DEFAULT 1,
 *   creado_en     DATETIME     DEFAULT CURRENT_TIMESTAMP
 * );
 *
 * -- 2. Calendario académico (cargado desde el Excel)
 * CREATE TABLE seduc_calendario (
 *   id            INT AUTO_INCREMENT PRIMARY KEY,
 *   titulo        VARCHAR(300)  NOT NULL,
 *   fecha_texto   VARCHAR(300),                   -- texto original del Excel
 *   fecha_inicio  DATE          DEFAULT NULL,      -- parseo cuando sea posible
 *   fecha_fin     DATE          DEFAULT NULL,
 *   tipo          ENUM('ingreso','vacaciones','feriado','jornada','fin_ano','otro') DEFAULT 'otro',
 *   estamento     VARCHAR(200),                   -- a quién aplica
 *   anio          SMALLINT      DEFAULT 2026,
 *   activo        TINYINT(1)    DEFAULT 1,
 *   actualizado   DATETIME      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
 * );
 *
 * -- 3. Log de cargas de Excel (auditoría)
 * CREATE TABLE seduc_carga_excel (
 *   id            INT AUTO_INCREMENT PRIMARY KEY,
 *   usuario       VARCHAR(100),
 *   archivo       VARCHAR(255),
 *   filas_cargadas INT DEFAULT 0,
 *   fecha         DATETIME DEFAULT CURRENT_TIMESTAMP
 * );
 *
 * ══════════════════════════════════════════════════════════════════
 *  DATOS ESTÁTICOS DE DEMOSTRACIÓN
 *  (reemplazar con consultas a BD en producción)
 * ══════════════════════════════════════════════════════════════════
 */

// ── Horario institucional ──────────────────────────────────────────
$HORARIO = [
    'lun-jue' => ['entrada' => '08:30', 'salida' => '17:00'],
    'vie'     => ['entrada' => '08:30', 'salida' => '15:30'],
];

// ── Funcionarios de ejemplo ────────────────────────────────────────
$hoy_md = date('m-d'); // mes-dia actual para comparar cumpleaños

$funcionarios = [
    ['id'=>1,'nombres'=>'Ana María','apellidos'=>'Rodríguez Vera',    'fecha_nac'=>'1985-'.date('m').'-'.date('d'), 'cargo'=>'Jefa de UTP',               'unidad'=>'seduc_central'],
    ['id'=>2,'nombres'=>'Carlos',    'apellidos'=>'Pérez Muñoz',       'fecha_nac'=>'1990-'.date('m').'-'.sprintf('%02d',date('d')+2>28?1:date('d')+2), 'cargo'=>'Coordinador TIC',           'unidad'=>'equipos_tecnicos'],
    ['id'=>3,'nombres'=>'Valentina', 'apellidos'=>'Soto Araya',        'fecha_nac'=>'1978-05-15',  'cargo'=>'Directora Colegio Los Pinos',  'unidad'=>'consejo_direccion'],
    ['id'=>4,'nombres'=>'Jorge',     'apellidos'=>'Fuentes Lagos',     'fecha_nac'=>'1992-06-22',  'cargo'=>'Administrativo',               'unidad'=>'colegio'],
    ['id'=>5,'nombres'=>'Daniela',   'apellidos'=>'Castillo Rojas',    'fecha_nac'=>'1988-07-04',  'cargo'=>'Paradocente',                  'unidad'=>'paradocente'],
    ['id'=>6,'nombres'=>'Roberto',   'apellidos'=>'Vidal Torres',      'fecha_nac'=>'1975-08-11',  'cargo'=>'Auxiliar',                     'unidad'=>'auxiliar'],
];

// Separar cumpleaños: hoy, próximos 30 días
function cumpleIsMd(string $fecha, string $ref_md): bool {
    return date('m-d', strtotime($fecha)) === $ref_md;
}
function diasParaCumple(string $fecha): int {
    $hoy = new DateTime(date('Y-m-d'));
    $cumple = new DateTime(date('Y').'-'.date('m-d', strtotime($fecha)));
    if ($cumple < $hoy) $cumple->modify('+1 year');
    return (int)$hoy->diff($cumple)->days;
}

$cumples_hoy    = array_filter($funcionarios, fn($f) => cumpleIsMd($f['fecha_nac'], $hoy_md));
$cumples_prox   = array_filter($funcionarios, fn($f) => !cumpleIsMd($f['fecha_nac'], $hoy_md) && diasParaCumple($f['fecha_nac']) <= 30);
usort($cumples_prox, fn($a,$b) => diasParaCumple($a['fecha_nac']) <=> diasParaCumple($b['fecha_nac']));

// ── Calendario académico 2026 (extraído del Excel) ─────────────────
$calendario = [
  // Ingresos
  ['tipo'=>'ingreso',   'titulo'=>'Ingreso Seduc Administración Central',                           'fecha'=>'Lunes 16 febrero 2026',      'estamento'=>'Seduc Central'],
  ['tipo'=>'ingreso',   'titulo'=>'Ingreso Administrativos y Auxiliares Colegios',                  'fecha'=>'Lunes 16 febrero 2026',      'estamento'=>'Colegios'],
  ['tipo'=>'ingreso',   'titulo'=>'Ingreso Paradocentes',                                           'fecha'=>'Con administrativos o docentes (a criterio del colegio)', 'estamento'=>'Paradocentes'],
  ['tipo'=>'ingreso',   'titulo'=>'Ingreso Consejos de Dirección',                                  'fecha'=>'Lunes 23 febrero 2026',      'estamento'=>'Consejos de Dirección'],
  ['tipo'=>'ingreso',   'titulo'=>'Ingreso Equipos Técnicos Seduc',                                 'fecha'=>'Lunes 23 febrero 2026',      'estamento'=>'Equipos Técnicos'],
  ['tipo'=>'ingreso',   'titulo'=>'Ingreso Profesores (Jornadas iniciales)',                        'fecha'=>'Miércoles 25 febrero 2026',  'estamento'=>'Profesores'],
  ['tipo'=>'jornada',   'titulo'=>'Jornada inducción Seduc — profesores nuevos',                    'fecha'=>'Martes 3 marzo (en Seduc)',  'estamento'=>'Profesores nuevos'],
  ['tipo'=>'ingreso',   'titulo'=>'Inicio año escolar Alumnos',                                     'fecha'=>'Miércoles 4 marzo 2026',     'estamento'=>'Alumnos'],
  // Vacaciones invierno
  ['tipo'=>'vacaciones','titulo'=>'Vacaciones invierno — Alumnos, Profesores y Consejos Dirección', 'fecha'=>'Lunes 22 junio – viernes 3 julio', 'estamento'=>'Alumnos / Profesores / Dirección'],
  ['tipo'=>'vacaciones','titulo'=>'Vacaciones invierno — Administrativos de Colegio',               'fecha'=>'Una semana por turnos, entre 22 jun – 3 jul', 'estamento'=>'Administrativos Colegio'],
  ['tipo'=>'vacaciones','titulo'=>'Vacaciones invierno — Seduc Adm. Central + Equipos Técnicos',    'fecha'=>'Lunes 29 junio – viernes 3 julio', 'estamento'=>'Seduc Central / Eq. Técnicos'],
  // Jornadas
  ['tipo'=>'jornada',   'titulo'=>'Jornada de Reflexión (sin alumnos ni profesores)',               'fecha'=>'11 septiembre y 9 octubre',  'estamento'=>'Todos los colegios'],
  ['tipo'=>'jornada',   'titulo'=>'Capacitación PRIMED Coordinadores',                              'fecha'=>'Segunda semana de julio (por confirmar)', 'estamento'=>'Coordinadores PRIMED'],
  // Fiestas patrias
  ['tipo'=>'feriado',   'titulo'=>'Vacaciones Fiestas Patrias — Alumnos, Dirección y Profesores',   'fecha'=>'Lunes 14 – viernes 18 septiembre', 'estamento'=>'Alumnos / Profesores / Dirección'],
  ['tipo'=>'feriado',   'titulo'=>'Vacaciones Fiestas Patrias — Adm., Secretaria, Auxiliares',      'fecha'=>'Jueves 17 septiembre (adicional a 18 y 19)', 'estamento'=>'Administrativos / Auxiliares'],
  ['tipo'=>'feriado',   'titulo'=>'Vacaciones Fiestas Patrias — Seduc Central + Eq. Técnicos',      'fecha'=>'Jueves 17 septiembre (adicional a 18 y 19)', 'estamento'=>'Seduc Central / Eq. Técnicos'],
  // Fin año académico
  ['tipo'=>'fin_ano',   'titulo'=>'Finalización año académico — Alumnos IV Medio',                  'fecha'=>'A criterio de cada colegio', 'estamento'=>'IV Medio'],
  ['tipo'=>'fin_ano',   'titulo'=>'Finalización año académico — Alumnos',                           'fecha'=>'Viernes 11 diciembre 2026',  'estamento'=>'Alumnos'],
  ['tipo'=>'fin_ano',   'titulo'=>'Finalización año académico — Profesores',                        'fecha'=>'Miércoles 30 diciembre 2026','estamento'=>'Profesores'],
  // Vacaciones verano
  ['tipo'=>'vacaciones','titulo'=>'Vacaciones verano — Profesores',                                 'fecha'=>'31 dic – una semana antes inicio 2027', 'estamento'=>'Profesores'],
  ['tipo'=>'vacaciones','titulo'=>'Vacaciones verano — Seduc Adm. Central',                         'fecha'=>'Miércoles 13 enero – viernes 12 febrero (ambos incluidos)', 'estamento'=>'Seduc Central'],
  ['tipo'=>'vacaciones','titulo'=>'Vacaciones verano — Consejos Dirección + Eq. Técnicos',          'fecha'=>'Lunes 11 enero – viernes 19 febrero (ambos incluidos)', 'estamento'=>'Dirección / Eq. Técnicos'],
  ['tipo'=>'vacaciones','titulo'=>'Vacaciones verano — Administrativos de Colegio',                 'fecha'=>'Lunes 18 enero – viernes 12 febrero (ambos incluidos)', 'estamento'=>'Administrativos Colegio'],
  // Feriados especiales
  ['tipo'=>'feriado',   'titulo'=>'Jueves Santo — todos los estamentos de colegios',                'fecha'=>'Jueves 2 abril 2026',        'estamento'=>'Todos'],
  ['tipo'=>'feriado',   'titulo'=>'Navidad — Seduc Central y Colegios',                             'fecha'=>'Jueves 24 diciembre 2026',   'estamento'=>'Todos'],
  ['tipo'=>'feriado',   'titulo'=>'Año Nuevo — estamentos de colegios',                             'fecha'=>'Jueves 31 diciembre 2026',   'estamento'=>'Colegios'],
  // Interferiados
  ['tipo'=>'feriado',   'titulo'=>'Interferiado',                                                   'fecha'=>'Viernes 22 mayo 2026',       'estamento'=>'Todos'],
  ['tipo'=>'feriado',   'titulo'=>'Interferiado',                                                   'fecha'=>'Viernes 17 julio 2026',      'estamento'=>'Todos'],
  ['tipo'=>'feriado',   'titulo'=>'Interferiado',                                                   'fecha'=>'Lunes 7 diciembre 2026',     'estamento'=>'Todos'],
];

// ── Día hábil actual ───────────────────────────────────────────────
$dow = (int)date('N'); // 1=lun … 7=dom
$es_habil = $dow >= 1 && $dow <= 5;
$horario_hoy = $dow === 5 ? $HORARIO['vie'] : $HORARIO['lun-jue'];
$turno_label = $dow === 5 ? 'Viernes' : 'Lun – Jue';

$tipo_config = [
  'ingreso'    => ['label'=>'Ingreso',    'color'=>'#1a56e8','bg'=>'#dce9ff','ico'=>'log-in'],
  'vacaciones' => ['label'=>'Vacaciones', 'color'=>'#0e9f6e','bg'=>'#def7ec','ico'=>'sun'],
  'feriado'    => ['label'=>'Feriado',    'color'=>'#e04b2a','bg'=>'#fde8e2','ico'=>'calendar-x'],
  'jornada'    => ['label'=>'Jornada',    'color'=>'#7e3af2','bg'=>'#ede9fe','ico'=>'users'],
  'fin_ano'    => ['label'=>'Fin Año',    'color'=>'#d97706','bg'=>'#fef3c7','ico'=>'flag'],
  'otro'       => ['label'=>'Otro',       'color'=>'#6b7280','bg'=>'#f3f4f6','ico'=>'info'],
];

$unidad_label = [
  'seduc_central'      => 'Seduc Central',
  'colegio'            => 'Colegio',
  'equipos_tecnicos'   => 'Eq. Técnicos',
  'consejo_direccion'  => 'Consejo Dirección',
  'paradocente'        => 'Paradocente',
  'auxiliar'           => 'Auxiliar',
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Seduc Hub | SEDUC Informa</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<!-- SheetJS para parseo de Excel en el navegador -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<?php renderRailAccionesStyles(); ?>
<?php renderPanelContactosStyles(); ?>
<?php renderKeepWidgetHead(); ?>
<style>
/* ── RESET & TOKENS ─────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
  --ink:       #111827;
  --ink-soft:  #374151;
  --ink-mute:  #6b7280;
  --line:      #e5e7eb;
  --bg:        #f3f4f6;
  --surface:   #ffffff;
  --primary:   #1e3a5f;
  --accent:    #e8a020;
  --accent-lt: #fef3c7;
  --ok:        #059669;
  --danger:    #dc2626;
  --info:      #2563eb;
  --radius:    12px;
  --shadow:    0 1px 8px rgba(0,0,0,.07), 0 1px 2px rgba(0,0,0,.05);
  --shadow-md: 0 4px 24px rgba(0,0,0,.10), 0 2px 6px rgba(0,0,0,.05);
  --font-h:    'Outfit', sans-serif;
  --font-b:    'Inter', sans-serif;
}
html { scroll-behavior: smooth; }
body { font-family: var(--font-b); background: var(--bg); color: var(--ink); font-size: 14px; line-height: 1.6; }
a { color: inherit; text-decoration: none; }
button { cursor: pointer; font-family: var(--font-b); }

/* ── HEADER ─────────────────────────────────────── */
.header {
  background: var(--primary);
  color: #fff;
  position: sticky; top:0; z-index:100;
}
.header__top {
  max-width:1280px; margin:0 auto;
  padding: 0 24px;
  height: 60px;
  display: flex; align-items: center; gap: 16px;
}
.header__logo {
  font-family: var(--font-h);
  font-weight: 800; font-size: 20px;
  display: flex; align-items: center; gap: 10px;
}
.header__logo-badge {
  background: var(--accent);
  color: var(--primary);
  padding: 3px 9px;
  border-radius: 6px;
  font-size: 13px; font-weight: 700;
}
.header__nav {
  margin-left: auto;
  display: flex; gap: 4px;
  list-style: none;
}
.header__nav a {
  padding: 6px 14px;
  border-radius: 8px;
  font-size: 13px; font-weight: 500;
  color: rgba(255,255,255,.75);
  transition: background .15s, color .15s;
}
.header__nav a:hover, .header__nav a.active {
  background: rgba(255,255,255,.12);
  color: #fff;
}
.header__horario {
  background: rgba(0,0,0,.25);
  padding: 10px 24px;
  display: flex; gap: 24px; justify-content: center; flex-wrap: wrap;
  font-size: 12px; color: rgba(255,255,255,.8);
  border-top: 1px solid rgba(255,255,255,.08);
}
.header__horario strong { color: var(--accent); font-weight: 600; }
.header__horario-item { display: flex; align-items: center; gap: 6px; }

/* ── LAYOUT ─────────────────────────────────────── */
.page { max-width: 1280px; margin: 0 auto; padding: 28px 24px 56px; }
.layout { display: grid; grid-template-columns: 1fr 340px; gap: 24px; }
@media (max-width: 900px) { .layout { grid-template-columns: 1fr; } }

/* ── SECTION HEADER ─────────────────────────────── */
.sec-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
.sec-title {
  font-family: var(--font-h);
  font-size: 17px; font-weight: 700;
  display: flex; align-items: center; gap: 8px;
}
.sec-title svg { width: 18px; height: 18px; flex-shrink: 0; }

/* ── CARD BASE ──────────────────────────────────── */
.card {
  background: var(--surface);
  border: 1px solid var(--line);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
}

/* ── CUMPLEAÑOS HOY ─────────────────────────────── */
.birthday-today {
  background: linear-gradient(135deg, #1e3a5f 0%, #2d5a8e 100%);
  border: none;
  color: #fff;
  padding: 24px;
  margin-bottom: 24px;
  position: relative; overflow: hidden;
}
.birthday-today::before {
  content: '🎂';
  position: absolute; right: 20px; top: 50%; transform: translateY(-50%);
  font-size: 64px; opacity: .15;
  pointer-events: none;
}
.birthday-today h2 {
  font-family: var(--font-h);
  font-size: 13px; font-weight: 700;
  text-transform: uppercase; letter-spacing: .08em;
  color: var(--accent); margin-bottom: 12px;
}
.birthday-today-list { display: flex; flex-wrap: wrap; gap: 12px; }
.bday-chip {
  display: flex; align-items: center; gap: 10px;
  background: rgba(255,255,255,.12);
  border: 1px solid rgba(255,255,255,.2);
  border-radius: 50px;
  padding: 8px 16px 8px 8px;
}
.bday-avatar {
  width: 38px; height: 38px; border-radius: 50%;
  background: var(--accent);
  display: grid; place-items: center;
  font-family: var(--font-h); font-weight: 800; font-size: 15px;
  color: var(--primary); flex-shrink: 0;
}
.bday-info strong { display: block; font-size: 14px; font-weight: 600; }
.bday-info span   { font-size: 12px; color: rgba(255,255,255,.65); }

/* ── PRÓXIMOS CUMPLEAÑOS ────────────────────────── */
.upcoming-list { display: flex; flex-direction: column; gap: 2px; }
.upcoming-item {
  display: flex; align-items: center; gap: 12px;
  padding: 11px 16px;
  border-radius: 8px;
  transition: background .12s;
}
.upcoming-item:hover { background: var(--bg); }
.uc-avatar {
  width: 34px; height: 34px; border-radius: 50%;
  display: grid; place-items: center;
  font-family: var(--font-h); font-weight: 700; font-size: 13px;
  color: #fff; flex-shrink: 0;
}
.uc-name { flex: 1; }
.uc-name strong { display: block; font-size: 13px; font-weight: 600; }
.uc-name span   { font-size: 12px; color: var(--ink-mute); }
.uc-days {
  font-family: var(--font-h); font-weight: 700;
  font-size: 12px; white-space: nowrap;
  padding: 3px 9px; border-radius: 20px;
  background: var(--bg); color: var(--ink-mute);
}
.uc-days.soon { background: #fef3c7; color: #92400e; }
.uc-date { font-size: 12px; color: var(--ink-mute); white-space: nowrap; }

/* ── HORARIO INFO ───────────────────────────────── */
.horario-card { padding: 20px; margin-bottom: 20px; }
.horario-card h3 {
  font-family: var(--font-h); font-size: 13px; font-weight: 700;
  text-transform: uppercase; letter-spacing: .07em;
  color: var(--ink-mute); margin-bottom: 14px;
}
.horario-row {
  display: flex; align-items: center; justify-content: space-between;
  padding: 9px 0; border-bottom: 1px dashed var(--line);
}
.horario-row:last-child { border-bottom: none; }
.horario-row__days { font-weight: 600; font-size: 13px; }
.horario-row__time {
  font-family: var(--font-h); font-weight: 700; font-size: 14px;
  color: var(--primary);
}
.horario-now {
  margin-top: 14px; padding: 10px 14px;
  background: <?= $es_habil ? '#f0fdf4' : '#f9fafb' ?>;
  border: 1px solid <?= $es_habil ? '#bbf7d0' : 'var(--line)' ?>;
  border-radius: 8px; font-size: 13px;
  color: <?= $es_habil ? '#166534' : 'var(--ink-mute)' ?>;
  display: flex; align-items: center; gap: 8px;
}
.horario-now-dot {
  width: 8px; height: 8px; border-radius: 50%;
  background: <?= $es_habil ? 'var(--ok)' : '#9ca3af' ?>;
  flex-shrink: 0;
  <?= $es_habil ? 'animation: pulse 2s infinite;' : '' ?>
}
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.35} }

/* ── CARGA EXCEL ────────────────────────────────── */
.upload-card { padding: 20px; }
.upload-card h3 {
  font-family: var(--font-h); font-size: 13px; font-weight: 700;
  text-transform: uppercase; letter-spacing: .07em;
  color: var(--ink-mute); margin-bottom: 14px;
}
.upload-zone {
  border: 2px dashed var(--line);
  border-radius: 10px;
  padding: 22px 16px;
  text-align: center;
  cursor: pointer;
  transition: border-color .2s, background .2s;
}
.upload-zone:hover, .upload-zone.drag { border-color: var(--info); background: #eff6ff; }
.upload-zone svg { width: 32px; height: 32px; stroke: var(--ink-mute); margin-bottom: 8px; }
.upload-zone p { font-size: 13px; color: var(--ink-mute); }
.upload-zone strong { color: var(--info); }
#fileInput { display: none; }

.btn-upload {
  width: 100%; margin-top: 12px;
  padding: 10px;
  background: var(--primary); color: #fff;
  border: none; border-radius: 8px;
  font-size: 13px; font-weight: 600;
  display: flex; align-items: center; justify-content: center; gap: 7px;
  transition: background .15s;
}
.btn-upload:hover { background: #162d4a; }
.btn-upload svg { width: 15px; height: 15px; }
.btn-upload:disabled { opacity: .5; cursor: default; }

.upload-status {
  margin-top: 10px; padding: 9px 12px;
  border-radius: 8px; font-size: 12px; font-weight: 500;
  display: none;
}
.upload-status.ok   { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; display: block; }
.upload-status.err  { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; display: block; }

/* ── CALENDARIO ─────────────────────────────────── */
.cal-filters {
  display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 16px;
}
.cal-filter-btn {
  padding: 5px 13px;
  border: 1.5px solid var(--line);
  border-radius: 20px;
  background: var(--surface);
  font-size: 12px; font-weight: 500;
  color: var(--ink-soft);
  transition: all .12s;
}
.cal-filter-btn:hover { border-color: var(--primary); color: var(--primary); }
.cal-filter-btn.active { background: var(--primary); border-color: var(--primary); color: #fff; }

.cal-table-wrap { overflow-x: auto; }
.cal-table {
  width: 100%; border-collapse: collapse;
  font-size: 13px;
}
.cal-table thead th {
  background: var(--bg);
  padding: 10px 14px;
  text-align: left;
  font-weight: 600;
  font-size: 11.5px;
  text-transform: uppercase; letter-spacing: .06em;
  color: var(--ink-mute);
  border-bottom: 1px solid var(--line);
  white-space: nowrap;
}
.cal-table tbody tr {
  border-bottom: 1px solid var(--line);
  transition: background .1s;
}
.cal-table tbody tr:last-child { border-bottom: none; }
.cal-table tbody tr:hover { background: #f9fafb; }
.cal-table td { padding: 12px 14px; vertical-align: middle; }

.tipo-badge {
  display: inline-flex; align-items: center; gap: 5px;
  padding: 3px 9px;
  border-radius: 20px;
  font-size: 11px; font-weight: 700;
  text-transform: uppercase; letter-spacing: .05em;
  white-space: nowrap;
}
.tipo-badge svg { width: 11px; height: 11px; flex-shrink: 0; }

.cal-titulo { font-weight: 500; color: var(--ink); line-height: 1.4; }
.cal-estamento { font-size: 11.5px; color: var(--ink-mute); margin-top: 2px; }
.cal-fecha { font-size: 12px; color: var(--ink-soft); white-space: nowrap; }

/* ── DYNAMIC CALENDAR (post-carga Excel) ────────── */
#calDynamic { display: none; margin-top: 24px; }
#calDynamic .sec-title { margin-bottom: 12px; }
#dynTable { width: 100%; border-collapse: collapse; font-size: 13px; }
#dynTable thead th {
  background: var(--bg); padding: 9px 14px;
  text-align: left; font-weight: 600;
  font-size: 11.5px; text-transform: uppercase; letter-spacing: .06em;
  color: var(--ink-mute); border-bottom: 1px solid var(--line);
}
#dynTable tbody tr { border-bottom: 1px solid var(--line); }
#dynTable tbody tr:hover { background: #f9fafb; }
#dynTable td { padding: 10px 14px; vertical-align: middle; font-size: 13px; }

/* ── STATS ROW ──────────────────────────────────── */
.stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
@media (max-width: 700px) { .stats-row { grid-template-columns: repeat(2, 1fr); } }
.stat-card {
  padding: 16px 18px;
  border-radius: var(--radius);
  background: var(--surface);
  border: 1px solid var(--line);
  box-shadow: var(--shadow);
}
.stat-card__val {
  font-family: var(--font-h); font-weight: 800;
  font-size: 28px; line-height: 1;
  margin-bottom: 4px;
}
.stat-card__lbl { font-size: 12px; color: var(--ink-mute); font-weight: 500; }

/* ── SCROLL TOP ─────────────────────────────────── */
#scrollTop {
  position: fixed; bottom: 22px; right: 22px;
  width: 38px; height: 38px;
  background: var(--primary); color: #fff;
  border: none; border-radius: 50%;
  display: grid; place-items: center;
  box-shadow: 0 4px 14px rgba(30,58,95,.4);
  opacity: 0; pointer-events: none;
  transition: opacity .3s; z-index: 50;
}
#scrollTop.visible { opacity: 1; pointer-events: all; }
#scrollTop svg { width: 16px; height: 16px; }

/* ── EMPTY STATE ────────────────────────────────── */
.empty { text-align: center; padding: 32px; color: var(--ink-mute); font-size: 13px; }
.empty svg { width: 36px; height: 36px; stroke: var(--line); margin-bottom: 8px; display: block; margin-left: auto; margin-right: auto; }

/* ── SEDUC HUB TOPBAR ─────────────────────────────────────────────── */
.container{width:min(1280px,calc(100% - 36px));margin-inline:auto}
.topbar{position:sticky;top:0;z-index:200;background:rgba(255,255,255,.95);backdrop-filter:blur(10px);border-bottom:1px solid #e5eaf6}
.topbar__inner{display:flex;align-items:center;justify-content:space-between;gap:14px;padding:14px 0}
.brand{display:flex;align-items:center;gap:12px}
.brand__logo{width:42px;height:42px;border-radius:14px;background:linear-gradient(135deg,#2f57b7,#23449a);color:#fff;display:grid;place-items:center;font-weight:900;font-size:14px;font-family:ui-sans-serif,system-ui,sans-serif}
.brand__name{font-weight:900;line-height:1;color:#0f172a;font-family:ui-sans-serif,system-ui,sans-serif} .brand__tag{font-size:12px;color:#64748b;margin-top:2px;font-family:ui-sans-serif,system-ui,sans-serif}
.topbar__nav{display:flex;align-items:center;gap:18px}
.navlink{font-weight:700;color:#64748b;padding:10px 12px;border-radius:12px;font-size:14px;font-family:ui-sans-serif,system-ui,sans-serif}
.navlink:hover{background:#eef2ff;color:#0f172a} .navlink.is-active{background:#eef2ff;color:#2f57b7}
.topbar__right .usermenu{position:relative}
.userbtn{display:flex;align-items:center;gap:10px;padding:8px 10px;border-radius:18px;border:1px solid #e5eaf6;background:rgba(255,255,255,.82);backdrop-filter:blur(10px);cursor:pointer;box-shadow:0 8px 20px rgba(15,23,42,.08);transition:.15s ease;font-family:ui-sans-serif,system-ui,sans-serif}
.userbtn:hover{background:#fff}
.userbtn__avatar{width:36px;height:36px;border-radius:14px;display:grid;place-items:center;background:#eef2ff;color:#2f57b7;font-weight:900}
.userbtn__text{display:flex;flex-direction:column;line-height:1.05;text-align:left}
.userbtn__name{font-weight:900;font-size:13px;color:#0f172a} .userbtn__role{font-weight:800;font-size:12px;color:#64748b;margin-top:2px} .userbtn__chev{margin-left:6px;color:#64748b;font-weight:900}
.topbar__right .dropdown{position:absolute;right:0;top:calc(100% + 10px);width:220px;border-radius:16px;border:1px solid #e5eaf6;background:rgba(255,255,255,.96);backdrop-filter:blur(10px);box-shadow:0 10px 30px rgba(15,23,42,.10);padding:8px;display:none;z-index:300}
.topbar__right .usermenu:hover .dropdown{display:block}
.dropdown__item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:12px;font-weight:800;color:#0f172a;font-size:13px;font-family:ui-sans-serif,system-ui,sans-serif}
.dropdown__item:hover{background:#eef2ff;color:#2f57b7} .dropdown__sep{height:1px;background:#e5eaf6;margin:8px 6px}
.dropdown__item--danger{color:#b91c1c} .dropdown__item--danger:hover{background:#fff1f2;color:#b91c1c}
@media(max-width:820px){.topbar__nav{display:none}}
</style>
</head>
<body>

<header class="topbar">
  <div class="container">
    <div class="topbar__inner">
      <div class="brand">
        <div class="brand__logo">SH</div>
        <div><div class="brand__name">Seduc Hub</div><div class="brand__tag">Portal Operativo</div></div>
      </div>
      <nav class="topbar__nav">
        <?php if (empty($menusCabecera)): ?>
          <a class="navlink" href="index_1.php">Inicio</a>
        <?php else: ?>
          <?php foreach ($menusCabecera as $menu): ?>
            <?php $claseActiva = basename($menu['href']) === $paginaActual ? ' is-active' : ''; ?>
            <a class="navlink<?= $claseActiva ?>" href="<?= htmlspecialchars($menu['href'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($menu['menu'] ?: 'Menu', ENT_QUOTES, 'UTF-8') ?></a>
          <?php endforeach; ?>
        <?php endif; ?>
      </nav>
      <?php renderTopbarUserMenu(); ?>
    </div>
  </div>
</header>

<!-- ═══ PAGE ══════════════════════════════════════ -->
<div class="page">

  <!-- Stats rápidos -->
  <div class="stats-row">
    <div class="stat-card">
      <div class="stat-card__val" style="color:var(--primary)"><?= count($funcionarios) ?></div>
      <div class="stat-card__lbl">Funcionarios</div>
    </div>
    <div class="stat-card">
      <div class="stat-card__val" style="color:#e8a020"><?= count($cumples_hoy) ?></div>
      <div class="stat-card__lbl">Cumplen hoy</div>
    </div>
    <div class="stat-card">
      <div class="stat-card__val" style="color:#7e3af2"><?= count($cumples_prox) ?></div>
      <div class="stat-card__lbl">Próximos 30 días</div>
    </div>
    <div class="stat-card">
      <div class="stat-card__val" style="color:#059669"><?= count($calendario) ?></div>
      <div class="stat-card__lbl">Eventos en calendario</div>
    </div>
  </div>

  <div class="layout">

    <!-- ══ COLUMNA PRINCIPAL ══════════════════════ -->
    <div>

      <!-- Cumpleaños HOY -->
      <?php if(count($cumples_hoy)): ?>
      <div class="birthday-today card" id="cumpleanos">
        <h2><?= svgIcon('gift', 14) ?> ¡Hoy cumplen años!</h2>
        <div class="birthday-today-list">
          <?php foreach($cumples_hoy as $f): ?>
          <div class="bday-chip">
            <div class="bday-avatar"><?= strtoupper(substr($f['nombres'],0,1).substr($f['apellidos'],0,1)) ?></div>
            <div class="bday-info">
              <strong><?= htmlspecialchars($f['nombres'].' '.$f['apellidos']) ?></strong>
              <span><?= htmlspecialchars($f['cargo']) ?></span>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php else: ?>
      <div id="cumpleanos"></div>
      <?php endif; ?>

      <!-- Calendario Académico -->
      <section id="calendario">
        <div class="sec-head">
          <h2 class="sec-title"><?= svgIcon('calendar', 18) ?> Calendario Académico 2026–2027</h2>
        </div>

        <div class="cal-filters">
          <button class="cal-filter-btn active" onclick="calFilter(this,'all')">Todos</button>
          <button class="cal-filter-btn" onclick="calFilter(this,'ingreso')">Ingresos</button>
          <button class="cal-filter-btn" onclick="calFilter(this,'vacaciones')">Vacaciones</button>
          <button class="cal-filter-btn" onclick="calFilter(this,'feriado')">Feriados</button>
          <button class="cal-filter-btn" onclick="calFilter(this,'jornada')">Jornadas</button>
          <button class="cal-filter-btn" onclick="calFilter(this,'fin_ano')">Fin Año</button>
        </div>

        <div class="card cal-table-wrap">
          <table class="cal-table" id="calTable">
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
                  <span class="tipo-badge" style="background:<?= $tc['bg'] ?>;color:<?= $tc['color'] ?>">
                    <?= svgIconRaw($tc['ico'], 11, $tc['color']) ?>
                    <?= $tc['label'] ?>
                  </span>
                </td>
                <td>
                  <div class="cal-titulo"><?= htmlspecialchars($ev['titulo']) ?></div>
                </td>
                <td class="cal-fecha"><?= htmlspecialchars($ev['fecha']) ?></td>
                <td><span class="cal-estamento"><?= htmlspecialchars($ev['estamento']) ?></span></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <!-- Tabla dinámica post-carga Excel -->
        <div id="calDynamic">
          <div class="sec-head" style="margin-top:28px">
            <h2 class="sec-title" style="color:var(--info)"><?= svgIcon('file-text', 18) ?> Datos cargados desde Excel</h2>
            <span id="dynCount" style="font-size:12px;color:var(--ink-mute)"></span>
          </div>
          <div class="card cal-table-wrap">
            <table id="dynTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Evento / Descripción</th>
                  <th>Fecha / Período</th>
                </tr>
              </thead>
              <tbody id="dynBody"></tbody>
            </table>
          </div>
        </div>
      </section>
    </div>

    <!-- ══ SIDEBAR ════════════════════════════════ -->
    <aside>

      <!-- Horario -->
      <div class="card horario-card">
        <h3><?= svgIcon('clock', 13) ?> Horario de funcionamiento</h3>
        <div class="horario-row">
          <span class="horario-row__days">Lunes a Jueves</span>
          <span class="horario-row__time">08:30 – 17:00</span>
        </div>
        <div class="horario-row">
          <span class="horario-row__days">Viernes</span>
          <span class="horario-row__time">08:30 – 15:30</span>
        </div>
        <div class="horario-now">
          <div class="horario-now-dot"></div>
          <?php if($es_habil): ?>
            Hoy es día hábil · <?= $turno_label ?> · Salida <?= $horario_hoy['salida'] ?>
          <?php else: ?>
            Hoy no es día hábil (<?= ['','Lun','Mar','Mié','Jue','Vie','Sáb','Dom'][$dow] ?>)
          <?php endif; ?>
        </div>
      </div>

      <!-- Carga Excel -->
      <div class="card upload-card" id="carga-excel">
        <h3><?= svgIcon('upload', 13) ?> Cargar Calendario (.xlsx)</h3>
        <div class="upload-zone" id="uploadZone" onclick="document.getElementById('fileInput').click()"
             ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)" ondrop="handleDrop(event)">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><polyline points="9 15 12 12 15 15"/>
          </svg>
          <p>Arrastra tu archivo aquí<br>o <strong>selecciona desde tu equipo</strong></p>
          <p id="uploadFileName" style="margin-top:6px;font-size:11px;color:#6b7280"></p>
        </div>
        <input type="file" id="fileInput" accept=".xlsx,.xls" onchange="handleFileSelect(event)">
        <button class="btn-upload" id="btnCargar" onclick="processExcel()" disabled>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
          Cargar y mostrar datos
        </button>
        <div class="upload-status" id="uploadStatus"></div>
      </div>

      <!-- Próximos cumpleaños -->
      <div style="margin-top:20px">
        <div class="sec-head">
          <h2 class="sec-title"><?= svgIcon('cake', 18) ?> Próximos cumpleaños</h2>
        </div>
        <div class="card">
          <?php if(count($cumples_prox)): ?>
          <div class="upcoming-list" style="padding: 8px 0;">
            <?php
            $avatar_colors = ['#1e3a5f','#7e3af2','#059669','#d97706','#dc2626','#2563eb'];
            $ci = 0;
            foreach($cumples_prox as $f):
              $dias = diasParaCumple($f['fecha_nac']);
              $initials = strtoupper(substr($f['nombres'],0,1).substr($f['apellidos'],0,1));
              $color = $avatar_colors[$ci++ % count($avatar_colors)];
            ?>
            <div class="upcoming-item">
              <div class="uc-avatar" style="background:<?= $color ?>"><?= $initials ?></div>
              <div class="uc-name">
                <strong><?= htmlspecialchars($f['nombres'].' '.$f['apellidos']) ?></strong>
                <span><?= htmlspecialchars($f['cargo']) ?></span>
              </div>
              <div>
                <div class="uc-days <?= $dias <= 7 ? 'soon' : '' ?>"><?= $dias === 0 ? '¡Hoy!' : "en {$dias}d" ?></div>
                <div class="uc-date"><?= date('d/m', strtotime($f['fecha_nac'])) ?></div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          <?php else: ?>
          <div class="empty">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            No hay cumpleaños en los próximos 30 días
          </div>
          <?php endif; ?>
        </div>
      </div>

    </aside>
  </div><!-- /layout -->
</div><!-- /page -->

<!-- Scroll top -->
<button id="scrollTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
  <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"/></svg>
</button>

<script>
// ── FILTRO CALENDARIO ─────────────────────────────
function calFilter(btn, tipo) {
  document.querySelectorAll('.cal-filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('#calTable tbody tr').forEach(row => {
    row.style.display = (tipo === 'all' || row.dataset.tipo === tipo) ? '' : 'none';
  });
}

// ── CARGA EXCEL ───────────────────────────────────
let excelFile = null;

function handleDragOver(e) {
  e.preventDefault();
  document.getElementById('uploadZone').classList.add('drag');
}
function handleDragLeave() {
  document.getElementById('uploadZone').classList.remove('drag');
}
function handleDrop(e) {
  e.preventDefault();
  document.getElementById('uploadZone').classList.remove('drag');
  const file = e.dataTransfer.files[0];
  if (file) setFile(file);
}
function handleFileSelect(e) {
  const file = e.target.files[0];
  if (file) setFile(file);
}
function setFile(file) {
  excelFile = file;
  document.getElementById('uploadFileName').textContent = '📄 ' + file.name;
  document.getElementById('btnCargar').disabled = false;
  setStatus('', '');
}

function setStatus(msg, type) {
  const el = document.getElementById('uploadStatus');
  el.textContent = msg;
  el.className = 'upload-status' + (type ? ' ' + type : '');
}

function processExcel() {
  if (!excelFile) return;
  const btn = document.getElementById('btnCargar');
  btn.disabled = true; btn.textContent = 'Procesando…';

  const reader = new FileReader();
  reader.onload = function(e) {
    try {
      const data  = new Uint8Array(e.target.result);
      const wb    = XLSX.read(data, { type: 'array' });
      const sheet = wb.Sheets[wb.SheetNames[0]];
      const rows  = XLSX.utils.sheet_to_json(sheet, { header: 1, defval: '' });

      // Filtrar filas vacías y cabeceras
      const valid = rows.filter((r, i) => i > 0 && (r[0] || r[1]) && String(r[0]).trim() !== 'CALENDARIO ACADÉMICO');

      const tbody = document.getElementById('dynBody');
      tbody.innerHTML = '';
      valid.forEach((row, idx) => {
        const col0 = String(row[0] || '').trim();
        const col1 = String(row[1] || '').trim();
        if (!col0 && !col1) return;
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td style="color:var(--ink-mute);font-size:12px;width:36px">${idx+1}</td>
          <td style="font-weight:500">${escHtml(col0 || '—')}</td>
          <td style="color:var(--ink-soft)">${escHtml(col1 || '—')}</td>
        `;
        tbody.appendChild(tr);
      });

      document.getElementById('calDynamic').style.display = 'block';
      document.getElementById('dynCount').textContent = valid.length + ' registros cargados';
      setStatus('✓ Archivo cargado: ' + valid.length + ' eventos importados.', 'ok');

      // scroll suave a la tabla dinámica
      document.getElementById('calDynamic').scrollIntoView({ behavior: 'smooth', block: 'start' });

    } catch(err) {
      setStatus('Error al procesar el archivo: ' + err.message, 'err');
    }
    btn.disabled = false;
    btn.innerHTML = `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg> Cargar y mostrar datos`;
  };
  reader.readAsArrayBuffer(excelFile);
}

function escHtml(str) {
  return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

// ── SCROLL TOP ────────────────────────────────────
const scrollBtn = document.getElementById('scrollTop');
window.addEventListener('scroll', () => {
  scrollBtn.classList.toggle('visible', window.scrollY > 280);
});
</script>

<?php renderRailAcciones(true); ?>
<?php renderPanelContactos(); ?>
</body>
</html>
<?php
/* ─── HELPERS ────────────────────────────────────── */
function svgIcon(string $name, int $size = 16): string {
  return svgIconRaw($name, $size, 'currentColor');
}
function svgIconRaw(string $name, int $size, string $stroke): string {
  $paths = [
    'clock'       => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
    'calendar'    => '<rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
    'gift'        => '<polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/>',
    'cake'        => '<path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/><path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/><line x1="2" y1="21" x2="22" y2="21"/><path d="M7 8v3"/><path d="M12 8v3"/><path d="M17 8v3"/><path d="M7 4h.01"/><path d="M12 4h.01"/><path d="M17 4h.01"/>',
    'upload'      => '<polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>',
    'file-text'   => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>',
    'log-in'      => '<path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>',
    'sun'         => '<circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>',
    'calendar-x'  => '<rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="10" y1="14" x2="14" y2="18"/><line x1="14" y1="14" x2="10" y2="18"/>',
    'users'       => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
    'flag'        => '<path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/>',
    'info'        => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>',
  ];
  $p = $paths[$name] ?? '<circle cx="12" cy="12" r="10"/>';
  return '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="'.$stroke.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0">'.$p.'</svg>';
}

function strftime_es(): string {
  $dias   = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
  $meses  = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
  return $dias[date('w')].', '.date('j').' de '.$meses[date('n')-1].' de '.date('Y');
}
?>