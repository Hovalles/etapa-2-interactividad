<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function usuarioAutenticado(): bool
{
    return isset($_SESSION['usuario_sistema']);
}

function obtenerUsuarioSesion(): ?array
{
    return $_SESSION['usuario_sistema'] ?? null;
}

function esAdministrador(): bool
{
    $usuario = obtenerUsuarioSesion();

    if (!$usuario) {
        return false;
    }

    return ($usuario['rol'] ?? '') === 'administrador'
        || ($usuario['tipo_cuenta'] ?? '') === 'administrador_sistema';
}

function requerirSesion(): void
{
    if (!usuarioAutenticado()) {
        header('Location: login.php');
        exit;
    }
}

function requerirAdministrador(): void
{
    requerirSesion();

    if (!esAdministrador()) {
        header('Location: panel.php');
        exit;
    }
}

function requerirSesionApi(): void
{
    if (!usuarioAutenticado()) {
        http_response_code(401);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['mensaje' => 'Debe iniciar sesión para utilizar esta API.'], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

function requerirAdministradorApi(): void
{
    requerirSesionApi();

    if (!esAdministrador()) {
        http_response_code(403);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['mensaje' => 'No tiene permiso para crear, editar o eliminar usuarios.'], JSON_UNESCAPED_UNICODE);
        exit;
    }
}
