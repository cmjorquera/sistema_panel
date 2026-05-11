/**
 * Ajusta el tamaño de los tiles para llenar el área visible sin scroll.
 * Calcula la celda óptima basándose en el ancho y alto disponible.
 */
function ajustarGrid() {
    var tiles = document.querySelectorAll('.tile');
    var total = tiles.length;
    if (!total) return;

    var cols = 8;
    var filas = Math.ceil(total / cols);
    var gap = 12;
    var grid = document.querySelector('.tiles');
    var areaAncho = grid.clientWidth - 86;
    var areaAlto = window.innerHeight - 74 - 12 - 80;
    var tilPorAncho = Math.floor((areaAncho - (cols - 1) * gap) / cols);
    var tilPorAlto = Math.floor((areaAlto - (filas - 1) * gap) / filas);
    var tileSize = Math.max(60, Math.min(tilPorAncho, tilPorAlto));

    grid.style.gridTemplateColumns = 'repeat(' + cols + ', ' + tileSize + 'px)';
    grid.style.gridAutoRows = tileSize + 'px';
    grid.style.gap = gap + 'px';
}

/**
 * Filtra los tiles visibles según el texto ingresado en la barra de búsqueda.
 * @param {string} valor - Texto a buscar (puede ser vacío para mostrar todos)
 */
function filtrarTiles(valor) {
    var q = valor.toLowerCase().trim();
    document.querySelectorAll('.tile').forEach(function(tile) {
        var nombre = (tile.dataset.tileNombre || '').toLowerCase();
        tile.style.display = (!q || nombre.includes(q)) ? '' : 'none';
    });
}

/**
 * Alterna la visibilidad del menú de acciones de un tile (los 3 puntos).
 * Cierra los demás menús abiertos antes de abrir el actual.
 * @param {HTMLElement} btn - Botón ⋯ que disparó el click
 */
function toggleMenuTile(btn) {
    var actions = btn.closest('.tile__actions');
    var estaAbierto = actions.classList.contains('is-open');

    cerrarMenusTile();

    if (!estaAbierto) {
        actions.classList.add('is-open');
    }
}

/**
 * Cierra todos los menús de tiles que estén actualmente abiertos.
 */
function cerrarMenusTile() {
    document.querySelectorAll('.tile__actions.is-open').forEach(function(a) {
        a.classList.remove('is-open');
    });
}

/* ——— Inicialización al cargar la página ——— */
ajustarGrid();
window.addEventListener('resize', ajustarGrid);

/* Cierra menús al hacer click fuera de un tile */
document.addEventListener('click', function(e) {
    if (!e.target.closest('.tile__actions')) {
        cerrarMenusTile();
    }
});
