# Proyecto Integrador – Etapa 4: Cierre del Proyecto

## Participante
Hector Ovalles

## Descripción
Esta versión corresponde al cierre del proyecto. Integra la etapa de backend y persistencia de datos con una interfaz refactorizada usando Bootstrap, CRUD completo y autenticación básica mediante sesiones PHP.

## Tecnologías utilizadas
- HTML5
- Bootstrap 5
- CSS personalizado
- JavaScript
- PHP 8 o superior
- SQLite mediante PDO
- API REST
- Sesiones PHP con `session_start()`

## Funciones implementadas
- Interfaz refactorizada con Bootstrap.
- Login y logout con sesiones del servidor.
- Control visual y funcional por roles.
- Inicio de sesión con el administrador o con usuarios creados desde el CRUD.
- Protección de rutas privadas.
- El rol administrador puede usar el CRUD.
- Los roles estudiante e invitado solo acceden a su panel personal.
- API protegida contra acceso sin sesión.
- CRUD completo de usuarios:
  - Create
  - Read
  - Update
  - Delete
- Persistencia de datos en SQLite.
- Contraseñas protegidas con `password_hash`.
- Script SQL de exportación.
- Migración SQL básica.
- Documentación OpenAPI/Swagger básica en `docs/openapi.json`.

## Roles del sistema
- `administrador`: puede crear, consultar, editar y eliminar usuarios.
- `estudiante`: puede iniciar sesión y ver su panel personal.
- `invitado`: puede iniciar sesión y ver su panel personal.

## Acceso de prueba
```text
Correo: admin@grupo9.com
Contraseña: Admin123
```

Después de crear un usuario en el panel CRUD, ese usuario también puede iniciar sesión usando su correo y la contraseña registrada.

## Estructura principal
```text
api/usuarios.php                    API REST con operaciones CRUD
config/database.php                 Conexión SQLite y creación automática de tablas
config/auth.php                     Funciones de autenticación y protección de sesión
login.php                           Pantalla de inicio de sesión
logout.php                          Cierre de sesión
registro.php                        Panel CRUD protegido solo para administrador
panel.php                           Panel personal para estudiante e invitado
index.php                           Página principal de la etapa final
css/style.css                       Estilos personalizados sobre Bootstrap
js/app.js                           Consumo de la API desde el frontend
database/database.sql               Script de exportación de la base de datos
database/migrations/001_create_tables.sql
docs/openapi.json                   Documentación básica de API
docs/GUIA_VIDEO_DEFENSA.md          Guía para grabar el video de defensa
```

## Instalación con XAMPP en Windows
1. Instale XAMPP.
2. Copie la carpeta del proyecto dentro de:
   `C:\xampp\htdocs\etapa-4-cierre`
3. Abra el panel de XAMPP e inicie **Apache**.
4. En el navegador, entre a:
   `http://localhost/etapa-4-cierre/`
5. Inicie sesión con:
   `admin@grupo9.com` / `Admin123`
6. Entre al panel CRUD y pruebe crear, consultar, editar y eliminar usuarios.
7. Cree un usuario con rol estudiante o invitado, cierre sesión e inicie con ese usuario para comprobar que solo puede ver su panel personal.

> No abra el proyecto dando doble clic sobre los archivos, porque PHP necesita ejecutarse desde Apache.

## Base de datos
La base de datos `database/proyecto.sqlite` se crea automáticamente al utilizar la aplicación por primera vez.

El script solicitado por el docente está en:

```text
database/database.sql
```

## Endpoints de la API
| Método | Ruta | Función |
|---|---|---|
| GET | `api/usuarios.php` | Consultar todos los usuarios |
| GET | `api/usuarios.php?id=1` | Consultar un usuario |
| POST | `api/usuarios.php` | Crear usuario |
| PUT | `api/usuarios.php?id=1` | Actualizar usuario |
| DELETE | `api/usuarios.php?id=1` | Eliminar usuario |
| DELETE | `api/usuarios.php?all=1` | Eliminar todos los usuarios |

## Rama recomendada para la entrega final
```bash
git checkout main
git pull origin main
git checkout -b etapa-4/cierre
git add .
git commit -m "Completar etapa final con Bootstrap CRUD y sesiones"
git push -u origin etapa-4/cierre
```

## Nota sobre GitHub Pages
GitHub Pages puede mostrar la parte visual, pero no ejecuta PHP ni SQLite. Para probar la funcionalidad completa del backend debe usarse XAMPP con Apache activo.


## Vistas profesionales por rol
El sistema incluye una experiencia visual diferente según el rol:

- **Administrador:** panel administrativo y acceso al CRUD.
- **Estudiante:** panel académico personal sin permisos de modificación.
- **Invitado:** panel informativo básico sin permisos administrativos.

La documentación de esta parte está en:

```text
docs/VISTAS_POR_ROL.md
```
