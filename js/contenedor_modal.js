/* Estado interno del modal */
var _contenedorModo = 'crear';   /* 'crear' o 'editar' */
var _contenedorIdActual = null;  /* ID del contenedor que se está editando */

/**
 * Abre el modal en modo CREAR: limpia el formulario y ajusta los textos.
 */
function abrirModalContenedor() {
    _contenedorModo = 'crear';
    _contenedorIdActual = null;

    _limpiarFormularioContenedor();

    document.querySelector('.contenedor-modal__eyebrow').textContent = 'Nuevo acceso';
    document.querySelector('#contenedorModalTitle').textContent = 'Crear contenedor';

    document.querySelector('[data-contenedor-modal]').classList.add('is-open');
    document.querySelector('[data-contenedor-backdrop]').classList.add('is-open');
}

/**
 * Abre el modal en modo EDITAR: llena el formulario con los datos del tile.
 * Lee los atributos data-tile-* del artículo más cercano al botón pulsado.
 * @param {HTMLElement} btn - Botón "Editar" dentro del menú del tile
 */
function abrirModalContenedorEditar(btn) {
    var tile = btn.closest('[data-tile-id]');
    if (!tile) return;

    _contenedorModo = 'editar';
    _contenedorIdActual = tile.dataset.tileId;

    _limpiarFormularioContenedor();

    document.querySelector('#contenedorNombre').value = tile.dataset.tileNombre || '';
    document.querySelector('#contenedorUrl').value    = tile.dataset.tileUrl    || '';

    /* Muestra la imagen actual si existe */
    var imagenActual = tile.dataset.tileImagen || '';
    if (imagenActual) {
        var nameEl = document.querySelector('[data-contenedor-preview-name]');
        nameEl.textContent = 'Imagen actual: ' + imagenActual;
        nameEl.classList.add('is-visible');

        var frame = document.querySelector('[data-contenedor-preview-frame]');
        var img   = frame.querySelector('img');
        img.src = 'imagenes/' + encodeURIComponent(imagenActual);
        img.onload = function() {
            frame.classList.add('is-ready');
            frame.querySelector('[data-contenedor-preview-empty]').style.display = 'none';
        };
        img.onerror = function() {
            frame.classList.remove('is-ready');
        };
    }

    document.querySelector('.contenedor-modal__eyebrow').textContent = 'Editar acceso';
    document.querySelector('#contenedorModalTitle').textContent = 'Editar contenedor';

    cerrarMenusTile();

    document.querySelector('[data-contenedor-modal]').classList.add('is-open');
    document.querySelector('[data-contenedor-backdrop]').classList.add('is-open');
}

/**
 * Cierra el modal de contenedor y limpia el formulario.
 */
function cerrarModalContenedor() {
    document.querySelector('[data-contenedor-modal]').classList.remove('is-open');
    document.querySelector('[data-contenedor-backdrop]').classList.remove('is-open');
    _limpiarFormularioContenedor();
}

/**
 * Muestra la vista previa de la imagen seleccionada en el campo file.
 * @param {HTMLInputElement} input - Input de tipo file con la imagen
 */
function previsualizarImagen(input) {
    var frame  = document.querySelector('[data-contenedor-preview-frame]');
    var img    = frame.querySelector('img');
    var empty  = frame.querySelector('[data-contenedor-preview-empty]');
    var nameEl = document.querySelector('[data-contenedor-preview-name]');

    var archivo = input.files && input.files[0];
    if (!archivo) return;

    var reader = new FileReader();
    reader.onload = function(e) {
        img.src = e.target.result;
        frame.classList.add('is-ready');
        empty.style.display = 'none';
        nameEl.textContent = archivo.name;
        nameEl.classList.add('is-visible');
    };
    reader.readAsDataURL(archivo);
}

/**
 * Envía el formulario al servidor para CREAR o ACTUALIZAR el contenedor.
 * Usa FormData para soportar la subida de imágenes.
 */
function guardarContenedor() {
    var form = document.querySelector('[data-contenedor-form]');
    var nombre = form.querySelector('#contenedorNombre').value.trim();
    var url    = form.querySelector('#contenedorUrl').value.trim();

    if (!nombre) {
        _mostrarEstadoContenedor('El nombre es obligatorio.', 'error');
        return;
    }
    if (!url) {
        _mostrarEstadoContenedor('La URL es obligatoria.', 'error');
        return;
    }

    var formData = new FormData();
    formData.append('nombre', nombre);
    formData.append('url_',   url);

    var fileInput = form.querySelector('#contenedorImagenFile');
    if (fileInput.files && fileInput.files[0]) {
        formData.append('imagen_file', fileInput.files[0]);
    }

    var endpoint = 'ajax/guardar_contenedor.php';

    if (_contenedorModo === 'editar' && _contenedorIdActual) {
        formData.append('id', _contenedorIdActual);
        endpoint = 'ajax/actualizar_contenedor.php';
    }

    var btnGuardar = document.querySelector('[data-contenedor-save]');
    btnGuardar.disabled = true;
    btnGuardar.textContent = 'Guardando...';

    fetch(endpoint, { method: 'POST', body: formData })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (!data.ok) throw new Error(data.message || 'Error desconocido.');

            _mostrarEstadoContenedor(data.message, 'success');

            if (_contenedorModo === 'crear') {
                _agregarTileAlGrid(data.contenedor);
            } else {
                _actualizarTileEnGrid(data.contenedor);
            }

            setTimeout(cerrarModalContenedor, 900);
        })
        .catch(function(err) {
            _mostrarEstadoContenedor(err.message, 'error');
        })
        .finally(function() {
            btnGuardar.disabled = false;
            btnGuardar.textContent = 'Guardar acceso';
        });
}

/**
 * Solicita confirmación y elimina el contenedor indicado del servidor y del DOM.
 * @param {HTMLElement} btn - Botón "Eliminar" dentro del menú del tile
 */
function eliminarContenedor(btn) {
    var tile = btn.closest('[data-tile-id]');
    if (!tile) return;

    var id     = tile.dataset.tileId;
    var nombre = tile.dataset.tileNombre || 'este acceso';

    if (!confirm('¿Eliminar "' + nombre + '"? Esta acción no se puede deshacer.')) return;

    cerrarMenusTile();

    var formData = new FormData();
    formData.append('id', id);

    fetch('ajax/eliminar_contenedor.php', { method: 'POST', body: formData })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (!data.ok) throw new Error(data.message || 'No se pudo eliminar.');
            tile.remove();
            ajustarGrid();
        })
        .catch(function(err) {
            alert('Error al eliminar: ' + err.message);
        });
}

/* ——— Funciones internas (prefijo _) ——— */

/**
 * Muestra un mensaje de estado dentro del modal (éxito o error).
 * @param {string} mensaje - Texto a mostrar
 * @param {'success'|'error'} tipo - Tipo de alerta
 */
function _mostrarEstadoContenedor(mensaje, tipo) {
    var el = document.querySelector('[data-contenedor-status]');
    el.textContent = mensaje;
    el.className = 'contenedor-modal__status is-visible contenedor-modal__status--' + tipo;
}

/**
 * Limpia todos los campos del formulario y oculta la vista previa y el estado.
 */
function _limpiarFormularioContenedor() {
    var form = document.querySelector('[data-contenedor-form]');
    form.reset();

    var frame  = document.querySelector('[data-contenedor-preview-frame]');
    var img    = frame.querySelector('img');
    var empty  = frame.querySelector('[data-contenedor-preview-empty]');
    var nameEl = document.querySelector('[data-contenedor-preview-name]');
    var status = document.querySelector('[data-contenedor-status]');

    img.src = '';
    frame.classList.remove('is-ready');
    empty.style.display = '';
    nameEl.textContent  = '';
    nameEl.classList.remove('is-visible');
    status.className = 'contenedor-modal__status';
    status.textContent = '';
}

/**
 * Normaliza una URL agregando https:// si no tiene esquema.
 * @param {string} url - URL a normalizar
 * @returns {string} URL con esquema garantizado
 */
function _normalizarUrl(url) {
    url = (url || '').trim();
    if (!url) return '#';
    if (!/^[a-z][a-z0-9+.\-]*:\/\//i.test(url)) {
        return 'https://' + url.replace(/^\/+/, '');
    }
    return url;
}

/**
 * Agrega un nuevo tile al grid del launcher sin recargar la página.
 * @param {{id: number, nombre: string, url_: string, imagen: string}} c - Datos del contenedor creado
 */
function _agregarTileAlGrid(c) {
    var grid = document.querySelector('.tiles');
    var href = _normalizarUrl(c.url_);
    var src  = c.imagen ? 'imagenes/' + encodeURIComponent(c.imagen) : 'imagenes/google.png';
    var nombre = _escaparHtml(c.nombre);

    var article = document.createElement('article');
    article.className = 'tile';
    article.dataset.tileId     = c.id;
    article.dataset.tileNombre = c.nombre;
    article.dataset.tileUrl    = c.url_;
    article.dataset.tileImagen = c.imagen || '';

    article.innerHTML =
        '<a class="tile__link" href="' + _escaparHtml(href) + '" title="' + nombre + '" target="_blank" rel="noopener noreferrer"></a>' +
        '<div class="tile__actions">' +
          '<button class="tile__menu-btn" type="button" onclick="toggleMenuTile(this)">⋯</button>' +
          '<div class="tile__menu" role="menu">' +
            '<button class="tile__menu-item" type="button" data-tile-edit>Editar</button>' +
            '<button class="tile__menu-item tile__menu-item--danger" type="button" data-tile-delete>Eliminar</button>' +
          '</div>' +
        '</div>' +
        '<div class="tile__media">' +
          '<img src="' + src + '" alt="' + nombre + '" onerror="this.onerror=null;this.src=\'imagenes/google.png\';" />' +
        '</div>';

    grid.appendChild(article);
    ajustarGrid();
}

/**
 * Actualiza visualmente el tile existente con los datos devueltos por el servidor.
 * @param {{id: number, nombre: string, url_: string, imagen: string}} c - Datos actualizados
 */
function _actualizarTileEnGrid(c) {
    var tile = document.querySelector('[data-tile-id="' + c.id + '"]');
    if (!tile) return;

    tile.dataset.tileNombre = c.nombre;
    tile.dataset.tileUrl    = c.url_;
    tile.dataset.tileImagen = c.imagen || '';

    var href = _normalizarUrl(c.url_);
    var src  = c.imagen ? 'imagenes/' + encodeURIComponent(c.imagen) : 'imagenes/google.png';

    var link = tile.querySelector('.tile__link');
    if (link) { link.href = href; link.title = c.nombre; }

    var img = tile.querySelector('.tile__media img');
    if (img) { img.src = src; img.alt = c.nombre; }
}

/**
 * Escapa caracteres especiales HTML para evitar XSS al insertar strings en innerHTML.
 * @param {string} str - Cadena a escapar
 * @returns {string} Cadena segura para HTML
 */
function _escaparHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

/* ——— Bindings para botones que vienen del HTML del componente (data-* attributes) ——— */

/** Enlaza todos los botones y controles del modal con sus funciones. */
(function iniciarBindingsContenedor() {
    /* Botón del rail para abrir modal en modo crear */
    document.querySelectorAll('[data-open-contenedor]').forEach(function(btn) {
        btn.addEventListener('click', abrirModalContenedor);
    });

    /* Botones de cerrar dentro del modal */
    document.querySelectorAll('[data-contenedor-close]').forEach(function(btn) {
        btn.addEventListener('click', cerrarModalContenedor);
    });

    /* Botón guardar */
    var btnGuardar = document.querySelector('[data-contenedor-save]');
    if (btnGuardar) btnGuardar.addEventListener('click', guardarContenedor);

    /* Input file para preview de imagen */
    var fileInput = document.querySelector('#contenedorImagenFile');
    if (fileInput) fileInput.addEventListener('change', function() { previsualizarImagen(this); });

    /* Cierre al hacer click en el backdrop */
    var backdrop = document.querySelector('[data-contenedor-backdrop]');
    if (backdrop) backdrop.addEventListener('click', cerrarModalContenedor);

    document.addEventListener('click', function(e) {
        var btnEditar = e.target.closest('[data-tile-edit]');
        if (btnEditar) {
            e.preventDefault();
            e.stopPropagation();
            abrirModalContenedorEditar(btnEditar);
            return;
        }

        var btnEliminar = e.target.closest('[data-tile-delete]');
        if (btnEliminar) {
            e.preventDefault();
            e.stopPropagation();
            eliminarContenedor(btnEliminar);
        }
    });
}());

window.abrirModalContenedor = abrirModalContenedor;
window.abrirModalContenedorEditar = abrirModalContenedorEditar;
window.cerrarModalContenedor = cerrarModalContenedor;
window.previsualizarImagen = previsualizarImagen;
window.guardarContenedor = guardarContenedor;
window.eliminarContenedor = eliminarContenedor;
