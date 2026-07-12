<?php
declare(strict_types=1);

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/auth.php';

function redirigirSegunRol(): void
{
    header('Location: panel.php');
    exit;
}

if (usuarioAutenticado()) {
    redirigirSegunRol();
}

$error = '';

function crearSesion(array $usuario, string $tipoCuenta): void
{
    session_regenerate_id(true);
    $_SESSION['usuario_sistema'] = [
        'id' => (int) $usuario['id'],
        'nombre' => $usuario['nombre'],
        'correo' => $usuario['correo'],
        'rol' => $usuario['rol'],
        'tipo_cuenta' => $tipoCuenta
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = strtolower(trim((string) ($_POST['correo'] ?? '')));
    $password = (string) ($_POST['password'] ?? '');

    if ($correo === '' || $password === '') {
        $error = 'Debe completar el correo y la contraseña.';
    } else {
        $pdo = obtenerConexion();

        $consultaAdmin = $pdo->prepare(
            'SELECT id, nombre, correo, password_hash, rol
             FROM usuarios_sistema
             WHERE correo = :correo AND activo = 1
             LIMIT 1'
        );
        $consultaAdmin->execute(['correo' => $correo]);
        $admin = $consultaAdmin->fetch();

        if ($admin && password_verify($password, $admin['password_hash'])) {
            crearSesion($admin, 'administrador_sistema');
            redirigirSegunRol();
        }

        $consultaUsuario = $pdo->prepare(
            'SELECT id, nombre, correo, password_hash, rol
             FROM usuarios
             WHERE correo = :correo
             LIMIT 1'
        );
        $consultaUsuario->execute(['correo' => $correo]);
        $usuarioRegistrado = $consultaUsuario->fetch();

        if ($usuarioRegistrado && password_verify($password, $usuarioRegistrado['password_hash'])) {
            crearSesion($usuarioRegistrado, 'usuario_registrado');
            redirigirSegunRol();
        }

        $error = 'Credenciales incorrectas. Puede usar el administrador o un usuario creado en el CRUD.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="author" content="Hector Ovalles" />
  <title>Login - Proyecto Integrador</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <main class="min-vh-100 d-flex align-items-center py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-5">
          <div class="card card-soft">
            <div class="card-body p-4 p-md-5">
              <div class="text-center mb-4">
                <span class="brand-logo mb-3">HO</span>
                <h1 class="h3 text-institucional fw-bold">Acceso al sistema</h1>
                <p class="text-secondary mb-0">Etapa 4 - Sesiones y control de roles</p>
              </div>

              <?php if ($error): ?>
                <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div>
              <?php endif; ?>

              <form method="post" action="login.php" autocomplete="off">
                <div class="mb-3">
                  <label for="correo" class="form-label fw-bold">Correo</label>
                  <input type="email" class="form-control" id="correo" name="correo" value="admin@grupo9.com" required>
                </div>

                <div class="mb-3">
                  <label for="password" class="form-label fw-bold">Contraseña</label>
                  <input type="password" class="form-control" id="password" name="password" value="Admin123" required>
                </div>

                <button class="btn btn-institucional w-100" type="submit">Iniciar sesión</button>
              </form>

              <div class="alert alert-info mt-4 mb-2 small">
                Usuario administrador de prueba:<br>
                <strong>admin@grupo9.com</strong> / <strong>Admin123</strong>
              </div>

              <div class="alert alert-secondary small mb-0">
                Los usuarios creados desde el CRUD también pueden iniciar sesión. 
                Los roles <strong>estudiante</strong> e <strong>invitado</strong> solo ven su panel. 
                El rol <strong>administrador</strong> puede gestionar usuarios.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
