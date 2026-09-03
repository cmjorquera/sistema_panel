<?php
require_once 'class/Sesion.php';
require_once 'class/Conexion.php';
Sesion::requerir();

$titulo_pagina     = 'Contactos';
$breadcrumb_actual = 'Contactos';
$pagina_actual     = 'contactos';

// ── Datos desde BD con fallback demo ───────────────────────────────
$contactos = [];
try {
    $db = Conexion::obtener();
    $stmt = $db->prepare("
        SELECT u.id, u.nombre, u.apellido_paterno, u.email, u.cargo, u.telefono, u.anexo,
               c.nombre AS colegio_nombre
        FROM usuarios u
        LEFT JOIN colegios c ON u.id_area_trabajo = c.id
        WHERE u.estado = 1
        ORDER BY u.nombre ASC
    ");
    if ($stmt) {
        $stmt->execute();
        $r = $stmt->get_result();
        while ($r && $row = $r->fetch_assoc()) $contactos[] = $row;
        $stmt->close();
    }
} catch (Exception $e) {}

if (empty($contactos)) {
    $contactos = [
        ['id'=>1,'nombre'=>'Cristian','apellido_paterno'=>'Jorquera','email'=>'cjorquera@seduc.cl','cargo'=>'Coordinador TIC','telefono'=>'+56 9 1234 5678','anexo'=>'101','colegio_nombre'=>'SEDUC Central'],
        ['id'=>2,'nombre'=>'Ana María','apellido_paterno'=>'Rodríguez','email'=>'arodriguez@seduc.cl','cargo'=>'Jefa de UTP','telefono'=>'+56 9 8765 4321','anexo'=>'102','colegio_nombre'=>'SEDUC Central'],
        ['id'=>3,'nombre'=>'Carlos','apellido_paterno'=>'Pérez','email'=>'cperez@seduc.cl','cargo'=>'Director Académico','telefono'=>'+56 9 2345 6789','anexo'=>'103','colegio_nombre'=>'Liceo Bicentenario'],
        ['id'=>4,'nombre'=>'Valentina','apellido_paterno'=>'Soto','email'=>'vsoto@seduc.cl','cargo'=>'Directora','telefono'=>'+56 9 3456 7890','anexo'=>'201','colegio_nombre'=>'Colegio Los Pinos'],
        ['id'=>5,'nombre'=>'Jorge','apellido_paterno'=>'Fuentes','email'=>'jfuentes@seduc.cl','cargo'=>'Administrativo','telefono'=>'+56 9 4567 8901','anexo'=>'202','colegio_nombre'=>'Colegio Los Pinos'],
        ['id'=>6,'nombre'=>'Daniela','apellido_paterno'=>'Castillo','email'=>'dcastillo@seduc.cl','cargo'=>'Paradocente','telefono'=>'+56 9 5678 9012','anexo'=>'','colegio_nombre'=>'Escuela Primavera'],
        ['id'=>7,'nombre'=>'Roberto','apellido_paterno'=>'Vidal','email'=>'rvidal@seduc.cl','cargo'=>'Auxiliar','telefono'=>'+56 9 6789 0123','anexo'=>'','colegio_nombre'=>'Escuela Primavera'],
        ['id'=>8,'nombre'=>'María José','apellido_paterno'=>'López','email'=>'mlopez@seduc.cl','cargo'=>'Coordinadora Convivencia','telefono'=>'+56 9 7890 1234','anexo'=>'104','colegio_nombre'=>'SEDUC Central'],
    ];
}

// Agrupar por colegio/unidad
$grupos = [];
foreach ($contactos as $c) {
    $g = $c['colegio_nombre'] ?? 'Sin unidad';
    $grupos[$g][] = $c;
}
ksort($grupos);

$avatar_colors = ['#005B96','#7e3af2','#3C8D2F','#F4B000','#C0392B','#2563eb','#0e9f6e','#d97706'];

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
      <h1>Directorio de Contactos</h1>
      <p><?= count($contactos) ?> funcionarios registrados en el sistema.</p>
    </div>
  </div>

  <!-- Buscador + vista -->
  <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;flex-wrap:wrap">
    <div class="input-icon-wrap" style="flex:1;max-width:360px">
      <svg class="icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      <input type="text" class="input" id="buscarContacto" placeholder="Buscar por nombre, cargo o email..." oninput="filtrarContactos(this.value)"/>
    </div>
    <div style="display:flex;gap:6px">
      <button class="btn btn-outline" id="btnVistaTarjetas" onclick="setVista('tarjetas')" title="Vista tarjetas">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
      </button>
      <button class="btn btn-outline" id="btnVistaLista" onclick="setVista('lista')" title="Vista lista">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
      </button>
    </div>
  </div>

  <!-- Vista tarjetas (por grupo) -->
  <div id="vista-tarjetas">
    <?php foreach ($grupos as $grupoNombre => $items): ?>
    <div class="cnt-group" data-group="<?= htmlspecialchars(mb_strtolower($grupoNombre,'UTF-8')) ?>">
      <div class="cnt-group-label"><?= htmlspecialchars($grupoNombre) ?> <span class="badge"><?= count($items) ?></span></div>
      <div class="cnt-grid">
        <?php foreach ($items as $idx => $c):
          $nombre = htmlspecialchars($c['nombre'].' '.$c['apellido_paterno']);
          $email  = htmlspecialchars($c['email'] ?? '');
          $cargo  = htmlspecialchars($c['cargo'] ?? '');
          $tel    = htmlspecialchars($c['telefono'] ?? '');
          $anx    = htmlspecialchars($c['anexo'] ?? '');
          $initials = strtoupper(mb_substr($c['nombre'],0,1,'UTF-8').mb_substr($c['apellido_paterno'],0,1,'UTF-8'));
          $color = $avatar_colors[$idx % count($avatar_colors)];
        ?>
        <div class="cnt-card card" data-nombre="<?= mb_strtolower($c['nombre'].' '.$c['apellido_paterno'].' '.$cargo.' '.$email, 'UTF-8') ?>">
          <div class="cnt-avatar" style="background:<?= $color ?>"><?= $initials ?></div>
          <div class="cnt-card__body">
            <div class="cnt-card__name"><?= $nombre ?></div>
            <div class="cnt-card__cargo"><?= $cargo ?></div>
          </div>
          <div class="cnt-card__info">
            <?php if ($email): ?>
            <a href="mailto:<?= $email ?>" class="cnt-info-row" title="Enviar correo">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              <?= $email ?>
            </a>
            <?php endif; ?>
            <?php if ($tel): ?>
            <div class="cnt-info-row">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 14.9a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 4h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 11.5a16 16 0 0 0 6 6l.94-.94a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.5 18.92z"/></svg>
              <?= $tel ?><?= $anx ? ' (anexo '.$anx.')' : '' ?>
            </div>
            <?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Vista lista (tabla) -->
  <div id="vista-lista" style="display:none">
    <div class="card" style="overflow:hidden">
      <div style="overflow-x:auto">
        <table class="table">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Cargo</th>
              <th>Unidad / Colegio</th>
              <th>Email</th>
              <th>Teléfono</th>
            </tr>
          </thead>
          <tbody id="tablaContactosBody">
            <?php foreach ($contactos as $idx => $c):
              $nombre = htmlspecialchars($c['nombre'].' '.$c['apellido_paterno']);
              $initials = strtoupper(mb_substr($c['nombre'],0,1,'UTF-8').mb_substr($c['apellido_paterno'],0,1,'UTF-8'));
              $color = $avatar_colors[$idx % count($avatar_colors)];
            ?>
            <tr class="cnt-table-row" data-nombre="<?= mb_strtolower($c['nombre'].' '.$c['apellido_paterno'].' '.($c['cargo']??'').' '.($c['email']??''), 'UTF-8') ?>">
              <td>
                <div style="display:flex;align-items:center;gap:10px">
                  <div style="width:30px;height:30px;border-radius:50%;background:<?= $color ?>;display:grid;place-items:center;color:#fff;font-size:11px;font-weight:700;flex-shrink:0"><?= $initials ?></div>
                  <span style="font-weight:600;font-size:13px"><?= $nombre ?></span>
                </div>
              </td>
              <td style="font-size:13px;color:var(--muted)"><?= htmlspecialchars($c['cargo'] ?? '') ?></td>
              <td style="font-size:13px;color:var(--muted)"><?= htmlspecialchars($c['colegio_nombre'] ?? '') ?></td>
              <td>
                <?php if(!empty($c['email'])): ?>
                <a href="mailto:<?= htmlspecialchars($c['email']) ?>" style="font-size:13px;color:var(--blue)"><?= htmlspecialchars($c['email']) ?></a>
                <?php endif; ?>
              </td>
              <td style="font-size:13px;color:var(--muted)"><?= htmlspecialchars($c['telefono'] ?? '') ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Estado vacío -->
  <div id="cnt-empty" style="display:none;text-align:center;padding:48px 24px">
    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--border)" stroke-width="1.5" style="margin:0 auto 12px;display:block"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
    <p style="font-size:14px;color:var(--muted)">No se encontraron contactos</p>
  </div>

</div><!-- /content -->
</div><!-- /main -->
</div><!-- /app -->

<style>
.cnt-group{margin-bottom:28px}
.cnt-group-label{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--muted);margin-bottom:12px;display:flex;align-items:center;gap:8px}
.cnt-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:12px}
.cnt-card{display:flex;flex-direction:column;gap:0;overflow:hidden;transition:box-shadow var(--transition),border-color var(--transition)}
.cnt-card:hover{box-shadow:var(--shadow-elevated);border-color:var(--blue)}
.cnt-avatar{width:100%;height:60px;display:grid;place-items:center;font-size:22px;font-weight:700;color:#fff;flex-shrink:0;letter-spacing:.5px}
.cnt-card__body{padding:12px 16px 8px}
.cnt-card__name{font-size:14px;font-weight:700;color:var(--fg);margin-bottom:3px}
.cnt-card__cargo{font-size:12px;color:var(--muted)}
.cnt-card__info{padding:8px 16px 14px;border-top:1px solid var(--border);display:flex;flex-direction:column;gap:5px;margin-top:2px}
.cnt-info-row{display:flex;align-items:center;gap:6px;font-size:12px;color:var(--muted);text-decoration:none;transition:color var(--transition)}
.cnt-info-row:hover{color:var(--blue)}
a.cnt-info-row{color:var(--blue)}
a.cnt-info-row:hover{color:var(--fg)}
.cnt-card[style*="display:none"]{display:none!important}
.cnt-group.hidden{display:none}
</style>

<?php include 'componentes/scripts.php'; ?>
<script>
let vistaActual = 'tarjetas';

function setVista(v) {
  vistaActual = v;
  document.getElementById('vista-tarjetas').style.display = v === 'tarjetas' ? '' : 'none';
  document.getElementById('vista-lista').style.display    = v === 'lista' ? '' : 'none';
  document.getElementById('btnVistaTarjetas').classList.toggle('btn-primary', v === 'tarjetas');
  document.getElementById('btnVistaTarjetas').classList.toggle('btn-outline', v !== 'tarjetas');
  document.getElementById('btnVistaLista').classList.toggle('btn-primary', v === 'lista');
  document.getElementById('btnVistaLista').classList.toggle('btn-outline', v !== 'lista');
}

function filtrarContactos(q) {
  q = q.toLowerCase().trim();
  let total = 0;

  // Tarjetas
  document.querySelectorAll('.cnt-card').forEach(card => {
    const match = !q || (card.dataset.nombre || '').includes(q);
    card.style.display = match ? '' : 'none';
    if (match) total++;
  });
  document.querySelectorAll('.cnt-group').forEach(g => {
    const visible = [...g.querySelectorAll('.cnt-card')].some(c => c.style.display !== 'none');
    g.classList.toggle('hidden', !visible);
  });

  // Lista
  document.querySelectorAll('.cnt-table-row').forEach(row => {
    const match = !q || (row.dataset.nombre || '').includes(q);
    row.style.display = match ? '' : 'none';
  });

  document.getElementById('cnt-empty').style.display = (q && total === 0) ? 'block' : 'none';
}
</script>
</body>
</html>
