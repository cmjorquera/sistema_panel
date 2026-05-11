<?php

function iniciarSesionPanel(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function usuarioPanelAutenticado(): bool
{
    iniciarSesionPanel();

    return !empty($_SESSION['panel_usuario']);
}

function obtenerUsuarioPanel(): ?array
{
    iniciarSesionPanel();

    return isset($_SESSION['panel_usuario']) && is_array($_SESSION['panel_usuario'])
        ? $_SESSION['panel_usuario']
        : null;
}

function requerirLoginPanel(): void
{
    if (usuarioPanelAutenticado()) {
        return;
    }

    header('Location: login.php');
    exit;
}

function guardarUsuarioPanel(array $usuario): void
{
    iniciarSesionPanel();
    $_SESSION['panel_usuario'] = $usuario;
}

function cerrarSesionPanel(): void
{
    iniciarSesionPanel();
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }

    session_destroy();
}
