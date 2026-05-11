/* Clave usada en localStorage para guardar las notas */
var KEEP_STORAGE_KEY = 'keepNotas_v1';

/* Color activo seleccionado en el modal */
var _keepColorActual = '#fff8b8';

/**
 * Abre el modal de notas en modo CREAR y limpia el formulario.
 */
function abrirModalKeep() {
    _limpiarFormularioKeep();
    document.querySelector('#keepModalTitle').textContent = 'Nueva nota';
    document.querySelector('[data-keep-modal]').classList.add('is-open');
    document.querySelector('[data-keep-backdrop]').classList.add('is-open');
}

/**
 * Cierra el modal de notas y limpia el formulario.
 */
function cerrarModalKeep() {
    document.querySelector('[data-keep-modal]').classList.remove('is-open');
    document.querySelector('[data-keep-backdrop]').classList.remove('is-open');
    _limpiarFormularioKeep();
}

/**
 * Marca el color elegido como activo y actualiza la selección visual.
 * @param {HTMLElement} btn - Botón de color que fue pulsado
 */
function seleccionarColorKeep(btn) {
    document.querySelectorAll('.keep-color-option').forEach(function(b) {
        b.classList.remove('is-selected');
    });
    btn.classList.add('is-selected');
    _keepColorActual = btn.dataset.color || '#fff8b8';
    document.querySelector('#keepColor').value = _keepColorActual;
}

/**
 * Guarda la nota actual en localStorage y actualiza el grid si existe en la página.
 */
function guardarNota() {
    var titulo      = (document.querySelector('#keepTitulo')?.value || '').trim();
    var contenido   = (document.querySelector('#keepContenido')?.value || '').trim();
    var fijada      = document.querySelector('#keepFijada')?.checked || false;
    var recordatorio = document.querySelector('#keepRecordatorio')?.value || '';
    var color       = document.querySelector('#keepColor')?.value || '#fff8b8';
    var notaId      = document.querySelector('#keepNotaId')?.value || '';

    if (!titulo && !contenido) {
        alert('Escribe un título o contenido para la nota.');
        return;
    }

    var notas = _cargarNotasStorage();

    if (notaId) {
        /* Edición de nota existente */
        notas = notas.map(function(n) {
            return n.id === notaId
                ? { id: notaId, titulo: titulo, contenido: contenido, color: color, fijada: fijada, recordatorio: recordatorio }
                : n;
        });
    } else {
        /* Nueva nota */
        notas.push({
            id:          'nota_' + Date.now(),
            titulo:      titulo,
            contenido:   contenido,
            color:       color,
            fijada:      fijada,
            recordatorio: recordatorio
        });
    }

    _guardarNotasStorage(notas);
    _renderizarGrid();
    cerrarModalKeep();
}

/**
 * Elimina una nota por su ID del almacenamiento y del DOM.
 * @param {string} id - Identificador único de la nota
 */
function eliminarNota(id) {
    if (!confirm('¿Eliminar esta nota?')) return;
    var notas = _cargarNotasStorage().filter(function(n) { return n.id !== id; });
    _guardarNotasStorage(notas);
    _renderizarGrid();
}

/* ——— Funciones internas ——— */

/**
 * Lee las notas guardadas en localStorage y las devuelve como array.
 * @returns {Array} Array de objetos nota
 */
function _cargarNotasStorage() {
    try {
        return JSON.parse(localStorage.getItem(KEEP_STORAGE_KEY) || '[]');
    } catch (e) {
        return [];
    }
}

/**
 * Guarda el array de notas en localStorage.
 * @param {Array} notas - Array de objetos nota a persistir
 */
function _guardarNotasStorage(notas) {
    localStorage.setItem(KEEP_STORAGE_KEY, JSON.stringify(notas));
}

/**
 * Renderiza todas las notas en el grid .keep-grid (si existe en la página).
 * Las notas fijadas aparecen primero.
 */
function _renderizarGrid() {
    var grid = document.querySelector('[data-keep-grid]');
    if (!grid) return;

    var notas = _cargarNotasStorage();
    notas.sort(function(a, b) { return (b.fijada ? 1 : 0) - (a.fijada ? 1 : 0); });

    if (!notas.length) {
        grid.innerHTML = '<div class="keep-empty">Todavía no hay notas. Usa el botón + para crear la primera.</div>';
        return;
    }

    grid.innerHTML = notas.map(function(n) { return _htmlNota(n); }).join('');
}

/**
 * Genera el HTML de una tarjeta de nota.
 * @param {{id, titulo, contenido, color, fijada, recordatorio}} n - Datos de la nota
 * @returns {string} Markup HTML de la tarjeta
 */
function _htmlNota(n) {
    var titulo    = _esc(n.titulo || 'Sin título');
    var contenido = _esc(n.contenido || '');
    var meta      = n.recordatorio ? '⏰ ' + new Date(n.recordatorio).toLocaleString('es-CL') : '';
    var pin       = n.fijada ? '<span class="keep-note__badge">📌 Fijada</span>' : '';

    return '<div class="keep-note" style="background:' + _esc(n.color || '#fff8b8') + '">' +
               '<div class="keep-note__header">' +
                 '<h4 class="keep-note__title">' + titulo + '</h4>' + pin +
               '</div>' +
               '<p class="keep-note__content">' + contenido + '</p>' +
               (meta ? '<p class="keep-note__meta">' + meta + '</p>' : '') +
               '<div class="keep-note__actions">' +
                 '<button class="keep-note__action keep-note__action--danger" onclick="eliminarNota(\'' + _esc(n.id) + '\')">🗑 Eliminar</button>' +
               '</div>' +
           '</div>';
}

/**
 * Escapa caracteres especiales para inserción segura en HTML.
 * @param {string} s - Cadena a escapar
 * @returns {string}
 */
function _esc(s) {
    return String(s)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

/**
 * Limpia todos los campos del formulario de nota y restablece el color por defecto.
 */
function _limpiarFormularioKeep() {
    var campos = ['#keepNotaId', '#keepTitulo', '#keepContenido', '#keepRecordatorio'];
    campos.forEach(function(sel) {
        var el = document.querySelector(sel);
        if (el) el.value = '';
    });

    var fijada = document.querySelector('#keepFijada');
    if (fijada) fijada.checked = false;

    /* Restablece color amarillo por defecto */
    _keepColorActual = '#fff8b8';
    var colorInput = document.querySelector('#keepColor');
    if (colorInput) colorInput.value = _keepColorActual;

    document.querySelectorAll('.keep-color-option').forEach(function(b) {
        b.classList.toggle('is-selected', b.dataset.color === _keepColorActual);
    });
}

/* ——— Bindings para botones del componente (data-* attributes) ——— */

/** Enlaza los botones del modal keep con sus funciones al cargar la página. */
(function iniciarBindingsKeep() {
    /* Botón del rail para abrir modal */
    document.querySelectorAll('[data-open-keep]').forEach(function(btn) {
        btn.addEventListener('click', abrirModalKeep);
    });

    /* Botones de cerrar modal */
    document.querySelectorAll('[data-keep-close]').forEach(function(btn) {
        btn.addEventListener('click', cerrarModalKeep);
    });

    /* Botón guardar nota */
    var btnGuardar = document.querySelector('#keepGuardarBtn');
    if (btnGuardar) btnGuardar.addEventListener('click', guardarNota);

    /* Botones de selección de color */
    document.querySelectorAll('.keep-color-option').forEach(function(btn) {
        btn.addEventListener('click', function() { seleccionarColorKeep(this); });
    });

    /* Cierre al hacer click en backdrop */
    var backdrop = document.querySelector('[data-keep-backdrop]');
    if (backdrop) backdrop.addEventListener('click', cerrarModalKeep);
}());

_renderizarGrid();
