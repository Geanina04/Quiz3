# Quiz 3 - CRUD de cursos y matrícula de estudiantes (CodeIgniter 4, MVC)

Aplicación hecha con el framework **CodeIgniter 4.7** siguiendo el patrón Modelo-Vista-Controlador.

## Funcionalidades

**CRUD de cursos** (`/courses`): cada curso tiene Nombre del Curso, Código de Curso, Cantidad de Créditos y Carrera. Las carreras vienen de un seed en la base de datos y se eligen en un dropdown. Se puede listar, crear, editar y eliminar (eliminar usa POST).

**Matrícula de estudiantes** (página principal `/`): formulario con los datos del estudiante (nombre, cédula y correo) y un listado de cursos cargado desde la base de datos (seed). Al presionar **Matricular** se guarda el registro y se muestran los datos de la matrícula: número, estudiante, curso, créditos, carrera y fecha.

Reglas de negocio:
- El código de curso es único y se guarda en mayúsculas.
- Un estudiante no puede matricularse dos veces en el mismo curso.
- Un curso que ya tiene matrículas no se puede eliminar.

## MVC

| Capa | Archivos | Responsabilidad |
|---|---|---|
| **Modelo** | `app/Models/CourseModel.php`, `EnrollmentModel.php`, `CareerModel.php` | Acceso a datos y validaciones |
| **Vista** | `app/Views/enrollments/`, `app/Views/courses/`, `app/Views/layouts/main.php` | Solo HTML con datos escapados (`esc()`) |
| **Controlador** | `app/Controllers/Enrollments.php`, `Courses.php` | Leen la petición, llaman al modelo y eligen la vista |
| **Rutas** | `app/Config/Routes.php` | URL -> acción del controlador |

## Rutas

| Verbo | URL | Descripción |
|---|---|---|
| GET | `/` | Formulario de matrícula |
| POST | `/enrollments` | Guarda la matrícula |
| GET | `/enrollments/{id}` | Datos del registro de matrícula |
| GET | `/courses` | Listado de cursos |
| GET | `/courses/create` | Formulario para crear un curso |
| POST | `/courses` | Crea el curso |
| GET | `/courses/{id}/edit` | Formulario de edición |
| POST | `/courses/{id}/update` | Guarda los cambios |
| POST | `/courses/{id}/delete` | Elimina el curso |

## Base de datos

Base propia: `quiz3`, con las tablas `careers` (seed de 6 carreras), `courses` (seed de 8 cursos) y `enrollments` (llaves foráneas a `courses`).

Hay dos formas de crearla:

1. **phpMyAdmin**: pestaña **Importar** y subir `database.sql` (ya incluye el seed de carreras y cursos).
2. **Migraciones de CodeIgniter**:
   ```
   php spark migrate
   php spark db:seed QuizSeeder
   ```
   (antes hay que crear la base `quiz3` vacía).

## Instalación

Requiere PHP 8.2 o superior con las extensiones `intl`, `mbstring` y `mysqli`. En XAMPP, si aparece un error por `intl`, quitar el `;` de `extension=intl` en `php.ini` y reiniciar Apache.

1. Iniciar **Apache** y **MySQL**.
2. Importar `database.sql` en phpMyAdmin.
3. Copiar el proyecto en `htdocs` (por ejemplo `htdocs/quiz3`) y abrir `http://localhost/quiz3/`.
   - Alternativa: apuntar el `DocumentRoot` de un virtual host a la carpeta `public/`.
4. Si MySQL tiene contraseña o usa otro puerto, ajustarlo en `.env`.

No hace falta Composer: la carpeta `system/` ya trae el framework. La URL base se detecta sola. El archivo `.env` va incluido en el repositorio porque solo tiene los valores por defecto de XAMPP.

## Seguridad

- Protección **CSRF** activa en todos los formularios.
- Consultas con el Query Builder de CodeIgniter (sentencias preparadas).
- Toda salida de las vistas pasa por `esc()`.
- Actualizar y eliminar solo aceptan POST.
- El `.htaccess` de la raíz reenvía todo a `public/`, así que `app/`, `system/`, `writable/` y `.env` no se pueden abrir por URL.
