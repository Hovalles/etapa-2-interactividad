<?php
declare(strict_types=1);

require_once __DIR__ . '/config/auth.php';
$usuario = obtenerUsuarioSesion();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="author" content="Hector Ovalles" />
  <title>Etapa 4 - Cierre del Proyecto</title>
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
      <div class="d-flex gap-2">
        <?php if ($usuario): ?>
          <?php if (esAdministrador()): ?>
            <a class="btn btn-outline-light" href="registro.php">Panel CRUD</a>
          <?php else: ?>
            <a class="btn btn-outline-light" href="panel.php">Mi panel</a>
          <?php endif; ?>
          <a class="btn btn-institucional" href="logout.php">Cerrar sesión</a>
        <?php else: ?>
          <a class="btn btn-institucional" href="login.php">Iniciar sesión</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <header class="bg-institucional text-white py-5">
    <div class="container">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <span class="badge badge-framework rounded-pill mb-3">ISW-306 · Etapa 4 de 4</span>
          <h1 class="display-5 fw-bold">Estandarización, Frameworks y Entrega Final</h1>
          <p class="lead mb-0">
            Aplicación web profesional con Bootstrap, CRUD completo, API REST, persistencia SQLite y autenticación con sesiones PHP, control visual por roles y vistas personalizadas para administrador, estudiante e invitado.
          </p>
        </div>
        <div class="col-lg-4">
          <div class="card card-soft text-institucional">
            <div class="card-body">
              <h2 class="h5 fw-bold">Estado del sistema</h2>
              <p class="mb-2">Framework CSS: <strong>Bootstrap 5</strong></p>
              <p class="mb-2">Backend: <strong>PHP + SQLite</strong></p>
              <p class="mb-0">Sesión: <strong><?= $usuario ? 'Activa (' . htmlspecialchars($usuario['rol']) . ')' : 'No iniciada' ?></strong></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <main class="container py-5">
    <section class="row g-4 mb-4">
      <div class="col-md-4">
        <article class="card card-soft h-100">
          <div class="card-body">
            <h2 class="h5 text-institucional fw-bold">Framework CSS</h2>
            <p class="mb-0">La interfaz fue refactorizada con Bootstrap para mejorar la consistencia visual.</p>
          </div>
        </article>
      </div>
      <div class="col-md-4">
        <article class="card card-soft h-100">
          <div class="card-body">
            <h2 class="h5 text-institucional fw-bold">CRUD completo</h2>
            <p class="mb-0">Permite crear, leer, actualizar y eliminar registros usando API REST.</p>
          </div>
        </article>
      </div>
      <div class="col-md-4">
        <article class="card card-soft h-100">
          <div class="card-body">
            <h2 class="h5 text-institucional fw-bold">Sesiones y roles</h2>
            <p class="mb-0">Administrador gestiona usuarios; estudiante e invitado solo acceden a su panel personal.</p>
          </div>
        </article>
      </div>
    </section>

    <div class="card card-soft">
      <div class="card-body p-4">
        <h2 class="h4 text-institucional fw-bold">Acceso de prueba</h2>
        <p>Para probar el sistema completo en XAMPP:</p>
        <ul>
          <li>Usuario: <strong>admin@grupo9.com</strong></li>
          <li>Contraseña: <strong>Admin123</strong></li>
        </ul>
        <?php if ($usuario && esAdministrador()): ?>
          <a class="btn btn-institucional" href="registro.php">Entrar al panel CRUD</a>
        <?php elseif ($usuario): ?>
          <a class="btn btn-institucional" href="panel.php">Entrar a mi panel</a>
        <?php else: ?>
          <a class="btn btn-institucional" href="login.php">Entrar al sistema</a>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <footer class="bg-institucional text-white text-center py-3">
    <p class="mb-0">&copy; 2026 - Proyecto realizado por Hector Ovalles</p>
  </footer>
</body>
</html>
