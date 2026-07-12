<?php
declare(strict_types=1);

function obtenerConexion(): PDO
{
    $directorio = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'database';

    if (!is_dir($directorio) && !mkdir($directorio, 0775, true) && !is_dir($directorio)) {
        throw new RuntimeException('No fue posible crear el directorio de la base de datos.');
    }

    $rutaBaseDatos = $directorio . DIRECTORY_SEPARATOR . 'proyecto.sqlite';
    $pdo = new PDO('sqlite:' . $rutaBaseDatos);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec('PRAGMA foreign_keys = ON');

    crearTablas($pdo);
    crearUsuarioAdministrador($pdo);

    return $pdo;
}

function crearTablas(PDO $pdo): void
{
    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS usuarios (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre TEXT NOT NULL,
            correo TEXT NOT NULL UNIQUE,
            telefono TEXT NOT NULL,
            usuario TEXT NOT NULL UNIQUE,
            password_hash TEXT NOT NULL,
            rol TEXT NOT NULL CHECK (rol IN ("estudiante", "administrador", "invitado")),
            comentario TEXT,
            creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            actualizado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        )'
    );

    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS usuarios_sistema (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre TEXT NOT NULL,
            correo TEXT NOT NULL UNIQUE,
            password_hash TEXT NOT NULL,
            rol TEXT NOT NULL DEFAULT "administrador",
            activo INTEGER NOT NULL DEFAULT 1,
            creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        )'
    );
}

function crearUsuarioAdministrador(PDO $pdo): void
{
    $correo = 'admin@grupo9.com';
    $consulta = $pdo->prepare('SELECT id FROM usuarios_sistema WHERE correo = :correo LIMIT 1');
    $consulta->execute(['correo' => $correo]);

    if ($consulta->fetch()) {
        return;
    }

    $insertar = $pdo->prepare(
        'INSERT INTO usuarios_sistema (nombre, correo, password_hash, rol)
         VALUES (:nombre, :correo, :password_hash, :rol)'
    );

    $insertar->execute([
        'nombre' => 'Administrador Grupo 9',
        'correo' => $correo,
        'password_hash' => password_hash('Admin123', PASSWORD_DEFAULT),
        'rol' => 'administrador'
    ]);
}
