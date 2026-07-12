# Guía para el video de defensa técnica

Duración máxima: 5 minutos.

## 1. Presentación inicial
Buenas tardes, mi nombre es Hector Ovalles. En este video presento la etapa final del Proyecto Integrador de ISW-306.

## 2. Arquitectura del proyecto
El proyecto está organizado en frontend, backend y base de datos.

- Frontend: HTML, Bootstrap, CSS y JavaScript.
- Backend: PHP.
- Base de datos: SQLite.
- API: archivo `api/usuarios.php`.

## 3. Framework CSS
La interfaz fue refactorizada con Bootstrap 5. Esto mejora la organización visual, la respuesta en diferentes pantallas y la estandarización de los componentes.

## 4. CRUD
Mostrar el panel `registro.php` y explicar:
- Crear usuario.
- Leer usuarios desde la tabla.
- Editar usuario.
- Eliminar usuario.
- Eliminar todos los usuarios.

## 5. Sesiones
Mostrar el login:
- Usuario: admin@grupo9.com
- Contraseña: Admin123

Explicar que `login.php` crea la sesión, `logout.php` la destruye y `config/auth.php` protege las rutas privadas.

## 6. Base de datos
Mostrar:
- `database/database.sql`
- `database/proyecto.sqlite` se crea automáticamente.
- `usuarios` guarda los datos del CRUD.
- `usuarios_sistema` guarda el usuario de acceso al sistema.

## 7. Cierre
Indicar que el proyecto cumple con el uso de framework, CRUD completo, autenticación básica con sesiones y código organizado.
