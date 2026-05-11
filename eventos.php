<?php
require_once __DIR__ . '/class/conexion.php';
require_once __DIR__ . '/componentes/menu_cabecera.php';

$db = new Conexion();
$conn = $db->getConexion();
$menusCabecera = menus_cabezera($conn);
$paginaActual = basename($_SERVER['PHP_SELF'] ?? 'eventos.php');
$db->cerrar();

// ── Conexión BD (ajustar credenciales) ────────────────────────────
// $pdo = new PDO('mysql:host=localhost;dbname=tu_bd;charset=utf8', 'usuario', 'clave');
// $stmt = $pdo->prepare("
//   SELECT id, titulo, descripcion, fecha_inicio, fecha_fin,
//          hora_inicio, hora_fin, hora_evento, con_audio, solo_presentacion,
//          musica_ambiental, cantidad_personas, ubicacion, tipo_evento,
//          estado, color_evento, observaciones_logisticas,
//          correo_enviado, responsable_id
//   FROM eventos
//   WHERE eliminado = 0
//     AND (
//       (MONTH(fecha_inicio) = :mes AND YEAR(fecha_inicio) = :anio)
//       OR (MONTH(fecha_fin)   = :mes AND YEAR(fecha_fin)   = :anio)
//       OR (fecha_inicio <= LAST_DAY(CONCAT(:anio,'-',:mes,'-01'))
//           AND fecha_fin >= CONCAT(:anio,'-',:mes,'-01'))
//     )
//   ORDER BY fecha_inicio, hora_inicio
// ");
// $stmt->execute([':mes' => $mes, ':anio' => $anio]);
// $eventos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ── Parámetros de navegación ───────────────────────────────────────
$hoy_full = date('Y-m-d');
$mes  = isset($_GET['mes'])  ? (int)$_GET['mes']  : (int)date('m');
$anio = isset($_GET['anio']) ? (int)$_GET['anio'] : (int)date('Y');
$mes  = max(1, min(12, $mes));

$prev_mes  = $mes === 1  ? 12 : $mes - 1;
$prev_anio = $mes === 1  ? $anio - 1 : $anio;
$next_mes  = $mes === 12 ? 1  : $mes + 1;
$next_anio = $mes === 12 ? $anio + 1 : $anio;

$primer_dia_mes = date('N', mktime(0,0,0,$mes,1,$anio)); // 1=lun…7=dom
$dias_en_mes    = (int)date('t', mktime(0,0,0,$mes,1,$anio));

$meses_es = ['','Enero','Febrero','Marzo','Abril','Mayo','Junio',
             'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
$dias_semana = ['Lun','Mar','Mié','Jue','Vie','Sáb','Dom'];

// ── Datos de demostración (reemplazar con $eventos_db) ─────────────
// Genera eventos para el mes actual
function makeDate(int $mes, int $anio, int $dia, string $extra=''): string {
  return sprintf('%04d-%02d-%02d', $anio, $mes, $dia) . $extra;
}
$y = $anio; $m = $mes;
$d = $dias_en_mes;
$eventos_demo = [
  ['id'=>1,  'titulo'=>'Reunión Contabilidad',           'descripcion'=>'Revisión de cierre contable mensual y análisis de presupuesto ejecutado.', 'fecha_inicio'=>makeDate($m,$y,min(5,$d)),  'fecha_fin'=>makeDate($m,$y,min(5,$d)),  'hora_inicio'=>'09:00', 'hora_fin'=>'10:30', 'hora_evento'=>'09:00', 'ubicacion'=>'Sala A – Piso 2',       'tipo_evento'=>'reunion',     'estado'=>'confirmado', 'color_evento'=>'#1a56e8', 'con_audio'=>0,'solo_presentacion'=>1,'musica_ambiental'=>0,'cantidad_personas'=>12,'observaciones_logisticas'=>'Proyector disponible. Llegar 10 min antes.','correo_enviado'=>1,'responsable_id'=>3],
  ['id'=>2,  'titulo'=>'Taller Docentes UTP',             'descripcion'=>'Capacitación en nuevas metodologías de evaluación formativa. Obligatorio para todos los docentes de ciclo básico.',  'fecha_inicio'=>makeDate($m,$y,min(7,$d)),  'fecha_fin'=>makeDate($m,$y,min(7,$d)),  'hora_inicio'=>'08:30', 'hora_fin'=>'13:00', 'hora_evento'=>'08:30', 'ubicacion'=>'Auditorio Principal',    'tipo_evento'=>'capacitacion','estado'=>'confirmado', 'color_evento'=>'#7e3af2', 'con_audio'=>1,'solo_presentacion'=>0,'musica_ambiental'=>0,'cantidad_personas'=>60,'observaciones_logisticas'=>'Audio + proyector. Café disponible desde 08:00.','correo_enviado'=>1,'responsable_id'=>5],
  ['id'=>3,  'titulo'=>'Comité Directivo',                'descripcion'=>'Sesión mensual del comité directivo. Revisión de indicadores, metas y planificación del trimestre.',                  'fecha_inicio'=>makeDate($m,$y,min(9,$d)),  'fecha_fin'=>makeDate($m,$y,min(9,$d)),  'hora_inicio'=>'14:00', 'hora_fin'=>'16:00', 'hora_evento'=>'14:00', 'ubicacion'=>'Sala Directorio',       'tipo_evento'=>'directivo',   'estado'=>'confirmado', 'color_evento'=>'#0e9f6e', 'con_audio'=>0,'solo_presentacion'=>0,'musica_ambiental'=>0,'cantidad_personas'=>8, 'observaciones_logisticas'=>'Documento de actas preparado por secretaría.','correo_enviado'=>1,'responsable_id'=>1],
  ['id'=>4,  'titulo'=>'Ceremonia Licenciatura IV Medio', 'descripcion'=>'Licenciatura oficial de los alumnos de IV Medio. Acto formal con presencia de apoderados, autoridades comunales y municipales.', 'fecha_inicio'=>makeDate($m,$y,min(12,$d)), 'fecha_fin'=>makeDate($m,$y,min(12,$d)), 'hora_inicio'=>'19:00', 'hora_fin'=>'21:30', 'hora_evento'=>'19:00', 'ubicacion'=>'Teatro Municipal',       'tipo_evento'=>'ceremonia',   'estado'=>'confirmado', 'color_evento'=>'#d97706', 'con_audio'=>1,'solo_presentacion'=>0,'musica_ambiental'=>1,'cantidad_personas'=>350,'observaciones_logisticas'=>'Sonido y luces a cargo de empresa externa. Musica ambiental desde 18:30.','correo_enviado'=>1,'responsable_id'=>2],
  ['id'=>5,  'titulo'=>'Consejo de Profesores',           'descripcion'=>'Consejo ordinario mensual. Puntos: revisión de asistencia, casos disciplinarios y coordinación de salidas pedagógicas.', 'fecha_inicio'=>makeDate($m,$y,min(14,$d)), 'fecha_fin'=>makeDate($m,$y,min(14,$d)), 'hora_inicio'=>'15:30', 'hora_fin'=>'17:00', 'hora_evento'=>'15:30', 'ubicacion'=>'Sala de Profesores',     'tipo_evento'=>'consejo',     'estado'=>'confirmado', 'color_evento'=>'#e04b2a', 'con_audio'=>0,'solo_presentacion'=>0,'musica_ambiental'=>0,'cantidad_personas'=>28,'observaciones_logisticas'=>'Lista de asistencia obligatoria.','correo_enviado'=>0,'responsable_id'=>4],
  ['id'=>6,  'titulo'=>'Jornada PRIMED',                  'descripcion'=>'Jornada de trabajo coordinadores PRIMED. Revisión de avances de proyectos y metas anuales.',                           'fecha_inicio'=>makeDate($m,$y,min(16,$d)), 'fecha_fin'=>makeDate($m,$y,min(16,$d)), 'hora_inicio'=>'09:00', 'hora_fin'=>'17:00', 'hora_evento'=>'09:00', 'ubicacion'=>'Sala B – Seduc Central', 'tipo_evento'=>'jornada',     'estado'=>'tentativo',  'color_evento'=>'#0891b2', 'con_audio'=>1,'solo_presentacion'=>1,'musica_ambiental'=>0,'cantidad_personas'=>22,'observaciones_logisticas'=>'Almuerzo a cargo de cada participante.','correo_enviado'=>0,'responsable_id'=>6],
  ['id'=>7,  'titulo'=>'Visita Supervisión MINEDUC',      'descripcion'=>'Visita de supervisión técnica del MINEDUC. Revisión documental y entrevistas con equipos directivos.',                  'fecha_inicio'=>makeDate($m,$y,min(19,$d)), 'fecha_fin'=>makeDate($m,$y,min(20,$d)), 'hora_inicio'=>'10:00', 'hora_fin'=>'15:00', 'hora_evento'=>'10:00', 'ubicacion'=>'Dependencias Seduc',     'tipo_evento'=>'visita',      'estado'=>'confirmado', 'color_evento'=>'#be185d', 'con_audio'=>0,'solo_presentacion'=>0,'musica_ambiental'=>0,'cantidad_personas'=>5, 'observaciones_logisticas'=>'Tener carpetas de antecedentes listos. Sala de reuniones reservada.','correo_enviado'=>1,'responsable_id'=>1],
  ['id'=>8,  'titulo'=>'Feria de Ciencias',               'descripcion'=>'Feria anual de ciencias con participación de todos los colegios de la red. Jurado externo evaluará proyectos.',         'fecha_inicio'=>makeDate($m,$y,min(22,$d)), 'fecha_fin'=>makeDate($m,$y,min(22,$d)), 'hora_inicio'=>'10:00', 'hora_fin'=>'14:00', 'hora_evento'=>'10:00', 'ubicacion'=>'Gimnasio Colegio Norte',  'tipo_evento'=>'academico',   'estado'=>'confirmado', 'color_evento'=>'#16a34a', 'con_audio'=>1,'solo_presentacion'=>0,'musica_ambiental'=>1,'cantidad_personas'=>200,'observaciones_logisticas'=>'Instalación de stands desde las 08:00. Señalética disponible.','correo_enviado'=>1,'responsable_id'=>7],
  ['id'=>9,  'titulo'=>'Reunión Apoderados',              'descripcion'=>'Reunión general de apoderados primer semestre. Informe de avance académico y presentación de actividades segundo semestre.', 'fecha_inicio'=>makeDate($m,$y,min(24,$d)), 'fecha_fin'=>makeDate($m,$y,min(24,$d)), 'hora_inicio'=>'19:00', 'hora_fin'=>'20:30', 'hora_evento'=>'19:00', 'ubicacion'=>'Auditorio Principal',    'tipo_evento'=>'apoderados',  'estado'=>'confirmado', 'color_evento'=>'#ea580c', 'con_audio'=>1,'solo_presentacion'=>1,'musica_ambiental'=>0,'cantidad_personas'=>180,'observaciones_logisticas'=>'Proyector + audio. Registro de asistencia obligatorio.','correo_enviado'=>1,'responsable_id'=>3],
  ['id'=>10, 'titulo'=>'Capacitación Primeros Auxilios',  'descripcion'=>'Taller práctico de primeros auxilios para personal administrativo y auxiliares. Dictado por Cruz Roja.',               'fecha_inicio'=>makeDate($m,$y,min(26,$d)), 'fecha_fin'=>makeDate($m,$y,min(26,$d)), 'hora_inicio'=>'09:00', 'hora_fin'=>'12:00', 'hora_evento'=>'09:00', 'ubicacion'=>'Sala Multiuso – Piso 1', 'tipo_evento'=>'capacitacion','estado'=>'tentativo',  'color_evento'=>'#dc2626', 'con_audio'=>0,'solo_presentacion'=>0,'musica_ambiental'=>0,'cantidad_personas'=>20,'observaciones_logisticas'=>'Traer ropa cómoda. Materiales provistos.','correo_enviado'=>0,'responsable_id'=>5],
  ['id'=>11, 'titulo'=>'Cierre Contable Semestral',       'descripcion'=>'Cierre y cuadraturas contables del primer semestre. Participación de jefes de área.',                                   'fecha_inicio'=>makeDate($m,$y,min(28,$d)), 'fecha_fin'=>makeDate($m,$y,min(28,$d>2?28:$d)), 'hora_inicio'=>'08:30', 'hora_fin'=>'17:00', 'hora_evento'=>'08:30', 'ubicacion'=>'Sala A – Piso 2',       'tipo_evento'=>'reunion',     'estado'=>'confirmado', 'color_evento'=>'#1a56e8', 'con_audio'=>0,'solo_presentacion'=>0,'musica_ambiental'=>0,'cantidad_personas'=>10,'observaciones_logisticas'=>'Día reservado solo para contabilidad.','correo_enviado'=>1,'responsable_id'=>3],
];

// Indexar eventos por día
$eventos_por_dia = [];
foreach($eventos_demo as $ev) {
  $fi = new DateTime($ev['fecha_inicio']);
  $ff = new DateTime($ev['fecha_fin']);
  $cur = clone $fi;
  while($cur <= $ff) {
    if ((int)$cur->format('m') === $mes && (int)$cur->format('Y') === $anio) {
      $dia = (int)$cur->format('j');
      $eventos_por_dia[$dia][] = $ev;
    }
    $cur->modify('+1 day');
  }
}

// Tipo etiqueta
$tipo_labels = [
  'reunion'=>'Reunión','capacitacion'=>'Capacitación','directivo'=>'Directivo',
  'ceremonia'=>'Ceremonia','consejo'=>'Consejo','jornada'=>'Jornada',
  'visita'=>'Visita','academico'=>'Académico','apoderados'=>'Apoderados',
];

// Contar por tipo para leyenda
$conteo_tipo = [];
foreach($eventos_demo as $ev) {
  $t = $ev['tipo_evento'];
  $conteo_tipo[$t] = ($conteo_tipo[$t] ?? 0) + 1;
}
arsort($conteo_tipo);

$total_eventos = count($eventos_demo);
$eventos_hoy   = isset($eventos_por_dia[(int)date('j')]) && date('Y-m') === "$anio-".sprintf('%02d',$mes)
                 ? count($eventos_por_dia[(int)date('j')]) : 0;
$confirmados   = count(array_filter($eventos_demo, fn($e) => $e['estado'] === 'confirmado'));
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Calendario de Eventos · SEDUC</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,500;0,9..144,700;0,9..144,800;1,9..144,300&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
<style>
/* ══ RESET & TOKENS ══════════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
  --ink:       #0f1623;
  --ink-soft:  #3b4559;
  --ink-mute:  #7c8698;
  --line:      #e2e6ed;
  --bg:        #f0f2f6;
  --surface:   #ffffff;
  --canvas:    #f7f8fb;
  --navy:      #1a2744;
  --accent:    #f0a500;
  --accent-dk: #c78500;
  --ok:        #0ea25f;
  --warn:      #f59e0b;
  --danger:    #e03030;
  --radius:    16px;
  --radius-sm: 9px;
  --sh:        0 2px 14px rgba(15,22,35,.07), 0 1px 3px rgba(15,22,35,.04);
  --sh-md:     0 6px 32px rgba(15,22,35,.13), 0 2px 8px rgba(15,22,35,.06);
  --sh-lg:     0 20px 60px rgba(15,22,35,.22), 0 6px 20px rgba(15,22,35,.1);
  --font-h:    'Fraunces', serif;
  --font-b:    'DM Sans', sans-serif;
  /* topbar tokens */
  --primary:      #2f57b7;
  --primary-700:  #23449a;
  --text:         #0f172a;
  --muted:        #64748b;
  --border:       #e5eaf6;
  --shadow-soft:  0 8px 20px rgba(15,23,42,.08);
}

/* ══ TOPBAR ══════════════════════════════════════════════════ */
.topbar{position:sticky;top:0;z-index:200;background:rgba(255,255,255,.92);backdrop-filter:blur(10px);border-bottom:1px solid var(--border)}
.topbar__inner{display:flex;align-items:center;justify-content:space-between;gap:14px;padding:14px 28px;max-width:1400px;margin:0 auto}
.brand{display:flex;align-items:center;gap:12px}
.brand__logo{width:42px;height:42px;border-radius:14px;background:linear-gradient(135deg,var(--primary),var(--primary-700));color:#fff;display:grid;place-items:center;font-weight:900;font-size:14px}
.brand__name{font-weight:900;line-height:1;font-size:15px} .brand__tag{font-size:12px;color:var(--muted);margin-top:2px}
.topbar__nav{display:flex;align-items:center;gap:18px}
.navlink{font-weight:700;color:var(--muted);padding:10px 12px;border-radius:12px;text-decoration:none;font-size:14px}
.navlink:hover{background:#eef2ff;color:var(--text)} .navlink.is-active{background:#eef2ff;color:var(--primary)}
.topbar__right{display:flex;align-items:center;gap:10px}
.usermenu{position:relative}
.userbtn{display:flex;align-items:center;gap:10px;padding:8px 10px;border-radius:18px;border:1px solid var(--border);background:rgba(255,255,255,.82);backdrop-filter:blur(10px);cursor:pointer;box-shadow:var(--shadow-soft);transition:.15s ease;font-family:var(--font-b)}
.userbtn:hover{background:#fff}
.userbtn__avatar{width:36px;height:36px;border-radius:14px;display:grid;place-items:center;background:#eef2ff;color:var(--primary);font-weight:900;font-size:13px}
.userbtn__text{display:flex;flex-direction:column;line-height:1.05;text-align:left}
.userbtn__name{font-weight:900;font-size:13px;color:var(--text)} .userbtn__role{font-weight:800;font-size:12px;color:var(--muted);margin-top:2px} .userbtn__chev{margin-left:6px;color:var(--muted);font-weight:900}
.dropdown{position:absolute;right:0;top:calc(100% + 10px);width:220px;border-radius:16px;border:1px solid var(--border);background:rgba(255,255,255,.96);backdrop-filter:blur(10px);box-shadow:0 10px 30px rgba(15,23,42,.10);padding:8px;display:none;z-index:300}
.usermenu:hover .dropdown{display:block}
.dropdown__item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:12px;font-weight:700;color:var(--text);text-decoration:none;font-size:14px}
.dropdown__item:hover{background:#eef2ff;color:var(--primary)} .dropdown__sep{height:1px;background:var(--border);margin:8px 6px}
.dropdown__item--danger{color:#b91c1c} .dropdown__item--danger:hover{background:#fff1f2;color:#b91c1c}
@media(max-width:820px){.topbar__nav{display:none}}
html { scroll-behavior: smooth; }
body {
  font-family: var(--font-b);
  background: var(--bg);
  color: var(--ink);
  min-height: 100vh;
  font-size: 14px;
  line-height: 1.6;
}
a { text-decoration: none; color: inherit; }
button { cursor: pointer; font-family: var(--font-b); }


/* ══ LAYOUT ══════════════════════════════════════════════════ */
.wrap { max-width: 1400px; margin: 0 auto; padding: 28px 28px 60px; }
.layout { display: grid; grid-template-columns: 1fr 300px; gap: 24px; }
@media(max-width:1000px){ .layout { grid-template-columns: 1fr; } }

/* ══ MONTH NAV ═══════════════════════════════════════════════ */
.month-nav {
  display: flex; align-items: center; gap: 16px;
  margin-bottom: 24px;
}
.month-nav__arrow {
  width: 40px; height: 40px;
  background: var(--surface); border: 1px solid var(--line);
  border-radius: 10px; display: grid; place-items: center;
  box-shadow: var(--sh);
  transition: background .15s, transform .1s;
  text-decoration: none;
}
.month-nav__arrow:hover { background: var(--ink); }
.month-nav__arrow:hover svg { stroke: #fff; }
.month-nav__arrow:active { transform: scale(.92); }
.month-nav__arrow svg { width: 17px; height: 17px; stroke: var(--ink-soft); fill: none; stroke-width: 2.2; stroke-linecap: round; stroke-linejoin: round; }
.month-nav__label {
  font-family: var(--font-h);
  font-size: 30px; font-weight: 700;
  letter-spacing: -.03em;
  line-height: 1;
}
.month-nav__year { font-weight: 300; color: var(--ink-mute); font-size: 22px; }
.month-nav__count {
  margin-left: auto;
  background: var(--navy);
  color: #fff;
  padding: 6px 14px; border-radius: 20px;
  font-size: 13px; font-weight: 600;
  display: flex; align-items: center; gap: 6px;
}
.month-nav__count-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--accent); }

/* ══ CALENDAR GRID ═══════════════════════════════════════════ */
.cal-header {
  display: grid; grid-template-columns: repeat(7, 1fr);
  margin-bottom: 6px;
}
.cal-header-cell {
  text-align: center;
  padding: 6px 0;
  font-size: 11px; font-weight: 700;
  text-transform: uppercase; letter-spacing: .08em;
  color: var(--ink-mute);
}
.cal-header-cell:nth-child(6), .cal-header-cell:nth-child(7) { color: #c0895a; }

.cal-grid {
  display: grid; grid-template-columns: repeat(7, 1fr);
  gap: 5px;
}

.cal-cell {
  background: var(--surface);
  border: 1.5px solid var(--line);
  border-radius: var(--radius-sm);
  padding: 10px 9px 8px;
  min-height: 110px;
  position: relative;
  cursor: default;
  transition: box-shadow .15s, border-color .15s;
  overflow: hidden;
}
.cal-cell--empty {
  background: var(--canvas);
  border-color: transparent;
  box-shadow: none;
}
.cal-cell--weekend { background: #fdf8f4; }
.cal-cell--today {
  border-color: var(--navy) !important;
  box-shadow: 0 0 0 2px var(--navy), var(--sh-md);
  background: #fff;
}
.cal-cell--has-events { cursor: pointer; }
.cal-cell--has-events:hover {
  border-color: var(--accent);
  box-shadow: var(--sh-md);
  z-index: 2;
}

.cal-day-num {
  font-family: var(--font-h);
  font-size: 17px; font-weight: 700;
  line-height: 1;
  margin-bottom: 7px;
  display: flex; align-items: center; justify-content: space-between;
}
.cal-day-today-pill {
  background: var(--navy);
  color: #fff;
  width: 26px; height: 26px;
  border-radius: 50%;
  display: grid; place-items: center;
  font-size: 13px; font-weight: 700;
  font-family: var(--font-h);
}
.cal-day-num .weekend-day { color: #c0895a; }

.cal-events { display: flex; flex-direction: column; gap: 3px; }
.cal-event-chip {
  display: flex; align-items: center; gap: 4px;
  padding: 3px 7px;
  border-radius: 5px;
  font-size: 11px; font-weight: 600;
  line-height: 1.2;
  overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
  cursor: pointer;
  transition: filter .12s, transform .12s;
  max-width: 100%;
}
.cal-event-chip:hover { filter: brightness(1.08); transform: translateX(2px); }
.cal-event-chip-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
.cal-event-chip-label { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

.cal-more {
  font-size: 10.5px; font-weight: 700;
  color: var(--ink-mute);
  padding: 2px 4px;
  cursor: pointer;
  transition: color .12s;
}
.cal-more:hover { color: var(--navy); }

/* Pulse animación para hoy */
.cal-cell--today::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0;
  height: 3px;
  background: var(--accent);
  border-radius: 0 0 3px 3px;
}

/* ══ SIDEBAR ══════════════════════════════════════════════════ */
.sidebar { display: flex; flex-direction: column; gap: 18px; }

/* Mini calendario de navegación */
.mini-cal { }
.mini-cal-title {
  font-family: var(--font-h); font-size: 15px; font-weight: 700;
  margin-bottom: 12px; padding: 0 4px;
}
.mini-cal-grid {
  display: grid; grid-template-columns: repeat(7,1fr);
  gap: 3px;
}
.mini-cal-hdr {
  text-align: center; font-size: 10px; font-weight: 700;
  text-transform: uppercase; color: var(--ink-mute);
  padding-bottom: 4px;
}
.mini-cal-day {
  aspect-ratio: 1; display: grid; place-items: center;
  font-size: 11px; font-weight: 500;
  border-radius: 6px; cursor: default;
  position: relative;
}
.mini-cal-day--has { cursor: pointer; background: rgba(240,165,0,.12); font-weight: 700; color: var(--accent-dk); }
.mini-cal-day--has::after { content:''; position:absolute; bottom:2px; left:50%; transform:translateX(-50%); width:4px; height:4px; border-radius:50%; background:var(--accent); }
.mini-cal-day--today { background: var(--navy); color: #fff; font-weight: 700; border-radius: 50%; }
.mini-cal-day--empty { opacity: 0; }

/* Tarjeta "Hoy" */
.today-card {
  background: var(--navy);
  color: #fff;
  border-radius: var(--radius);
  padding: 20px;
}
.today-card h3 {
  font-family: var(--font-h); font-size: 13px; font-weight: 500;
  color: rgba(255,255,255,.55); text-transform: uppercase; letter-spacing: .07em;
  margin-bottom: 10px;
}
.today-card-date {
  font-family: var(--font-h);
  font-size: 42px; font-weight: 800;
  line-height: 1; color: #fff;
  margin-bottom: 2px;
}
.today-card-month { font-size: 15px; color: rgba(255,255,255,.6); margin-bottom: 14px; }
.today-event {
  background: rgba(255,255,255,.1);
  border-radius: 8px; padding: 10px 12px;
  margin-bottom: 6px;
  display: flex; gap: 10px; align-items: flex-start;
}
.today-event-bar { width: 3px; border-radius: 2px; flex-shrink: 0; align-self: stretch; min-height: 100%; }
.today-event-info strong { display: block; font-size: 13px; font-weight: 600; }
.today-event-info span   { font-size: 11.5px; color: rgba(255,255,255,.55); }
.today-card-empty { font-size: 13px; color: rgba(255,255,255,.45); text-align: center; padding: 12px 0; }

/* Leyenda */
.legend-card { background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius); padding: 18px; box-shadow: var(--sh); }
.legend-card h3 { font-family: var(--font-h); font-size: 14px; font-weight: 700; margin-bottom: 12px; }
.legend-item { display: flex; align-items: center; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid var(--line); }
.legend-item:last-child { border-bottom: none; }
.legend-item-left { display: flex; align-items: center; gap: 9px; }
.legend-dot { width: 10px; height: 10px; border-radius: 3px; flex-shrink: 0; }
.legend-label { font-size: 13px; font-weight: 500; }
.legend-count { font-family: var(--font-h); font-size: 15px; font-weight: 700; color: var(--ink-mute); }

/* ══ MODAL ═══════════════════════════════════════════════════ */
.modal-overlay {
  position: fixed; inset: 0; z-index: 1000;
  background: rgba(10,15,28,.55);
  backdrop-filter: blur(6px);
  display: flex; align-items: center; justify-content: center;
  padding: 20px;
  opacity: 0; pointer-events: none;
  transition: opacity .25s;
}
.modal-overlay.open { opacity: 1; pointer-events: all; }

.modal {
  background: var(--surface);
  border-radius: 20px;
  width: 100%; max-width: 560px;
  box-shadow: var(--sh-lg);
  overflow: hidden;
  transform: translateY(20px) scale(.97);
  transition: transform .3s cubic-bezier(.34,1.56,.64,1);
  max-height: 90vh;
  overflow-y: auto;
}
.modal-overlay.open .modal { transform: translateY(0) scale(1); }

.modal-head {
  padding: 24px 24px 20px;
  position: relative;
}
.modal-head-stripe {
  position: absolute; top: 0; left: 0; right: 0;
  height: 5px;
  border-radius: 20px 20px 0 0;
}
.modal-tipo-badge {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 4px 12px; border-radius: 20px;
  font-size: 11px; font-weight: 700;
  text-transform: uppercase; letter-spacing: .07em;
  margin-bottom: 10px; margin-top: 6px;
}
.modal-title {
  font-family: var(--font-h);
  font-size: 24px; font-weight: 700;
  line-height: 1.2;
  margin-bottom: 6px;
  padding-right: 32px;
}
.modal-estado {
  display: inline-flex; align-items: center; gap: 5px;
  font-size: 12px; font-weight: 600;
  padding: 3px 10px; border-radius: 20px;
}
.modal-estado--confirmado { background: #dcfce7; color: #14532d; }
.modal-estado--tentativo  { background: #fef3c7; color: #78350f; }
.modal-estado--cancelado  { background: #fee2e2; color: #7f1d1d; }

.modal-close {
  position: absolute; top: 16px; right: 16px;
  width: 32px; height: 32px; border-radius: 50%;
  background: var(--bg); border: none;
  display: grid; place-items: center;
  transition: background .15s;
}
.modal-close:hover { background: var(--line); }
.modal-close svg { width: 16px; height: 16px; stroke: var(--ink-soft); fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }

.modal-body { padding: 0 24px 24px; }
.modal-desc {
  font-size: 14px; color: var(--ink-soft);
  line-height: 1.65;
  padding: 14px 16px;
  background: var(--canvas);
  border-radius: 10px;
  margin-bottom: 18px;
  border-left: 3px solid var(--line);
}

.modal-grid {
  display: grid; grid-template-columns: 1fr 1fr;
  gap: 10px;
  margin-bottom: 18px;
}
.modal-info {
  background: var(--canvas);
  border: 1px solid var(--line);
  border-radius: 10px;
  padding: 12px 14px;
  display: flex; flex-direction: column; gap: 3px;
}
.modal-info-label {
  font-size: 10.5px; font-weight: 700;
  text-transform: uppercase; letter-spacing: .08em;
  color: var(--ink-mute);
}
.modal-info-val {
  font-size: 14px; font-weight: 600; color: var(--ink);
  display: flex; align-items: center; gap: 6px;
}
.modal-info-val svg { width: 14px; height: 14px; stroke: var(--ink-mute); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; flex-shrink: 0; }

.modal-chips { display: flex; flex-wrap: wrap; gap: 7px; margin-bottom: 16px; }
.modal-chip {
  display: inline-flex; align-items: center; gap: 5px;
  padding: 5px 12px; border-radius: 20px;
  font-size: 12px; font-weight: 600;
}
.modal-chip--ok  { background: #dcfce7; color: #14532d; }
.modal-chip--off { background: var(--bg); color: var(--ink-mute); text-decoration: line-through; opacity: .6; }
.modal-chip svg  { width: 12px; height: 12px; flex-shrink: 0; }

.modal-obs {
  background: #fffbeb;
  border: 1px solid #fde68a;
  border-radius: 10px; padding: 12px 14px;
  font-size: 13px; color: #78350f;
  line-height: 1.5;
  display: flex; gap: 8px; align-items: flex-start;
}
.modal-obs svg { width: 15px; height: 15px; stroke: #d97706; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; flex-shrink: 0; margin-top: 2px; }

.modal-correo-badge {
  display: inline-flex; align-items: center; gap: 5px;
  font-size: 11.5px; font-weight: 600;
  padding: 4px 10px; border-radius: 6px;
  margin-top: 14px;
}
.modal-correo-badge--sent { background: #dcfce7; color: #14532d; }
.modal-correo-badge--pend { background: #fef3c7; color: #78350f; }
.modal-correo-badge svg { width: 13px; height: 13px; flex-shrink:0; }

/* ══ LISTA EVENTOS (vista alterna) ══════════════════════════ */
#vistaLista { display: none; }
.lista-group-title {
  font-family: var(--font-h); font-size: 13px; font-weight: 700;
  text-transform: uppercase; letter-spacing: .07em;
  color: var(--ink-mute); padding: 16px 0 8px;
  border-bottom: 1px solid var(--line); margin-bottom: 8px;
}
.lista-item {
  background: var(--surface); border: 1px solid var(--line);
  border-radius: var(--radius-sm); padding: 14px 16px;
  display: flex; align-items: center; gap: 14px;
  margin-bottom: 6px; cursor: pointer;
  transition: box-shadow .15s, transform .15s;
  border-left: 4px solid transparent;
}
.lista-item:hover { box-shadow: var(--sh-md); transform: translateX(3px); }
.lista-item__date {
  text-align: center; min-width: 44px; flex-shrink: 0;
  font-family: var(--font-h);
}
.lista-item__date strong { display: block; font-size: 24px; font-weight: 800; line-height: 1; }
.lista-item__date span   { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .06em; color: var(--ink-mute); }
.lista-item__sep { width: 1px; height: 40px; background: var(--line); flex-shrink: 0; }
.lista-item__body { flex: 1; }
.lista-item__title { font-weight: 700; font-size: 15px; margin-bottom: 3px; }
.lista-item__meta  { font-size: 12px; color: var(--ink-mute); display: flex; gap: 12px; flex-wrap: wrap; }
.lista-item__chips { display: flex; gap: 6px; flex-wrap: wrap; }

/* ══ SCROLL TOP ══════════════════════════════════════════════ */
#scrollTop {
  position: fixed; bottom: 22px; right: 22px;
  width: 40px; height: 40px; border-radius: 50%;
  background: var(--navy); border: none;
  display: grid; place-items: center;
  box-shadow: 0 4px 16px rgba(26,39,68,.4);
  opacity: 0; pointer-events: none; transition: opacity .3s; z-index:50;
}
#scrollTop.visible { opacity:1; pointer-events:all; }
#scrollTop svg { width:18px; height:18px; stroke:#fff; fill:none; stroke-width:2.5; stroke-linecap:round; stroke-linejoin:round; }

/* ══ RESPONSIVE ══════════════════════════════════════════════ */
@media(max-width:700px){
  .cal-cell { min-height: 76px; }
  .cal-event-chip-label { display: none; }
  .cal-event-chip { padding: 4px; justify-content: center; }
  .wrap { padding: 16px 12px 48px; }
  .topbar__nav { display: none; }
}

/* ══ ANIMATIONS ══════════════════════════════════════════════ */
@keyframes fadeSlideUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
.cal-cell { animation: fadeSlideUp .35s ease both; }
<?php for($i=1;$i<=42;$i++) echo ".cal-cell:nth-child({$i}){animation-delay:".($i*18)."ms}\n"; ?>
</style>
</head>
<body>

<!-- ══ TOPBAR ══════════════════════════════════════════════ -->
<header class="topbar">
  <div class="topbar__inner">
    <div class="brand">
      <div class="brand__logo">SH</div>
      <div><div class="brand__name">Seduc Hub</div><div class="brand__tag">Portal Operativo</div></div>
    </div>
    <nav class="topbar__nav">
      <?php foreach ($menusCabecera as $menu): ?>
        <?php $claseActiva = basename($menu['href']) === $paginaActual ? ' is-active' : ''; ?>
        <a class="navlink<?= $claseActiva ?>" href="<?= htmlspecialchars($menu['href'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($menu['menu'] ?: 'Menu', ENT_QUOTES, 'UTF-8') ?></a>
      <?php endforeach; ?>
    </nav>
    <?php renderTopbarUserMenu(); ?>
  </div>
</header>

<!-- ══ BARRA CALENDARIO ═══════════════════════════════════ -->
<div style="background:var(--navy);padding:10px 28px;display:flex;align-items:center;justify-content:flex-end;gap:10px;max-width:100%">
  <a href="?mes=<?= date('m') ?>&anio=<?= date('Y') ?>" style="padding:7px 16px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);border-radius:8px;color:rgba(255,255,255,.85);font-size:13px;font-weight:500;text-decoration:none">Hoy</a>
  <div style="display:flex;background:rgba(255,255,255,.08);border-radius:8px;overflow:hidden">
    <button id="btnCalView" class="active" onclick="setView('cal')" style="padding:7px 13px;background:rgba(255,255,255,.18);border:none;color:#fff;font-size:12px;font-weight:600;cursor:pointer">Mes</button>
    <button id="btnListView" onclick="setView('lista')" style="padding:7px 13px;background:none;border:none;color:rgba(255,255,255,.5);font-size:12px;font-weight:600;cursor:pointer">Lista</button>
  </div>
</div>

<!-- ══ WRAP ══════════════════════════════════════════════ -->
<div class="wrap">

  <!-- Navegación de mes -->
  <div class="month-nav">
    <a href="?mes=<?= $prev_mes ?>&anio=<?= $prev_anio ?>" class="month-nav__arrow">
      <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    </a>
    <h1 class="month-nav__label">
      <?= $meses_es[$mes] ?>
      <span class="month-nav__year"> <?= $anio ?></span>
    </h1>
    <a href="?mes=<?= $next_mes ?>&anio=<?= $next_anio ?>" class="month-nav__arrow">
      <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    </a>
    <div class="month-nav__count">
      <div class="month-nav__count-dot"></div>
      <?= $total_eventos ?> evento<?= $total_eventos !== 1 ? 's' : '' ?>
    </div>
  </div>

  <div class="layout">

    <!-- ══ CALENDAR MAIN ═══════════════════════════════ -->
    <div>
      <!-- Vista calendario -->
      <div id="vistaCalendario">
        <!-- Cabecera de días -->
        <div class="cal-header">
          <?php foreach($dias_semana as $i => $d): ?>
          <div class="cal-header-cell"><?= $d ?></div>
          <?php endforeach; ?>
        </div>
        <!-- Grid -->
        <div class="cal-grid">
          <?php
          // Celdas vacías antes del primer día
          $offset = $primer_dia_mes - 1; // lun=0 … dom=6
          for($i = 0; $i < $offset; $i++) echo '<div class="cal-cell cal-cell--empty"></div>';

          for($dia = 1; $dia <= $dias_en_mes; $dia++):
            $dow_cell = (($offset + $dia - 1) % 7) + 1; // 1=lun…7=dom
            $es_finde = $dow_cell >= 6;
            $es_hoy   = date('Y-m-d') === sprintf('%04d-%02d-%02d', $anio, $mes, $dia);
            $evs_dia  = $eventos_por_dia[$dia] ?? [];
            $n_evs    = count($evs_dia);
            $clases   = 'cal-cell';
            if($es_finde) $clases .= ' cal-cell--weekend';
            if($es_hoy)   $clases .= ' cal-cell--today';
            if($n_evs)    $clases .= ' cal-cell--has-events';
            $max_vis  = 3;
          ?>
          <div class="<?= $clases ?>"
               <?= $n_evs ? 'onclick="openDayModal('.json_encode($evs_dia).', '.$dia.')"' : '' ?>>

            <!-- Número del día -->
            <div class="cal-day-num">
              <?php if($es_hoy): ?>
                <span class="cal-day-today-pill"><?= $dia ?></span>
              <?php else: ?>
                <span class="<?= $es_finde ? 'weekend-day' : '' ?>"><?= $dia ?></span>
              <?php endif; ?>
            </div>

            <!-- Chips de eventos -->
            <div class="cal-events">
              <?php
              $visible = array_slice($evs_dia, 0, $max_vis);
              foreach($visible as $ev):
                $col = $ev['color_evento'] ?: '#1a56e8';
                $col_r = hexdec(substr($col,1,2));
                $col_g = hexdec(substr($col,3,2));
                $col_b = hexdec(substr($col,5,2));
                $bg_alpha = "rgba({$col_r},{$col_g},{$col_b},.12)";
              ?>
              <div class="cal-event-chip"
                   style="background:<?= $bg_alpha ?>;color:<?= $col ?>;"
                   onclick="event.stopPropagation();openEventModal(<?= json_encode($ev) ?>)">
                <div class="cal-event-chip-dot" style="background:<?= $col ?>"></div>
                <span class="cal-event-chip-label"><?= htmlspecialchars($ev['titulo']) ?></span>
              </div>
              <?php endforeach; ?>

              <?php if($n_evs > $max_vis): ?>
              <div class="cal-more">+<?= $n_evs - $max_vis ?> más</div>
              <?php endif; ?>
            </div>
          </div>
          <?php endfor; ?>

          <?php
          // Celdas vacías al final para completar la última semana
          $total_cells = $offset + $dias_en_mes;
          $rem = (7 - ($total_cells % 7)) % 7;
          for($i = 0; $i < $rem; $i++) echo '<div class="cal-cell cal-cell--empty"></div>';
          ?>
        </div>
      </div>

      <!-- Vista lista -->
      <div id="vistaLista">
        <?php
        $dias_ordenados = array_keys($eventos_por_dia);
        sort($dias_ordenados);
        $dia_nombres = ['','Lun','Mar','Mié','Jue','Vie','Sáb','Dom'];
        foreach($dias_ordenados as $dia):
          $evs = $eventos_por_dia[$dia];
          $dow_l = date('N', mktime(0,0,0,$mes,$dia,$anio));
          $fecha_label = $dia_nombres[$dow_l].', '.$dia.' '.$meses_es[$mes];
        ?>
        <div class="lista-group-title"><?= $fecha_label ?></div>
        <?php foreach($evs as $ev):
          $col = $ev['color_evento'] ?: '#1a56e8';
          $tl  = $tipo_labels[$ev['tipo_evento']] ?? ucfirst($ev['tipo_evento']);
        ?>
        <div class="lista-item" style="border-left-color:<?= $col ?>"
             onclick="openEventModal(<?= json_encode($ev) ?>)">
          <div class="lista-item__date" style="color:<?= $col ?>">
            <strong><?= $dia ?></strong>
            <span><?= substr($meses_es[$mes],0,3) ?></span>
          </div>
          <div class="lista-item__sep"></div>
          <div class="lista-item__body">
            <div class="lista-item__title"><?= htmlspecialchars($ev['titulo']) ?></div>
            <div class="lista-item__meta">
              <span>🕐 <?= $ev['hora_inicio'] ?> – <?= $ev['hora_fin'] ?></span>
              <span>📍 <?= htmlspecialchars($ev['ubicacion']) ?></span>
              <span>👥 <?= $ev['cantidad_personas'] ?> pers.</span>
            </div>
          </div>
          <div class="lista-item__chips">
            <span class="modal-estado modal-estado--<?= $ev['estado'] ?>"><?= ucfirst($ev['estado']) ?></span>
          </div>
        </div>
        <?php endforeach; ?>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- ══ SIDEBAR ════════════════════════════════════ -->
    <aside class="sidebar">

      <!-- Tarjeta Hoy -->
      <div class="today-card">
        <h3>📅 Hoy</h3>
        <div class="today-card-date"><?= date('j') ?></div>
        <div class="today-card-month"><?= $meses_es[(int)date('m')] ?> <?= date('Y') ?></div>
        <?php
        $hoy_dia = (int)date('j');
        $evs_hoy_sidebar = (date('Y-m') === "$anio-".sprintf('%02d',$mes)) ? ($eventos_por_dia[$hoy_dia] ?? []) : [];
        if(count($evs_hoy_sidebar)):
          foreach($evs_hoy_sidebar as $ev):
            $col = $ev['color_evento'] ?: '#1a56e8';
        ?>
        <div class="today-event" onclick="openEventModal(<?= json_encode($ev) ?>)" style="cursor:pointer">
          <div class="today-event-bar" style="background:<?= $col ?>"></div>
          <div class="today-event-info">
            <strong><?= htmlspecialchars($ev['titulo']) ?></strong>
            <span><?= $ev['hora_inicio'] ?> · <?= htmlspecialchars($ev['ubicacion']) ?></span>
          </div>
        </div>
        <?php endforeach;
        else: ?>
        <div class="today-card-empty">Sin eventos programados para hoy</div>
        <?php endif; ?>
      </div>

      <!-- Mini calendario -->
      <div class="legend-card">
        <h3 class="mini-cal-title"><?= $meses_es[$mes] ?> <?= $anio ?></h3>
        <div class="mini-cal-grid">
          <?php foreach(['L','M','M','J','V','S','D'] as $h): ?>
          <div class="mini-cal-hdr"><?= $h ?></div>
          <?php endforeach; ?>
          <?php
          for($i=0;$i<$offset;$i++) echo '<div class="mini-cal-day mini-cal-day--empty"></div>';
          for($dia=1;$dia<=$dias_en_mes;$dia++):
            $is_hoy = date('Y-m-d') === sprintf('%04d-%02d-%02d',$anio,$mes,$dia);
            $has = isset($eventos_por_dia[$dia]);
            $cls = 'mini-cal-day';
            if($is_hoy) $cls .= ' mini-cal-day--today';
            elseif($has) $cls .= ' mini-cal-day--has';
          ?>
          <div class="<?= $cls ?>" <?= $has && !$is_hoy ? 'title="'.$dia.': '.count($eventos_por_dia[$dia]).' evento(s)"' : '' ?>><?= $dia ?></div>
          <?php endfor; ?>
        </div>
      </div>

      <!-- Leyenda por tipo -->
      <div class="legend-card">
        <h3>Tipos de evento</h3>
        <?php
        $tipo_colors = [];
        foreach($eventos_demo as $ev) $tipo_colors[$ev['tipo_evento']] = $ev['color_evento'];
        foreach($conteo_tipo as $tipo => $cnt):
          $lbl = $tipo_labels[$tipo] ?? ucfirst($tipo);
          $col = $tipo_colors[$tipo] ?? '#888';
        ?>
        <div class="legend-item">
          <div class="legend-item-left">
            <div class="legend-dot" style="background:<?= $col ?>"></div>
            <span class="legend-label"><?= $lbl ?></span>
          </div>
          <span class="legend-count"><?= $cnt ?></span>
        </div>
        <?php endforeach; ?>
      </div>

      <!-- Stats rápidos -->
      <div class="legend-card">
        <h3>Resumen del mes</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:4px">
          <?php
          $stats = [
            ['Total','⚡',$total_eventos,'#1a2744'],
            ['Confirmados','✓',$confirmados,'#0ea25f'],
            ['Tentativos','⏳',count(array_filter($eventos_demo,fn($e)=>$e['estado']==='tentativo')),'#f59e0b'],
            ['Con audio','🔊',count(array_filter($eventos_demo,fn($e)=>$e['con_audio'])),'#7e3af2'],
          ];
          foreach($stats as [$lbl,$ico,$val,$col]):
          ?>
          <div style="background:var(--canvas);border:1px solid var(--line);border-radius:10px;padding:12px 14px">
            <div style="font-size:20px;font-family:var(--font-h);font-weight:800;color:<?= $col ?>"><?= $val ?></div>
            <div style="font-size:11.5px;color:var(--ink-mute);font-weight:500"><?= $ico ?> <?= $lbl ?></div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

    </aside>
  </div>
</div>

<!-- ══ MODAL EVENTO ═══════════════════════════════════════ -->
<div class="modal-overlay" id="modalOverlay" onclick="closeModal(event)">
  <div class="modal" id="modalBox">
    <div class="modal-head">
      <div class="modal-head-stripe" id="mStripe"></div>
      <div id="mTipo" class="modal-tipo-badge"></div>
      <h2 class="modal-title" id="mTitle"></h2>
      <span class="modal-estado" id="mEstado"></span>
      <button class="modal-close" onclick="closeModal()">
        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <div class="modal-body">
      <div class="modal-desc" id="mDesc"></div>
      <div class="modal-grid">
        <div class="modal-info"><div class="modal-info-label">Fecha</div><div class="modal-info-val" id="mFecha"></div></div>
        <div class="modal-info"><div class="modal-info-label">Horario</div><div class="modal-info-val" id="mHora"></div></div>
        <div class="modal-info"><div class="modal-info-label">Ubicación</div><div class="modal-info-val" id="mUbic"></div></div>
        <div class="modal-info"><div class="modal-info-label">Asistentes</div><div class="modal-info-val" id="mPers"></div></div>
      </div>
      <div class="modal-chips" id="mChips"></div>
      <div class="modal-obs" id="mObs" style="display:none">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span id="mObsText"></span>
      </div>
      <div id="mCorreo"></div>
    </div>
  </div>
</div>

<!-- ══ MODAL DÍA (varios eventos) ═══════════════════════ -->
<div class="modal-overlay" id="dayOverlay" onclick="closeDayModal(event)">
  <div class="modal" id="dayBox">
    <div class="modal-head">
      <div class="modal-head-stripe" style="background:var(--navy)"></div>
      <div style="font-family:var(--font-h);font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--ink-mute);margin-top:6px;margin-bottom:8px">Eventos del día</div>
      <h2 class="modal-title" id="dayTitle" style="font-size:22px"></h2>
      <button class="modal-close" onclick="closeDayModal()">
        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <div class="modal-body" id="dayBody" style="padding-top:0"></div>
  </div>
</div>

<button id="scrollTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
  <svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg>
</button>

<script>
const meses = <?= json_encode($meses_es) ?>;
const tipoLabels = <?= json_encode($tipo_labels) ?>;

// ── VISTA CAL / LISTA ─────────────────────────────────────
function setView(v) {
  const isLista = v === 'lista';
  document.getElementById('vistaCalendario').style.display = isLista ? 'none' : '';
  document.getElementById('vistaLista').style.display      = isLista ? '' : 'none';
  const btnCal  = document.getElementById('btnCalView');
  const btnList = document.getElementById('btnListView');
  btnCal.style.background  = !isLista ? 'rgba(255,255,255,.18)' : 'none';
  btnCal.style.color       = !isLista ? '#fff' : 'rgba(255,255,255,.5)';
  btnList.style.background = isLista  ? 'rgba(255,255,255,.18)' : 'none';
  btnList.style.color      = isLista  ? '#fff' : 'rgba(255,255,255,.5)';
}

// ── FORMATO DE FECHA ──────────────────────────────────────
function fmtFecha(fi, ff) {
  if (fi === ff) {
    const [y,m,d] = fi.split('-');
    return `${+d} ${meses[+m]} ${y}`;
  }
  const [y1,m1,d1] = fi.split('-');
  const [y2,m2,d2] = ff.split('-');
  if (m1 === m2 && y1 === y2) return `${+d1} – ${+d2} ${meses[+m1]} ${y1}`;
  return `${+d1} ${meses[+m1]} – ${+d2} ${meses[+m2]} ${y1}`;
}

// ── MODAL EVENTO ──────────────────────────────────────────
function openEventModal(ev) {
  const col = ev.color_evento || '#1a56e8';
  const [r,g,b] = [parseInt(col.slice(1,3),16),parseInt(col.slice(3,5),16),parseInt(col.slice(5,7),16)];
  document.getElementById('mStripe').style.background = col;
  const tipoBadge = document.getElementById('mTipo');
  tipoBadge.textContent = tipoLabels[ev.tipo_evento] || ev.tipo_evento;
  tipoBadge.style.cssText = `background:rgba(${r},${g},${b},.13);color:${col}`;
  document.getElementById('mTitle').textContent = ev.titulo;

  const estado = document.getElementById('mEstado');
  estado.textContent = ev.estado.charAt(0).toUpperCase() + ev.estado.slice(1);
  estado.className = 'modal-estado modal-estado--' + ev.estado;

  document.getElementById('mDesc').textContent = ev.descripcion || 'Sin descripción.';
  document.getElementById('mFecha').innerHTML  = `<svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>${fmtFecha(ev.fecha_inicio, ev.fecha_fin)}`;
  document.getElementById('mHora').innerHTML   = `<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>${ev.hora_inicio} – ${ev.hora_fin}`;
  document.getElementById('mUbic').innerHTML   = `<svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>${ev.ubicacion}`;
  document.getElementById('mPers').innerHTML   = `<svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>${ev.cantidad_personas} personas`;

  // Chips de recursos
  const chips = document.getElementById('mChips');
  chips.innerHTML = '';
  const recursos = [
    [ev.con_audio,       '🔊 Audio',              'ok'],
    [ev.solo_presentacion,'📊 Solo presentación',  'ok'],
    [ev.musica_ambiental,'🎵 Música ambiental',    'ok'],
  ];
  recursos.forEach(([on, lbl, cls]) => {
    const c = document.createElement('span');
    c.className = 'modal-chip modal-chip--' + (on ? cls : 'off');
    c.textContent = lbl;
    chips.appendChild(c);
  });

  // Observaciones
  const obs = document.getElementById('mObs');
  if(ev.observaciones_logisticas) {
    obs.style.display = 'flex';
    document.getElementById('mObsText').textContent = ev.observaciones_logisticas;
  } else obs.style.display = 'none';

  // Correo
  const correo = document.getElementById('mCorreo');
  correo.innerHTML = ev.correo_enviado
    ? '<div class="modal-correo-badge modal-correo-badge--sent"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:13px;height:13px"><polyline points="20 6 9 17 4 12"/></svg> Convocatoria enviada por correo</div>'
    : '<div class="modal-correo-badge modal-correo-badge--pend">⏳ Correo pendiente de envío</div>';

  document.getElementById('modalOverlay').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeModal(e) {
  if(e && e.target !== document.getElementById('modalOverlay')) return;
  document.getElementById('modalOverlay').classList.remove('open');
  document.body.style.overflow = '';
}

// ── MODAL DÍA ──────────────────────────────────────────
function openDayModal(evs, dia) {
  document.getElementById('dayTitle').textContent = `${dia} de ${meses[<?= $mes ?>]} — ${evs.length} evento${evs.length>1?'s':''}`;
  const body = document.getElementById('dayBody');
  body.innerHTML = '';
  evs.forEach(ev => {
    const col = ev.color_evento || '#1a56e8';
    const d = document.createElement('div');
    d.style.cssText = `
      display:flex;gap:12px;align-items:flex-start;
      padding:12px 14px;margin-bottom:8px;
      background:var(--canvas);border-radius:10px;
      border-left:4px solid ${col};cursor:pointer;
      transition:box-shadow .15s;
    `;
    d.onmouseenter = () => d.style.boxShadow = 'var(--sh-md)';
    d.onmouseleave = () => d.style.boxShadow = '';
    d.innerHTML = `
      <div style="flex:1">
        <div style="font-weight:700;font-size:14px;margin-bottom:3px">${ev.titulo}</div>
        <div style="font-size:12px;color:var(--ink-mute)">🕐 ${ev.hora_inicio} – ${ev.hora_fin} &nbsp;·&nbsp; 📍 ${ev.ubicacion}</div>
      </div>
      <span class="modal-estado modal-estado--${ev.estado}" style="font-size:11px">${ev.estado}</span>
    `;
    d.onclick = () => { closeDayModal(); setTimeout(() => openEventModal(ev), 200); };
    body.appendChild(d);
  });
  document.getElementById('dayOverlay').classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeDayModal(e) {
  if(e && e.target !== document.getElementById('dayOverlay')) return;
  document.getElementById('dayOverlay').classList.remove('open');
  document.body.style.overflow = '';
}

// ── ESC PARA CERRAR MODALES ───────────────────────────────
document.addEventListener('keydown', e => {
  if(e.key === 'Escape') { closeModal(); closeDayModal(); }
});

// ── SCROLL TOP ────────────────────────────────────────────
window.addEventListener('scroll', () => {
  document.getElementById('scrollTop').classList.toggle('visible', scrollY > 300);
});
</script>
</body>
</html>