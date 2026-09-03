<?php
require_once 'class/Sesion.php';
Sesion::destruir();
header('Location: login.php');
exit;
