<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../class/conexion.php';
require_once __DIR__ . '/../modelos/ContenedorModelo.php';
require_once __DIR__ . '/../componentes/auth.php';

iniciarSesionPanel();
$usuarioSesion = obtenerUsuarioPanel();
$idUsuario     = (int)($usuarioSesion['id'] ?? 1);

/**
 * Guarda el archivo de imagen en la carpeta del usuario y retorna la ruta relativa a imagenes/.
 */
function guardarImagenContenedor(array $archivo, string $nombre, int $idUsuario): string
{
    if ((int)($archivo['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return '';
    }

    if ((int)($archivo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        throw new RuntimeException('No se pudo cargar la nueva imagen.');
    }

    $tmpPath = (string)($archivo['tmp_name'] ?? '');
    if ($tmpPath === '' || !is_uploaded_file($tmpPath)) {
        throw new RuntimeException('La nueva imagen no es valida.');
    }

    $mime = mime_content_type($tmpPath) ?: '';
    $extensiones = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp',
    ];

    if (!isset($extensiones[$mime])) {
        throw new RuntimeException('La imagen debe ser JPG, PNG, GIF o WEBP.');
    }

    $directorioPrincipal = dirname(__DIR__) . '/imagenes';
    $directorioUsuario   = $directorioPrincipal . '/usuarios_contenedores/usuario_' . $idUsuario;

    if (!is_dir($directorioPrincipal)) {
        throw new RuntimeException('La carpeta de imagenes no existe.');
    }

    if (!is_dir($directorioUsuario)) {
        if (!mkdir($directorioUsuario, 0755, true)) {
            throw new RuntimeException('No se pudo crear la carpeta del usuario.');
        }
    }

    $slug = preg_replace('/[^a-z0-9]+/i', '-', $nombre);
    $slug = trim((string)$slug, '-') ?: 'contenedor';

    $nombreArchivo = $slug . '-' . date('YmdHis') . '.' . $extensiones[$mime];
    $destino       = $directorioUsuario . '/' . $nombreArchivo;

    if (!move_uploaded_file($tmpPath, $destino)) {
        throw new RuntimeException('No se pudo guardar la nueva imagen en el servidor.');
    }

    return 'usuarios_contenedores/usuario_' . $idUsuario . '/' . $nombreArchivo;
}

/**
 * Elimina la imagen del disco. Acepta rutas relativas a imagenes/ (con o sin subcarpetas).
 */
function borrarImagenContenedor(string $imagen): void
{
    $imagen = trim($imagen);
    if ($imagen === '' || strpos($imagen, '..') !== false) {
        return;
    }

    $imagen    = ltrim($imagen, '/');
    $rutaCompleta = dirname(__DIR__) . '/imagenes/' . $imagen;
    if (is_file($rutaCompleta)) {
        @unlink($rutaCompleta);
    }
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new RuntimeException('Metodo no permitido.');
    }

    $id     = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1],
    ]);
    $nombre = trim((string)($_POST['nombre'] ?? ''));
    $url    = trim((string)($_POST['url_']   ?? ''));

    if ($id === false || $id === null) {
        throw new RuntimeException('El identificador del contenedor es invalido.');
    }
    if ($nombre === '') {
        throw new RuntimeException('El nombre es obligatorio.');
    }
    if ($url === '') {
        throw new RuntimeException('La URL es obligatoria.');
    }

    $db     = new Conexion();
    $modelo = new ContenedorModelo($db->getConexion());

    $imagenAnterior = $modelo->obtenerImagenActual($id);
    $imagenNueva    = isset($_FILES['imagen_file'])
        ? guardarImagenContenedor($_FILES['imagen_file'], $nombre, $idUsuario)
        : '';
    $imagen = $imagenNueva !== '' ? $imagenNueva : $imagenAnterior;

    if (!$modelo->actualizar($id, $nombre, $url, $imagen)) {
        throw new RuntimeException('No se pudo actualizar el contenedor.');
    }

    if ($imagenNueva !== '' && $imagenAnterior !== '') {
        borrarImagenContenedor($imagenAnterior);
    }

    $db->cerrar();

    echo json_encode([
        'ok'      => true,
        'message' => 'Contenedor actualizado correctamente.',
        'contenedor' => [
            'id'     => $id,
            'nombre' => $nombre,
            'url_'   => $url,
            'imagen' => $imagen,
        ],
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode([
        'ok'      => false,
        'message' => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}
