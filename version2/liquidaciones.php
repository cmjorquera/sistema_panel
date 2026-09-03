<?php
require_once 'class/Sesion.php';
require_once 'class/Conexion.php';
Sesion::requerir();

$titulo_pagina     = 'Liquidaciones';
$breadcrumb_actual = 'Liquidaciones';
$pagina_actual     = 'liquidaciones';

/* Datos de liquidaciones — conectar a tabla cuando esté disponible */
$liquidaciones = [
    ['mes'=>'04-2026','bruto'=>1379433,'liquido'=>790367,'patronal'=>97627, 'horas_extra'=>0.0,'recargos'=>0.0,'horas_no_trab'=>0.00,'dias_no_trab'=>0.00],
    ['mes'=>'03-2026','bruto'=>1379433,'liquido'=>790367,'patronal'=>96523, 'horas_extra'=>0.0,'recargos'=>0.0,'horas_no_trab'=>0.00,'dias_no_trab'=>0.00],
    ['mes'=>'02-2026','bruto'=>1373632,'liquido'=>1013619,'patronal'=>96122,'horas_extra'=>0.0,'recargos'=>0.0,'horas_no_trab'=>0.00,'dias_no_trab'=>0.00],
    ['mes'=>'01-2026','bruto'=>1373632,'liquido'=>1013619,'patronal'=>95800,'horas_extra'=>0.0,'recargos'=>0.0,'horas_no_trab'=>0.00,'dias_no_trab'=>0.00],
    ['mes'=>'12-2025','bruto'=>1350000,'liquido'=>985000,'patronal'=>94500, 'horas_extra'=>0.0,'recargos'=>0.0,'horas_no_trab'=>0.00,'dias_no_trab'=>0.00],
];

function pesos(int $n): string { return '$' . number_format($n, 0, ',', '.'); }

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
      <h1>Liquidaciones</h1>
      <p>Historial de remuneraciones y liquidaciones de sueldo.</p>
    </div>
  </div>

  <!-- Resumen rápido -->
  <div class="stat-grid" style="margin-bottom:24px">
    <?php
      $ultimo = $liquidaciones[0] ?? null;
    ?>
    <div class="stat-card">
      <div class="row">
        <div>
          <p class="label">Sueldo Bruto (último mes)</p>
          <p class="value" style="font-size:22px"><?= $ultimo ? pesos((int)$ultimo['bruto']) : '—' ?></p>
        </div>
        <div class="stat-icon icon-blue">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
        </div>
      </div>
    </div>
    <div class="stat-card">
      <div class="row">
        <div>
          <p class="label">Sueldo Líquido (último mes)</p>
          <p class="value" style="font-size:22px"><?= $ultimo ? pesos((int)$ultimo['liquido']) : '—' ?></p>
        </div>
        <div class="stat-icon icon-green">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
      </div>
    </div>
    <div class="stat-card">
      <div class="row">
        <div>
          <p class="label">Aporte Patronal (último mes)</p>
          <p class="value" style="font-size:22px"><?= $ultimo ? pesos((int)$ultimo['patronal']) : '—' ?></p>
        </div>
        <div class="stat-icon icon-yellow">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
      </div>
    </div>
  </div>

  <!-- Tabla de liquidaciones -->
  <div class="card">
    <div class="toolbar" style="flex-wrap:wrap;gap:10px">
      <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:var(--muted)">
        Mostrar
        <select id="showCount" class="input" style="width:auto;padding:5px 28px 5px 8px">
          <option value="10" selected>10</option>
          <option value="25">25</option>
          <option value="50">50</option>
        </select>
        registros
      </div>
      <div style="display:flex;align-items:center;gap:10px;margin-left:auto">
        <div class="input-icon-wrap" style="width:220px">
          <svg class="icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
          <input type="search" class="input" id="buscar" placeholder="Buscar mes…" autocomplete="off"/>
        </div>
        <button class="btn btn-outline btn-sm" onclick="window.print()">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
          Imprimir
        </button>
        <span class="toolbar-count" id="liq-count" style="white-space:nowrap"><?= count($liquidaciones) ?> registros</span>
      </div>
    </div>

    <div class="table-wrap">
      <table id="tabla">
        <thead>
          <tr>
            <th><input type="checkbox" id="chkAll" style="accent-color:var(--blue)"/></th>
            <th>Mes</th>
            <th style="text-align:right">Sueldo Bruto</th>
            <th style="text-align:right">Sueldo Líquido</th>
            <th style="text-align:right">Aporte Patronal</th>
            <th style="text-align:right">Horas Extras</th>
            <th style="text-align:right">Recargos</th>
            <th style="text-align:right">Hrs no Trabajadas</th>
            <th style="text-align:right">Días no Trabajados</th>
            <th style="text-align:right">Acciones</th>
          </tr>
        </thead>
        <tbody id="tbody">
          <?php foreach ($liquidaciones as $liq): ?>
            <tr data-mes="<?= strtolower(htmlspecialchars($liq['mes'])) ?>">
              <td><input type="checkbox" class="row-chk" style="accent-color:var(--blue)"/></td>
              <td style="font-weight:600;color:var(--blue)"><?= htmlspecialchars($liq['mes']) ?></td>
              <td style="text-align:right"><?= pesos($liq['bruto']) ?></td>
              <td style="text-align:right;color:var(--green);font-weight:600"><?= pesos($liq['liquido']) ?></td>
              <td style="text-align:right"><?= pesos($liq['patronal']) ?></td>
              <td style="text-align:right;color:var(--muted)"><?= number_format($liq['horas_extra'], 1) ?> hrs</td>
              <td style="text-align:right;color:var(--muted)"><?= number_format($liq['recargos'], 1) ?> hrs</td>
              <td style="text-align:right;color:var(--muted)"><?= number_format($liq['horas_no_trab'], 2, ',', '.') ?> hrs</td>
              <td style="text-align:right;color:var(--muted)"><?= number_format($liq['dias_no_trab'], 2, ',', '.') ?> días</td>
              <td style="text-align:right">
                <button class="btn-icon" title="Imprimir" onclick="window.print()">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                </button>
                <button class="btn-icon" title="Ver detalle">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-top:1px solid var(--border);flex-wrap:wrap;gap:8px">
      <span id="tableInfo" style="font-size:12px;color:var(--muted)"></span>
      <div id="pagination" style="display:flex;gap:4px"></div>
    </div>
  </div>

</div><!-- /content -->
</div><!-- /main -->
</div><!-- /app -->

<?php include 'componentes/scripts.php'; ?>
<script>
const tbody      = document.getElementById('tbody');
const buscarEl   = document.getElementById('buscar');
const showCount  = document.getElementById('showCount');
const tableInfo  = document.getElementById('tableInfo');
const paginacion = document.getElementById('pagination');
const chkAll     = document.getElementById('chkAll');
const liqCount   = document.getElementById('liq-count');

let pagActual   = 1;
let porPagina   = parseInt(showCount.value);
let filtroTexto = '';

function filas() { return Array.from(tbody.querySelectorAll('tr')); }

function filtrar() {
    filas().forEach(function(tr) {
        var mes = tr.dataset.mes || '';
        tr.hidden = filtroTexto !== '' && !mes.includes(filtroTexto);
    });
    pagActual = 1;
    paginar();
}

function paginar() {
    var visibles = filas().filter(function(tr) { return !tr.hidden; });
    var total    = visibles.length;
    var inicio   = (pagActual - 1) * porPagina;
    var fin      = Math.min(inicio + porPagina, total);

    visibles.forEach(function(tr, i) { tr.style.display = (i >= inicio && i < fin) ? '' : 'none'; });
    filas().filter(function(tr) { return tr.hidden; }).forEach(function(tr) { tr.style.display = 'none'; });

    liqCount.textContent = total + ' registro' + (total !== 1 ? 's' : '');
    tableInfo.textContent = total === 0
        ? 'Sin registros'
        : 'Mostrando ' + (inicio + 1) + '–' + fin + ' de ' + total + ' registros';

    var totalPag = Math.ceil(total / porPagina);
    paginacion.innerHTML = '';

    var btnPrev = document.createElement('button');
    btnPrev.className = 'btn btn-sm btn-outline';
    btnPrev.textContent = '‹';
    btnPrev.disabled = pagActual === 1;
    btnPrev.onclick = function() { pagActual--; paginar(); };
    paginacion.appendChild(btnPrev);

    for (var p = 1; p <= totalPag; p++) {
        var btn = document.createElement('button');
        btn.className = 'btn btn-sm ' + (p === pagActual ? 'btn-primary' : 'btn-outline');
        btn.textContent = p;
        btn.onclick = (function(pg) { return function() { pagActual = pg; paginar(); }; })(p);
        paginacion.appendChild(btn);
    }

    var btnNext = document.createElement('button');
    btnNext.className = 'btn btn-sm btn-outline';
    btnNext.textContent = '›';
    btnNext.disabled = pagActual === totalPag || totalPag === 0;
    btnNext.onclick = function() { pagActual++; paginar(); };
    paginacion.appendChild(btnNext);
}

buscarEl.addEventListener('input', function() { filtroTexto = this.value.toLowerCase().trim(); filtrar(); });
showCount.addEventListener('change', function() { porPagina = parseInt(this.value); pagActual = 1; paginar(); });
chkAll.addEventListener('change', function() { tbody.querySelectorAll('.row-chk').forEach(function(c) { c.checked = chkAll.checked; }); });

paginar();
</script>
</body>
</html>
