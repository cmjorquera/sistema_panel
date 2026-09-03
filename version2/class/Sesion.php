<?php
class Sesion {

    public static function requerir(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['usuario_id'])) {
            header('Location: login.php');
            exit;
        }
    }

    public static function crear(array $datos): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_regenerate_id(true);
        $_SESSION['usuario_id']     = $datos['id'];
        $_SESSION['usuario_nombre'] = $datos['nombre'];
        $_SESSION['usuario_perfil'] = $datos['perfil'];
    }

    public static function destruir(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_unset();
        session_destroy();
    }

    public static function get(string $clave): mixed {
        if (session_status() === PHP_SESSION_NONE) session_start();
        return $_SESSION[$clave] ?? null;
    }

    public static function iniciales(): string {
        $nombre  = self::get('usuario_nombre') ?? '';
        $partes  = array_filter(explode(' ', trim($nombre)));
        $result  = '';
        foreach (array_slice(array_values($partes), 0, 2) as $p) {
            $result .= mb_strtoupper(mb_substr($p, 0, 1));
        }
        return $result ?: 'US';
    }
}
