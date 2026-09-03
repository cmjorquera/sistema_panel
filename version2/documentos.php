<?php
require_once 'class/Sesion.php';
require_once 'class/Conexion.php';
Sesion::requerir();

$titulo_pagina     = 'Documentos';
$breadcrumb_actual = 'Documentos';
$pagina_actual     = 'documentos';

/* Documentos — conectar a tabla/directorio cuando esté disponible */
$documentos = [
    ['nombre'=>'JORQUERA_16423446-0_1_SEDUC_RIOHS.pdf',                                                                          'tamano'=>'1 MB',   'fecha'=>'19-02-2026'],
    ['nombre'=>'JORQUERA_16423446-0_1_Prestamo_Compra_PC_032025.pdf',                                                            'tamano'=>'400 KB', 'fecha'=>'19-02-2026'],
    ['nombre'=>'JORQUERA_16423446-0_1_Certificado_de_renta_de_CRISTIAN_MICHEL_JORQUERA_GONZALEZ_contrato__1_-_2023.pdf',          'tamano'=>'50 KB',  'fecha'=>'19-02-2026'],
    ['nombre'=>'JORQUERA_16423446-0_1_Anexo_Anual_de_Contrato.pdf',                                                              'tamano'=>'200 KB', 'fecha'=>'19-02-2026'],
    ['nombre'=>'JORQUERA_16423446-0_1_Certificado_de_renta_de_CRISTIAN_MICHEL_JORQUERA_GONZALEZ_contrato__1_-_2021.pdf',          'tamano'=>'50 KB',  'fecha'=>'19-02-2026'],
    ['nombre'=>'JORQUERA_16423446-0_1_Certificado_de_Titulo.pdf',                                                                'tamano'=>'100 KB', 'fecha'=>'19-02-2026'],
];

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
      <h1>Documentos</h1>
      <p>Documentos personales, contratos y certificados asociados a tu perfil.</p>
    </div>
  </div>

  <!-- Tabla de documentos -->
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
        <div class="input-icon-wrap" style="width:260px">
          <svg class="icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
          <input type="search" class="input" id="buscar" placeholder="Buscar documento…" autocomplete="off"/>
        </div>
        <span class="toolbar-count" id="doc-count" style="white-space:nowrap"><?= count($documentos) ?> documentos</span>
      </div>
    </div>

    <div class="table-wrap">
      <table id="tabla">
        <thead>
          <tr>
            <th><input type="checkbox" id="chkAll" style="accent-color:var(--blue)"/></th>
            <th>Nombre del archivo</th>
            <th>Tamaño</th>
            <th>Fecha</th>
            <th style="text-align:right">Acciones</th>
          </tr>
        </thead>
        <tbody id="tbody">
          <?php foreach ($documentos as $doc):
            $nombre   = htmlspecialchars($doc['nombre'], ENT_QUOTES, 'UTF-8');
            $busqueda = strtolower($doc['nombre']);
            /* Detecta extensión para icono */
            $ext = strtolower(pathinfo($doc['nombre'], PATHINFO_EXTENSION));
          ?>
            <tr data-nombre="<?= $busqueda ?>">
              <td><input type="checkbox" class="row-chk" style="accent-color:var(--blue)"/></td>
              <td>
                <div style="display:flex;align-items:center;gap:10px">
                  <div style="width:34px;height:34px;border-radius:8px;background:var(--danger-light);border:1px solid rgba(192,57,43,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:15px">
                    <?= $ext === 'pdf' ? '📄' : ($ext === 'xlsx' || $ext === 'xls' ? '📊' : '📁') ?>
                  </div>
                  <a href="documentos/<?= $nombre ?>" target="_blank" rel="noopener noreferrer"
                     style="color:var(--blue);font-weight:500;font-size:12px;word-break:break-all;text-decoration:none"
                     onmouseover="this.style.textDecoration='underline'"
                     onmouseout="this.style.textDecoration='none'">
                    <?= $nombre ?>
                  </a>
                </div>
              </td>
              <td class="text-muted"><?= htmlspecialchars($doc['tamano']) ?></td>
              <td class="text-muted"><?= htmlspecialchars($doc['fecha']) ?></td>
              <td style="text-align:right">
                <a class="btn-icon" href="documentos/<?= $nombre ?>" download title="Descargar">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                </a>
                <a class="btn-icon" href="documentos/<?= $nombre ?>" target="_blank" title="Ver en nueva pestaña">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                </a>
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
const docCount   = document.getElementById('doc-count');

let pagActual   = 1;
let porPagina   = parseInt(showCount.value);
let filtroTexto = '';

function filas() { return Array.from(tbody.querySelectorAll('tr')); }

function filtrar() {
    filas().forEach(function(tr) {
        var nombre = tr.dataset.nombre || '';
        tr.hidden = filtroTexto !== '' && !nombre.includes(filtroTexto);
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

    docCount.textContent = total + ' documento' + (total !== 1 ? 's' : '');
    tableInfo.textContent = total === 0
        ? 'Sin documentos'
        : 'Mostrando ' + (inicio + 1) + '–' + fin + ' de ' + total + ' documentos';

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
