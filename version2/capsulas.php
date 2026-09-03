<?php
require_once 'class/Sesion.php';
require_once 'class/Conexion.php';
Sesion::requerir();

$titulo_pagina     = 'Cápsulas Informáticas';
$breadcrumb_actual = 'Cápsulas';
$pagina_actual     = 'capsulas';

// ── Helpers SVG ────────────────────────────────────────────────────
function getSvg(string $name, int $size = 15): string {
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
    return '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">'.$path.'</svg>';
}

function getCapIcon(string $name, int $size = 22, string $color = 'currentColor'): string {
    $icons = [
        'smartphone' => '<rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/>',
        'mail'       => '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>',
        'lock'       => '<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
        'bug'        => '<circle cx="12" cy="13" r="4"/><path d="M12 9V7"/>',
        'wifi'       => '<path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/>',
        'phone-call' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 4.69 14.9"/><path d="M15.05 5A5 5 0 0 1 19 8.95"/>',
    ];
    $path = $icons[$name] ?? '<circle cx="12" cy="12" r="10"/>';
    return '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="'.$color.'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">'.$path.'</svg>';
}

// ── Datos estáticos ────────────────────────────────────────────────
$capsulas = [
    ['id'=>1,'titulo'=>'Smishing: Fraudes por SMS','resumen'=>'Los mensajes de texto también pueden ser una trampa. Conoce cómo identificar y evitar el smishing.','categoria'=>'smishing','nivel'=>'Básico','icono'=>'smartphone','destacado'=>true,'fecha'=>'08 May 2025','url_profundizar'=>'https://sitiospublicos.bancochile.cl/personas/seguridad/detalle/smishing','archivo_descarga'=>null,'vistas'=>1240],
    ['id'=>2,'titulo'=>'Phishing: El anzuelo digital','resumen'=>'Aprende a identificar correos electrónicos fraudulentos que buscan robar tus credenciales y datos bancarios.','categoria'=>'phishing','nivel'=>'Básico','icono'=>'mail','destacado'=>true,'fecha'=>'05 May 2025','url_profundizar'=>'https://www.bcn.cl/leychile/navegar?idNorma=1036049','archivo_descarga'=>'guia_phishing.pdf','vistas'=>2180],
    ['id'=>3,'titulo'=>'Contraseñas Seguras: La primera línea de defensa','resumen'=>'Una contraseña robusta puede ser la diferencia entre proteger tu identidad digital o perderla.','categoria'=>'contrasenas','nivel'=>'Básico','icono'=>'lock','destacado'=>false,'fecha'=>'01 May 2025','url_profundizar'=>'https://www.csirt.gob.cl/','archivo_descarga'=>'buenas_practicas_contrasenas.pdf','vistas'=>980],
    ['id'=>4,'titulo'=>'Malware y Ransomware: Amenazas invisibles','resumen'=>'Descubre qué son los programas maliciosos, cómo se propagan y qué hacer si tu equipo es infectado.','categoria'=>'malware','nivel'=>'Intermedio','icono'=>'bug','destacado'=>false,'fecha'=>'28 Abr 2025','url_profundizar'=>'https://www.csirt.gob.cl/alertas/','archivo_descarga'=>null,'vistas'=>756],
    ['id'=>5,'titulo'=>'Redes Wi-Fi Públicas: Navegar con precaución','resumen'=>'Conectarse a una red pública puede exponer toda tu actividad. Aprende a protegerte cuando estés fuera de casa.','categoria'=>'redes','nivel'=>'Intermedio','icono'=>'wifi','destacado'=>false,'fecha'=>'22 Abr 2025','url_profundizar'=>null,'archivo_descarga'=>'seguridad_wifi_publico.pdf','vistas'=>612],
    ['id'=>6,'titulo'=>'Vishing: Fraude por llamadas telefónicas','resumen'=>'Los estafadores también usan el teléfono. Conoce las técnicas de ingeniería social por voz y cómo detectarlas.','categoria'=>'vishing','nivel'=>'Básico','icono'=>'phone-call','destacado'=>true,'fecha'=>'18 Abr 2025','url_profundizar'=>'https://www.sernac.cl/','archivo_descarga'=>null,'vistas'=>890],
];

$quiz_preguntas = [
    ['id'=>1,'pregunta'=>'¿Cuál de estas señales indica que un correo puede ser phishing?','opciones'=>['a'=>'Viene de un remitente que conoces','b'=>'Tiene urgencia extrema y solicita tus datos bancarios','c'=>'Contiene imágenes de alta calidad','d'=>'Está escrito en español correcto'],'correcta'=>'b','explicacion'=>'Los correos de phishing suelen crear urgencia artificial para que actúes sin pensar. Ningún banco o institución legítima te pedirá datos sensibles por correo.'],
    ['id'=>2,'pregunta'=>'¿Qué debes hacer si recibes un SMS con un enlace pidiendo verificar tu cuenta bancaria?','opciones'=>['a'=>'Hacer clic y verificar rápidamente','b'=>'Ignorarlo y eliminar el mensaje','c'=>'Llamar al número que aparece en el SMS','d'=>'Reenviarlo a tus contactos para alertarlos'],'correcta'=>'b','explicacion'=>'Nunca hagas clic en enlaces de SMS no solicitados. Contacta a tu banco directamente a través de sus canales oficiales.'],
    ['id'=>3,'pregunta'=>'¿Cuál es la contraseña más segura?','opciones'=>['a'=>'Mi nombre y año de nacimiento (ej: Juan1990)','b'=>'La misma para todas las cuentas pero muy larga','c'=>'Una frase larga con mayúsculas, números y símbolos (ej: C@fé#Seg.2025!)','d'=>'12345678'],'correcta'=>'c','explicacion'=>'Una contraseña segura combina longitud (mínimo 12 caracteres), mayúsculas, minúsculas, números y símbolos. Usa una distinta para cada servicio.'],
    ['id'=>4,'pregunta'=>'¿Qué es el ransomware?','opciones'=>['a'=>'Un antivirus gratuito','b'=>'Un tipo de red social privada','c'=>'Un programa que cifra tus archivos y pide rescate para recuperarlos','d'=>'Una extensión de navegador para privacidad'],'correcta'=>'c','explicacion'=>'El ransomware es un malware que secuestra tus archivos cifrándolos. Los cibercriminales exigen pago para devolver el acceso. Mantén copias de seguridad actualizadas.'],
    ['id'=>5,'pregunta'=>'¿Cuál es el mayor riesgo de conectarse a una Wi-Fi pública sin protección?','opciones'=>['a'=>'Que el internet sea más lento','b'=>'Que alguien pueda interceptar tus comunicaciones y robar datos','c'=>'Que se descarguen actualizaciones automáticas','d'=>'Que se gaste más batería del dispositivo'],'correcta'=>'b','explicacion'=>'En redes públicas, un atacante puede realizar ataques de "man-in-the-middle" para interceptar tu tráfico. Usa siempre una VPN o evita ingresar datos sensibles.'],
];

$categorias_info = [
    'phishing'   => ['color'=>'#e74c3c','bg'=>'#fdf0ef','label'=>'Phishing'],
    'smishing'   => ['color'=>'#e67e22','bg'=>'#fef5ec','label'=>'Smishing'],
    'vishing'    => ['color'=>'#9b59b6','bg'=>'#f5f0fb','label'=>'Vishing'],
    'malware'    => ['color'=>'#c0392b','bg'=>'#fdecea','label'=>'Malware'],
    'fraude'     => ['color'=>'#d35400','bg'=>'#fdf2ec','label'=>'Fraude'],
    'contrasenas'=> ['color'=>'#27ae60','bg'=>'#eafaf1','label'=>'Contraseñas'],
    'redes'      => ['color'=>'#2980b9','bg'=>'#eaf4fd','label'=>'Redes'],
    'identidad'  => ['color'=>'#16a085','bg'=>'#e8f8f5','label'=>'Identidad Digital'],
];

$destacada = array_values(array_filter($capsulas, fn($c) => $c['destacado']))[0] ?? $capsulas[0];

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
      <h1>Cápsulas de Ciberseguridad</h1>
      <p>Información práctica para protegerte en el mundo digital, sin tecnicismos.</p>
    </div>
  </div>

  <!-- Filtros -->
  <div class="cap-filter-bar">
    <button class="cap-filter-btn active" data-filter="all" onclick="filterCaps(this,'all')">Todas</button>
    <?php foreach($categorias_info as $key => $cat): ?>
    <button class="cap-filter-btn" data-filter="<?= $key ?>" onclick="filterCaps(this,'<?= $key ?>')"><?= $cat['label'] ?></button>
    <?php endforeach; ?>
  </div>

  <!-- Cápsula Destacada -->
  <?php $ci = $categorias_info[$destacada['categoria']] ?? ['color'=>'var(--blue)','bg'=>'var(--blue-light)','label'=>ucfirst($destacada['categoria'])]; ?>
  <div class="cap-featured card" data-cat="<?= $destacada['categoria'] ?>" style="margin-bottom:24px">
    <div class="cap-featured__visual">
      <div class="cap-featured__icon-wrap">
        <?= getCapIcon($destacada['icono'], 44, '#7fb3ff') ?>
      </div>
    </div>
    <div class="cap-featured__body">
      <div style="display:flex;gap:8px;align-items:center;margin-bottom:10px">
        <span class="badge" style="background:#fff3cd;color:#92600a">⭐ Destacado</span>
        <span class="badge" style="background:var(--blue-light);color:var(--blue)"><?= htmlspecialchars($destacada['nivel']) ?></span>
      </div>
      <h2 style="font-size:20px;font-weight:700;margin-bottom:8px;line-height:1.3"><?= htmlspecialchars($destacada['titulo']) ?></h2>
      <p style="color:var(--muted);font-size:14px;margin-bottom:16px"><?= htmlspecialchars($destacada['resumen']) ?></p>
      <div style="display:flex;gap:10px;flex-wrap:wrap">
        <?php if($destacada['url_profundizar']): ?>
        <a href="<?= htmlspecialchars($destacada['url_profundizar']) ?>" target="_blank" rel="noopener" class="btn btn-primary" style="font-size:13px">
          <?= getSvg('external-link',14) ?> Profundizar
        </a>
        <?php endif; ?>
        <?php if($destacada['archivo_descarga']): ?>
        <a href="descargas/<?= htmlspecialchars($destacada['archivo_descarga']) ?>" download class="btn btn-outline" style="font-size:13px">
          <?= getSvg('download',14) ?> Descargar guía
        </a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Grid de cápsulas -->
  <h2 style="font-size:16px;font-weight:700;margin-bottom:4px">Todas las cápsulas</h2>
  <p style="font-size:13px;color:var(--muted);margin-bottom:16px">Selecciona una categoría para filtrar.</p>
  <div class="cap-grid" id="capsulaGrid">
    <?php foreach($capsulas as $cap):
      $ci2 = $categorias_info[$cap['categoria']] ?? ['color'=>'var(--blue)','bg'=>'var(--blue-light)','label'=>ucfirst($cap['categoria'])];
      $nivel_class = 'cap-nivel--' . strtolower($cap['nivel']);
    ?>
    <div class="card cap-card" data-cat="<?= $cap['categoria'] ?>">
      <div class="cap-card__header">
        <div class="cap-card__icon" style="background:<?= $ci2['bg'] ?>">
          <?= getCapIcon($cap['icono'], 22, $ci2['color']) ?>
        </div>
        <div style="flex:1">
          <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:<?= $ci2['color'] ?>"><?= $ci2['label'] ?></div>
          <div style="font-size:12px;color:var(--muted)"><?= htmlspecialchars($cap['fecha']) ?></div>
        </div>
        <span class="cap-nivel <?= $nivel_class ?>"><?= htmlspecialchars($cap['nivel']) ?></span>
      </div>
      <div class="cap-card__body">
        <h3><?= htmlspecialchars($cap['titulo']) ?></h3>
        <p><?= htmlspecialchars($cap['resumen']) ?></p>
      </div>
      <div class="cap-card__footer">
        <div style="display:flex;gap:6px;flex-wrap:wrap">
          <?php if($cap['url_profundizar']): ?>
          <a href="<?= htmlspecialchars($cap['url_profundizar']) ?>" target="_blank" rel="noopener" class="cap-btn-sm cap-btn-sm--link">
            <?= getSvg('external-link',12) ?> Profundizar
          </a>
          <?php endif; ?>
          <?php if($cap['archivo_descarga']): ?>
          <a href="descargas/<?= htmlspecialchars($cap['archivo_descarga']) ?>" download class="cap-btn-sm cap-btn-sm--dl">
            <?= getSvg('download',12) ?> Descargar
          </a>
          <?php endif; ?>
        </div>
        <div style="font-size:12px;color:var(--muted);display:flex;align-items:center;gap:4px">
          <?= getSvg('eye',12) ?> <?= number_format($cap['vistas']) ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Alertas recientes -->
  <h2 style="font-size:16px;font-weight:700;margin:32px 0 4px">Alertas recientes</h2>
  <p style="font-size:13px;color:var(--muted);margin-bottom:16px">Amenazas activas y avisos de seguridad de los últimos 30 días</p>

  <div class="cap-alert cap-alert--warn">
    <div class="cap-alert-icon cap-alert-icon--warn"><?= getSvg('alert-triangle',18) ?></div>
    <div><strong style="font-size:13px;display:block;margin-bottom:2px">Campaña de smishing activa: falsos mensajes de Banco Estado</strong>
    <span style="font-size:13px;color:var(--muted)">Se han detectado SMS fraudulentos suplantando a Banco Estado pidiendo verificar cuentas. No hagas clic en ningún enlace. — <em>08 May 2025</em></span></div>
  </div>
  <div class="cap-alert cap-alert--warn">
    <div class="cap-alert-icon cap-alert-icon--warn"><?= getSvg('alert-triangle',18) ?></div>
    <div><strong style="font-size:13px;display:block;margin-bottom:2px">Phishing vía correo: supuestas facturas del SII</strong>
    <span style="font-size:13px;color:var(--muted)">Correos masivos simulando notificaciones del SII con archivos adjuntos con malware. — <em>03 May 2025</em></span></div>
  </div>
  <div class="cap-alert cap-alert--info" style="margin-top:8px">
    <div class="cap-alert-icon cap-alert-icon--info"><?= getSvg('info',18) ?></div>
    <div><strong style="font-size:13px;display:block;margin-bottom:2px">CSIRT Chile actualiza recomendaciones para contraseñas corporativas</strong>
    <span style="font-size:13px;color:var(--muted)">El organismo publicó nuevas guías para la gestión de credenciales en empresas. — <em>28 Abr 2025</em></span></div>
  </div>
  <div class="cap-alert cap-alert--ok" style="margin-top:8px;margin-bottom:8px">
    <div class="cap-alert-icon cap-alert-icon--ok"><?= getSvg('check-circle',18) ?></div>
    <div><strong style="font-size:13px;display:block;margin-bottom:2px">Tip: Activa el segundo factor de autenticación (2FA)</strong>
    <span style="font-size:13px;color:var(--muted)">Agregar una capa extra de seguridad reduce en un 99% el riesgo de acceso no autorizado. — <em>22 Abr 2025</em></span></div>
  </div>

  <!-- Quiz -->
  <div class="card" style="margin-top:24px;margin-bottom:32px;overflow:hidden">
    <div class="cap-quiz-header">
      <div class="cap-quiz-header-icon"><?= getSvg('help-circle',26) ?></div>
      <div>
        <div style="font-size:17px;font-weight:700;color:#fff;margin-bottom:2px">¿Qué tanto sabes de ciberseguridad?</div>
        <div style="font-size:13px;color:rgba(255,255,255,.6)"><?= count($quiz_preguntas) ?> preguntas · Aprende con cada respuesta</div>
      </div>
    </div>
    <div style="padding:28px 32px">
      <div class="cap-quiz-progress">
        <div class="cap-quiz-bar"><div class="cap-quiz-bar-fill" id="quizBar" style="width:0%"></div></div>
        <div style="font-size:13px;font-weight:600;color:var(--muted);white-space:nowrap" id="quizCounter">Pregunta 1 de <?= count($quiz_preguntas) ?></div>
      </div>

      <?php foreach($quiz_preguntas as $i => $q): ?>
      <div class="cap-quiz-q <?= $i===0?'active':'' ?>" id="quizQ<?= $i ?>">
        <p style="font-size:16px;font-weight:600;margin-bottom:16px;line-height:1.4"><?= $i+1 ?>. <?= htmlspecialchars($q['pregunta']) ?></p>
        <div style="display:flex;flex-direction:column;gap:8px">
          <?php foreach(['a','b','c','d'] as $letra): ?>
          <div class="cap-quiz-opt" id="q<?= $i ?>opt<?= $letra ?>" onclick="answerQuiz(<?= $i ?>,'<?= $letra ?>','<?= $q['correcta'] ?>')">
            <div class="cap-quiz-opt__letter"><?= $letra ?></div>
            <span style="font-size:14px"><?= htmlspecialchars($q['opciones'][$letra]) ?></span>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="cap-quiz-feedback" id="quizFb<?= $i ?>"></div>
      </div>
      <?php endforeach; ?>

      <div class="cap-quiz-result" id="quizResult">
        <div style="font-size:52px;font-weight:800;color:var(--blue);line-height:1;margin-bottom:8px" id="quizScore">0/<?= count($quiz_preguntas) ?></div>
        <div style="font-size:18px;font-weight:600;margin-bottom:6px" id="quizLabel">¡Buen trabajo!</div>
        <div style="font-size:13px;color:var(--muted);margin-bottom:20px" id="quizMsg">Sigue aprendiendo.</div>
        <button class="btn btn-primary" onclick="restartQuiz()"><?= getSvg('refresh-cw',14) ?> Intentar de nuevo</button>
      </div>

      <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px" id="quizNav">
        <button class="btn btn-outline" id="quizPrev" onclick="quizMove(-1)" style="display:none"><?= getSvg('chevron-left',14) ?> Anterior</button>
        <button class="btn btn-primary" id="quizNext" onclick="quizMove(1)" style="display:none">Siguiente <?= getSvg('chevron-right',14) ?></button>
        <button class="btn btn-primary" id="quizFinish" onclick="showQuizResult()" style="display:none">Ver resultado <?= getSvg('check',14) ?></button>
      </div>
    </div>
  </div>

</div><!-- /content -->
</div><!-- /main -->
</div><!-- /app -->

<style>
.cap-filter-bar{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:20px}
.cap-filter-btn{padding:6px 14px;border:1.5px solid var(--border);border-radius:20px;background:var(--card);font-size:13px;font-weight:500;color:var(--muted);cursor:pointer;transition:all var(--transition)}
.cap-filter-btn:hover{border-color:var(--blue);color:var(--blue)}
.cap-filter-btn.active{background:var(--blue);border-color:var(--blue);color:#fff}

.cap-featured{display:grid;grid-template-columns:200px 1fr}
.cap-featured__visual{background:linear-gradient(135deg,#0d1117,#1a2844);display:flex;align-items:center;justify-content:center;min-height:180px;border-radius:var(--radius) 0 0 var(--radius)}
.cap-featured__icon-wrap{width:72px;height:72px;border:2px solid rgba(255,255,255,.15);border-radius:20px;display:grid;place-items:center;background:rgba(255,255,255,.08)}
.cap-featured__body{padding:28px}
@media(max-width:640px){.cap-featured{grid-template-columns:1fr}.cap-featured__visual{min-height:120px;border-radius:var(--radius) var(--radius) 0 0}}

.cap-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;margin-bottom:8px}
.cap-card{display:flex;flex-direction:column}
.cap-card__header{padding:16px 16px 0;display:flex;align-items:flex-start;gap:12px}
.cap-card__icon{width:40px;height:40px;border-radius:10px;display:grid;place-items:center;flex-shrink:0}
.cap-card__body{padding:12px 16px 0;flex:1}
.cap-card__body h3{font-size:15px;font-weight:700;line-height:1.3;margin-bottom:6px}
.cap-card__body p{font-size:13px;color:var(--muted);line-height:1.5}
.cap-card__footer{padding:14px 16px 16px;display:flex;align-items:center;justify-content:space-between;border-top:1px solid var(--border);margin-top:14px;gap:8px;flex-wrap:wrap}
.cap-card[style*="display:none"]{display:none!important}

.cap-btn-sm{display:inline-flex;align-items:center;gap:4px;padding:5px 10px;border-radius:6px;font-size:12px;font-weight:600;border:none;cursor:pointer;text-decoration:none;transition:all var(--transition)}
.cap-btn-sm--link{background:var(--blue-light);color:var(--blue)}
.cap-btn-sm--link:hover{background:var(--blue-mid)}
.cap-btn-sm--dl{background:#eafaf1;color:#1da462}
.cap-btn-sm--dl:hover{background:#d4f3e4}

.cap-nivel{display:inline-block;padding:2px 7px;border-radius:4px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.05em}
.cap-nivel--básico{background:#dff4e8;color:#1a7a40}
.cap-nivel--intermedio{background:#fff3cd;color:#8a6200}
.cap-nivel--avanzado{background:#fce4e1;color:#a3200f}

.cap-alert{display:flex;align-items:flex-start;gap:12px;background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;margin-bottom:8px}
.cap-alert--warn{border-left:4px solid var(--danger)}
.cap-alert--info{border-left:4px solid var(--blue)}
.cap-alert--ok{border-left:4px solid var(--green)}
.cap-alert-icon{width:32px;height:32px;border-radius:8px;display:grid;place-items:center;flex-shrink:0}
.cap-alert-icon--warn{background:var(--danger-light);color:var(--danger)}
.cap-alert-icon--info{background:var(--blue-light);color:var(--blue)}
.cap-alert-icon--ok{background:var(--green-light);color:var(--green)}

.cap-quiz-header{background:linear-gradient(135deg,#0d1117,#1a2844);padding:24px 32px;display:flex;align-items:center;gap:16px}
.cap-quiz-header-icon{width:48px;height:48px;background:rgba(0,91,150,.4);border:1.5px solid rgba(0,91,150,.6);border-radius:12px;display:grid;place-items:center;flex-shrink:0;color:#7fb3ff}
.cap-quiz-progress{display:flex;align-items:center;gap:12px;margin-bottom:24px}
.cap-quiz-bar{flex:1;height:5px;background:var(--bg);border-radius:3px;overflow:hidden}
.cap-quiz-bar-fill{height:100%;background:var(--blue);border-radius:3px;transition:width .4s ease}
.cap-quiz-q{display:none}
.cap-quiz-q.active{display:block}
.cap-quiz-opt{display:flex;align-items:center;gap:12px;padding:12px 14px;border:1.5px solid var(--border);border-radius:var(--radius);cursor:pointer;transition:all var(--transition);background:var(--card);margin-bottom:8px}
.cap-quiz-opt:hover:not(.answered){border-color:var(--blue);background:var(--blue-light)}
.cap-quiz-opt__letter{width:26px;height:26px;border-radius:50%;background:var(--bg);border:1.5px solid var(--border);display:grid;place-items:center;font-size:11px;font-weight:700;text-transform:uppercase;flex-shrink:0;transition:all var(--transition)}
.cap-quiz-opt.correct{border-color:var(--green);background:var(--green-light)}
.cap-quiz-opt.correct .cap-quiz-opt__letter{background:var(--green);border-color:var(--green);color:#fff}
.cap-quiz-opt.wrong{border-color:var(--danger);background:var(--danger-light)}
.cap-quiz-opt.wrong .cap-quiz-opt__letter{background:var(--danger);border-color:var(--danger);color:#fff}
.cap-quiz-feedback{margin-top:12px;padding:12px 14px;border-radius:var(--radius);font-size:13px;line-height:1.5;display:none}
.cap-quiz-feedback.show{display:block}
.cap-quiz-feedback--ok{background:var(--green-light);border-left:4px solid var(--green);color:#1a5c38}
.cap-quiz-feedback--bad{background:var(--danger-light);border-left:4px solid var(--danger);color:#7a1e0d}
.cap-quiz-result{display:none;text-align:center;padding:16px 0}
.cap-quiz-result.show{display:block}
</style>

<?php include 'componentes/scripts.php'; ?>
<script>
function filterCaps(btn, cat) {
  document.querySelectorAll('.cap-filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('#capsulaGrid .cap-card').forEach(card => {
    card.style.display = (cat === 'all' || card.dataset.cat === cat) ? '' : 'none';
  });
}

const TOTAL = <?= count($quiz_preguntas) ?>;
const EXPLICACIONES = <?= json_encode(array_column($quiz_preguntas, 'explicacion')) ?>;
let current = 0;
let answered = new Array(TOTAL).fill(false);
let scores   = new Array(TOTAL).fill(null);

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
  fb.classList.add('show', isOk ? 'cap-quiz-feedback--ok' : 'cap-quiz-feedback--bad');
  fb.innerHTML = `<strong>${isOk ? '✓ Correcto.' : '✗ Incorrecto.'}</strong> ${EXPLICACIONES[qi]}`;
  updateNav();
}

function updateNav() {
  const isLast = current === TOTAL - 1;
  document.getElementById('quizNext').style.display   = (!isLast && answered[current]) ? '' : 'none';
  document.getElementById('quizFinish').style.display = (isLast && answered[current]) ? '' : 'none';
  document.getElementById('quizPrev').style.display   = current > 0 ? '' : 'none';
}

function quizMove(dir) {
  const target = current + dir;
  if (target < 0 || target >= TOTAL) return;
  document.getElementById(`quizQ${current}`).classList.remove('active');
  current = target;
  document.getElementById(`quizQ${current}`).classList.add('active');
  document.getElementById('quizBar').style.width = (current / TOTAL * 100) + '%';
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
  if (pct === 1)       { label = '🏆 ¡Perfecto!'; msg = 'Excelente dominio del tema.'; }
  else if (pct >= 0.6) { label = '👍 ¡Bien hecho!'; msg = 'Buen nivel. Revisa las preguntas que fallaste.'; }
  else                 { label = '📚 Sigue aprendiendo'; msg = 'Te recomendamos leer nuestras cápsulas para mejorar.'; }
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
    q.style.display = '';
    q.classList.toggle('active', i === 0);
    ['a','b','c','d'].forEach(l => {
      const el = document.getElementById(`q${i}opt${l}`);
      el.classList.remove('answered','correct','wrong');
    });
    const fb = document.getElementById(`quizFb${i}`);
    fb.classList.remove('show','cap-quiz-feedback--ok','cap-quiz-feedback--bad');
    fb.innerHTML = '';
  }
  updateNav();
}
</script>
</body>
</html>
