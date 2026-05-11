<?php
/* ============================================================
   AJAX handler — debe ejecutarse antes de cualquier HTML
   ============================================================ */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');

    require_once __DIR__ . '/class/conexion.php';
    $db  = new Conexion();
    $conn = $db->getConexion();

    $accion = trim($_POST['accion'] ?? '');

    /* ---- ELIMINAR ---- */
    if ($accion === 'eliminar') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) { echo json_encode(['ok' => false, 'msg' => 'ID invalido']); exit; }
        $stmt = $conn->prepare("DELETE FROM convenios WHERE id_convenio = ?");
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $stmt->close();
        $db->cerrar();
        echo json_encode(['ok' => $ok, 'msg' => $ok ? 'Eliminado' : $conn->error]);
        exit;
    }

    /* ---- CREAR / EDITAR ---- */
    if ($accion === 'crear' || $accion === 'editar') {
        $idConvenio  = (int)($_POST['id'] ?? 0);
        $idTipo      = (int)($_POST['id_tipo'] ?? 0);
        $empresa     = trim($_POST['empresa'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $descuento   = trim($_POST['descuento'] ?? '');
        $url         = trim($_POST['url'] ?? '');
        $fechaInicio = trim($_POST['fecha_inicio'] ?? '') ?: null;
        $fechaTermino= trim($_POST['fecha_termino'] ?? '') ?: null;
        $activo      = isset($_POST['activo']) ? 1 : 0;
        $destacado   = isset($_POST['destacado']) ? 1 : 0;

        if ($empresa === '') {
            echo json_encode(['ok' => false, 'msg' => 'El campo empresa es obligatorio']);
            exit;
        }

        // Subida de imagen
        $imagen = trim($_POST['imagen_actual'] ?? '');
        if (!empty($_FILES['imagen']['name'])) {
            $tmpName = $_FILES['imagen']['tmp_name'];
            $ext     = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
            $extsOk  = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $mimesOk = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $mime    = mime_content_type($tmpName);
            if (in_array($ext, $extsOk, true) && in_array($mime, $mimesOk, true) && is_uploaded_file($tmpName)) {
                $slug     = preg_replace('/[^a-z0-9]/i', '_', $empresa);
                $filename = strtolower($slug) . '_' . time() . '.' . $ext;
                $destDir  = __DIR__ . '/imagenes/';
                if (move_uploaded_file($tmpName, $destDir . $filename)) {
                    $imagen = $filename;
                }
            }
        }

        if ($accion === 'crear') {
            $stmt = $conn->prepare("
                INSERT INTO convenios (id_tipo, empresa, descripcion, descuento, imagen, url, fecha_inicio, fecha_termino, activo, destacado)
                VALUES (?,?,?,?,?,?,?,?,?,?)
            ");
            $stmt->bind_param('isssssssii', $idTipo, $empresa, $descripcion, $descuento, $imagen, $url, $fechaInicio, $fechaTermino, $activo, $destacado);
            $ok = $stmt->execute();
            $newId = $conn->insert_id;
            $stmt->close();
            $db->cerrar();
            echo json_encode(['ok' => $ok, 'msg' => $ok ? 'Creado' : $conn->error, 'id' => $newId, 'imagen' => $imagen]);
        } else {
            if ($idConvenio <= 0) { echo json_encode(['ok' => false, 'msg' => 'ID invalido']); exit; }
            $stmt = $conn->prepare("
                UPDATE convenios SET id_tipo=?, empresa=?, descripcion=?, descuento=?, imagen=?, url=?, fecha_inicio=?, fecha_termino=?, activo=?, destacado=?
                WHERE id_convenio=?
            ");
            $stmt->bind_param('isssssssiii', $idTipo, $empresa, $descripcion, $descuento, $imagen, $url, $fechaInicio, $fechaTermino, $activo, $destacado, $idConvenio);
            $ok = $stmt->execute();
            $stmt->close();
            $db->cerrar();
            echo json_encode(['ok' => $ok, 'msg' => $ok ? 'Actualizado' : $conn->error, 'imagen' => $imagen]);
        }
        exit;
    }

    echo json_encode(['ok' => false, 'msg' => 'Accion desconocida']);
    exit;
}

/* ============================================================
   Carga normal de la página
   ============================================================ */
require_once __DIR__ . '/class/conexion.php';
require_once __DIR__ . '/componentes/rail_acciones.php';
require_once __DIR__ . '/componentes/panel_contactos.php';
require_once __DIR__ . '/componentes/keep_widget.php';

$menuCabeceraCandidates = [
    __DIR__ . '/componentes/menu_cabecera.php',
    dirname(__DIR__) . '/componentes/menu_cabecera.php',
];
$menuCabeceraPath = null;
foreach ($menuCabeceraCandidates as $candidate) {
    if (is_file($candidate)) { $menuCabeceraPath = $candidate; break; }
}
if ($menuCabeceraPath === null) {
    throw new RuntimeException('No se encontro menu_cabecera.php en rutas esperadas.');
}
require_once $menuCabeceraPath;

$db   = new Conexion();
$conn = $db->getConexion();
$menusCabecera = menus_cabezera($conn);
$paginaActual  = basename($_SERVER['PHP_SELF'] ?? 'admin_convenios.php');

$tipos = [];
$resT  = $conn->query("SELECT id_tipo, nombre FROM tipo_convenio ORDER BY orden ASC");
if ($resT) { while ($t = $resT->fetch_assoc()) $tipos[] = $t; $resT->free(); }

$convenios = [];
$resC = $conn->query("
    SELECT c.*, t.nombre AS tipo_nombre
    FROM convenios c
    LEFT JOIN tipo_convenio t ON c.id_tipo = t.id_tipo
    ORDER BY c.id_convenio DESC
");
if ($resC) { while ($row = $resC->fetch_assoc()) $convenios[] = $row; $resC->free(); }

$db->cerrar();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Seduc Hub | Admin Convenios</title>
  <style>
    :root{
      --primary:#2f57b7; --primary-700:#23449a;
      --green:#3B6D11; --gold:#c8a84b;
      --bg:#f6f8fe; --text:#0f172a; --muted:#64748b; --border:#e5eaf6;
      --shadow:0 10px 30px rgba(15,23,42,.10);
      --shadow-soft:0 8px 20px rgba(15,23,42,.08);
      --container:1280px;
    }
    *{box-sizing:border-box}
    body{margin:0;font-family:ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Arial;color:var(--text);background:var(--bg)}
    a{color:inherit;text-decoration:none}
    .container{width:min(var(--container),calc(100% - 36px));margin-inline:auto}

    /* TOPBAR */
    .topbar{position:sticky;top:0;z-index:80;background:rgba(255,255,255,.92);backdrop-filter:blur(10px);border-bottom:1px solid var(--border)}
    .topbar__inner{display:flex;align-items:center;justify-content:space-between;gap:14px;padding:14px 0}
    .brand{display:flex;align-items:center;gap:12px}
    .brand__logo{width:42px;height:42px;border-radius:14px;background:linear-gradient(135deg,var(--primary),var(--primary-700));color:#fff;display:grid;place-items:center;font-weight:900;font-size:14px}
    .brand__name{font-weight:900;line-height:1}
    .brand__tag{font-size:12px;color:var(--muted);margin-top:2px}
    .topbar__nav{display:flex;align-items:center;gap:18px}
    .navlink{font-weight:700;color:var(--muted);padding:10px 12px;border-radius:12px}
    .navlink:hover{background:#eef2ff;color:var(--text)}
    .navlink.is-active{background:#eef2ff;color:var(--primary)}
    .usermenu{position:relative}
    .userbtn{display:flex;align-items:center;gap:10px;padding:8px 10px;border-radius:18px;border:1px solid var(--border);background:rgba(255,255,255,.82);backdrop-filter:blur(10px);cursor:pointer;box-shadow:var(--shadow-soft);transition:.15s ease}
    .userbtn:hover{background:#fff}
    .userbtn__avatar{width:36px;height:36px;border-radius:14px;display:grid;place-items:center;background:#eef2ff;color:var(--primary);font-weight:900}
    .userbtn__text{display:flex;flex-direction:column;line-height:1.05;text-align:left}
    .userbtn__name{font-weight:900;font-size:13px}
    .userbtn__role{font-weight:800;font-size:12px;color:var(--muted);margin-top:2px}
    .userbtn__chev{margin-left:6px;color:var(--muted);font-weight:900}
    .dropdown{position:absolute;right:0;top:calc(100% + 10px);width:220px;border-radius:16px;border:1px solid var(--border);background:rgba(255,255,255,.96);backdrop-filter:blur(10px);box-shadow:var(--shadow);padding:8px;display:none;z-index:120}
    .usermenu:hover .dropdown{display:block}
    .dropdown__item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:12px;font-weight:800;color:var(--text)}
    .dropdown__item:hover{background:#eef2ff;color:var(--primary)}
    .dropdown__sep{height:1px;background:var(--border);margin:8px 6px}
    .dropdown__item--danger{color:#b91c1c}
    .dropdown__item--danger:hover{background:#fff1f2;color:#b91c1c}

    /* PAGE HEADER */
    .page-header{
      display:flex;align-items:center;justify-content:space-between;gap:16px;
      padding:28px 0 20px;
    }
    .page-header__title{margin:0;font-size:22px;font-weight:900}
    .page-header__sub{margin:4px 0 0;color:var(--muted);font-size:14px;font-weight:700}

    /* BOTONES */
    .btn{border:1px solid transparent;border-radius:12px;padding:10px 16px;font-weight:800;cursor:pointer;transition:.15s ease;font-size:13px}
    .btn:active{transform:translateY(1px)}
    .btn--primary{background:var(--green);color:#fff;border-color:var(--green)}
    .btn--primary:hover{background:var(--green-light, #4a8a16)}
    .btn--ghost{background:transparent;border-color:var(--border);color:var(--text)}
    .btn--ghost:hover{background:#fff}
    .btn--danger{background:#fef2f2;border-color:#fecaca;color:#b91c1c}
    .btn--danger:hover{background:#fee2e2}
    .btn--sm{padding:6px 10px;font-size:12px;border-radius:8px}

    /* TABLA */
    .table-wrap{
      background:#fff;border-radius:18px;border:1px solid var(--border);
      box-shadow:var(--shadow-soft);overflow:hidden;margin-bottom:40px;
    }
    table{width:100%;border-collapse:collapse;font-size:13px}
    thead{background:#f8fafc}
    th{padding:13px 14px;text-align:left;font-weight:900;color:var(--muted);font-size:12px;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid var(--border)}
    td{padding:12px 14px;border-bottom:1px solid var(--border);vertical-align:middle}
    tr:last-child td{border-bottom:none}
    tr:hover td{background:#f8fafc}
    .badge{display:inline-block;padding:3px 8px;border-radius:999px;font-size:11px;font-weight:800}
    .badge--green{background:#dcfce7;color:#166534}
    .badge--gray{background:#f1f5f9;color:#64748b}
    .badge--gold{background:#fef9c3;color:#854d0e}
    .td-actions{display:flex;gap:6px;align-items:center}

    /* MODAL BACKDROP */
    .modal-bd{
      position:fixed;inset:0;background:rgba(15,23,42,.44);
      z-index:145;opacity:0;pointer-events:none;transition:opacity .18s ease;
    }
    .modal-bd.is-open{opacity:1;pointer-events:auto}

    /* MODAL */
    .modal{
      position:fixed;inset:0;display:grid;place-items:center;
      padding:20px;z-index:150;
      opacity:0;pointer-events:none;transition:opacity .18s ease;
    }
    .modal.is-open{opacity:1;pointer-events:auto}
    .modal__dialog{
      width:min(680px,100%);max-height:90vh;overflow-y:auto;
      border-radius:24px;
      background:linear-gradient(180deg,rgba(255,255,255,.99),rgba(248,250,252,.99));
      border:1px solid rgba(226,232,240,.95);
      box-shadow:0 30px 70px rgba(15,23,42,.30);
    }
    .modal__header{
      display:flex;align-items:flex-start;justify-content:space-between;gap:16px;
      padding:24px 24px 18px;border-bottom:1px solid var(--border);
      position:sticky;top:0;background:#fff;z-index:2;border-radius:24px 24px 0 0;
    }
    .modal__title{margin:0;font-size:20px;font-weight:900}
    .modal__sub{margin:4px 0 0;color:var(--muted);font-size:13px;font-weight:700}
    .modal__close{width:38px;height:38px;border:none;border-radius:999px;background:#e2e8f0;color:#475569;cursor:pointer;font-size:22px;display:grid;place-items:center}
    .modal__body{padding:22px 24px;display:grid;gap:14px}
    .modal__grid{display:grid;grid-template-columns:repeat(2,1fr);gap:14px}
    .modal__footer{
      display:flex;justify-content:flex-end;gap:10px;
      padding:0 24px 24px;position:sticky;bottom:0;
      background:linear-gradient(180deg,transparent,rgba(248,250,252,.98) 30%);
      border-radius:0 0 24px 24px;
    }

    /* CAMPOS */
    .field{display:grid;gap:6px}
    .field--full{grid-column:1/-1}
    .field label{font-size:13px;font-weight:900;color:var(--text)}
    .field input,.field textarea,.field select{
      width:100%;border:1px solid #d7dee8;border-radius:12px;
      padding:11px 13px;background:#fff;color:var(--text);
      font-size:14px;font-family:inherit;outline:none;
      transition:border-color .15s ease,box-shadow .15s ease;
    }
    .field input:focus,.field textarea:focus,.field select:focus{
      border-color:var(--green);box-shadow:0 0 0 4px rgba(59,109,17,.12);
    }
    .field textarea{min-height:80px;resize:vertical}
    .field--check{flex-direction:row;align-items:center;gap:10px}
    .field--check label{margin:0;font-weight:800}
    .field--check input[type=checkbox]{width:18px;height:18px;accent-color:var(--green)}
    .field-hint{margin:0;font-size:11px;color:var(--muted);font-weight:700}
    .check-group{display:flex;gap:20px;align-items:center}

    /* STATUS */
    .modal__status{
      display:none;border-radius:12px;padding:11px 14px;font-weight:800;font-size:13px;
      margin:0 24px;
    }
    .modal__status.is-visible{display:block}
    .modal__status--error{background:#fef2f2;color:#b91c1c;border:1px solid #fecaca}
    .modal__status--success{background:#ecfdf5;color:#166534;border:1px solid #bbf7d0}

    /* IMAGEN PREVIEW */
    .img-preview{
      width:100%;height:110px;border-radius:12px;border:1px dashed #d7dee8;
      background:#f8fafc;display:grid;place-items:center;overflow:hidden;
    }
    .img-preview img{max-width:100%;max-height:100%;object-fit:contain}
    .img-preview span{color:var(--muted);font-size:13px;font-weight:700}

    @media(max-width:820px){
      .topbar__nav{display:none}
      .modal__grid{grid-template-columns:1fr}
    }
  </style>
  <?php renderRailAccionesStyles(); ?>
  <?php renderPanelContactosStyles(); ?>
  <?php renderKeepWidgetHead(); ?>
</head>
<body>

<header class="topbar">
  <div class="container topbar__inner">
    <div class="brand">
      <div class="brand__logo">SH</div>
      <div>
        <div class="brand__name">Seduc Hub</div>
        <div class="brand__tag">Portal Operativo</div>
      </div>
    </div>
    <nav class="topbar__nav">
      <?php if (empty($menusCabecera)): ?>
        <a class="navlink" href="index_1.php">Inicio</a>
        <a class="navlink" href="componentes/beneficios.php">Beneficios</a>
        <a class="navlink is-active" href="admin_convenios.php">Admin Convenios</a>
      <?php else: ?>
        <?php foreach ($menusCabecera as $menu): ?>
          <?php
            $hrefMenu  = htmlspecialchars($menu['href'], ENT_QUOTES, 'UTF-8');
            $textoMenu = htmlspecialchars($menu['menu'] !== '' ? $menu['menu'] : 'Menu', ENT_QUOTES, 'UTF-8');
            $claseActiva = basename($menu['href']) === $paginaActual ? ' is-active' : '';
          ?>
          <a class="navlink<?= $claseActiva ?>" href="<?= $hrefMenu ?>"><?= $textoMenu ?></a>
        <?php endforeach; ?>
      <?php endif; ?>
    </nav>
    <?php renderTopbarUserMenu(); ?>
  </div>
</header>

<main class="container">

  <div class="page-header">
    <div>
      <h1 class="page-header__title">Gestión de Convenios</h1>
      <p class="page-header__sub"><?= count($convenios) ?> convenio<?= count($convenios) !== 1 ? 's' : '' ?> registrados</p>
    </div>
    <button class="btn btn--primary" id="btnNuevo">+ Nuevo convenio</button>
  </div>

  <div class="table-wrap">
    <table id="tablaConvenios">
      <thead>
        <tr>
          <th>#</th>
          <th>Empresa</th>
          <th>Tipo</th>
          <th>Descuento</th>
          <th>Inicio</th>
          <th>Término</th>
          <th>Activo</th>
          <th>Dest.</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="tbody">
        <?php foreach ($convenios as $c): ?>
          <?php
            $id       = (int)($c['id_convenio'] ?? 0);
            $empresa  = htmlspecialchars($c['empresa'] ?? '', ENT_QUOTES, 'UTF-8');
            $tipoNom  = htmlspecialchars($c['tipo_nombre'] ?? '—', ENT_QUOTES, 'UTF-8');
            $descto   = htmlspecialchars($c['descuento'] ?? '', ENT_QUOTES, 'UTF-8');
            $fIni     = $c['fecha_inicio'] ?? '';
            $fTer     = $c['fecha_termino'] ?? '';
            $activo   = (int)($c['activo'] ?? 0);
            $destacado= (int)($c['destacado'] ?? 0);
          ?>
          <tr data-id="<?= $id ?>">
            <td><?= $id ?></td>
            <td><strong><?= $empresa ?></strong></td>
            <td><?= $tipoNom ?></td>
            <td><?= $descto ?: '—' ?></td>
            <td><?= $fIni ? date('d/m/Y', strtotime($fIni)) : '—' ?></td>
            <td><?= $fTer ? date('d/m/Y', strtotime($fTer)) : '—' ?></td>
            <td><span class="badge <?= $activo ? 'badge--green' : 'badge--gray' ?>"><?= $activo ? 'Sí' : 'No' ?></span></td>
            <td><span class="badge <?= $destacado ? 'badge--gold' : 'badge--gray' ?>"><?= $destacado ? '⭐' : '—' ?></span></td>
            <td>
              <div class="td-actions">
                <button class="btn btn--ghost btn--sm btn-edit"
                  data-id="<?= $id ?>"
                  data-empresa="<?= $empresa ?>"
                  data-id-tipo="<?= (int)($c['id_tipo'] ?? 0) ?>"
                  data-descripcion="<?= htmlspecialchars($c['descripcion'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                  data-descuento="<?= htmlspecialchars($c['descuento'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                  data-url="<?= htmlspecialchars($c['url'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                  data-fecha-inicio="<?= htmlspecialchars($c['fecha_inicio'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                  data-fecha-termino="<?= htmlspecialchars($c['fecha_termino'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                  data-activo="<?= $activo ?>"
                  data-destacado="<?= $destacado ?>"
                  data-imagen="<?= htmlspecialchars($c['imagen'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                >Editar</button>
                <button class="btn btn--danger btn--sm btn-delete" data-id="<?= $id ?>" data-empresa="<?= $empresa ?>">Eliminar</button>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($convenios)): ?>
          <tr><td colspan="9" style="text-align:center;color:var(--muted);padding:32px">No hay convenios aún. Crea el primero.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</main>

<!-- MODAL BACKDROP -->
<div class="modal-bd" id="modalBd"></div>

<!-- MODAL FORMULARIO -->
<div class="modal" id="modal">
  <div class="modal__dialog" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal__header">
      <div>
        <h2 class="modal__title" id="modalTitle">Nuevo convenio</h2>
        <p class="modal__sub" id="modalSub">Completa los datos del convenio</p>
      </div>
      <button class="modal__close" id="modalClose" aria-label="Cerrar">×</button>
    </div>

    <form id="formConvenio" enctype="multipart/form-data" novalidate>
      <input type="hidden" name="accion" id="fAccion" value="crear" />
      <input type="hidden" name="id" id="fId" value="" />
      <input type="hidden" name="imagen_actual" id="fImagenActual" value="" />

      <div class="modal__body">
        <div class="modal__grid">
          <div class="field field--full">
            <label for="fEmpresa">Empresa *</label>
            <input type="text" id="fEmpresa" name="empresa" maxlength="150" placeholder="Nombre de la empresa" required />
          </div>

          <div class="field">
            <label for="fTipo">Tipo de convenio</label>
            <select id="fTipo" name="id_tipo">
              <option value="0">— Sin categoría —</option>
              <?php foreach ($tipos as $t): ?>
                <option value="<?= (int)$t['id_tipo'] ?>"><?= htmlspecialchars($t['nombre'], ENT_QUOTES, 'UTF-8') ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="field">
            <label for="fDescuento">Descuento</label>
            <input type="text" id="fDescuento" name="descuento" maxlength="80" placeholder="Ej: 30% en compras" />
          </div>

          <div class="field field--full">
            <label for="fDescripcion">Descripción</label>
            <textarea id="fDescripcion" name="descripcion" placeholder="Describe el beneficio..."></textarea>
          </div>

          <div class="field field--full">
            <label for="fUrl">URL del beneficio</label>
            <input type="text" id="fUrl" name="url" maxlength="255" placeholder="https://..." />
          </div>

          <div class="field">
            <label for="fFechaInicio">Fecha inicio</label>
            <input type="date" id="fFechaInicio" name="fecha_inicio" />
          </div>

          <div class="field">
            <label for="fFechaTermino">Fecha término</label>
            <input type="date" id="fFechaTermino" name="fecha_termino" />
          </div>

          <div class="field field--full">
            <label for="fImagen">Imagen</label>
            <input type="file" id="fImagen" name="imagen" accept="image/*" />
            <p class="field-hint">JPG, PNG, WEBP o GIF. Se guarda en imagenes/</p>
            <div class="img-preview" id="imgPreview">
              <span>Vista previa</span>
            </div>
          </div>

          <div class="field field--full">
            <div class="check-group">
              <label class="field--check" style="display:flex;align-items:center;gap:8px">
                <input type="checkbox" id="fActivo" name="activo" value="1" checked />
                <span style="font-weight:800;font-size:13px">Activo (visible en la web)</span>
              </label>
              <label class="field--check" style="display:flex;align-items:center;gap:8px">
                <input type="checkbox" id="fDestacado" name="destacado" value="1" />
                <span style="font-weight:800;font-size:13px">⭐ Destacado (aparece en carrusel)</span>
              </label>
            </div>
          </div>
        </div>
      </div>

      <div class="modal__status" id="modalStatus"></div>

      <div class="modal__footer">
        <button type="button" class="btn btn--ghost" id="modalCancel">Cancelar</button>
        <button type="submit" class="btn btn--primary" id="modalSubmit">Guardar convenio</button>
      </div>
    </form>
  </div>
</div>

<?php renderRailAcciones(true); ?>
<?php renderPanelContactos(); ?>

<script>
const modalBd     = document.getElementById('modalBd');
const modal       = document.getElementById('modal');
const modalTitle  = document.getElementById('modalTitle');
const modalSub    = document.getElementById('modalSub');
const modalStatus = document.getElementById('modalStatus');
const form        = document.getElementById('formConvenio');
const btnNuevo    = document.getElementById('btnNuevo');

function abrirModal() { modalBd.classList.add('is-open'); modal.classList.add('is-open'); }
function cerrarModal() {
    modalBd.classList.remove('is-open'); modal.classList.remove('is-open');
    form.reset();
    document.getElementById('fId').value = '';
    document.getElementById('fImagenActual').value = '';
    document.getElementById('fAccion').value = 'crear';
    resetPreview();
    ocultarStatus();
}
function mostrarStatus(msg, tipo) {
    modalStatus.textContent = msg;
    modalStatus.className = 'modal__status is-visible modal__status--' + tipo;
}
function ocultarStatus() { modalStatus.className = 'modal__status'; }
function resetPreview() {
    document.getElementById('imgPreview').innerHTML = '<span>Vista previa</span>';
}

/* ---- ABRIR MODAL NUEVO ---- */
btnNuevo.addEventListener('click', () => {
    modalTitle.textContent = 'Nuevo convenio';
    modalSub.textContent   = 'Completa los datos del convenio';
    cerrarModal();
    abrirModal();
});

/* ---- CERRAR MODAL ---- */
document.getElementById('modalClose').addEventListener('click', cerrarModal);
document.getElementById('modalCancel').addEventListener('click', cerrarModal);
modalBd.addEventListener('click', cerrarModal);

/* ---- PREVIEW IMAGEN ---- */
document.getElementById('fImagen').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) { resetPreview(); return; }
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('imgPreview').innerHTML = `<img src="${e.target.result}" alt="preview" />`;
    };
    reader.readAsDataURL(file);
});

/* ---- EDITAR ---- */
document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-edit');
    if (!btn) return;
    const d = btn.dataset;
    modalTitle.textContent = 'Editar convenio';
    modalSub.textContent   = 'Modifica los datos del convenio';

    document.getElementById('fAccion').value       = 'editar';
    document.getElementById('fId').value           = d.id;
    document.getElementById('fEmpresa').value      = d.empresa;
    document.getElementById('fTipo').value         = d.idTipo;
    document.getElementById('fDescripcion').value  = d.descripcion;
    document.getElementById('fDescuento').value    = d.descuento;
    document.getElementById('fUrl').value          = d.url;
    document.getElementById('fFechaInicio').value  = d.fechaInicio;
    document.getElementById('fFechaTermino').value = d.fechaTermino;
    document.getElementById('fActivo').checked     = d.activo === '1';
    document.getElementById('fDestacado').checked  = d.destacado === '1';
    document.getElementById('fImagenActual').value = d.imagen;

    // Preview imagen actual
    const prev = document.getElementById('imgPreview');
    if (d.imagen) {
        prev.innerHTML = `<img src="imagenes/${encodeURIComponent(d.imagen)}" onerror="this.parentElement.innerHTML='<span>Sin imagen</span>'" />`;
    } else {
        resetPreview();
    }

    ocultarStatus();
    abrirModal();
});

/* ---- ELIMINAR ---- */
document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-delete');
    if (!btn) return;
    const id      = btn.dataset.id;
    const empresa = btn.dataset.empresa;
    if (!confirm(`¿Eliminar el convenio con "${empresa}"? Esta acción no se puede deshacer.`)) return;

    const fd = new FormData();
    fd.append('accion', 'eliminar');
    fd.append('id', id);

    fetch('', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            if (res.ok) {
                const fila = document.querySelector(`tr[data-id="${id}"]`);
                fila?.remove();
            } else {
                alert('Error al eliminar: ' + res.msg);
            }
        })
        .catch(() => alert('Error de conexión'));
});

/* ---- SUBMIT FORM ---- */
form.addEventListener('submit', function(e) {
    e.preventDefault();
    const submitBtn = document.getElementById('modalSubmit');
    submitBtn.disabled = true;
    ocultarStatus();

    fetch('', { method: 'POST', body: new FormData(form) })
        .then(r => r.json())
        .then(res => {
            if (!res.ok) {
                mostrarStatus(res.msg || 'Error desconocido', 'error');
                submitBtn.disabled = false;
                return;
            }

            mostrarStatus(res.msg, 'success');
            submitBtn.disabled = false;

            const accion  = document.getElementById('fAccion').value;
            const empresa = document.getElementById('fEmpresa').value;
            const tipo    = document.getElementById('fTipo');
            const tipoNom = tipo.options[tipo.selectedIndex]?.text || '—';
            const descuento= document.getElementById('fDescuento').value;
            const fIni    = document.getElementById('fFechaInicio').value;
            const fTer    = document.getElementById('fFechaTermino').value;
            const activo  = document.getElementById('fActivo').checked;
            const dest    = document.getElementById('fDestacado').checked;

            const fmtFecha = d => d ? d.split('-').reverse().join('/') : '—';
            const badgeActivo   = activo ? '<span class="badge badge--green">Sí</span>' : '<span class="badge badge--gray">No</span>';
            const badgeDestacado= dest   ? '<span class="badge badge--gold">⭐</span>'  : '<span class="badge badge--gray">—</span>';

            if (accion === 'crear' && res.id) {
                const tbody = document.getElementById('tbody');
                const emptyRow = tbody.querySelector('td[colspan]');
                emptyRow?.closest('tr')?.remove();
                const tr = document.createElement('tr');
                tr.dataset.id = res.id;
                tr.innerHTML = `
                    <td>${res.id}</td>
                    <td><strong>${empresa}</strong></td>
                    <td>${tipoNom}</td>
                    <td>${descuento || '—'}</td>
                    <td>${fmtFecha(fIni)}</td>
                    <td>${fmtFecha(fTer)}</td>
                    <td>${badgeActivo}</td>
                    <td>${badgeDestacado}</td>
                    <td>
                      <div class="td-actions">
                        <button class="btn btn--ghost btn--sm btn-edit"
                          data-id="${res.id}" data-empresa="${empresa}"
                          data-id-tipo="${document.getElementById('fTipo').value}"
                          data-descripcion="${document.getElementById('fDescripcion').value}"
                          data-descuento="${descuento}"
                          data-url="${document.getElementById('fUrl').value}"
                          data-fecha-inicio="${fIni}" data-fecha-termino="${fTer}"
                          data-activo="${activo ? 1 : 0}" data-destacado="${dest ? 1 : 0}"
                          data-imagen="${res.imagen || ''}"
                        >Editar</button>
                        <button class="btn btn--danger btn--sm btn-delete" data-id="${res.id}" data-empresa="${empresa}">Eliminar</button>
                      </div>
                    </td>`;
                tbody.prepend(tr);
            } else if (accion === 'editar') {
                const id  = document.getElementById('fId').value;
                const fila = document.querySelector(`tr[data-id="${id}"]`);
                if (fila) {
                    fila.cells[1].innerHTML = `<strong>${empresa}</strong>`;
                    fila.cells[2].textContent = tipoNom;
                    fila.cells[3].textContent = descuento || '—';
                    fila.cells[4].textContent = fmtFecha(fIni);
                    fila.cells[5].textContent = fmtFecha(fTer);
                    fila.cells[6].innerHTML   = badgeActivo;
                    fila.cells[7].innerHTML   = badgeDestacado;
                    // Actualizar datos del botón editar
                    const editBtn = fila.querySelector('.btn-edit');
                    if (editBtn) {
                        editBtn.dataset.empresa      = empresa;
                        editBtn.dataset.idTipo       = document.getElementById('fTipo').value;
                        editBtn.dataset.descripcion  = document.getElementById('fDescripcion').value;
                        editBtn.dataset.descuento    = descuento;
                        editBtn.dataset.url          = document.getElementById('fUrl').value;
                        editBtn.dataset.fechaInicio  = fIni;
                        editBtn.dataset.fechaTermino = fTer;
                        editBtn.dataset.activo       = activo ? '1' : '0';
                        editBtn.dataset.destacado    = dest ? '1' : '0';
                        editBtn.dataset.imagen       = res.imagen || editBtn.dataset.imagen;
                    }
                }
            }

            setTimeout(cerrarModal, 1200);
        })
        .catch(() => {
            mostrarStatus('Error de conexión', 'error');
            submitBtn.disabled = false;
        });
});
</script>

</body>
</html>
