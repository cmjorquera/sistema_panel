<?php
class Conexion {
    private static ?mysqli $instancia = null;

    public static function obtener(): mysqli {
        if (self::$instancia === null) {
            self::$instancia = new mysqli('localhost', 'qaseduc_ucomun', 'jorquera86;', 'qaseduc_panel');
            if (self::$instancia->connect_error) {
                error_log('BD error: ' . self::$instancia->connect_error);
                die('Error de conexión con la base de datos.');
            }
            self::$instancia->set_charset('utf8mb4');
        }
        return self::$instancia;
    }
}
