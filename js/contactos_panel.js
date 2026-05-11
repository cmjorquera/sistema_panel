/**
 * Abre el panel lateral de contactos.
 */
function abrirPanelContactos() {
    var panel    = document.querySelector('[data-contact-panel]');
    var backdrop = document.querySelector('[data-contact-backdrop]');
    if (panel)    panel.classList.add('is-open');
    if (backdrop) backdrop.classList.add('is-open');
}

/**
 * Cierra el panel lateral de contactos y colapsa cualquier chat abierto.
 */
function cerrarPanelContactos() {
    var panel    = document.querySelector('[data-contact-panel]');
    var backdrop = document.querySelector('[data-contact-backdrop]');
    if (panel)    panel.classList.remove('is-open');
    if (backdrop) backdrop.classList.remove('is-open');
    _cerrarChatsContacto();
}

/**
 * Alterna la visibilidad del chat de un contacto específico.
 * Cierra los demás chats antes de abrir el seleccionado.
 * @param {HTMLElement} btn - Botón 💬 del contacto
 */
function toggleChatContacto(btn) {
    var chatId  = btn.getAttribute('data-chat-toggle');
    var panel   = document.querySelector('[data-contact-panel]');
    var chatBox = panel ? panel.querySelector('[data-chat-box="' + chatId + '"]') : null;
    var estaAbierto = btn.classList.contains('is-active');

    _cerrarChatsContacto();

    if (!estaAbierto && chatBox) {
        btn.classList.add('is-active');
        chatBox.classList.add('is-open');
    }
}

/**
 * Colapsa todos los chats y quita el estado activo de sus botones.
 */
function _cerrarChatsContacto() {
    var panel = document.querySelector('[data-contact-panel]');
    if (!panel) return;
    panel.querySelectorAll('[data-chat-box]').forEach(function(box) {
        box.classList.remove('is-open');
    });
    panel.querySelectorAll('[data-chat-toggle]').forEach(function(btn) {
        btn.classList.remove('is-active');
    });
}

/* ——— Bindings para los elementos del componente (data-* attributes) ——— */

/** Enlaza todos los controles del panel de contactos con sus funciones. */
(function iniciarBindingsContactos() {
    /* Botón del rail para abrir el panel */
    document.querySelectorAll('[data-open-contacts]').forEach(function(btn) {
        btn.addEventListener('click', abrirPanelContactos);
    });

    /* Botón de cerrar dentro del panel */
    var btnCerrar = document.querySelector('[data-contact-close]');
    if (btnCerrar) btnCerrar.addEventListener('click', cerrarPanelContactos);

    /* Backdrop */
    var backdrop = document.querySelector('[data-contact-backdrop]');
    if (backdrop) backdrop.addEventListener('click', cerrarPanelContactos);

    /* Botones de toggle de chat */
    document.querySelectorAll('[data-chat-toggle]').forEach(function(btn) {
        btn.addEventListener('click', function() { toggleChatContacto(this); });
    });
}());
