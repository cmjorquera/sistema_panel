<?php
require_once 'class/Sesion.php';
require_once 'class/Conexion.php';
Sesion::requerir();

$titulo_pagina     = 'Contenedores';
$breadcrumb_actual = 'Contenedores';
$pagina_actual     = 'contenedores';

$idUsuario = (int)(Sesion::get('usuario_id') ?? 1);

$contenedores = [];
try {
    $db   = Conexion::obtener();
    $stmt = $db->prepare(
        'SELECT id, nombre, url_, imagen FROM contenedor WHERE id_usuario = ? ORDER BY id ASC'
    );
    if ($stmt) {
        $stmt->bind_param('i', $idUsuario);
        $stmt->execute();
        $r = $stmt->get_result();
        while ($r && $row = $r->fetch_assoc()) $contenedores[] = $row;
        $stmt->close();
    }
} catch (Exception $e) {}

/** Construye el src de la imagen soportando rutas con subcarpetas. */
function tileImagen(string $imagen): string {
    $imagen = trim($imagen);
    if ($imagen === '' || strpos($imagen, '..') !== false) {
        return '../imagenes/google.png';
    }
    $imagen     = ltrim($imagen, '/');
    $rutaFisica = __DIR__ . '/../imagenes/' . $imagen;
    if (!is_file($rutaFisica)) {
        return '../imagenes/google.png';
    }
    return '../imagenes/' . implode('/', array_map('rawurlencode', explode('/', $imagen)));
}

function tileUrl(string $url): string {
    $url = trim($url);
    if ($url === '') return '#';
    if (!preg_match('~^[a-z][a-z0-9+.\-]*://~i', $url)) return 'https://' . ltrim($url, '/');
    return $url;
}

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
      <h1>Mis contenedores</h1>
      <p>Accesos directos configurados para <?= htmlspecialchars(Sesion::get('usuario_nombre') ?? '') ?>.</p>
    </div>
    <button class="btn btn-primary" onclick="abrirModalNuevo()">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Nuevo contenedor
    </button>
  </div>

  <!-- Buscador -->
  <div style="margin-bottom:20px;max-width:380px">
    <div class="input-icon-wrap">
      <svg class="icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      <input type="text" class="input" id="tile-search" placeholder="Buscar acceso..." oninput="filtrarTiles(this.value)"/>
    </div>
  </div>

  <?php if (empty($contenedores)): ?>
  <div style="text-align:center;padding:64px 24px">
    <div style="width:64px;height:64px;border-radius:16px;background:var(--blue-light);display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
    </div>
    <p style="font-size:15px;font-weight:600;color:var(--fg)">Sin contenedores aún</p>
    <p style="font-size:13px;color:var(--muted);margin-top:6px">Agrega tu primer acceso directo con el botón de arriba.</p>
  </div>

  <?php else: ?>
  <div class="tiles-grid" id="tiles-grid">
    <?php foreach ($contenedores as $c):
      $nombre   = htmlspecialchars($c['nombre'] ?? 'Sin nombre', ENT_QUOTES, 'UTF-8');
      $href     = htmlspecialchars(tileUrl($c['url_'] ?? ''), ENT_QUOTES, 'UTF-8');
      $src      = htmlspecialchars(tileImagen($c['imagen'] ?? ''), ENT_QUOTES, 'UTF-8');
      $id       = (int)$c['id'];
      $imagenJs = htmlspecialchars($c['imagen'] ?? '', ENT_QUOTES, 'UTF-8');
      $urlJs    = htmlspecialchars($c['url_']   ?? '', ENT_QUOTES, 'UTF-8');
    ?>
    <div class="tile-card" data-nombre="<?= strtolower($c['nombre'] ?? '') ?>">
      <div class="tile-actions">
        <button class="tile-menu-btn" onclick="toggleTileMenu(this)" title="Opciones">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/></svg>
        </button>
        <div class="tile-menu">
          <button class="tile-menu-item" onclick="editarContenedor(<?= $id ?>, '<?= $nombre ?>', '<?= $urlJs ?>', '<?= $imagenJs ?>')">Editar</button>
          <button class="tile-menu-item tile-menu-item--danger" onclick="eliminarContenedor(<?= $id ?>)">Eliminar</button>
        </div>
      </div>
      <a href="<?= $href ?>" target="_blank" rel="noopener noreferrer" class="tile-link" title="<?= $nombre ?>">
        <div class="tile-img-wrap">
          <img src="<?= $src ?>" alt="<?= $nombre ?>" onerror="this.src='../imagenes/google.png'"/>
        </div>
        <p class="tile-name"><?= $nombre ?></p>
      </a>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

</div><!-- /content -->
</div><!-- /main -->
</div><!-- /app -->

<!-- ═══════════════════════════════════════
     MODAL: Crear / Editar contenedor
════════════════════════════════════════ -->
<div class="modal-overlay" id="modal-nuevo-contenedor" onclick="closeModalOutside(event,'modal-nuevo-contenedor')">
  <div class="modal" style="max-width:480px">
    <div class="modal-header">
      <h3 id="modal-contenedor-titulo">Nuevo contenedor</h3>
      <p>Agrega un acceso directo a tu panel.</p>
    </div>
    <div class="modal-body">
      <div id="form-status" style="display:none;padding:10px 14px;border-radius:var(--radius);font-size:13px;margin-bottom:14px"></div>
      <form id="form-contenedor" enctype="multipart/form-data">
        <input type="hidden" name="accion" id="form-accion" value="guardar"/>
        <input type="hidden" name="id"     id="form-id"     value=""/>

        <div style="margin-bottom:14px">
          <label class="field-label">Nombre <span style="color:var(--danger)">*</span></label>
          <input class="input" name="nombre" id="form-nombre" placeholder="Ej: SIGE" required/>
        </div>

        <div style="margin-bottom:14px">
          <label class="field-label">URL <span style="color:var(--danger)">*</span></label>
          <input class="input" name="url" id="form-url" placeholder="https://..." required/>
        </div>

        <div style="margin-bottom:14px">
          <label class="field-label">Imagen</label>
          <input class="input" name="imagen_file" id="form-imagen-file" type="file"
                 accept="image/jpeg,image/png,image/gif,image/webp"
                 onchange="previsualizarImagenContenedor(this)"
                 style="padding:8px 12px;background:#f9fafb;border-style:dashed;cursor:pointer"/>
          <p style="font-size:11px;color:var(--muted);margin-top:5px">
            JPG, PNG, GIF o WEBP. Si no adjuntas imagen se usará la predeterminada.
          </p>
          <!-- Preview de imagen -->
          <div id="img-preview-wrap" style="display:none;margin-top:10px;border:1px solid var(--border);border-radius:var(--radius);padding:10px;background:var(--bg);display:none">
            <img id="img-preview" src="" alt="Vista previa"
                 style="max-height:100px;max-width:100%;border-radius:6px;object-fit:contain;display:block"/>
            <p id="img-preview-name" style="font-size:11px;color:var(--muted);margin-top:6px;margin-bottom:0"></p>
          </div>
        </div>

      </form>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" type="button" onclick="closeModal('modal-nuevo-contenedor')">Cancelar</button>
      <button class="btn btn-primary" id="btn-guardar-contenedor" type="button" onclick="submitContenedor()">Guardar</button>
    </div>
  </div>
</div>

<style>
.tiles-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(130px,1fr));gap:16px;}
@media(max-width:768px){.tiles-grid{grid-template-columns:repeat(auto-fill,minmax(100px,1fr));gap:12px;}}
.tile-card{position:relative;border-radius:var(--radius);background:var(--card);border:1px solid var(--border);box-shadow:var(--shadow-card);transition:box-shadow var(--transition),border-color var(--transition);text-align:center;}
.tile-card:hover{box-shadow:var(--shadow-elevated);border-color:var(--blue);}
.tile-link{display:flex;flex-direction:column;align-items:center;padding:20px 12px 16px;text-decoration:none;color:var(--fg);}
.tile-img-wrap{width:56px;height:56px;border-radius:12px;background:var(--bg);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;overflow:hidden;margin-bottom:10px;flex-shrink:0;}
.tile-img-wrap img{width:40px;height:40px;object-fit:contain;}
.tile-name{font-size:12px;font-weight:500;color:var(--fg);line-height:1.3;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;word-break:break-word;}
.tile-actions{position:absolute;top:6px;right:6px;z-index:10;}
.tile-menu-btn{width:24px;height:24px;border:none;background:none;border-radius:5px;cursor:pointer;color:var(--muted);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity var(--transition),background var(--transition);}
.tile-card:hover .tile-menu-btn{opacity:1;}
.tile-menu-btn:hover{background:var(--bg);color:var(--fg);}
.tile-menu{position:absolute;right:0;top:calc(100% + 4px);background:var(--card);border:1px solid var(--border);border-radius:var(--radius);box-shadow:0 8px 24px -4px rgba(0,0,0,.12);min-width:130px;display:none;padding:4px;z-index:50;}
.tile-menu.open{display:block;}
.tile-menu-item{display:block;width:100%;padding:7px 12px;font-size:12px;background:none;border:none;text-align:left;border-radius:5px;cursor:pointer;color:var(--fg);transition:background var(--transition);}
.tile-menu-item:hover{background:var(--bg);}
.tile-menu-item--danger{color:var(--danger);}
.tile-card.hidden{display:none;}
</style>

<?php include 'componentes/scripts.php'; ?>
<script>
/* ─── Filtro ──────────────────────────────────────────────────────── */
function filtrarTiles(q) {
    q = q.toLowerCase().trim();
    document.querySelectorAll('.tile-card').forEach(function(card) {
        card.classList.toggle('hidden', q !== '' && !(card.dataset.nombre ?? '').includes(q));
    });
}

/* ─── Menú 3 puntos ───────────────────────────────────────────────── */
function toggleTileMenu(btn) {
    var menu = btn.nextElementSibling;
    document.querySelectorAll('.tile-menu.open').forEach(function(m) { if (m !== menu) m.classList.remove('open'); });
    menu.classList.toggle('open');
}
document.addEventListener('click', function(e) {
    if (!e.target.closest('.tile-actions')) {
        document.querySelectorAll('.tile-menu.open').forEach(function(m) { m.classList.remove('open'); });
    }
});

/* ─── Preview imagen ──────────────────────────────────────────────── */
function previsualizarImagenContenedor(input) {
    var wrap = document.getElementById('img-preview-wrap');
    var img  = document.getElementById('img-preview');
    var name = document.getElementById('img-preview-name');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            img.src  = e.target.result;
            name.textContent = input.files[0].name;
            wrap.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

/* ─── Limpiar modal ───────────────────────────────────────────────── */
function _limpiarModalContenedor() {
    document.getElementById('form-accion').value  = 'guardar';
    document.getElementById('form-id').value      = '';
    document.getElementById('form-nombre').value  = '';
    document.getElementById('form-url').value     = '';
    document.getElementById('form-imagen-file').value = '';
    var wrap = document.getElementById('img-preview-wrap');
    wrap.style.display = 'none';
    var st = document.getElementById('form-status');
    st.style.display = 'none';
    st.textContent = '';
    var btn = document.getElementById('btn-guardar-contenedor');
    btn.disabled = false;
    btn.textContent = 'Guardar';
}

/* ─── Abrir modal modo crear ──────────────────────────────────────── */
function abrirModalNuevo() {
    _limpiarModalContenedor();
    document.getElementById('modal-contenedor-titulo').textContent = 'Nuevo contenedor';
    openModal('modal-nuevo-contenedor');
}

/* ─── Abrir modal modo editar ─────────────────────────────────────── */
function editarContenedor(id, nombre, url, imagenActual) {
    _limpiarModalContenedor();
    document.getElementById('modal-contenedor-titulo').textContent = 'Editar contenedor';
    document.getElementById('form-accion').value = 'actualizar';
    document.getElementById('form-id').value     = id;
    document.getElementById('form-nombre').value = nombre;
    document.getElementById('form-url').value    = url;

    /* Muestra la imagen actual en el preview si existe */
    if (imagenActual) {
        var wrap = document.getElementById('img-preview-wrap');
        var img  = document.getElementById('img-preview');
        var name = document.getElementById('img-preview-name');
        img.src  = '../imagenes/' + imagenActual.split('/').map(encodeURIComponent).join('/');
        img.onerror = function() { wrap.style.display = 'none'; };
        name.textContent = 'Imagen actual: ' + imagenActual.split('/').pop();
        wrap.style.display = 'block';
    }
    openModal('modal-nuevo-contenedor');
}

/* ─── Enviar formulario (crea o actualiza) ────────────────────────── */
function submitContenedor() {
    var btn = document.getElementById('btn-guardar-contenedor');
    var st  = document.getElementById('form-status');

    btn.disabled    = true;
    btn.textContent = 'Guardando…';
    st.style.display = 'none';

    var fd = new FormData(document.getElementById('form-contenedor'));

    fetch('ajax/contenedores_ajax.php', { method: 'POST', body: fd })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.ok) {
                location.reload();
            } else {
                st.textContent    = data.error ?? 'Error desconocido.';
                st.style.display  = 'block';
                st.style.background = 'var(--danger-light)';
                st.style.color      = 'var(--danger)';
                st.style.border     = '1px solid rgba(192,57,43,.2)';
            }
        })
        .catch(function(err) {
            st.textContent    = err.message;
            st.style.display  = 'block';
            st.style.background = 'var(--danger-light)';
            st.style.color      = 'var(--danger)';
        })
        .finally(function() {
            btn.disabled    = false;
            btn.textContent = 'Guardar';
        });
}

/* ─── Eliminar contenedor ─────────────────────────────────────────── */
function eliminarContenedor(id) {
    if (!confirm('¿Eliminar este contenedor?')) return;
    var fd = new FormData();
    fd.append('accion', 'eliminar');
    fd.append('id', id);
    fetch('ajax/contenedores_ajax.php', { method: 'POST', body: fd })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.ok) location.reload();
            else alert('Error al eliminar: ' + (data.error ?? ''));
        });
}
</script>
</body>
</html>
