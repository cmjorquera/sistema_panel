<?php

class ContenedorModelo
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function obtener(int $idUsuario): array
    {
        $stmt = $this->conn->prepare(
            'SELECT id, nombre, url_, imagen
             FROM contenedor
             WHERE id_usuario = ?
             ORDER BY id ASC'
        );

        if (!$stmt) {
            throw new RuntimeException('No se pudo preparar la consulta de contenedores.');
        }

        $stmt->bind_param('i', $idUsuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $contenedores = [];
        while ($resultado && ($fila = $resultado->fetch_assoc())) {
            $contenedores[] = $fila;
        }

        $stmt->close();

        return $contenedores;
    }

    public function guardar(int $idUsuario, string $nombre, string $url, string $imagen): int
    {
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');

        $stmt = $this->conn->prepare(
            'INSERT INTO contenedor (id_usuario, nombre, url_, imagen, fecha, hora)
             VALUES (?, ?, ?, ?, ?, ?)'
        );

        if (!$stmt) {
            throw new RuntimeException('No se pudo preparar el guardado del contenedor.');
        }

        $stmt->bind_param('isssss', $idUsuario, $nombre, $url, $imagen, $fecha, $hora);

        if (!$stmt->execute()) {
            $stmt->close();
            throw new RuntimeException('No se pudo guardar el contenedor.');
        }

        $id = (int)$stmt->insert_id;
        $stmt->close();

        return $id;
    }

    public function actualizar(int $id, string $nombre, string $url, string $imagen): bool
    {
        $stmt = $this->conn->prepare(
            'UPDATE contenedor
             SET nombre = ?, url_ = ?, imagen = ?
             WHERE id = ?'
        );

        if (!$stmt) {
            throw new RuntimeException('No se pudo preparar la actualizacion del contenedor.');
        }

        $stmt->bind_param('sssi', $nombre, $url, $imagen, $id);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    public function eliminar(int $id): string
    {
        $imagen = $this->obtenerImagenActual($id);

        $stmt = $this->conn->prepare('DELETE FROM contenedor WHERE id = ?');
        if (!$stmt) {
            throw new RuntimeException('No se pudo preparar la eliminacion del contenedor.');
        }

        $stmt->bind_param('i', $id);

        if (!$stmt->execute()) {
            $stmt->close();
            throw new RuntimeException('No se pudo eliminar el contenedor.');
        }

        $stmt->close();

        return $imagen;
    }

    public function obtenerImagenActual(int $id): string
    {
        $stmt = $this->conn->prepare('SELECT imagen FROM contenedor WHERE id = ? LIMIT 1');
        if (!$stmt) {
            throw new RuntimeException('No se pudo consultar la imagen actual del contenedor.');
        }

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado ? $resultado->fetch_assoc() : null;
        $stmt->close();

        if (!$fila) {
            throw new RuntimeException('El contenedor no existe.');
        }

        return basename(trim((string)($fila['imagen'] ?? '')));
    }
}
