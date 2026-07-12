# Corrección de roles visuales y permisos

En esta versión el sistema separa los permisos por rol:

## Administrador
Puede:
- Iniciar sesión.
- Entrar al panel CRUD.
- Crear usuarios.
- Consultar usuarios.
- Editar usuarios.
- Eliminar usuarios.

## Estudiante e invitado
Pueden:
- Iniciar sesión.
- Ver su panel personal.

No pueden:
- Entrar al panel CRUD.
- Crear usuarios.
- Editar usuarios.
- Eliminar usuarios.

## Archivos modificados
- `config/auth.php`: funciones `esAdministrador`, `requerirAdministrador` y `requerirAdministradorApi`.
- `login.php`: redirección por rol.
- `panel.php`: panel visual para estudiante/invitado.
- `registro.php`: protegido solo para administrador.
- `api/usuarios.php`: API protegida contra usuarios sin permiso.
- `index.php`: botones dinámicos según el rol.
