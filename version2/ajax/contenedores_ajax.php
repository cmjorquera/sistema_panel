<?php
require_once '../class/Sesion.php';
require_once '../class/Conexion.php';
Sesion::requerir();

header('Content-Type: application/json');

$accion    = $_POST['accion'] ?? '';
$idUsuario = (int)(Sesion::get('usuario_id') ?? 1);

/* Guarda el archivo subido, devuelve ruta relativa o '' si no hay archivo */
function guardarImagenContenedor(int $idUsuario): string {
    if (empty($_FILES['imagen_file']['tmp_name']) || $_FILES['imagen_file']['error'] !== UPLOAD_ERR_OK) {
        return '';
    }
    $archivo = $_FILES['imagen_file'];
    $ext     = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg','jpeg','png','gif','webp'], true)) return '';
    if ($archivo['size'] > 5 * 1024 * 1024) return '';

    $carpeta = dirname(dirname(__DIR__)) . '/imagenes/usuarios_contenedores/usuario_' . $idUsuario . '/';
    if (!is_dir($carpeta)) mkdir($carpeta, 0755, true);

    $base          = preg_replace('/[^a-zA-Z0-9_\-]/', '', pathinfo($archivo['name'], PATHINFO_FILENAME));
    $nombreArchivo = ($base ?: 'imagen') . '-' . date('YmdHis') . '.' . $ext;

    if (!move_uploaded_file($archivo['tmp_name'], $carpeta . $nombreArchivo)) return '';
    return 'usuarios_contenedores/usuario_' . $idUsuario . '/' . $nombreArchivo;
}

/* Elimina un archivo de imagen almacenado en imagenes/ */
function borrarImagenContenedor(string $imagen): void {
    if ($imagen === '' || strpos($imagen, '..') !== false) return;
    $ruta = dirname(dirname(__DIR__)) . '/imagenes/' . ltrim($imagen, '/');
    if (is_file($ruta)) unlink($ruta);
}

try {
    $db = Conexion::obtener();

    if ($accion === 'guardar') {
        $nombre = trim($_POST['nombre'] ?? '');
        $url    = trim($_POST['url']    ?? '');
        if ($nombre === '') { echo json_encode(['ok'=>false,'error'=>'Nombre requerido']); exit; }

        $imagen = guardarImagenContenedor($idUsuario);

        $stmt = $db->prepare('INSERT INTO contenedor (id_usuario, nombre, url_, imagen, fecha, hora) VALUES (?,?,?,?,CURDATE(),CURTIME())');
        $stmt->bind_param('isss', $idUsuario, $nombre, $url, $imagen);
        $stmt->execute();
        $stmt->close();
        echo json_encode(['ok' => true]);

    } elseif ($accion === 'actualizar') {
        $id     = (int)($_POST['id']    ?? 0);
        $nombre = trim($_POST['nombre'] ?? '');
        $url    = trim($_POST['url']    ?? '');
        if ($id === 0 || $nombre === '') { echo json_encode(['ok'=>false,'error'=>'Datos invalidos']); exit; }

        /* Recuperar imagen actual antes de actualizar */
        $r = $db->prepare('SELECT imagen FROM contenedor WHERE id=? AND id_usuario=?');
        $r->bind_param('ii', $id, $idUsuario);
        $r->execute();
        $r->bind_result($imagenActual);
        $r->fetch();
        $r->close();

        $nuevaImagen = guardarImagenContenedor($idUsuario);
        if ($nuevaImagen !== '') {
            borrarImagenContenedor((string)($imagenActual ?? ''));
            $imagen = $nuevaImagen;
        } else {
            $imagen = (string)($imagenActual ?? '');
        }

        $stmt = $db->prepare('UPDATE contenedor SET nombre=?, url_=?, imagen=? WHERE id=? AND id_usuario=?');
        $stmt->bind_param('sssii', $nombre, $url, $imagen, $id, $idUsuario);
        $stmt->execute();
        $stmt->close();
        echo json_encode(['ok' => true]);

    } elseif ($accion === 'eliminar') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id === 0) { echo json_encode(['ok'=>false,'error'=>'ID invalido']); exit; }

        /* Recuperar imagen antes de eliminar el registro */
        $r = $db->prepare('SELECT imagen FROM contenedor WHERE id=? AND id_usuario=?');
        $r->bind_param('ii', $id, $idUsuario);
        $r->execute();
        $r->bind_result($imagen);
        $r->fetch();
        $r->close();

        $stmt = $db->prepare('DELETE FROM contenedor WHERE id=? AND id_usuario=?');
        $stmt->bind_param('ii', $id, $idUsuario);
        $stmt->execute();
        $stmt->close();

        borrarImagenContenedor((string)($imagen ?? ''));
        echo json_encode(['ok' => true]);

    } else {
        echo json_encode(['ok' => false, 'error' => 'Accion desconocida']);
    }

} catch (Exception $e) {
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
