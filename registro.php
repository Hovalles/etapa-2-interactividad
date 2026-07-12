<?php
declare(strict_types=1);

require_once __DIR__ . '/config/auth.php';
requerirAdministrador();
$usuarioSesion = obtenerUsuarioSesion();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="author" content="Hector Ovalles" />
  <title>Panel Administrativo CRUD - Proyecto Integrador</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-institucional">
    <div class="container">
      <a class="navbar-brand fw-bold" href="index.php">Proyecto Integrador</a>
      <div class="d-flex align-items-center gap-3">
        <span class="text-white small d-none d-md-inline"><?= htmlspecialchars(($usuarioSesion['nombre'] ?? 'Usuario') . ' - ' . ($usuarioSesion['rol'] ?? '')) ?></span>
        <a class="btn btn-outline-light btn-sm" href="index.php">Inicio</a>
        <a class="btn btn-institucional btn-sm" href="logout.php">Cerrar sesión</a>
      </div>
    </div>
  </nav>

  <main class="container py-5">
    <section class="row g-4">
      <aside class="col-lg-3">
        <div class="card card-soft">
          <div class="card-body">
            <h1 class="h5 text-institucional fw-bold">Panel de administrador</h1>
            <p>Esta vista pertenece al administrador. Desde aquí se crean, editan y eliminan usuarios.</p>
            <ul class="small">
              <li>El correo y el usuario no pueden repetirse.</li>
              <li>La contraseña debe tener al menos 6 caracteres.</li>
              <li>El panel está protegido con sesiones PHP.</li>
              <li>Estudiante e invitado solo acceden a su panel personal.</li>
            </ul>
          </div>
        </div>
      </aside>

      <section class="col-lg-9">
        <article class="card card-soft mb-4">
          <div class="card-body p-4">
            <p class="text-uppercase text-warning fw-bold small mb-1">Persistencia de datos</p>
            <h2 class="h3 text-institucional fw-bold" id="tituloFormulario">Crear nuevo usuario</h2>

            <div id="mensajeFormulario" class="form-message" hidden></div>

            <form action="#" method="post" id="registroForm" novalidate>
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="nombre" class="form-label fw-bold">Nombre completo</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Hector Ovalles" required />
                </div>
                <div class="col-md-6">
                  <label for="correo" class="form-label fw-bold">Correo electrónico</label>
                  <input type="email" class="form-control" id="correo" name="correo" placeholder="ejemplo@correo.com" required />
                </div>
                <div class="col-md-6">
                  <label for="telefono" class="form-label fw-bold">Teléfono</label>
                  <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="809-000-0000" required />
                </div>
                <div class="col-md-6">
                  <label for="usuario" class="form-label fw-bold">Usuario</label>
                  <input type="text" class="form-control" id="usuario" name="usuario" placeholder="hector.ovalles" required />
                </div>
                <div class="col-md-6">
                  <label for="password" class="form-label fw-bold">Contraseña</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Mínimo 6 caracteres" required />
                  <small id="ayudaPassword">Obligatoria para crear un usuario.</small>
                </div>
                <div class="col-md-6">
                  <label for="rol" class="form-label fw-bold">Rol</label>
                  <select id="rol" name="rol" class="form-select" required>
                    <option value="">Seleccione una opción</option>
                    <option value="estudiante">Estudiante</option>
                    <option value="administrador">Administrador</option>
                    <option value="invitado">Invitado</option>
                  </select>
                </div>
                <div class="col-12">
                  <label for="comentario" class="form-label fw-bold">Comentario</label>
                  <textarea id="comentario" name="comentario" class="form-control" rows="4" placeholder="Escriba una observación opcional"></textarea>
                </div>
              </div>

              <div class="d-flex gap-2 flex-wrap mt-4">
                <button type="submit" class="btn btn-institucional" id="botonGuardar">Registrar</button>
                <button type="reset" class="btn btn-secondary" id="botonLimpiar">Limpiar</button>
                <button type="button" class="btn btn-outline-secondary" id="cancelarEdicion" hidden>Cancelar edición</button>
              </div>
            </form>
          </div>
        </article>

        <section class="card card-soft">
          <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-3">
              <div>
                <p class="text-uppercase text-warning fw-bold small mb-1">Base de datos</p>
                <h2 class="h3 text-institucional fw-bold">Usuarios registrados</h2>
              </div>
              <button type="button" id="limpiarTabla" class="btn btn-outline-danger">Eliminar todos</button>
            </div>

            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <div class="p-3 rounded bg-light border-start border-4 border-warning">
                  <strong id="totalUsuarios" class="fs-3 text-institucional d-block">0</strong>
                  <span>Total de usuarios</span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="p-3 rounded bg-light border-start border-4 border-warning">
                  <strong id="ultimoRegistro" class="fs-3 text-institucional d-block">Sin registros</strong>
                  <span>Último registro</span>
                </div>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-hover align-middle" id="tablaUsuarios">
                <thead class="table-dark">
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </section>
      </section>
    </section>
  </main>

  <script src="js/app.js"></script>
</body>
</html>
