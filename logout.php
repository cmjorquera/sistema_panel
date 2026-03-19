<?php
require_once __DIR__ . '/componentes/auth.php';

cerrarSesionPanel();

header('Location: login.php');
exit;
