/* Instancia del calendario FullCalendar (se crea solo la primera vez que se abre) */
var _calendarioInstance = null;

/**
 * Abre el modal del calendario e inicializa FullCalendar si aún no existe.
 */
function abrirModalCalendario() {
    document.querySelector('[data-calendar-modal]').classList.add('is-open');
    document.querySelector('[data-calendar-backdrop]').classList.add('is-open');

    /* FullCalendar necesita que el contenedor sea visible para calcular tamaños */
    if (!_calendarioInstance) {
        _inicializarCalendario();
    } else {
        _calendarioInstance.updateSize();
    }
}

/**
 * Cierra el modal del calendario.
 */
function cerrarModalCalendario() {
    document.querySelector('[data-calendar-modal]').classList.remove('is-open');
    document.querySelector('[data-calendar-backdrop]').classList.remove('is-open');
}

/**
 * Limpia el formulario de evento y quita el ID del campo hidden.
 */
function limpiarFormularioCalendario() {
    var form = document.querySelector('[data-calendar-form]');
    if (form) {
        form.reset();
        var idInput = form.querySelector('input[name="id"]');
        if (idInput) idInput.value = '';
    }
    _ocultarEstadoCalendario();
}

/**
 * Inicializa la instancia de FullCalendar en el contenedor #panelCalendar.
 * Carga los eventos desde el servidor al crearse.
 */
function _inicializarCalendario() {
    var contenedor = document.getElementById('panelCalendar');
    if (!contenedor || typeof FullCalendar === 'undefined') return;

    _calendarioInstance = new FullCalendar.Calendar(contenedor, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left:   'prev,next today',
            center: 'title',
            right:  'dayGridMonth,timeGridWeek,listWeek'
        },

        /* Al hacer click en un día, precarga la fecha en el formulario */
        dateClick: function(info) {
            var form = document.querySelector('[data-calendar-form]');
            if (!form) return;
            var inicio = form.querySelector('#calendarInicio');
            var fin    = form.querySelector('#calendarFin');
            var fecha  = info.dateStr + 'T09:00';
            if (inicio) inicio.value = fecha;
            if (fin)    fin.value    = info.dateStr + 'T10:00';
        },

        /* Al hacer click en un evento, carga sus datos en el formulario para editar */
        eventClick: function(info) {
            var form = document.querySelector('[data-calendar-form]');
            if (!form) return;
            var ev = info.event;

            form.querySelector('input[name="id"]').value        = ev.id || '';
            form.querySelector('#calendarTitulo').value         = ev.title || '';
            form.querySelector('#calendarDescripcion').value    = ev.extendedProps.descripcion || '';
            form.querySelector('#calendarInicio').value         = _formatearFechaInput(ev.start);
            form.querySelector('#calendarFin').value            = ev.end ? _formatearFechaInput(ev.end) : '';
            form.querySelector('#calendarColor').value          = ev.backgroundColor || '#2563eb';
            form.querySelector('#calendarAllDay').checked       = ev.allDay || false;
        },

        /* Carga eventos desde el servidor */
        events: function(info, successCallback, failureCallback) {
            fetch('ajax/listar_eventos_calendario.php')
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    successCallback(data.eventos || []);
                    _actualizarProximosEventos(data.eventos || []);
                })
                .catch(function() {
                    successCallback([]);
                });
        }
    });

    _calendarioInstance.render();
}

/**
 * Guarda un evento (nuevo o existente) enviando el formulario al servidor.
 * @param {Event} e - Evento submit del formulario
 */
function guardarEvento(e) {
    if (e) e.preventDefault();

    var form = document.querySelector('[data-calendar-form]');
    if (!form) return;

    var formData = new FormData(form);
    var id       = (form.querySelector('input[name="id"]')?.value || '').trim();
    var endpoint = id ? 'ajax/guardar_evento_calendario.php' : 'ajax/guardar_evento_calendario.php';

    var btnGuardar = form.querySelector('[data-calendar-save]');
    if (btnGuardar) { btnGuardar.disabled = true; btnGuardar.textContent = 'Guardando...'; }

    fetch(endpoint, { method: 'POST', body: formData })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (!data.ok) throw new Error(data.message || 'Error desconocido.');
            _mostrarEstadoCalendario(data.message || 'Guardado.', 'success');
            limpiarFormularioCalendario();
            if (_calendarioInstance) _calendarioInstance.refetchEvents();
        })
        .catch(function(err) {
            _mostrarEstadoCalendario(err.message, 'error');
        })
        .finally(function() {
            if (btnGuardar) { btnGuardar.disabled = false; btnGuardar.textContent = 'Guardar evento'; }
        });
}

/**
 * Actualiza la lista de "Próximos eventos" en el panel lateral.
 * @param {Array} eventos - Array de objetos de evento de FullCalendar
 */
function _actualizarProximosEventos(eventos) {
    var lista = document.querySelector('[data-calendar-upcoming]');
    if (!lista) return;

    var hoy = new Date();
    var proximos = eventos
        .filter(function(ev) { return new Date(ev.start) >= hoy; })
        .sort(function(a, b) { return new Date(a.start) - new Date(b.start); })
        .slice(0, 5);

    if (!proximos.length) {
        lista.innerHTML = '<div class="calendar-mini-item"><p class="calendar-mini-item__title">Sin eventos próximos</p><p class="calendar-mini-item__meta">Los eventos aparecerán aquí.</p></div>';
        return;
    }

    lista.innerHTML = proximos.map(function(ev) {
        var fecha = new Date(ev.start).toLocaleDateString('es-CL', { day:'numeric', month:'short' });
        return '<div class="calendar-mini-item">' +
               '<p class="calendar-mini-item__title">' + _esc(ev.title) + '</p>' +
               '<p class="calendar-mini-item__meta">' + fecha + '</p>' +
               '</div>';
    }).join('');
}

/**
 * Muestra un mensaje de estado en el formulario del calendario.
 * @param {string} msg  - Texto a mostrar
 * @param {'success'|'error'} tipo
 */
function _mostrarEstadoCalendario(msg, tipo) {
    var el = document.querySelector('[data-calendar-status]');
    if (!el) return;
    el.textContent = msg;
    el.className = 'calendar-status is-visible calendar-status--' + tipo;
}

/** Oculta el área de estado del formulario del calendario. */
function _ocultarEstadoCalendario() {
    var el = document.querySelector('[data-calendar-status]');
    if (el) el.className = 'calendar-status';
}

/**
 * Convierte un objeto Date al formato requerido por inputs datetime-local.
 * @param {Date} fecha
 * @returns {string} "YYYY-MM-DDTHH:MM"
 */
function _formatearFechaInput(fecha) {
    if (!fecha) return '';
    var d = new Date(fecha);
    var pad = function(n) { return String(n).padStart(2, '0'); };
    return d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate()) +
           'T' + pad(d.getHours()) + ':' + pad(d.getMinutes());
}

/**
 * Escapa caracteres HTML para inserción segura.
 * @param {string} s
 * @returns {string}
 */
function _esc(s) {
    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

/* ——— Bindings para los elementos del componente (data-* attributes) ——— */

/** Enlaza los controles del modal calendario con sus funciones. */
(function iniciarBindingsCalendario() {
    /* Botón del rail para abrir */
    document.querySelectorAll('[data-open-calendar]').forEach(function(btn) {
        btn.addEventListener('click', abrirModalCalendario);
    });

    /* Botón cerrar */
    var btnCerrar = document.querySelector('[data-calendar-close]');
    if (btnCerrar) btnCerrar.addEventListener('click', cerrarModalCalendario);

    /* Botón limpiar formulario */
    var btnReset = document.querySelector('[data-calendar-reset]');
    if (btnReset) btnReset.addEventListener('click', limpiarFormularioCalendario);

    /* Submit del formulario */
    var form = document.querySelector('[data-calendar-form]');
    if (form) form.addEventListener('submit', guardarEvento);

    /* Backdrop */
    var backdrop = document.querySelector('[data-calendar-backdrop]');
    if (backdrop) backdrop.addEventListener('click', cerrarModalCalendario);
}());
