<?php
declare(strict_types=1);

require_once __DIR__ . '/config/auth.php';
requerirSesion();

$usuarioSesion = obtenerUsuarioSesion();
$rol = $usuarioSesion['rol'] ?? 'invitado';
$nombre = $usuarioSesion['nombre'] ?? 'Usuario';
$correo = $usuarioSesion['correo'] ?? '';

$contenidoPorRol = [
    'administrador' => [
        'titulo' => 'Panel Administrativo',
        'subtitulo' => 'Gestión completa del sistema',
        'descripcion' => 'Desde esta vista el administrador puede gestionar usuarios, consultar registros y mantener el control general de la aplicación.',
        'alerta' => 'Usted tiene permisos para crear, consultar, editar y eliminar usuarios.',
        'color' => 'success',
        'acciones' => [
            ['texto' => 'Abrir CRUD de usuarios', 'url' => 'registro.php', 'clase' => 'btn-institucional'],
            ['texto' => 'Ver documentación API', 'url' => 'docs/openapi.json', 'clase' => 'btn-outline-primary']
        ],
        'tarjetas' => [
            ['titulo' => 'Usuarios', 'texto' => 'Administración completa de registros mediante CRUD.'],
            ['titulo' => 'API REST', 'texto' => 'Operaciones protegidas por sesión y permisos.'],
            ['titulo' => 'Base de datos', 'texto' => 'Persistencia de datos en SQLite con script SQL.']
        ]
    ],
    'estudiante' => [
        'titulo' => 'Panel del Estudiante',
        'subtitulo' => 'Vista académica personal',
        'descripcion' => 'Esta vista está pensada para un usuario estudiante. Puede visualizar su información y el estado general de su acceso al sistema.',
        'alerta' => 'Acceso limitado: puede ver su panel, pero no crear, editar ni eliminar usuarios.',
        'color' => 'warning',
        'acciones' => [
            ['texto' => 'Ver mi perfil', 'url' => '#perfil', 'clase' => 'btn-institucional'],
            ['texto' => 'Cerrar sesión', 'url' => 'logout.php', 'clase' => 'btn-outline-secondary']
        ],
        'tarjetas' => [
            ['titulo' => 'Mi perfil', 'texto' => 'Consulta de los datos principales del estudiante.'],
            ['titulo' => 'Estado', 'texto' => 'Usuario activo dentro del sistema.'],
            ['titulo' => 'Permisos', 'texto' => 'Acceso de solo lectura para proteger la información.']
        ]
    ],
    'invitado' => [
        'titulo' => 'Panel del Invitado',
        'subtitulo' => 'Vista de acceso básico',
        'descripcion' => 'Esta vista está diseñada para usuarios invitados. El invitado puede entrar al sistema, pero solo con permisos informativos.',
        'alerta' => 'Acceso básico: este rol no puede modificar registros ni administrar usuarios.',
        'color' => 'info',
        'acciones' => [
            ['texto' => 'Ver información', 'url' => '#informacion', 'clase' => 'btn-institucional'],
            ['texto' => 'Cerrar sesión', 'url' => 'logout.php', 'clase' => 'btn-outline-secondary']
        ],
        'tarjetas' => [
            ['titulo' => 'Bienvenida', 'texto' => 'Acceso general al sistema como visitante.'],
            ['titulo' => 'Consulta', 'texto' => 'Vista informativa sin permisos administrativos.'],
            ['titulo' => 'Seguridad', 'texto' => 'Restricción de operaciones críticas del sistema.']
        ]
    ]
];

$config = $contenidoPorRol[$rol] ?? $contenidoPorRol['invitado'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="author" content="Hector Ovalles" />
  <title><?= htmlspecialchars($config['titulo']) ?> - Proyecto Integrador</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-institucional">
    <div class="container">
      <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="index.php">
        <span class="brand-logo">HO</span>
        Proyecto Integrador
      </a>
      <div class="d-flex align-items-center gap-2">
        <?php if (esAdministrador()): ?>
          <a class="btn btn-outline-light btn-sm" href="registro.php">CRUD</a>
        <?php endif; ?>
        <a class="btn btn-institucional btn-sm" href="logout.php">Cerrar sesión</a>
      </div>
    </div>
  </nav>

  <header class="bg-institucional text-white py-5">
    <div class="container">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <span class="badge rounded-pill badge-framework mb-3">
            Rol: <?= htmlspecialchars(ucfirst($rol)) ?>
          </span>
          <h1 class="display-6 fw-bold mb-2"><?= htmlspecialchars($config['titulo']) ?></h1>
          <p class="lead mb-0"><?= htmlspecialchars($config['subtitulo']) ?></p>
        </div>
        <div class="col-lg-4">
          <div class="card hero-card text-institucional">
            <div class="card-body">
              <h2 class="h5 fw-bold mb-3">Sesión activa</h2>
              <p class="mb-1"><strong><?= htmlspecialchars($nombre) ?></strong></p>
              <p class="mb-1"><?= htmlspecialchars($correo) ?></p>
              <span class="badge text-bg-light"><?= htmlspecialchars($rol) ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <main class="container py-5">
    <section class="card card-soft mb-4" id="perfil">
      <div class="card-body p-4 p-md-5">
        <div class="row align-items-center g-4">
          <div class="col-lg-8">
            <p class="text-uppercase text-warning fw-bold small mb-1">Vista personalizada</p>
            <h2 class="h3 text-institucional fw-bold mb-3">
              Hola, <?= htmlspecialchars($nombre) ?>
            </h2>
            <p class="mb-0"><?= htmlspecialchars($config['descripcion']) ?></p>
          </div>
          <div class="col-lg-4">
            <div class="alert alert-<?= htmlspecialchars($config['color']) ?> mb-0">
              <?= htmlspecialchars($config['alerta']) ?>
            </div>
          </div>
        </div>

        <div class="d-flex gap-2 flex-wrap mt-4">
          <?php foreach ($config['acciones'] as $accion): ?>
            <a class="btn <?= htmlspecialchars($accion['clase']) ?>" href="<?= htmlspecialchars($accion['url']) ?>">
              <?= htmlspecialchars($accion['texto']) ?>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section class="row g-4" id="informacion">
      <?php foreach ($config['tarjetas'] as $tarjeta): ?>
        <div class="col-md-4">
          <article class="card card-soft h-100">
            <div class="card-body p-4">
              <h3 class="h5 text-institucional fw-bold"><?= htmlspecialchars($tarjeta['titulo']) ?></h3>
              <p class="mb-0"><?= htmlspecialchars($tarjeta['texto']) ?></p>
            </div>
          </article>
        </div>
      <?php endforeach; ?>
    </section>

    <?php if (!esAdministrador()): ?>
      <section class="card card-soft mt-4">
        <div class="card-body p-4">
          <h2 class="h5 text-institucional fw-bold">Control de permisos</h2>
          <p class="mb-0">
            Esta cuenta no muestra las opciones de creación, edición o eliminación de usuarios.
            Así se separa la experiencia visual y funcional según el rol del usuario.
          </p>
        </div>
      </section>
    <?php endif; ?>
  </main>

  <footer class="bg-institucional text-white text-center py-3">
    <p class="mb-0">&copy; 2026 - Proyecto realizado por Hector Ovalles</p>
  </footer>
</body>
</html>
