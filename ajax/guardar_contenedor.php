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
 * Si no se adjunta archivo devuelve cadena vacía.
 */
function guardarImagenContenedor(array $archivo, string $nombre, int $idUsuario): string
{
    if ((int)($archivo['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return '';
    }

    if ((int)($archivo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        throw new RuntimeException('No se pudo cargar la imagen adjunta.');
    }

    $tmpPath = (string)($archivo['tmp_name'] ?? '');
    if ($tmpPath === '' || !is_uploaded_file($tmpPath)) {
        throw new RuntimeException('La imagen subida no es valida.');
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
        throw new RuntimeException('No se pudo guardar la imagen en el servidor.');
    }

    return 'usuarios_contenedores/usuario_' . $idUsuario . '/' . $nombreArchivo;
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new RuntimeException('Metodo no permitido.');
    }

    $nombre = trim((string)($_POST['nombre'] ?? ''));
    $url    = trim((string)($_POST['url_']   ?? ''));

    if ($nombre === '') {
        throw new RuntimeException('El nombre es obligatorio.');
    }
    if ($url === '') {
        throw new RuntimeException('La URL es obligatoria.');
    }

    $imagen = isset($_FILES['imagen_file'])
        ? guardarImagenContenedor($_FILES['imagen_file'], $nombre, $idUsuario)
        : '';

    $db    = new Conexion();
    $modelo = new ContenedorModelo($db->getConexion());
    $id    = $modelo->guardar($idUsuario, $nombre, $url, $imagen);
    $db->cerrar();

    echo json_encode([
        'ok'      => true,
        'message' => 'Contenedor creado correctamente.',
        'contenedor' => [
            'id'          => $id,
            'id_usuario'  => $idUsuario,
            'nombre'      => $nombre,
            'url_'        => $url,
            'imagen'      => $imagen,
        ],
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode([
        'ok'      => false,
        'message' => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}
