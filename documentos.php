<?php
require_once __DIR__ . '/class/conexion.php';
require_once __DIR__ . '/componentes/rail_acciones.php';
require_once __DIR__ . '/componentes/panel_contactos.php';
require_once __DIR__ . '/componentes/keep_widget.php';

$menuCabeceraCandidates = [__DIR__ . '/componentes/menu_cabecera.php'];
$menuCabeceraPath = null;
foreach ($menuCabeceraCandidates as $c) { if (is_file($c)) { $menuCabeceraPath = $c; break; } }
if ($menuCabeceraPath === null) throw new RuntimeException('No se encontro menu_cabecera.php');
require_once $menuCabeceraPath;

$db = new Conexion();
$conn = $db->getConexion();
$menusCabecera = menus_cabezera($conn);
$paginaActual = basename($_SERVER['PHP_SELF'] ?? 'documentos.php');
$db->cerrar();

// Documentos — conectar a tabla/directorio cuando esté disponible
$documentos = [
    ['nombre'=>'JORQUERA_16423446-0_1_SEDUC_RIOHS.pdf',                                          'tamano'=>'1 MB',   'fecha'=>'19-02-2026'],
    ['nombre'=>'JORQUERA_16423446-0_1_Prestamo_Compra_PC_032025.pdf',                             'tamano'=>'400 KB', 'fecha'=>'19-02-2026'],
    ['nombre'=>'JORQUERA_16423446-0_1_Certificado_de_renta_de_CRISTIAN_MICHEL_JORQUERA_GONZALEZ_contrato__1_-_2023.pdf', 'tamano'=>'50 KB',  'fecha'=>'19-02-2026'],
    ['nombre'=>'JORQUERA_16423446-0_1_Anexo_Anual_de_Contrato.pdf',                               'tamano'=>'200 KB', 'fecha'=>'19-02-2026'],
    ['nombre'=>'JORQUERA_16423446-0_1_Certificado_de_renta_de_CRISTIAN_MICHEL_JORQUERA_GONZALEZ_contrato__1_-_2021.pdf', 'tamano'=>'50 KB',  'fecha'=>'19-02-2026'],
    ['nombre'=>'JORQUERA_16423446-0_1_Certificado_de_Titulo.pdf',                                 'tamano'=>'100 KB', 'fecha'=>'19-02-2026'],
];
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Seduc Hub | Documentos</title>
  <style>
    :root{
      --primary:#2f57b7; --primary-700:#23449a;
      --bg:#f6f8fe; --text:#0f172a; --muted:#64748b; --border:#e5eaf6;
      --shadow:0 10px 30px rgba(15,23,42,.10); --shadow-soft:0 8px 20px rgba(15,23,42,.08);
      --container:1280px;
    }
    *{box-sizing:border-box} body{margin:0;font-family:ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Arial;color:var(--text);background:var(--bg)}
    a{color:inherit;text-decoration:none}
    .container{width:min(var(--container),calc(100% - 36px));margin-inline:auto}
    .topbar{position:sticky;top:0;z-index:80;background:rgba(255,255,255,.92);backdrop-filter:blur(10px);border-bottom:1px solid var(--border)}
    .topbar__inner{display:flex;align-items:center;justify-content:space-between;gap:14px;padding:14px 0}
    .brand{display:flex;align-items:center;gap:12px}
    .brand__logo{width:42px;height:42px;border-radius:14px;background:linear-gradient(135deg,var(--primary),var(--primary-700));color:#fff;display:grid;place-items:center;font-weight:900;font-size:14px}
    .brand__name{font-weight:900;line-height:1} .brand__tag{font-size:12px;color:var(--muted);margin-top:2px}
    .topbar__nav{display:flex;align-items:center;gap:18px}
    .navlink{font-weight:700;color:var(--muted);padding:10px 12px;border-radius:12px}
    .navlink:hover{background:#eef2ff;color:var(--text)} .navlink.is-active{background:#eef2ff;color:var(--primary)}
    .usermenu{position:relative}
    .userbtn{display:flex;align-items:center;gap:10px;padding:8px 10px;border-radius:18px;border:1px solid var(--border);background:rgba(255,255,255,.82);backdrop-filter:blur(10px);cursor:pointer;box-shadow:var(--shadow-soft);transition:.15s ease}
    .userbtn:hover{background:#fff}
    .userbtn__avatar{width:36px;height:36px;border-radius:14px;display:grid;place-items:center;background:#eef2ff;color:var(--primary);font-weight:900}
    .userbtn__text{display:flex;flex-direction:column;line-height:1.05;text-align:left}
    .userbtn__name{font-weight:900;font-size:13px} .userbtn__role{font-weight:800;font-size:12px;color:var(--muted);margin-top:2px} .userbtn__chev{margin-left:6px;color:var(--muted);font-weight:900}
    .dropdown{position:absolute;right:0;top:calc(100% + 10px);width:220px;border-radius:16px;border:1px solid var(--border);background:rgba(255,255,255,.96);backdrop-filter:blur(10px);box-shadow:var(--shadow);padding:8px;display:none;z-index:120}
    .usermenu:hover .dropdown{display:block}
    .dropdown__item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:12px;font-weight:800;color:var(--text)}
    .dropdown__item:hover{background:#eef2ff;color:var(--primary)} .dropdown__sep{height:1px;background:var(--border);margin:8px 6px}
    .dropdown__item--danger{color:#b91c1c} .dropdown__item--danger:hover{background:#fff1f2;color:#b91c1c}

    /* HERO / TABS */
    .profile-hero{background:linear-gradient(135deg,var(--primary),var(--primary-700));padding:32px 0;color:#fff}
    .profile-hero__inner{display:flex;align-items:center;gap:20px}
    .profile-hero__avatar{width:72px;height:72px;border-radius:999px;background:rgba(255,255,255,.22);border:3px solid rgba(255,255,255,.5);display:grid;place-items:center;font-size:26px;font-weight:900}
    .profile-hero__name{margin:0 0 4px;font-size:22px;font-weight:900}
    .profile-hero__cargo{margin:0;font-size:14px;color:rgba(255,255,255,.8);font-weight:700}
    .profile-tabs{background:#fff;border-bottom:1px solid var(--border)}
    .tabs{display:flex;gap:0}
    .tab{display:block;padding:14px 20px;font-size:14px;font-weight:800;color:var(--muted);border-bottom:3px solid transparent;transition:.15s ease;white-space:nowrap}
    .tab:hover{color:var(--primary);border-bottom-color:rgba(47,87,183,.3)}
    .tab.is-active{color:var(--primary);border-bottom-color:var(--primary)}

    /* TABLA DOCUMENTOS */
    .page-body{padding:28px 0 60px}
    .table-toolbar{display:flex;align-items:center;justify-content:space-between;gap:14px;margin-bottom:16px;flex-wrap:wrap}
    .toolbar-left{display:flex;align-items:center;gap:10px;font-size:14px;font-weight:700;color:var(--muted)}
    .toolbar-left select{border:1px solid var(--border);border-radius:8px;padding:6px 10px;font-size:13px;font-weight:700;background:#fff;color:var(--text)}
    .toolbar-right{display:flex;align-items:center;gap:10px}
    .toolbar-right label{font-size:14px;font-weight:700;color:var(--muted)}
    .toolbar-right input{border:1px solid var(--border);border-radius:10px;padding:8px 12px;font-size:13px;outline:none;width:200px}
    .toolbar-right input:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(47,87,183,.12)}
    .table-wrap{background:#fff;border-radius:18px;border:1px solid var(--border);box-shadow:var(--shadow-soft);overflow:hidden}
    table{width:100%;border-collapse:collapse;font-size:13px}
    thead{background:#f8fafc}
    th{padding:12px 16px;text-align:left;font-weight:900;color:var(--muted);font-size:12px;text-transform:uppercase;letter-spacing:.04em;border-bottom:1px solid var(--border)}
    td{padding:13px 16px;border-bottom:1px solid var(--border);vertical-align:middle}
    tr:last-child td{border-bottom:none}
    tr:hover td{background:#f8fafc}
    .td-nombre{display:flex;align-items:center;gap:10px}
    .td-nombre__icon{width:34px;height:34px;border-radius:8px;background:#fff1f2;border:1px solid #fecaca;display:grid;place-items:center;font-size:16px;flex-shrink:0}
    .td-nombre__link{color:var(--primary);font-weight:800;font-size:13px;word-break:break-all}
    .td-nombre__link:hover{text-decoration:underline}
    .td-muted{color:var(--muted);font-weight:700;white-space:nowrap}
    .td-actions{display:flex;gap:6px}
    .action-icon{border:none;background:none;cursor:pointer;color:var(--muted);font-size:16px;padding:5px;border-radius:6px;transition:.12s ease}
    .action-icon:hover{background:#eef2ff;color:var(--primary)}
    .chk{accent-color:var(--primary)}
    .table-footer{display:flex;align-items:center;justify-content:space-between;padding:14px 18px;flex-wrap:wrap;gap:10px}
    .pagination{display:flex;gap:4px;align-items:center}
    .pag-btn{border:1px solid var(--border);border-radius:8px;padding:6px 12px;font-size:13px;font-weight:700;background:#fff;color:var(--text);cursor:pointer}
    .pag-btn.is-active,.pag-btn:hover{background:var(--primary);border-color:var(--primary);color:#fff}
    .table-info{font-size:13px;font-weight:700;color:var(--muted)}
    .hidden-row{display:none}

    @media(max-width:820px){.topbar__nav{display:none}.tabs{overflow-x:auto}.table-toolbar{flex-direction:column;align-items:flex-start}}
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
      <div><div class="brand__name">Seduc Hub</div><div class="brand__tag">Portal Operativo</div></div>
    </div>
    <nav class="topbar__nav">
      <?php foreach ($menusCabecera as $menu): ?>
        <?php $claseActiva = basename($menu['href']) === $paginaActual ? ' is-active' : ''; ?>
        <a class="navlink<?= $claseActiva ?>" href="<?= htmlspecialchars($menu['href'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($menu['menu'] ?: 'Menu', ENT_QUOTES, 'UTF-8') ?></a>
      <?php endforeach; ?>
    </nav>
    <?php renderTopbarUserMenu(['editar_perfil_href' => 'perfil.php']); ?>
  </div>
</header>

<div class="profile-hero">
  <div class="container">
    <div class="profile-hero__inner">
      <div class="profile-hero__avatar">CJ</div>
      <div>
        <h1 class="profile-hero__name">Cristian Jorquera</h1>
        <p class="profile-hero__cargo">Analista Programador · SEDUC</p>
      </div>
    </div>
  </div>
</div>

<div class="profile-tabs">
  <div class="container">
    <nav class="tabs">
      <a class="tab" href="perfil.php">Resumen</a>
      <a class="tab" href="liquidaciones.php">Liquidaciones</a>
      <a class="tab is-active" href="documentos.php">Documentos</a>
      <a class="tab" href="#">Bitácora</a>
    </nav>
  </div>
</div>

<main class="page-body">
  <div class="container">

    <div class="table-toolbar">
      <div class="toolbar-left">
        Mostrar
        <select id="showCount">
          <option value="10">10</option>
          <option value="25" selected>25</option>
          <option value="50">50</option>
        </select>
        registros
      </div>
      <div class="toolbar-right">
        <label for="buscar">Buscar:</label>
        <input type="search" id="buscar" placeholder="Nombre del documento..." autocomplete="off" />
      </div>
    </div>

    <div class="table-wrap">
      <table id="tabla">
        <thead>
          <tr>
            <th><input type="checkbox" class="chk" id="chkAll" /></th>
            <th>Nombre</th>
            <th>Tamaño</th>
            <th>Fecha Creación</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="tbody">
          <?php foreach ($documentos as $doc):
            $nombre = htmlspecialchars($doc['nombre'], ENT_QUOTES, 'UTF-8');
            $busqueda = strtolower($doc['nombre']);
          ?>
            <tr data-nombre="<?= $busqueda ?>">
              <td><input type="checkbox" class="chk row-chk" /></td>
              <td>
                <div class="td-nombre">
                  <div class="td-nombre__icon">📄</div>
                  <a class="td-nombre__link" href="documentos/<?= $nombre ?>" target="_blank" rel="noopener noreferrer"><?= $nombre ?></a>
                </div>
              </td>
              <td class="td-muted"><?= htmlspecialchars($doc['tamano'], ENT_QUOTES, 'UTF-8') ?></td>
              <td class="td-muted"><?= htmlspecialchars($doc['fecha'], ENT_QUOTES, 'UTF-8') ?></td>
              <td>
                <div class="td-actions">
                  <a class="action-icon" href="documentos/<?= $nombre ?>" download title="Descargar">⬇️</a>
                  <a class="action-icon" href="documentos/<?= $nombre ?>" target="_blank" title="Ver">👁️</a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="table-footer">
      <div class="table-info" id="tableInfo"></div>
      <div class="pagination" id="pagination"></div>
    </div>

  </div>
</main>

<?php renderRailAcciones(true); ?>
<?php renderPanelContactos(); ?>

<script>
const tbody     = document.getElementById('tbody');
const buscar    = document.getElementById('buscar');
const showCount = document.getElementById('showCount');
const tableInfo = document.getElementById('tableInfo');
const paginacion= document.getElementById('pagination');
const chkAll    = document.getElementById('chkAll');

let pagActual = 1;
let porPagina = parseInt(showCount.value);
let filtroTexto = '';

function filas() { return Array.from(tbody.querySelectorAll('tr')); }

function filtrar() {
    filas().forEach(tr => {
        const nombre = tr.dataset.nombre || '';
        tr.classList.toggle('hidden-row', filtroTexto !== '' && !nombre.includes(filtroTexto));
    });
    pagActual = 1;
    paginar();
}

function paginar() {
    const visibles = filas().filter(tr => !tr.classList.contains('hidden-row'));
    const total = visibles.length;
    const inicio = (pagActual - 1) * porPagina;
    const fin = Math.min(inicio + porPagina, total);

    visibles.forEach((tr, i) => { tr.style.display = (i >= inicio && i < fin) ? '' : 'none'; });

    tableInfo.textContent = total === 0
        ? 'Sin documentos'
        : `Mostrando registros del ${inicio + 1} al ${fin} de un total de ${total} registros`;

    const totalPag = Math.ceil(total / porPagina);
    paginacion.innerHTML = '';

    const btnPrev = document.createElement('button');
    btnPrev.className = 'pag-btn'; btnPrev.textContent = '← Anterior'; btnPrev.disabled = pagActual === 1;
    btnPrev.onclick = () => { pagActual--; paginar(); };
    paginacion.appendChild(btnPrev);

    for (let p = 1; p <= totalPag; p++) {
        const btn = document.createElement('button');
        btn.className = 'pag-btn' + (p === pagActual ? ' is-active' : '');
        btn.textContent = p;
        btn.onclick = () => { pagActual = p; paginar(); };
        paginacion.appendChild(btn);
    }

    const btnNext = document.createElement('button');
    btnNext.className = 'pag-btn'; btnNext.textContent = 'Siguiente →'; btnNext.disabled = pagActual === totalPag || totalPag === 0;
    btnNext.onclick = () => { pagActual++; paginar(); };
    paginacion.appendChild(btnNext);
}

buscar.addEventListener('input', function() { filtroTexto = this.value.toLowerCase().trim(); filtrar(); });
showCount.addEventListener('change', function() { porPagina = parseInt(this.value); pagActual = 1; paginar(); });
chkAll.addEventListener('change', function() { tbody.querySelectorAll('.row-chk').forEach(c => c.checked = this.checked); });

paginar();
</script>

</body>
</html>
