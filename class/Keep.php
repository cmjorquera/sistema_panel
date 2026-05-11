<?php

require_once __DIR__ . '/../componentes/conexion.php';

class Keep
{
    private $db;

    public function __construct()
    {
        $this->db = new MySQL('', '', '');
    }

    public function crearNota($data)
    {
        $idUsuario = (int)($data['id_usuario'] ?? 1);
        $titulo = $this->limpiarTexto($data['titulo'] ?? '');
        $contenido = $this->limpiarTexto($data['contenido'] ?? '');
        $color = $this->limpiarColor($data['color'] ?? '#ffffff');
        $fijada = !empty($data['fijada']) ? 1 : 0;
        $recordatorio = $this->limpiarFecha($data['recordatorio'] ?? null);

        if ($contenido === '') {
            throw new RuntimeException('El contenido de la nota es obligatorio.');
        }

        $sql = "INSERT INTO keep_notas (id_usuario, titulo, contenido, color, fijada, recordatorio)
                VALUES (
                    {$idUsuario},
                    '{$titulo}',
                    '{$contenido}',
                    '{$color}',
                    {$fijada},
                    " . ($recordatorio === null ? "NULL" : "'{$recordatorio}'") . "
                )";

        $error = $this->db->guardar($sql);
        if ($error !== 0) {
            throw new RuntimeException('No se pudo guardar la nota.');
        }

        return [
            'ok' => true,
            'id' => (int)$this->db->ultimo_id(),
        ];
    }

    public function listarNotas($idUsuario)
    {
        $idUsuario = (int)$idUsuario;
        $sql = "SELECT id, id_usuario, titulo, contenido, color, fijada, recordatorio, fecha_creacion, fecha_actualizacion
                FROM keep_notas
                WHERE id_usuario = {$idUsuario}
                ORDER BY fijada DESC, fecha_creacion DESC";

        $resultado = $this->db->consulta($sql);
        $notas = [];

        while ($fila = $this->db->fetch_assoc($resultado)) {
            $fila['id'] = (int)$fila['id'];
            $fila['id_usuario'] = (int)$fila['id_usuario'];
            $fila['fijada'] = (int)$fila['fijada'];
            $notas[] = $fila;
        }

        return $notas;
    }

    public function eliminarNota($id)
    {
        $id = (int)$id;
        if ($id <= 0) {
            throw new RuntimeException('ID de nota invalido.');
        }

        $error = $this->db->guardar("DELETE FROM keep_notas WHERE id = {$id} LIMIT 1");
        if ($error !== 0) {
            throw new RuntimeException('No se pudo eliminar la nota.');
        }

        return ['ok' => true];
    }

    public function actualizarNota($data)
    {
        $id = (int)($data['id'] ?? 0);
        $titulo = $this->limpiarTexto($data['titulo'] ?? '');
        $contenido = $this->limpiarTexto($data['contenido'] ?? '');
        $color = $this->limpiarColor($data['color'] ?? '#ffffff');
        $fijada = !empty($data['fijada']) ? 1 : 0;
        $recordatorio = $this->limpiarFecha($data['recordatorio'] ?? null);

        if ($id <= 0) {
            throw new RuntimeException('ID de nota invalido.');
        }

        if ($contenido === '') {
            throw new RuntimeException('El contenido de la nota es obligatorio.');
        }

        $sql = "UPDATE keep_notas
                SET titulo = '{$titulo}',
                    contenido = '{$contenido}',
                    color = '{$color}',
                    fijada = {$fijada},
                    recordatorio = " . ($recordatorio === null ? "NULL" : "'{$recordatorio}'") . ",
                    fecha_actualizacion = NOW()
                WHERE id = {$id}
                LIMIT 1";

        $error = $this->db->guardar($sql);
        if ($error !== 0) {
            throw new RuntimeException('No se pudo actualizar la nota.');
        }

        return ['ok' => true];
    }

    public function fijarNota($id, $estado)
    {
        $id = (int)$id;
        $estado = (int)$estado === 1 ? 1 : 0;

        if ($id <= 0) {
            throw new RuntimeException('ID de nota invalido.');
        }

        $sql = "UPDATE keep_notas
                SET fijada = {$estado},
                    fecha_actualizacion = NOW()
                WHERE id = {$id}
                LIMIT 1";

        $error = $this->db->guardar($sql);
        if ($error !== 0) {
            throw new RuntimeException('No se pudo cambiar el estado de la nota.');
        }

        return ['ok' => true];
    }

    private function limpiarTexto($texto)
    {
        return $this->db->escape_string(trim((string)$texto));
    }

    private function limpiarColor($color)
    {
        $color = trim((string)$color);
        if (!preg_match('/^#[a-f0-9]{6}$/i', $color)) {
            return '#ffffff';
        }

        return $this->db->escape_string($color);
    }

    private function limpiarFecha($fecha)
    {
        $fecha = trim((string)$fecha);
        if ($fecha === '') {
            return null;
        }

        $timestamp = strtotime($fecha);
        if ($timestamp === false) {
            return null;
        }

        return date('Y-m-d H:i:s', $timestamp);
    }
}
