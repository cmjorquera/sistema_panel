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
$paginaActual = basename($_SERVER['PHP_SELF'] ?? 'capsulas.php');

/**
 * capsulas.php
 * Página de Cápsulas Informáticas de Ciberseguridad
 * 
 * TABLAS SQL NECESARIAS (ejecutar en tu BD antes de usar la parte admin):
 * 
 * -- Tabla de cápsulas/noticias
 * CREATE TABLE capsulas (
 *   id INT AUTO_INCREMENT PRIMARY KEY,
 *   titulo VARCHAR(255) NOT NULL,
 *   resumen TEXT NOT NULL,
 *   contenido LONGTEXT NOT NULL,
 *   categoria ENUM('phishing','smishing','vishing','malware','fraude','contrasenas','redes','identidad') NOT NULL,
 *   nivel ENUM('basico','intermedio','avanzado') DEFAULT 'basico',
 *   icono VARCHAR(100) DEFAULT 'shield',
 *   archivo_descarga VARCHAR(255) DEFAULT NULL,
 *   url_profundizar VARCHAR(500) DEFAULT NULL,
 *   activo TINYINT(1) DEFAULT 1,
 *   destacado TINYINT(1) DEFAULT 0,
 *   fecha_publicacion DATETIME DEFAULT CURRENT_TIMESTAMP,
 *   vistas INT DEFAULT 0
 * );
 *
 * -- Tabla de preguntas del quiz
 * CREATE TABLE quiz_preguntas (
 *   id INT AUTO_INCREMENT PRIMARY KEY,
 *   pregunta TEXT NOT NULL,
 *   opcion_a VARCHAR(255) NOT NULL,
 *   opcion_b VARCHAR(255) NOT NULL,
 *   opcion_c VARCHAR(255) NOT NULL,
 *   opcion_d VARCHAR(255) NOT NULL,
 *   respuesta_correcta ENUM('a','b','c','d') NOT NULL,
 *   explicacion TEXT,
 *   categoria VARCHAR(100),
 *   activo TINYINT(1) DEFAULT 1
 * );
 *
 * -- Tabla de resultados del quiz (estadísticas)
 * CREATE TABLE quiz_resultados (
 *   id INT AUTO_INCREMENT PRIMARY KEY,
 *   sesion_id VARCHAR(64),
 *   puntaje INT,
 *   total_preguntas INT,
 *   fecha DATETIME DEFAULT CURRENT_TIMESTAMP
 * );
 *
 * -- Datos de ejemplo para cápsulas
 * INSERT INTO capsulas (titulo, resumen, contenido, categoria, nivel, icono, url_profundizar, destacado) VALUES
 * ('¿Qué es el Phishing?', 'Aprende a identificar correos fraudulentos que buscan robar tus datos.', 'El phishing es...', 'phishing', 'basico', 'mail', 'https://www.creadess.org/phishing', 1),
 * ('Smishing: Fraudes por SMS', 'Los mensajes de texto también pueden ser una trampa. Conoce cómo protegerte.', 'El smishing es...', 'smishing', 'basico', 'smartphone', 'https://sitiospublicos.bancochile.cl/personas/seguridad/detalle/smishing', 1);
 *
 * -- Datos de ejemplo para quiz
 * INSERT INTO quiz_preguntas (pregunta, opcion_a, opcion_b, opcion_c, opcion_d, respuesta_correcta, explicacion, categoria) VALUES
 * ('¿Cuál de estas señales indica que un correo puede ser phishing?', 'Viene de un amigo conocido', 'Tiene urgencia extrema y pide tus datos bancarios', 'Tiene imágenes coloridas', 'Está escrito en español', 'b', 'Los correos de phishing suelen crear urgencia falsa para presionarte a actuar sin pensar.', 'phishing'),
 * ('¿Qué debes hacer si recibes un SMS pidiendo verificar tu cuenta bancaria con un enlace?', 'Hacer clic y verificar', 'Ignorarlo y borrar el mensaje', 'Llamar al número del mensaje', 'Reenviar a tus contactos', 'b', 'Nunca hagas clic en enlaces de SMS no solicitados. Contacta a tu banco directamente por sus canales oficiales.', 'smishing');
 */

// Datos estáticos de demostración (reemplazar con consultas BD en producción)
$capsulas = [
    [
        'id' => 1,
        'titulo' => 'Smishing: Fraudes por SMS',
        'resumen' => 'Los mensajes de texto también pueden ser una trampa. Conoce cómo identificar y evitar el smishing.',
        'categoria' => 'smishing',
        'nivel' => 'Básico',
        'icono' => 'smartphone',
        'destacado' => true,
        'fecha' => '08 May 2025',
        'url_profundizar' => 'https://sitiospublicos.bancochile.cl/personas/seguridad/detalle/smishing',
        'archivo_descarga' => null,
        'vistas' => 1240,
    ],
    [
        'id' => 2,
        'titulo' => 'Phishing: El anzuelo digital',
        'resumen' => 'Aprende a identificar correos electrónicos fraudulentos que buscan robar tus credenciales y datos bancarios.',
        'categoria' => 'phishing',
        'nivel' => 'Básico',
        'icono' => 'mail',
        'destacado' => true,
        'fecha' => '05 May 2025',
        'url_profundizar' => 'https://www.bcn.cl/leychile/navegar?idNorma=1036049',
        'archivo_descarga' => 'guia_phishing.pdf',
        'vistas' => 2180,
    ],
    [
        'id' => 3,
        'titulo' => 'Contraseñas Seguras: La primera línea de defensa',
        'resumen' => 'Una contraseña robusta puede ser la diferencia entre proteger tu identidad digital o perderla.',
        'categoria' => 'contrasenas',
        'nivel' => 'Básico',
        'icono' => 'lock',
        'destacado' => false,
        'fecha' => '01 May 2025',
        'url_profundizar' => 'https://www.csirt.gob.cl/',
        'archivo_descarga' => 'buenas_practicas_contrasenas.pdf',
        'vistas' => 980,
    ],
    [
        'id' => 4,
        'titulo' => 'Malware y Ransomware: Amenazas invisibles',
        'resumen' => 'Descubre qué son los programas maliciosos, cómo se propagan y qué hacer si tu equipo es infectado.',
        'categoria' => 'malware',
        'nivel' => 'Intermedio',
        'icono' => 'bug',
        'destacado' => false,
        'fecha' => '28 Apr 2025',
        'url_profundizar' => 'https://www.csirt.gob.cl/alertas/',
        'archivo_descarga' => null,
        'vistas' => 756,
    ],
    [
        'id' => 5,
        'titulo' => 'Redes Wi-Fi Públicas: Navegar con precaución',
        'resumen' => 'Conectarse a una red pública puede exponer toda tu actividad. Aprende a protegerte cuando estés fuera de casa.',
        'categoria' => 'redes',
        'nivel' => 'Intermedio',
        'icono' => 'wifi',
        'destacado' => false,
        'fecha' => '22 Apr 2025',
        'url_profundizar' => null,
        'archivo_descarga' => 'seguridad_wifi_publico.pdf',
        'vistas' => 612,
    ],
    [
        'id' => 6,
        'titulo' => 'Vishing: Fraude por llamadas telefónicas',
        'resumen' => 'Los estafadores también usan el teléfono. Conoce las técnicas de ingeniería social por voz y cómo detectarlas.',
        'categoria' => 'vishing',
        'nivel' => 'Básico',
        'icono' => 'phone-call',
        'destacado' => true,
        'fecha' => '18 Apr 2025',
        'url_profundizar' => 'https://www.sernac.cl/',
        'archivo_descarga' => null,
        'vistas' => 890,
    ],
];

$quiz_preguntas = [
    [
        'id' => 1,
        'pregunta' => '¿Cuál de estas señales indica que un correo puede ser phishing?',
        'opciones' => [
            'a' => 'Viene de un remitente que conoces',
            'b' => 'Tiene urgencia extrema y solicita tus datos bancarios',
            'c' => 'Contiene imágenes de alta calidad',
            'd' => 'Está escrito en español correcto'
        ],
        'correcta' => 'b',
        'explicacion' => 'Los correos de phishing suelen crear urgencia artificial para que actúes sin pensar. Ningún banco o institución legítima te pedirá datos sensibles por correo.',
    ],
    [
        'id' => 2,
        'pregunta' => '¿Qué debes hacer si recibes un SMS con un enlace pidiendo verificar tu cuenta bancaria?',
        'opciones' => [
            'a' => 'Hacer clic y verificar rápidamente',
            'b' => 'Ignorarlo y eliminar el mensaje',
            'c' => 'Llamar al número que aparece en el SMS',
            'd' => 'Reenviarlo a tus contactos para alertarlos'
        ],
        'correcta' => 'b',
        'explicacion' => 'Nunca hagas clic en enlaces de SMS no solicitados. Contacta a tu banco directamente a través de sus canales oficiales (número en tu tarjeta o sitio web oficial).',
    ],
    [
        'id' => 3,
        'pregunta' => '¿Cuál es la contraseña más segura?',
        'opciones' => [
            'a' => 'Mi nombre y año de nacimiento (ej: Juan1990)',
            'b' => 'La misma para todas las cuentas pero muy larga',
            'c' => 'Una frase larga con mayúsculas, números y símbolos (ej: C@fé#Seg.2025!)',
            'd' => '12345678'
        ],
        'correcta' => 'c',
        'explicacion' => 'Una contraseña segura combina longitud (mínimo 12 caracteres), mayúsculas, minúsculas, números y símbolos. Usa una distinta para cada servicio.',
    ],
    [
        'id' => 4,
        'pregunta' => '¿Qué es el ransomware?',
        'opciones' => [
            'a' => 'Un antivirus gratuito',
            'b' => 'Un tipo de red social privada',
            'c' => 'Un programa que cifra tus archivos y pide rescate para recuperarlos',
            'd' => 'Una extensión de navegador para privacidad'
        ],
        'correcta' => 'c',
        'explicacion' => 'El ransomware es un malware que secuestra tus archivos cifrándolos. Los cibercriminales exigen pago (generalmente en criptomonedas) para devolver el acceso. Mantén copias de seguridad actualizadas.',
    ],
    [
        'id' => 5,
        'pregunta' => '¿Cuál es el mayor riesgo de conectarse a una Wi-Fi pública sin protección?',
        'opciones' => [
            'a' => 'Que el internet sea más lento',
            'b' => 'Que alguien pueda interceptar tus comunicaciones y robar datos',
            'c' => 'Que se descarguen actualizaciones automáticas',
            'd' => 'Que se gaste más batería del dispositivo'
        ],
        'correcta' => 'b',
        'explicacion' => 'En redes públicas, un atacante puede realizar ataques de "man-in-the-middle" para interceptar tu tráfico. Usa siempre una VPN o evita ingresar datos sensibles en redes públicas.',
    ],
];

$categorias_info = [
    'phishing' => ['color' => '#e74c3c', 'bg' => '#fdf0ef', 'label' => 'Phishing'],
    'smishing' => ['color' => '#e67e22', 'bg' => '#fef5ec', 'label' => 'Smishing'],
    'vishing' => ['color' => '#9b59b6', 'bg' => '#f5f0fb', 'label' => 'Vishing'],
    'malware' => ['color' => '#c0392b', 'bg' => '#fdecea', 'label' => 'Malware'],
    'fraude' => ['color' => '#d35400', 'bg' => '#fdf2ec', 'label' => 'Fraude'],
    'contrasenas' => ['color' => '#27ae60', 'bg' => '#eafaf1', 'label' => 'Contraseñas'],
    'redes' => ['color' => '#2980b9', 'bg' => '#eaf4fd', 'label' => 'Redes'],
    'identidad' => ['color' => '#16a085', 'bg' => '#e8f8f5', 'label' => 'Identidad Digital'],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Seduc Hub | Cápsulas Informativas</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
<?php renderRailAccionesStyles(); ?>
<?php renderPanelContactosStyles(); ?>
<?php renderKeepWidgetHead(); ?>
<style>
/* ─── RESET & VARIABLES ─────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --ink:       #0d1117;
  --ink-soft:  #3d4450;
  --ink-mute:  #6b7280;
  --line:      #e5e8ed;
  --bg:        #f7f8fa;
  --surface:   #ffffff;
  --accent:    #1a56e8;
  --accent-lt: #dce9ff;
  --accent-dk: #0e3ab5;
  --warn:      #e04b2a;
  --ok:        #1da462;
  --radius:    14px;
  --radius-sm: 8px;
  --shadow:    0 2px 12px rgba(0,0,0,.07), 0 1px 3px rgba(0,0,0,.05);
  --shadow-lg: 0 8px 40px rgba(0,0,0,.11), 0 2px 8px rgba(0,0,0,.06);
  --font-head: 'Syne', sans-serif;
  --font-body: 'DM Sans', sans-serif;
  --header-h: 64px;
}

html { scroll-behavior: smooth; }
body {
  font-family: var(--font-body);
  background: var(--bg);
  color: var(--ink);
  font-size: 15px;
  line-height: 1.6;
}
a { color: inherit; text-decoration: none; }
button { cursor: pointer; font-family: var(--font-body); }

/* ─── HEADER ─────────────────────────────────────────── */
.header {
  position: sticky; top: 0; z-index: 100;
  background: rgba(255,255,255,.92);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  border-bottom: 1px solid var(--line);
  height: var(--header-h);
  display: flex; align-items: center;
}
.header__inner {
  width: 100%; max-width: 1200px; margin: 0 auto;
  padding: 0 24px;
  display: flex; align-items: center; gap: 32px;
}
.logo {
  font-family: var(--font-head);
  font-size: 20px; font-weight: 800;
  color: var(--ink);
  display: flex; align-items: center; gap: 9px;
  white-space: nowrap;
}
.logo-icon {
  width: 32px; height: 32px;
  background: var(--accent);
  border-radius: 8px;
  display: grid; place-items: center;
}
.logo-icon svg { width: 18px; height: 18px; stroke: #fff; fill: none; stroke-width: 2.2; stroke-linecap: round; stroke-linejoin: round; }

.header__nav {
  display: flex; align-items: center; gap: 2px;
  list-style: none;
  flex: 1;
}
.header__nav a {
  padding: 6px 13px;
  border-radius: var(--radius-sm);
  font-size: 14px; font-weight: 500;
  color: var(--ink-soft);
  transition: background .15s, color .15s;
}
.header__nav a:hover,
.header__nav a.active { background: var(--accent-lt); color: var(--accent); }

.header__cta {
  margin-left: auto;
  padding: 8px 18px;
  background: var(--accent);
  color: #fff;
  border: none;
  border-radius: var(--radius-sm);
  font-size: 13px; font-weight: 600;
  transition: background .15s;
}
.header__cta:hover { background: var(--accent-dk); }

/* ─── HERO BANNER ────────────────────────────────────── */
.hero {
  background: linear-gradient(135deg, #0d1117 0%, #1a2844 60%, #0e3ab5 100%);
  padding: 64px 24px 56px;
  position: relative;
  overflow: hidden;
}
.hero::before {
  content: '';
  position: absolute; inset: 0;
  background-image: radial-gradient(circle at 70% 50%, rgba(26,86,232,.3) 0%, transparent 60%),
                    url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  pointer-events: none;
}
.hero__inner { max-width: 1200px; margin: 0 auto; position: relative; }
.hero__badge {
  display: inline-flex; align-items: center; gap: 6px;
  background: rgba(26,86,232,.25);
  border: 1px solid rgba(26,86,232,.5);
  color: #7fb3ff;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 12px; font-weight: 600;
  letter-spacing: .05em; text-transform: uppercase;
  margin-bottom: 20px;
}
.hero__badge-dot { width: 6px; height: 6px; border-radius: 50%; background: #4d9fff; animation: pulse 2s infinite; }
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }

.hero h1 {
  font-family: var(--font-head);
  font-size: clamp(28px, 5vw, 46px);
  font-weight: 800;
  color: #fff;
  line-height: 1.15;
  max-width: 600px;
  margin-bottom: 16px;
}
.hero h1 em { color: #6aa3ff; font-style: normal; }
.hero p {
  color: rgba(255,255,255,.65);
  font-size: 16px;
  max-width: 520px;
  margin-bottom: 32px;
}
.hero__stats {
  display: flex; gap: 32px; flex-wrap: wrap;
}
.hero__stat { color: #fff; }
.hero__stat strong {
  font-family: var(--font-head);
  font-size: 28px; font-weight: 800;
  display: block;
}
.hero__stat span { font-size: 13px; color: rgba(255,255,255,.5); }

/* ─── LAYOUT ─────────────────────────────────────────── */
.page { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

/* ─── SECTION TITLES ─────────────────────────────────── */
.section-title {
  font-family: var(--font-head);
  font-size: 22px; font-weight: 700;
  margin-bottom: 4px;
}
.section-sub { color: var(--ink-mute); font-size: 14px; margin-bottom: 28px; }

/* ─── FILTER BAR ─────────────────────────────────────── */
.filter-bar {
  padding: 28px 0 0;
  display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
}
.filter-btn {
  padding: 7px 16px;
  border: 1.5px solid var(--line);
  border-radius: 20px;
  background: var(--surface);
  font-size: 13px; font-weight: 500;
  color: var(--ink-soft);
  transition: all .15s;
}
.filter-btn:hover { border-color: var(--accent); color: var(--accent); }
.filter-btn.active { background: var(--accent); border-color: var(--accent); color: #fff; }

/* ─── FEATURED CAPSULE ───────────────────────────────── */
.featured-section { padding: 36px 0 0; }
.featured-card {
  background: var(--surface);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  overflow: hidden;
  display: grid;
  grid-template-columns: 1fr 1fr;
  border: 1px solid var(--line);
}
.featured-card__visual {
  background: linear-gradient(135deg, #0d1117, #1a2844);
  display: flex; align-items: center; justify-content: center;
  min-height: 240px;
  position: relative;
  overflow: hidden;
}
.featured-card__visual::after {
  content: '';
  position: absolute; inset: 0;
  background: radial-gradient(circle at 30% 70%, rgba(26,86,232,.4), transparent 60%);
}
.featured-icon-wrap {
  width: 88px; height: 88px;
  border: 2px solid rgba(255,255,255,.15);
  border-radius: 24px;
  display: grid; place-items: center;
  background: rgba(255,255,255,.08);
  position: relative; z-index: 1;
}
.featured-icon-wrap svg { width: 44px; height: 44px; stroke: #7fb3ff; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
.featured-card__body { padding: 36px 40px; display: flex; flex-direction: column; justify-content: center; gap: 14px; }
.featured-card__meta { display: flex; gap: 10px; align-items: center; }
.tag {
  display: inline-block;
  padding: 3px 10px;
  border-radius: 4px;
  font-size: 11px; font-weight: 600;
  text-transform: uppercase; letter-spacing: .05em;
}
.tag--destaca { background: #fff3cd; color: #92600a; }
.tag--nivel { background: var(--accent-lt); color: var(--accent); }
.featured-card__body h2 { font-family: var(--font-head); font-size: 26px; font-weight: 700; line-height: 1.2; }
.featured-card__body p { color: var(--ink-soft); font-size: 15px; }
.card__actions { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 4px; }

.btn {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 9px 18px;
  border-radius: var(--radius-sm);
  font-size: 13px; font-weight: 600;
  border: none;
  transition: all .15s;
}
.btn svg { width: 15px; height: 15px; flex-shrink: 0; }
.btn--primary { background: var(--accent); color: #fff; }
.btn--primary:hover { background: var(--accent-dk); }
.btn--ghost { background: transparent; color: var(--accent); border: 1.5px solid var(--accent); }
.btn--ghost:hover { background: var(--accent-lt); }
.btn--dl { background: #eafaf1; color: #1da462; border: 1.5px solid #b7e5cc; }
.btn--dl:hover { background: #d4f3e4; }

/* ─── CAPSULES GRID ──────────────────────────────────── */
.grid-section { padding: 36px 0; }
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 20px;
}
.card {
  background: var(--surface);
  border: 1px solid var(--line);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  overflow: hidden;
  display: flex; flex-direction: column;
  transition: transform .2s, box-shadow .2s;
}
.card:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); }
.card__header {
  padding: 20px 20px 0;
  display: flex; align-items: flex-start; gap: 14px;
}
.card__icon {
  width: 44px; height: 44px; border-radius: 12px;
  display: grid; place-items: center; flex-shrink: 0;
}
.card__icon svg { width: 22px; height: 22px; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
.card__meta-top { flex: 1; }
.card__category {
  font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em;
  margin-bottom: 2px;
}
.card__date { font-size: 12px; color: var(--ink-mute); }

.card__body { padding: 14px 20px 0; flex: 1; }
.card__body h3 { font-family: var(--font-head); font-size: 17px; font-weight: 700; line-height: 1.3; margin-bottom: 8px; }
.card__body p { color: var(--ink-soft); font-size: 13.5px; line-height: 1.55; }

.card__footer {
  padding: 16px 20px 20px;
  display: flex; align-items: center; justify-content: space-between;
  border-top: 1px solid var(--line);
  margin-top: 16px;
  gap: 8px; flex-wrap: wrap;
}
.card__footer-links { display: flex; gap: 8px; flex-wrap: wrap; }

.btn-sm {
  display: inline-flex; align-items: center; gap: 5px;
  padding: 6px 12px;
  border-radius: 6px;
  font-size: 12px; font-weight: 600;
  border: none;
  transition: all .15s;
  white-space: nowrap;
}
.btn-sm svg { width: 13px; height: 13px; flex-shrink: 0; }
.btn-sm--link { background: var(--accent-lt); color: var(--accent); }
.btn-sm--link:hover { background: #c5d9ff; }
.btn-sm--dl { background: #eafaf1; color: #1da462; }
.btn-sm--dl:hover { background: #d4f3e4; }
.btn-sm--read { background: var(--bg); color: var(--ink-soft); border: 1px solid var(--line); }
.btn-sm--read:hover { background: var(--line); }

.card__views { font-size: 12px; color: var(--ink-mute); display: flex; align-items: center; gap: 4px; }
.card__views svg { width: 13px; height: 13px; }

/* ─── NIVEL BADGE ────────────────────────────────────── */
.nivel-badge {
  display: inline-block;
  padding: 2px 8px;
  border-radius: 4px;
  font-size: 10px; font-weight: 700;
  text-transform: uppercase; letter-spacing: .06em;
}
.nivel-badge--basico { background: #dff4e8; color: #1a7a40; }
.nivel-badge--intermedio { background: #fff3cd; color: #8a6200; }
.nivel-badge--avanzado { background: #fce4e1; color: #a3200f; }

/* ─── QUIZ SECTION ───────────────────────────────────── */
.quiz-section {
  margin: 12px 0 48px;
  background: var(--surface);
  border: 1px solid var(--line);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  overflow: hidden;
}
.quiz-header {
  background: linear-gradient(135deg, #0d1117, #1a2844);
  padding: 28px 36px;
  display: flex; align-items: center; gap: 20px;
}
.quiz-header-icon {
  width: 52px; height: 52px;
  background: rgba(26,86,232,.4);
  border: 1.5px solid rgba(26,86,232,.6);
  border-radius: 14px;
  display: grid; place-items: center; flex-shrink: 0;
}
.quiz-header-icon svg { width: 26px; height: 26px; stroke: #7fb3ff; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
.quiz-header-text h2 { font-family: var(--font-head); font-size: 20px; font-weight: 700; color: #fff; margin-bottom: 4px; }
.quiz-header-text p { color: rgba(255,255,255,.55); font-size: 14px; }

.quiz-body { padding: 32px 36px; }
.quiz-progress {
  display: flex; align-items: center; gap: 12px;
  margin-bottom: 28px;
}
.quiz-progress__bar {
  flex: 1; height: 6px; background: var(--bg); border-radius: 3px; overflow: hidden;
}
.quiz-progress__fill {
  height: 100%; background: var(--accent); border-radius: 3px;
  transition: width .4s ease;
}
.quiz-progress__label { font-size: 13px; font-weight: 600; color: var(--ink-mute); white-space: nowrap; }

.quiz-question { display: none; }
.quiz-question.active { display: block; animation: fadeIn .3s ease; }
@keyframes fadeIn { from{opacity:0; transform:translateY(8px)} to{opacity:1; transform:translateY(0)} }

.quiz-q-text {
  font-family: var(--font-head);
  font-size: 18px; font-weight: 600;
  color: var(--ink);
  margin-bottom: 20px;
  line-height: 1.4;
}
.quiz-options { display: flex; flex-direction: column; gap: 10px; }
.quiz-opt {
  display: flex; align-items: center; gap: 12px;
  padding: 13px 16px;
  border: 1.5px solid var(--line);
  border-radius: var(--radius-sm);
  cursor: pointer;
  transition: all .15s;
  background: var(--surface);
}
.quiz-opt:hover:not(.answered) { border-color: var(--accent); background: var(--accent-lt); }
.quiz-opt__letter {
  width: 28px; height: 28px; border-radius: 50%;
  background: var(--bg); border: 1.5px solid var(--line);
  display: grid; place-items: center;
  font-size: 12px; font-weight: 700; text-transform: uppercase;
  flex-shrink: 0; transition: all .15s;
}
.quiz-opt span { font-size: 14px; font-weight: 500; }
.quiz-opt.correct { border-color: var(--ok); background: #edfbf3; }
.quiz-opt.correct .quiz-opt__letter { background: var(--ok); border-color: var(--ok); color: #fff; }
.quiz-opt.wrong { border-color: var(--warn); background: #fdf2f0; }
.quiz-opt.wrong .quiz-opt__letter { background: var(--warn); border-color: var(--warn); color: #fff; }

.quiz-feedback {
  margin-top: 16px; padding: 14px 16px;
  border-radius: var(--radius-sm);
  font-size: 14px; line-height: 1.5;
  display: none;
}
.quiz-feedback.show { display: block; animation: fadeIn .2s ease; }
.quiz-feedback--ok { background: #edfbf3; border-left: 4px solid var(--ok); color: #1a5c38; }
.quiz-feedback--bad { background: #fdf2f0; border-left: 4px solid var(--warn); color: #7a1e0d; }
.quiz-feedback strong { font-weight: 700; }

.quiz-nav { display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px; }
.quiz-result {
  display: none; text-align: center; padding: 16px 0;
  animation: fadeIn .4s ease;
}
.quiz-result.show { display: block; }
.quiz-result__score {
  font-family: var(--font-head);
  font-size: 56px; font-weight: 800;
  color: var(--accent); line-height: 1;
  margin-bottom: 8px;
}
.quiz-result__label { font-size: 18px; font-weight: 600; margin-bottom: 8px; }
.quiz-result__msg { color: var(--ink-mute); font-size: 14px; margin-bottom: 24px; }

/* ─── ALERTAS SECTION ────────────────────────────────── */
.alerts-section { padding: 0 0 48px; }
.alert-card {
  display: flex; align-items: flex-start; gap: 14px;
  background: var(--surface);
  border: 1px solid var(--line);
  border-left: 4px solid var(--warn);
  border-radius: var(--radius-sm);
  padding: 16px 20px;
  margin-bottom: 10px;
}
.alert-card--warn { border-left-color: var(--warn); }
.alert-card--info { border-left-color: var(--accent); }
.alert-card--ok   { border-left-color: var(--ok); }
.alert-icon {
  width: 36px; height: 36px; border-radius: 9px;
  display: grid; place-items: center; flex-shrink: 0;
}
.alert-icon svg { width: 18px; height: 18px; fill: none; stroke-width: 2.2; stroke-linecap: round; stroke-linejoin: round; }
.alert-icon--warn { background: #fdf2f0; }
.alert-icon--warn svg { stroke: var(--warn); }
.alert-icon--info { background: var(--accent-lt); }
.alert-icon--info svg { stroke: var(--accent); }
.alert-icon--ok { background: #eafaf1; }
.alert-icon--ok svg { stroke: var(--ok); }
.alert-body h4 { font-size: 14px; font-weight: 700; margin-bottom: 2px; }
.alert-body p { font-size: 13px; color: var(--ink-soft); }

/* ─── FOOTER ─────────────────────────────────────────── */
.footer {
  background: var(--ink);
  color: rgba(255,255,255,.5);
  padding: 32px 24px;
  text-align: center;
  font-size: 13px;
}
.footer a { color: rgba(255,255,255,.7); }
.footer strong { color: rgba(255,255,255,.85); font-family: var(--font-head); font-weight: 700; }

/* ─── RESPONSIVE ─────────────────────────────────────── */
@media (max-width: 768px) {
  .featured-card { grid-template-columns: 1fr; }
  .featured-card__visual { min-height: 160px; }
  .featured-card__body { padding: 24px; }
  .featured-card__body h2 { font-size: 20px; }
  .quiz-body { padding: 20px; }
  .quiz-header { padding: 20px; }
  .header__nav { display: none; }
  .hero h1 { font-size: 26px; }
  .hero__stats { gap: 20px; }
}

/* ─── SCROLL TO TOP ──────────────────────────────────── */
#scrollTop {
  position: fixed; bottom: 24px; right: 24px;
  width: 40px; height: 40px;
  background: var(--accent); color: #fff;
  border: none; border-radius: 50%;
  display: grid; place-items: center;
  box-shadow: 0 4px 16px rgba(26,86,232,.4);
  opacity: 0; pointer-events: none;
  transition: opacity .3s;
  z-index: 50;
}
#scrollTop.visible { opacity: 1; pointer-events: all; }
#scrollTop svg { width: 18px; height: 18px; }

/* ── SEDUC HUB TOPBAR ─────────────────────────────────────────────── */
.container{width:min(1200px,calc(100% - 36px));margin-inline:auto}
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

<!-- ═══ HERO ══════════════════════════════════════════ -->
<section class="hero">
  <div class="hero__inner">
    <div class="hero__badge">
      <span class="hero__badge-dot"></span>
      Actualizado semanalmente
    </div>
    <h1>Aprende a protegerte<br>en el <em>mundo digital</em></h1>
    <p>Cápsulas informativas sobre ciberseguridad: fraudes, amenazas actuales y buenas prácticas para usuarios, sin tecnicismos.</p>
    <div class="hero__stats">
      <div class="hero__stat"><strong>+60</strong><span>Cápsulas publicadas</span></div>
      <div class="hero__stat"><strong>12k</strong><span>Usuarios informados</span></div>
      <div class="hero__stat"><strong>5</strong><span>Nuevas alertas este mes</span></div>
    </div>
  </div>
</section>

<!-- ═══ MAIN ══════════════════════════════════════════ -->
<main>
<div class="page">

  <!-- Filtros -->
  <div class="filter-bar" id="capsulas">
    <button class="filter-btn active" data-filter="all" onclick="filterCapsules(this,'all')">Todas</button>
    <?php foreach($categorias_info as $key => $cat): ?>
    <button class="filter-btn" data-filter="<?= $key ?>" onclick="filterCapsules(this,'<?= $key ?>')"><?= $cat['label'] ?></button>
    <?php endforeach; ?>
  </div>

  <!-- Cápsula Destacada -->
  <?php
    $dest = array_values(array_filter($capsulas, fn($c) => $c['destacado']))[0] ?? $capsulas[0];
    $cinfo = $categorias_info[$dest['categoria']] ?? ['color'=>'#1a56e8','bg'=>'#dce9ff','label'=>ucfirst($dest['categoria'])];
  ?>
  <section class="featured-section">
    <div class="featured-card" data-cat="<?= $dest['categoria'] ?>">
      <div class="featured-card__visual">
        <div class="featured-icon-wrap">
          <?= getIcon($dest['icono'], 44) ?>
        </div>
      </div>
      <div class="featured-card__body">
        <div class="featured-card__meta">
          <span class="tag tag--destaca">⭐ Destacado</span>
          <span class="tag tag--nivel"><?= $dest['nivel'] ?></span>
        </div>
        <h2><?= htmlspecialchars($dest['titulo']) ?></h2>
        <p><?= htmlspecialchars($dest['resumen']) ?></p>
        <div class="card__actions">
          <a href="capsula_detalle.php?id=<?= $dest['id'] ?>" class="btn btn--primary">
            <?= getSvg('book-open') ?> Leer cápsula
          </a>
          <?php if($dest['url_profundizar']): ?>
          <a href="<?= htmlspecialchars($dest['url_profundizar']) ?>" target="_blank" rel="noopener" class="btn btn--ghost">
            <?= getSvg('external-link') ?> Profundizar
          </a>
          <?php endif; ?>
          <?php if($dest['archivo_descarga']): ?>
          <a href="descargas/<?= $dest['archivo_descarga'] ?>" download class="btn btn--dl">
            <?= getSvg('download') ?> Descargar guía
          </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- Grid de cápsulas -->
  <section class="grid-section">
    <h2 class="section-title">Todas las cápsulas</h2>
    <p class="section-sub">Selecciona una categoría para filtrar. Haz clic en una cápsula para leerla completa.</p>
    <div class="grid" id="capsulaGrid">
      <?php foreach($capsulas as $cap):
        $ci = $categorias_info[$cap['categoria']] ?? ['color'=>'#1a56e8','bg'=>'#dce9ff','label'=>ucfirst($cap['categoria'])];
        $nivel_class = 'nivel-badge--' . strtolower($cap['nivel']);
      ?>
      <article class="card" data-cat="<?= $cap['categoria'] ?>">
        <div class="card__header">
          <div class="card__icon" style="background:<?= $ci['bg'] ?>">
            <?= getIcon($cap['icono'], 22, $ci['color']) ?>
          </div>
          <div class="card__meta-top">
            <div class="card__category" style="color:<?= $ci['color'] ?>"><?= $ci['label'] ?></div>
            <div class="card__date"><?= $cap['fecha'] ?></div>
          </div>
          <span class="nivel-badge <?= $nivel_class ?>"><?= $cap['nivel'] ?></span>
        </div>
        <div class="card__body">
          <h3><?= htmlspecialchars($cap['titulo']) ?></h3>
          <p><?= htmlspecialchars($cap['resumen']) ?></p>
        </div>
        <div class="card__footer">
          <div class="card__footer-links">
            <a href="capsula_detalle.php?id=<?= $cap['id'] ?>" class="btn-sm btn-sm--read">
              <?= getSvg('arrow-right', 13) ?> Ver
            </a>
            <?php if($cap['url_profundizar']): ?>
            <a href="<?= htmlspecialchars($cap['url_profundizar']) ?>" target="_blank" rel="noopener" class="btn-sm btn-sm--link">
              <?= getSvg('external-link', 13) ?> Profundizar
            </a>
            <?php endif; ?>
            <?php if($cap['archivo_descarga']): ?>
            <a href="descargas/<?= $cap['archivo_descarga'] ?>" download class="btn-sm btn-sm--dl">
              <?= getSvg('download', 13) ?> Descargar
            </a>
            <?php endif; ?>
          </div>
          <div class="card__views">
            <?= getSvg('eye', 13) ?> <?= number_format($cap['vistas']) ?>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ─── ALERTAS ─────────────────────────────────── -->
  <section class="alerts-section" id="alertas">
    <h2 class="section-title">Alertas recientes</h2>
    <p class="section-sub">Amenazas activas y avisos de seguridad de los últimos 30 días</p>

    <div class="alert-card alert-card--warn">
      <div class="alert-icon alert-icon--warn"><?= getSvg('alert-triangle', 18) ?></div>
      <div class="alert-body">
        <h4>Campaña de smishing activa: falsos mensajes de Banco Estado</h4>
        <p>Se han detectado SMS fraudulentos suplantando a Banco Estado pidiendo verificar cuentas. No hagas clic en ningún enlace. — <em>08 May 2025</em></p>
      </div>
    </div>
    <div class="alert-card alert-card--warn">
      <div class="alert-icon alert-icon--warn"><?= getSvg('alert-triangle', 18) ?></div>
      <div class="alert-body">
        <h4>Phishing vía correo: supuestas facturas del SII</h4>
        <p>Correos masivos simulando notificaciones del Servicio de Impuestos Internos. Contienen archivos adjuntos con malware. — <em>03 May 2025</em></p>
      </div>
    </div>
    <div class="alert-card alert-card--info">
      <div class="alert-icon alert-icon--info"><?= getSvg('info', 18) ?></div>
      <div class="alert-body">
        <h4>CSIRT Chile actualiza recomendaciones para contraseñas corporativas</h4>
        <p>El organismo publicó nuevas guías para la gestión de credenciales en empresas. Descarga el documento oficial en csirt.gob.cl — <em>28 Apr 2025</em></p>
      </div>
    </div>
    <div class="alert-card alert-card--ok">
      <div class="alert-icon alert-icon--ok"><?= getSvg('check-circle', 18) ?></div>
      <div class="alert-body">
        <h4>Tip: Activa el segundo factor de autenticación (2FA)</h4>
        <p>Agregar una capa extra de seguridad a tus cuentas principales reduce en un 99% el riesgo de acceso no autorizado. — <em>22 Apr 2025</em></p>
      </div>
    </div>
  </section>

  <!-- ─── QUIZ ─────────────────────────────────────── -->
  <section class="quiz-section" id="quiz">
    <div class="quiz-header">
      <div class="quiz-header-icon"><?= getSvg('help-circle', 26) ?></div>
      <div class="quiz-header-text">
        <h2>¿Qué tanto sabes de ciberseguridad?</h2>
        <p><?= count($quiz_preguntas) ?> preguntas · Aprende con cada respuesta · Sin límite de intentos</p>
      </div>
    </div>
    <div class="quiz-body">

      <!-- Progreso -->
      <div class="quiz-progress">
        <div class="quiz-progress__bar">
          <div class="quiz-progress__fill" id="quizBar" style="width:0%"></div>
        </div>
        <div class="quiz-progress__label" id="quizCounter">Pregunta 1 de <?= count($quiz_preguntas) ?></div>
      </div>

      <!-- Preguntas (PHP genera el HTML, JS lo anima) -->
      <?php foreach($quiz_preguntas as $i => $q): ?>
      <div class="quiz-question <?= $i===0?'active':'' ?>" id="quizQ<?= $i ?>">
        <p class="quiz-q-text"><?= $i+1 ?>. <?= htmlspecialchars($q['pregunta']) ?></p>
        <div class="quiz-options">
          <?php foreach(['a','b','c','d'] as $letra): ?>
          <div class="quiz-opt" id="q<?= $i ?>opt<?= $letra ?>"
               onclick="answerQuiz(<?= $i ?>,'<?= $letra ?>','<?= $q['correcta'] ?>')">
            <div class="quiz-opt__letter"><?= $letra ?></div>
            <span><?= htmlspecialchars($q['opciones'][$letra]) ?></span>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="quiz-feedback" id="quizFb<?= $i ?>"></div>
      </div>
      <?php endforeach; ?>

      <!-- Resultado final -->
      <div class="quiz-result" id="quizResult">
        <div class="quiz-result__score" id="quizScore">0/<?= count($quiz_preguntas) ?></div>
        <div class="quiz-result__label" id="quizLabel">¡Buen trabajo!</div>
        <div class="quiz-result__msg" id="quizMsg">Sigue aprendiendo con nuestras cápsulas.</div>
        <button class="btn btn--primary" onclick="restartQuiz()">
          <?= getSvg('refresh-cw') ?> Intentar de nuevo
        </button>
      </div>

      <!-- Navegación -->
      <div class="quiz-nav" id="quizNav">
        <button class="btn btn--ghost" id="quizPrev" onclick="quizMove(-1)" style="display:none">
          <?= getSvg('chevron-left') ?> Anterior
        </button>
        <button class="btn btn--primary" id="quizNext" onclick="quizMove(1)" style="display:none">
          Siguiente <?= getSvg('chevron-right') ?>
        </button>
        <button class="btn btn--primary" id="quizFinish" onclick="showQuizResult()" style="display:none">
          Ver resultado <?= getSvg('check') ?>
        </button>
      </div>
    </div>
  </section>

</div><!-- /page -->
</main>

<!-- ═══ FOOTER ════════════════════════════════════════ -->
<footer class="footer">
  <p><strong>SecuraBit</strong> · Cápsulas de Ciberseguridad · <?= date('Y') ?></p>
  <p style="margin-top:6px">Información educativa. Ante emergencias de seguridad contacta a <a href="https://www.csirt.gob.cl" target="_blank">CSIRT Chile</a>.</p>
</footer>

<!-- Scroll top -->
<button id="scrollTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
  <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"/></svg>
</button>

<script>
// ── FILTRO DE CÁPSULAS ────────────────────────────────
function filterCapsules(btn, cat) {
  document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('#capsulaGrid .card').forEach(card => {
    card.style.display = (cat === 'all' || card.dataset.cat === cat) ? '' : 'none';
  });
}

// ── QUIZ ──────────────────────────────────────────────
const TOTAL = <?= count($quiz_preguntas) ?>;
const EXPLICACIONES = <?= json_encode(array_column($quiz_preguntas, 'explicacion')) ?>;
let current = 0;
let answered = new Array(TOTAL).fill(false);
let scores   = new Array(TOTAL).fill(null); // true/false/null

function answerQuiz(qi, chosen, correct) {
  if (answered[qi]) return;
  answered[qi] = true;
  const isOk = chosen === correct;
  scores[qi] = isOk;

  ['a','b','c','d'].forEach(l => {
    const el = document.getElementById(`q${qi}opt${l}`);
    el.classList.add('answered');
    if (l === correct) el.classList.add('correct');
    if (l === chosen && !isOk) el.classList.add('wrong');
  });

  const fb = document.getElementById(`quizFb${qi}`);
  fb.classList.add('show', isOk ? 'quiz-feedback--ok' : 'quiz-feedback--bad');
  fb.innerHTML = `<strong>${isOk ? '✓ Correcto.' : '✗ Incorrecto.'}</strong> ${EXPLICACIONES[qi]}`;

  updateNav();
}

function updateNav() {
  const isLast = current === TOTAL - 1;
  document.getElementById('quizNext').style.display   = (!isLast && answered[current]) ? '' : 'none';
  document.getElementById('quizFinish').style.display = (isLast  && answered[current]) ? '' : 'none';
  document.getElementById('quizPrev').style.display   = current > 0 ? '' : 'none';
}

function quizMove(dir) {
  const target = current + dir;
  if (target < 0 || target >= TOTAL) return;
  document.getElementById(`quizQ${current}`).classList.remove('active');
  current = target;
  document.getElementById(`quizQ${current}`).classList.add('active');
  const pct = (current / TOTAL) * 100;
  document.getElementById('quizBar').style.width = pct + '%';
  document.getElementById('quizCounter').textContent = `Pregunta ${current+1} de ${TOTAL}`;
  updateNav();
}

function showQuizResult() {
  document.getElementById(`quizQ${current}`).style.display = 'none';
  document.getElementById('quizNav').style.display = 'none';
  document.getElementById('quizBar').style.width = '100%';
  const correct = scores.filter(Boolean).length;
  document.getElementById('quizScore').textContent = `${correct}/${TOTAL}`;
  const pct = correct / TOTAL;
  let label, msg;
  if (pct === 1)        { label = '🏆 ¡Perfecto!'; msg = 'Excelente dominio del tema. ¡Comparte el test con tus contactos!'; }
  else if (pct >= 0.6)  { label = '👍 ¡Bien hecho!'; msg = 'Buen nivel. Revisa las preguntas que fallaste para reforzar.'; }
  else                  { label = '📚 Sigue aprendiendo'; msg = 'Te recomendamos leer nuestras cápsulas para mejorar tu conocimiento.'; }
  document.getElementById('quizLabel').textContent = label;
  document.getElementById('quizMsg').textContent = msg;
  document.getElementById('quizResult').classList.add('show');
  document.getElementById('quizCounter').textContent = `Completado · ${correct}/${TOTAL} correctas`;
}

function restartQuiz() {
  current = 0;
  answered = new Array(TOTAL).fill(false);
  scores   = new Array(TOTAL).fill(null);
  document.getElementById('quizResult').classList.remove('show');
  document.getElementById('quizNav').style.display = '';
  document.getElementById('quizBar').style.width = '0%';
  document.getElementById('quizCounter').textContent = `Pregunta 1 de ${TOTAL}`;
  for (let i = 0; i < TOTAL; i++) {
    const q = document.getElementById(`quizQ${i}`);
    q.style.display = ''; q.classList.toggle('active', i === 0);
    ['a','b','c','d'].forEach(l => {
      const el = document.getElementById(`q${i}opt${l}`);
      el.classList.remove('answered','correct','wrong');
    });
    const fb = document.getElementById(`quizFb${i}`);
    fb.classList.remove('show','quiz-feedback--ok','quiz-feedback--bad');
    fb.innerHTML = '';
  }
  updateNav();
}

// ── SCROLL TOP ────────────────────────────────────────
const scrollBtn = document.getElementById('scrollTop');
window.addEventListener('scroll', () => {
  scrollBtn.classList.toggle('visible', window.scrollY > 300);
});
</script>

<?php renderRailAcciones(true); ?>
<?php renderPanelContactos(); ?>
</body>
</html>
<?php
/* ─── SVG ICON HELPERS ─────────────────────────────────
 * Genera SVG inline para los íconos usados en la página.
 */
function getSvg(string $name, int $size = 15): string {
  $s = $size;
  $icons = [
    'shield'         => '<path d="M12 2L4 5v6c0 5.25 3.5 10.15 8 11.35C16.5 21.15 20 16.25 20 11V5l-8-3z"/>',
    'smartphone'     => '<rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/>',
    'mail'           => '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>',
    'lock'           => '<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
    'bug'            => '<circle cx="12" cy="13" r="4"/><path d="M12 9V7m0 12v-2M3 13h2m14 0h2M5 7l1.5 1.5M19 7l-1.5 1.5M5 19l1.5-1.5M19 19l-1.5-1.5"/>',
    'wifi'           => '<path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/>',
    'phone-call'     => '<path d="M15.05 5A5 5 0 0 1 19 8.95M15.05 1A9 9 0 0 1 23 8.94m-1 7.98v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 14.9a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 4h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 11.5a16 16 0 0 0 6 6l.94-.94a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.5 18.92z"/>',
    'book-open'      => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>',
    'external-link'  => '<path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>',
    'download'       => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>',
    'arrow-right'    => '<line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>',
    'eye'            => '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>',
    'alert-triangle' => '<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>',
    'info'           => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>',
    'check-circle'   => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>',
    'help-circle'    => '<circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/>',
    'refresh-cw'     => '<polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>',
    'chevron-left'   => '<polyline points="15 18 9 12 15 6"/>',
    'chevron-right'  => '<polyline points="9 18 15 12 9 6"/>',
    'check'          => '<polyline points="20 6 9 17 4 12"/>',
  ];
  $path = $icons[$name] ?? '<circle cx="12" cy="12" r="10"/>';
  return '<svg width="'.$s.'" height="'.$s.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">'.$path.'</svg>';
}

function getIcon(string $name, int $size = 22, string $color = 'currentColor'): string {
  $icons = [
    'smartphone'     => '<rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/>',
    'mail'           => '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>',
    'lock'           => '<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
    'bug'            => '<circle cx="12" cy="13" r="4"/><path d="M12 9V7"/>',
    'wifi'           => '<path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/>',
    'phone-call'     => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 4.69 14.9"/><path d="M15.05 5A5 5 0 0 1 19 8.95"/>',
  ];
  $path = $icons[$name] ?? '<circle cx="12" cy="12" r="10"/>';
  return '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">'.$path.'</svg>';
}
?>