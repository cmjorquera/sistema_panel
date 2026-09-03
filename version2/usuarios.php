<?php
require_once 'class/Sesion.php';
require_once 'class/Conexion.php';
Sesion::requerir();

$titulo_pagina     = 'Usuarios';
$breadcrumb_actual = 'Usuarios';
$pagina_actual     = 'usuarios';

$usuarios = [];
$areas    = [];
try {
    $db = Conexion::obtener();

    $r = $db->query(
        "SELECT u.id, u.nombre, u.apellido_paterno, u.apellido_materno,
                u.email, u.cargo, u.telefono, u.sexo, u.estado,
                u.anexo, u.id_area_trabajo, u.identificador,
                COALESCE(u.fecha_nacimiento,'') AS fecha_nacimiento,
                COALESCE(a.nombre_area,'—') AS nombre_area,
                DATE_FORMAT(u.fecha_creacion,'%d/%m/%Y') AS fecha_creacion
         FROM usuarios u
         LEFT JOIN area_trabajo a ON a.id_area = u.id_area_trabajo
         ORDER BY u.nombre ASC"
    );
    if ($r) {
        while ($row = $r->fetch_assoc()) {
            $usuarios[] = $row;
        }
    }

    $r2 = $db->query("SELECT id_area, nombre_area FROM area_trabajo ORDER BY nombre_area ASC");
    if ($r2) {
        while ($row = $r2->fetch_assoc()) {
            $areas[] = $row;
        }
    }
} catch (Exception $e) {}

include 'componentes/head.php';
?>
<div id="app">
<?php include 'componentes/sidebar.php'; ?>
<div id="mobile-overlay" onclick="closeMobileSidebar()"></div>
<div id="main">
<?php include 'componentes/topbar.php'; ?>
<div id="content">

  <!-- Page header -->
  <div class="page-header">
    <div>
      <h1>Gestión de usuarios</h1>
      <p>Administra usuarios, áreas y accesos al sistema.</p>
    </div>
    <button class="btn btn-primary" onclick="abrirModalUsuario()">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
      </svg>
      Nuevo usuario
    </button>
  </div>

  <!-- Card con tabla -->
  <div class="card">
    <!-- Toolbar: filtros + búsqueda -->
    <div class="toolbar" style="flex-wrap:wrap;gap:10px">
      <div style="display:flex;gap:6px;flex-wrap:wrap">
        <button class="btn btn-sm btn-primary" id="filtro-todos"   onclick="aplicarFiltroEstado('todos')">Todos</button>
        <button class="btn btn-sm btn-outline" id="filtro-activo"   onclick="aplicarFiltroEstado('Activo')">Activo</button>
        <button class="btn btn-sm btn-outline" id="filtro-inactivo" onclick="aplicarFiltroEstado('Inactivo')">Inactivo</button>
        <button class="btn btn-sm btn-outline" id="filtro-pendiente"onclick="aplicarFiltroEstado('Pendiente')">Pendiente</button>
        <button class="btn btn-sm btn-outline" id="filtro-bloqueado"onclick="aplicarFiltroEstado('Bloqueado')">Bloqueado</button>
      </div>
      <div style="display:flex;align-items:center;gap:12px;margin-left:auto">
        <div class="input-icon-wrap" style="width:260px">
          <svg class="icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
          </svg>
          <input type="text" class="input" id="usr-search" placeholder="Buscar por nombre o correo…" oninput="aplicarFiltroBusqueda(this.value)"/>
        </div>
        <span class="toolbar-count" id="usr-count" style="white-space:nowrap">— usuarios</span>
      </div>
    </div>

    <!-- Tabla -->
    <div class="table-wrap">
      <table id="usr-table">
        <thead>
          <tr>
            <th>Usuario</th>
            <th>Cargo</th>
            <th>Área</th>
            <th>Estado</th>
            <th style="text-align:right">Acciones</th>
          </tr>
        </thead>
        <tbody id="usr-tbody">
          <tr><td colspan="5" style="text-align:center;padding:32px;color:var(--muted)">Cargando…</td></tr>
        </tbody>
      </table>
    </div>

    <!-- Paginación -->
    <div id="usr-pagination" style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-top:1px solid var(--border);">
      <span id="usr-page-info" style="font-size:12px;color:var(--muted)"></span>
      <div id="usr-page-btns" style="display:flex;gap:4px"></div>
    </div>
  </div>

</div><!-- /content -->
</div><!-- /main -->
</div><!-- /app -->

<!-- ═══════════════════════════════════════
     MODAL: Crear / Editar usuario
════════════════════════════════════════ -->
<div class="modal-overlay" id="modal-usuario" onclick="closeModalOutside(event,'modal-usuario')">
  <div class="modal" style="max-width:560px">
    <div class="modal-header">
      <h3 id="modal-usr-titulo">Nuevo usuario</h3>
      <p id="modal-usr-desc">Completa los datos del nuevo usuario. Se enviará un correo para que establezca su contraseña.</p>
    </div>
    <div class="modal-body" style="padding-bottom:8px">

      <div id="modal-usr-status" style="display:none;padding:10px 14px;border-radius:var(--radius);font-size:13px;margin-bottom:14px"></div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
        <div>
          <label class="field-label">Nombre <span style="color:var(--danger)">*</span></label>
          <input type="text" class="input" id="usr-nombre" placeholder="Nombre"/>
        </div>
        <div>
          <label class="field-label">Apellido paterno <span style="color:var(--danger)">*</span></label>
          <input type="text" class="input" id="usr-apPat" placeholder="Apellido paterno"/>
        </div>
        <div>
          <label class="field-label">Apellido materno</label>
          <input type="text" class="input" id="usr-apMat" placeholder="Apellido materno"/>
        </div>
        <div>
          <label class="field-label">Correo electrónico <span style="color:var(--danger)">*</span></label>
          <input type="email" class="input" id="usr-email" placeholder="correo@seduc.cl"/>
        </div>
        <div>
          <label class="field-label">Cargo</label>
          <input type="text" class="input" id="usr-cargo" placeholder="Ej: Analista"/>
        </div>
        <div>
          <label class="field-label">Área de trabajo <span style="color:var(--danger)">*</span></label>
          <select class="input" id="usr-area">
            <option value="">Seleccionar área…</option>
            <?php foreach ($areas as $a): ?>
            <option value="<?= (int)$a['id_area'] ?>"><?= htmlspecialchars($a['nombre_area']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div>
          <label class="field-label">Teléfono</label>
          <input type="text" class="input" id="usr-telefono" placeholder="+56 9 xxxx xxxx"/>
        </div>
        <div>
          <label class="field-label">Sexo</label>
          <select class="input" id="usr-sexo">
            <option value="">Seleccionar…</option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
            <option value="Otro">Prefiero no indicar</option>
          </select>
        </div>
        <div>
          <label class="field-label">Fecha de nacimiento</label>
          <input type="date" class="input" id="usr-fechaNac"/>
        </div>
        <div>
          <label class="field-label">Anexo</label>
          <input type="text" class="input" id="usr-anexo" placeholder="Ej: 201"/>
        </div>
        <div style="grid-column:1/-1">
          <label class="field-label">Identificador (RUT u otro)</label>
          <input type="text" class="input" id="usr-identif" placeholder="Ej: 12.345.678-9"/>
        </div>
        <!-- Campo estado solo visible en modo editar -->
        <div id="campo-estado" style="grid-column:1/-1;display:none">
          <label class="field-label">Estado</label>
          <select class="input" id="usr-estado">
            <option value="Activo">Activo</option>
            <option value="Inactivo">Inactivo</option>
            <option value="Pendiente">Pendiente</option>
            <option value="Bloqueado">Bloqueado</option>
          </select>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeModal('modal-usuario')">Cancelar</button>
      <button class="btn btn-primary" id="btn-guardar-usr" onclick="guardarUsuario()">Crear usuario</button>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════
     MODAL: Reenviar correo de bienvenida
════════════════════════════════════════ -->
<div class="modal-overlay" id="modal-reenviar" onclick="closeModalOutside(event,'modal-reenviar')">
  <div class="modal" style="max-width:420px">
    <div class="modal-header">
      <h3>Reenviar correo de bienvenida</h3>
      <p id="modal-reenv-desc">¿Deseas reenviar el correo de bienvenida a este usuario?</p>
    </div>
    <div class="modal-body">
      <div id="modal-reenv-status" style="display:none;padding:10px 14px;border-radius:var(--radius);font-size:13px"></div>
      <p style="font-size:13px;color:var(--muted)">El usuario recibirá un enlace para establecer o restablecer su contraseña.</p>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeModal('modal-reenviar')">No</button>
      <button class="btn btn-primary" id="btn-reenviar" onclick="confirmarReenvio()">Sí, reenviar</button>
    </div>
  </div>
</div>

<?php include 'componentes/scripts.php'; ?>

<script>
/* ─── Datos desde PHP ─────────────────────────────────────── */
var USR_DATA  = <?= json_encode(array_values($usuarios), JSON_UNESCAPED_UNICODE) ?>;
var USR_AREAS = <?= json_encode(array_values($areas),    JSON_UNESCAPED_UNICODE) ?>;

/* ─── Estado interno ──────────────────────────────────────── */
var _usrModo       = 'crear';
var _usrIdActual   = null;
var _usrReenvId    = null;
var _filtroEstado  = 'todos';
var _filtroBusqueda = '';
var _paginaActual  = 1;
var _porPagina     = 10;
var _datosFiltrados = [];

/* ─── Inicialización ──────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function() {
    aplicarFiltros();
});

/* ─── Filtros ─────────────────────────────────────────────── */

/** Aplica el filtro de estado y actualiza los botones. */
function aplicarFiltroEstado(estado) {
    _filtroEstado = estado;
    _paginaActual = 1;
    document.querySelectorAll('[id^="filtro-"]').forEach(function(btn) {
        btn.className = 'btn btn-sm btn-outline';
    });
    var activo = document.getElementById('filtro-' + (estado === 'todos' ? 'todos' : estado.toLowerCase()));
    if (activo) activo.className = 'btn btn-sm btn-primary';
    aplicarFiltros();
}

/** Aplica el filtro de texto libre. */
function aplicarFiltroBusqueda(q) {
    _filtroBusqueda = q.toLowerCase().trim();
    _paginaActual = 1;
    aplicarFiltros();
}

/** Combina ambos filtros y re-renderiza. */
function aplicarFiltros() {
    _datosFiltrados = USR_DATA.filter(function(u) {
        var pasaEstado = _filtroEstado === 'todos' || u.estado === _filtroEstado;
        var q = _filtroBusqueda;
        var pasaBusqueda = q === '' ||
            (u.nombre + ' ' + u.apellido_paterno + ' ' + u.apellido_materno).toLowerCase().includes(q) ||
            (u.email || '').toLowerCase().includes(q) ||
            (u.cargo || '').toLowerCase().includes(q) ||
            (u.nombre_area || '').toLowerCase().includes(q);
        return pasaEstado && pasaBusqueda;
    });
    renderizarTabla();
    renderizarPaginacion();
    document.getElementById('usr-count').textContent = _datosFiltrados.length + ' usuario' + (_datosFiltrados.length !== 1 ? 's' : '');
}

/* ─── Renderizado de tabla ────────────────────────────────── */

/** Escapa HTML para inserción segura. */
function esc(str) {
    return String(str || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

/** Devuelve las iniciales de un nombre completo (máx. 2 letras). */
function iniciales(nombre, apPat) {
    var n = (nombre  || '').trim().charAt(0).toUpperCase();
    var a = (apPat   || '').trim().charAt(0).toUpperCase();
    return n + a;
}

/** Clase CSS para el badge según estado. */
function badgeClase(estado) {
    var m = { 'Activo':'active', 'Inactivo':'inactivo', 'Pendiente':'pendiente', 'Bloqueado':'bloqueado' };
    return 'badge badge-' + (m[estado] || 'inactivo');
}

/** Renderiza las filas correspondientes a la página actual. */
function renderizarTabla() {
    var inicio  = (_paginaActual - 1) * _porPagina;
    var fin     = inicio + _porPagina;
    var pagina  = _datosFiltrados.slice(inicio, fin);
    var tbody   = document.getElementById('usr-tbody');

    if (pagina.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;padding:40px;color:var(--muted)">No se encontraron usuarios.</td></tr>';
        return;
    }

    tbody.innerHTML = pagina.map(function(u) {
        var nombreCompleto = esc(u.nombre + ' ' + u.apellido_paterno + (u.apellido_materno ? ' ' + u.apellido_materno : ''));
        return '<tr data-usr-id="' + u.id + '">' +
            '<td>' +
              '<div style="display:flex;align-items:center;gap:10px">' +
                '<div class="user-avatar">' + iniciales(u.nombre, u.apellido_paterno) + '</div>' +
                '<div style="min-width:0">' +
                  '<p class="font-medium truncate" style="max-width:200px">' + nombreCompleto + '</p>' +
                  '<p class="text-xs text-muted truncate" style="max-width:200px">' + esc(u.email) + '</p>' +
                '</div>' +
              '</div>' +
            '</td>' +
            '<td class="text-muted">' + esc(u.cargo || '—') + '</td>' +
            '<td class="text-muted">' + esc(u.nombre_area || '—') + '</td>' +
            '<td><span class="' + badgeClase(u.estado) + '">' + esc(u.estado) + '</span></td>' +
            '<td style="text-align:right">' +
              '<button class="btn-icon" title="Reenviar correo de bienvenida" onclick="abrirModalReenviar(' + u.id + ',\'' + esc(u.nombre) + ' ' + esc(u.apellido_paterno) + '\')">' +
                '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>' +
              '</button>' +
              '<button class="btn-icon" title="Editar usuario" onclick="abrirModalUsuarioEditar(' + u.id + ')">' +
                '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>' +
              '</button>' +
              '<button class="btn-danger-ghost" title="Eliminar usuario" onclick="eliminarUsuario(' + u.id + ',\'' + esc(u.nombre) + ' ' + esc(u.apellido_paterno) + '\')">' +
                '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>' +
              '</button>' +
            '</td>' +
        '</tr>';
    }).join('');
}

/** Renderiza los botones de paginación. */
function renderizarPaginacion() {
    var total   = _datosFiltrados.length;
    var paginas = Math.ceil(total / _porPagina);
    var inicio  = total === 0 ? 0 : (_paginaActual - 1) * _porPagina + 1;
    var fin     = Math.min(_paginaActual * _porPagina, total);

    document.getElementById('usr-page-info').textContent =
        total === 0 ? '' : 'Mostrando ' + inicio + '–' + fin + ' de ' + total;

    var wrap = document.getElementById('usr-page-btns');
    if (paginas <= 1) { wrap.innerHTML = ''; return; }

    var btns = '';
    btns += '<button class="btn btn-sm ' + (_paginaActual === 1 ? 'btn-outline" disabled' : 'btn-outline"') +
            ' onclick="cambiarPagina(' + (_paginaActual - 1) + ')">‹</button>';

    for (var p = 1; p <= paginas; p++) {
        if (paginas > 7 && p > 2 && p < paginas - 1 && Math.abs(p - _paginaActual) > 1) {
            if (p === 3 || p === paginas - 2) btns += '<span style="padding:0 4px;color:var(--muted)">…</span>';
            continue;
        }
        btns += '<button class="btn btn-sm ' + (p === _paginaActual ? 'btn-primary' : 'btn-outline') +
                '" onclick="cambiarPagina(' + p + ')">' + p + '</button>';
    }

    btns += '<button class="btn btn-sm ' + (_paginaActual === paginas ? 'btn-outline" disabled' : 'btn-outline"') +
            ' onclick="cambiarPagina(' + (_paginaActual + 1) + ')">›</button>';

    wrap.innerHTML = btns;
}

/** Cambia a la página indicada y re-renderiza. */
function cambiarPagina(p) {
    var paginas = Math.ceil(_datosFiltrados.length / _porPagina);
    if (p < 1 || p > paginas) return;
    _paginaActual = p;
    renderizarTabla();
    renderizarPaginacion();
}

/* ─── Modal crear/editar ──────────────────────────────────── */

/** Limpia todos los campos del modal. */
function _limpiarModalUsr() {
    ['usr-nombre','usr-apPat','usr-apMat','usr-email','usr-cargo',
     'usr-area','usr-telefono','usr-sexo','usr-fechaNac','usr-anexo','usr-identif','usr-estado'
    ].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) el.value = '';
    });
    var st = document.getElementById('modal-usr-status');
    st.style.display = 'none';
    st.textContent = '';
}

/** Abre el modal en modo crear. */
function abrirModalUsuario() {
    _usrModo      = 'crear';
    _usrIdActual  = null;
    _limpiarModalUsr();
    document.getElementById('modal-usr-titulo').textContent = 'Nuevo usuario';
    document.getElementById('modal-usr-desc').textContent   = 'Completa los datos. Se enviará un correo para que el usuario establezca su contraseña.';
    document.getElementById('btn-guardar-usr').textContent  = 'Crear usuario';
    document.getElementById('campo-estado').style.display   = 'none';
    openModal('modal-usuario');
}

/** Abre el modal en modo editar con los datos del usuario. */
function abrirModalUsuarioEditar(id) {
    var u = USR_DATA.find(function(x) { return x.id == id; });
    if (!u) return;

    _usrModo     = 'editar';
    _usrIdActual = id;
    _limpiarModalUsr();

    document.getElementById('usr-nombre').value   = u.nombre           || '';
    document.getElementById('usr-apPat').value    = u.apellido_paterno || '';
    document.getElementById('usr-apMat').value    = u.apellido_materno || '';
    document.getElementById('usr-email').value    = u.email            || '';
    document.getElementById('usr-cargo').value    = u.cargo            || '';
    document.getElementById('usr-area').value     = u.id_area_trabajo  || '';
    document.getElementById('usr-telefono').value = u.telefono         || '';
    document.getElementById('usr-sexo').value     = u.sexo             || '';
    document.getElementById('usr-fechaNac').value = u.fecha_nacimiento || '';
    document.getElementById('usr-anexo').value    = u.anexo            || '';
    document.getElementById('usr-identif').value  = u.identificador    || '';
    document.getElementById('usr-estado').value   = u.estado           || 'Activo';

    document.getElementById('modal-usr-titulo').textContent = 'Editar usuario';
    document.getElementById('modal-usr-desc').textContent   = 'Modifica los datos del usuario.';
    document.getElementById('btn-guardar-usr').textContent  = 'Guardar cambios';
    document.getElementById('campo-estado').style.display   = '';
    openModal('modal-usuario');
}

/** Muestra un mensaje de estado en el modal. */
function _statusModalUsr(msg, tipo) {
    var el = document.getElementById('modal-usr-status');
    el.textContent  = msg;
    el.style.display = 'block';
    el.style.background = tipo === 'ok'
        ? 'var(--success-light)' : 'var(--danger-light)';
    el.style.color = tipo === 'ok'
        ? 'var(--success)' : 'var(--danger)';
    el.style.border = '1px solid ' + (tipo === 'ok'
        ? 'rgba(60,141,47,.2)' : 'rgba(192,57,43,.2)');
}

/** Envía el formulario al servidor (crear o editar). */
function guardarUsuario() {
    var btn = document.getElementById('btn-guardar-usr');
    var fd  = new FormData();

    fd.append('nombre',           document.getElementById('usr-nombre').value.trim());
    fd.append('apellido_paterno', document.getElementById('usr-apPat').value.trim());
    fd.append('apellido_materno', document.getElementById('usr-apMat').value.trim());
    fd.append('email',            document.getElementById('usr-email').value.trim());
    fd.append('cargo',            document.getElementById('usr-cargo').value.trim());
    fd.append('id_area_trabajo',  document.getElementById('usr-area').value);
    fd.append('telefono',         document.getElementById('usr-telefono').value.trim());
    fd.append('sexo',             document.getElementById('usr-sexo').value);
    fd.append('fecha_nacimiento', document.getElementById('usr-fechaNac').value);
    fd.append('anexo',            document.getElementById('usr-anexo').value.trim());
    fd.append('identificador',    document.getElementById('usr-identif').value.trim());

    var endpoint = 'ajax/guardar_usuario.php';
    if (_usrModo === 'editar' && _usrIdActual) {
        fd.append('id',     _usrIdActual);
        fd.append('estado', document.getElementById('usr-estado').value);
        endpoint = 'ajax/actualizar_usuario.php';
    }

    btn.disabled    = true;
    btn.textContent = 'Guardando…';

    fetch(endpoint, { method: 'POST', body: fd })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (!data.ok) throw new Error(data.message || 'Error desconocido.');
            _statusModalUsr(data.message, 'ok');

            if (_usrModo === 'crear') {
                data.usuario.nombre_area = _nombreArea(data.usuario.id_area_trabajo);
                USR_DATA.push(data.usuario);
            } else {
                var idx = USR_DATA.findIndex(function(x) { return x.id == _usrIdActual; });
                if (idx !== -1) {
                    data.usuario.fecha_creacion = USR_DATA[idx].fecha_creacion;
                    USR_DATA[idx] = data.usuario;
                }
            }
            aplicarFiltros();
            setTimeout(function() { closeModal('modal-usuario'); }, 1000);
        })
        .catch(function(err) {
            _statusModalUsr(err.message, 'error');
        })
        .finally(function() {
            btn.disabled    = false;
            btn.textContent = _usrModo === 'crear' ? 'Crear usuario' : 'Guardar cambios';
        });
}

/** Devuelve el nombre del área a partir de su id. */
function _nombreArea(idArea) {
    var a = USR_AREAS.find(function(x) { return x.id_area == idArea; });
    return a ? a.nombre_area : '—';
}

/* ─── Eliminar usuario ────────────────────────────────────── */

/** Pide confirmación y elimina el usuario. */
function eliminarUsuario(id, nombre) {
    if (!confirm('¿Eliminar al usuario "' + nombre + '"? Esta acción no se puede deshacer.')) return;

    var fd = new FormData();
    fd.append('id', id);

    fetch('ajax/eliminar_usuario.php', { method: 'POST', body: fd })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (!data.ok) throw new Error(data.message);
            USR_DATA = USR_DATA.filter(function(u) { return u.id != id; });
            aplicarFiltros();
        })
        .catch(function(err) {
            alert('Error al eliminar: ' + err.message);
        });
}

/* ─── Reenviar correo de bienvenida ──────────────────────── */

/** Abre el modal de confirmación para reenviar el correo. */
function abrirModalReenviar(id, nombre) {
    _usrReenvId = id;
    document.getElementById('modal-reenv-desc').textContent =
        '¿Reenviar el correo de bienvenida a ' + nombre + '?';
    var st = document.getElementById('modal-reenv-status');
    st.style.display = 'none';
    st.textContent   = '';
    document.getElementById('btn-reenviar').disabled    = false;
    document.getElementById('btn-reenviar').textContent = 'Sí, reenviar';
    openModal('modal-reenviar');
}

/** Confirma y envía el correo de bienvenida. */
function confirmarReenvio() {
    if (!_usrReenvId) return;
    var btn = document.getElementById('btn-reenviar');
    var st  = document.getElementById('modal-reenv-status');
    btn.disabled    = true;
    btn.textContent = 'Enviando…';

    var fd = new FormData();
    fd.append('id', _usrReenvId);

    fetch('ajax/reenviar_bienvenida.php', { method: 'POST', body: fd })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            st.textContent   = data.message;
            st.style.display = 'block';
            st.style.background = data.ok ? 'var(--success-light)' : 'var(--danger-light)';
            st.style.color      = data.ok ? 'var(--success)'       : 'var(--danger)';
            st.style.border     = '1px solid ' + (data.ok ? 'rgba(60,141,47,.2)' : 'rgba(192,57,43,.2)');
            st.style.borderRadius = 'var(--radius)';
            st.style.padding   = '10px 14px';
            st.style.fontSize  = '13px';
            if (data.ok) setTimeout(function() { closeModal('modal-reenviar'); }, 1500);
        })
        .catch(function(err) {
            st.textContent    = err.message;
            st.style.display  = 'block';
            st.style.background = 'var(--danger-light)';
            st.style.color      = 'var(--danger)';
        })
        .finally(function() {
            btn.disabled    = false;
            btn.textContent = 'Sí, reenviar';
        });
}
</script>
</body>
</html>
