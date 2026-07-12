# Vistas profesionales por rol

El sistema ahora presenta una vista diferente según el rol del usuario.

## Administrador
Ruta principal después del login: `panel.php`  
Puede acceder al CRUD desde el botón **CRUD** o **Abrir CRUD de usuarios**.

Funciones:
- Crear usuarios.
- Consultar usuarios.
- Editar usuarios.
- Eliminar usuarios.
- Ver documentación de API.

## Estudiante
Ruta principal después del login: `panel.php`

Funciones:
- Ver panel académico personal.
- Ver sus datos principales.
- No puede acceder al CRUD.

## Invitado
Ruta principal después del login: `panel.php`

Funciones:
- Ver panel informativo básico.
- No puede acceder al CRUD.
- No puede modificar registros.

## Protección real
No solo se ocultan botones. También se protege el backend:

- `registro.php` usa `requerirAdministrador()`.
- `api/usuarios.php` usa `requerirAdministradorApi()`.

Esto evita que un estudiante o invitado modifique usuarios aunque intente entrar manualmente a la ruta.
