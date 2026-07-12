# Corrección aplicada

Se corrigió el inicio de sesión para que no dependa solamente del usuario administrador.

Ahora el archivo `login.php` valida dos fuentes:

1. `usuarios_sistema`: administrador inicial del sistema.
2. `usuarios`: personas registradas desde el panel CRUD.

Esto permite que, después de crear una persona en el CRUD, esa persona pueda cerrar sesión e iniciar sesión con su correo y contraseña.

También se mantiene la funcionalidad de la Etapa 3:
- API REST en `api/usuarios.php`.
- Base de datos SQLite.
- Script `database/database.sql`.
- CRUD completo.
- Validaciones de datos.
- Contraseñas protegidas con `password_hash`.
