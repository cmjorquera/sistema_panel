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
$paginaActual = basename($_SERVER['PHP_SELF'] ?? 'liquidaciones.php');
$db->cerrar();

// Datos de liquidaciones — conectar a tabla cuando esté disponible
$liquidaciones = [
    ['mes'=>'04-2026','bruto'=>1379433,'liquido'=>790367,'patronal'=>97627,'horas_extra'=>0.0,'recargos'=>0.0,'horas_no_trab'=>0.00,'dias_no_trab'=>0.00],
    ['mes'=>'03-2026','bruto'=>1379433,'liquido'=>790367,'patronal'=>96523,'horas_extra'=>0.0,'recargos'=>0.0,'horas_no_trab'=>0.00,'dias_no_trab'=>0.00],
    ['mes'=>'02-2026','bruto'=>1373632,'liquido'=>1013619,'patronal'=>96122,'horas_extra'=>0.0,'recargos'=>0.0,'horas_no_trab'=>0.00,'dias_no_trab'=>0.00],
];

function pesos(int $n): string { return '$' . number_format($n, 0, ',', '.'); }
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Seduc Hub | Liquidaciones</title>
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

    /* TABS */
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

    /* TABLA */
    .page-body{padding:28px 0 60px}
    .table-toolbar{display:flex;align-items:center;justify-content:space-between;gap:14px;margin-bottom:16px;flex-wrap:wrap}
    .toolbar-left{display:flex;align-items:center;gap:10px;font-size:14px;font-weight:700;color:var(--muted)}
    .toolbar-left select{border:1px solid var(--border);border-radius:8px;padding:6px 10px;font-size:13px;font-weight:700;background:#fff;color:var(--text)}
    .toolbar-right{display:flex;align-items:center;gap:10px}
    .toolbar-right label{font-size:14px;font-weight:700;color:var(--muted)}
    .toolbar-right input{border:1px solid var(--border);border-radius:10px;padding:8px 12px;font-size:13px;outline:none;width:180px}
    .toolbar-right input:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(47,87,183,.12)}
    .btn-acciones{border:none;border-radius:12px;padding:10px 16px;font-weight:900;font-size:13px;cursor:pointer;background:var(--primary);color:#fff;display:flex;align-items:center;gap:6px}
    .btn-acciones:hover{background:var(--primary-700)}
    .table-wrap{background:#fff;border-radius:18px;border:1px solid var(--border);box-shadow:var(--shadow-soft);overflow:hidden}
    table{width:100%;border-collapse:collapse;font-size:13px}
    thead{background:#f8fafc}
    th{padding:12px 14px;text-align:left;font-weight:900;color:var(--muted);font-size:12px;text-transform:uppercase;letter-spacing:.04em;border-bottom:1px solid var(--border);white-space:nowrap}
    td{padding:13px 14px;border-bottom:1px solid var(--border);vertical-align:middle;white-space:nowrap}
    tr:last-child td{border-bottom:none}
    tr:hover td{background:#f8fafc}
    .td-mes{color:var(--primary);font-weight:800}
    .td-num{text-align:right}
    .td-actions{display:flex;gap:8px;align-items:center}
    .action-icon{border:none;background:none;cursor:pointer;color:var(--muted);font-size:17px;padding:4px;border-radius:6px;transition:.12s ease}
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
      <a class="tab is-active" href="liquidaciones.php">Liquidaciones</a>
      <a class="tab" href="documentos.php">Documentos</a>
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
          <option value="100">100</option>
        </select>
        registros
      </div>
      <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
        <button class="btn-acciones" onclick="window.print()">Acciones ▾</button>
        <div class="toolbar-right">
          <label for="buscar">Buscar:</label>
          <input type="search" id="buscar" placeholder="" autocomplete="off" />
        </div>
      </div>
    </div>

    <div class="table-wrap">
      <table id="tabla">
        <thead>
          <tr>
            <th><input type="checkbox" class="chk" id="chkAll" /></th>
            <th>Mes</th>
            <th class="td-num">Sueldo Bruto</th>
            <th class="td-num">Sueldo Líquido</th>
            <th class="td-num">Aporte Patronal</th>
            <th class="td-num">Horas Extras</th>
            <th class="td-num">Recargos</th>
            <th class="td-num">Horas no Trabajadas</th>
            <th class="td-num">Días no Trabajados</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="tbody">
          <?php foreach ($liquidaciones as $liq): ?>
            <tr data-mes="<?= strtolower($liq['mes']) ?>">
              <td><input type="checkbox" class="chk row-chk" /></td>
              <td class="td-mes"><?= htmlspecialchars($liq['mes'], ENT_QUOTES, 'UTF-8') ?></td>
              <td class="td-num"><?= pesos($liq['bruto']) ?></td>
              <td class="td-num"><?= pesos($liq['liquido']) ?></td>
              <td class="td-num"><?= pesos($liq['patronal']) ?></td>
              <td class="td-num"><?= number_format($liq['horas_extra'], 1) ?> hrs</td>
              <td class="td-num"><?= number_format($liq['recargos'], 1) ?> hrs</td>
              <td class="td-num"><?= number_format($liq['horas_no_trab'], 2, ',', '.') ?> hrs</td>
              <td class="td-num"><?= number_format($liq['dias_no_trab'], 2, ',', '.') ?> días</td>
              <td>
                <div class="td-actions">
                  <button class="action-icon" title="Imprimir" onclick="window.print()">🖨️</button>
                  <button class="action-icon" title="Ver detalle">🔍</button>
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
        const mes = tr.dataset.mes || '';
        tr.classList.toggle('hidden-row', filtroTexto !== '' && !mes.includes(filtroTexto));
    });
    pagActual = 1;
    paginar();
}

function paginar() {
    const visibles = filas().filter(tr => !tr.classList.contains('hidden-row'));
    const total = visibles.length;
    const inicio = (pagActual - 1) * porPagina;
    const fin = Math.min(inicio + porPagina, total);

    visibles.forEach((tr, i) => {
        tr.style.display = (i >= inicio && i < fin) ? '' : 'none';
    });

    tableInfo.textContent = total === 0
        ? 'Sin registros'
        : `Mostrando registros del ${inicio + 1} al ${fin} de un total de ${total} registros`;

    const totalPag = Math.ceil(total / porPagina);
    paginacion.innerHTML = '';

    const btnPrev = document.createElement('button');
    btnPrev.className = 'pag-btn'; btnPrev.textContent = '← Anterior';
    btnPrev.disabled = pagActual === 1;
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
    btnNext.className = 'pag-btn'; btnNext.textContent = 'Siguiente →';
    btnNext.disabled = pagActual === totalPag || totalPag === 0;
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
