# Proyecto-Apuntame

**Proyecto de final de curso – Desarrollo de Aplicaciones Multiplataforma (DAM)**

Apuntame es una aplicación web destinada a la gestión de películas y series. Permite a los usuarios organizar sus contenidos audiovisuales, guardar películas y series en su biblioteca personal, consultar información y gestionar sus preferencias.

## Requisitos previos

Antes de ejecutar el proyecto, es necesario instalar las siguientes herramientas:

- [XAMPP](https://www.apachefriends.org/es/index.html): proporciona PHP para ejecutar el proyecto.
- [Composer](https://getcomposer.org/): gestor de dependencias de PHP.
- [PostgreSQL](https://www.postgresql.org/download/): sistema de gestión de bases de datos utilizado por el proyecto.
- [Git](https://git-scm.com/downloads): necesario para descargar el repositorio.

## 1. Instalar XAMPP

1. Acceder a https://www.apachefriends.org/es/index.html.
2. Descargar la versión de XAMPP compatible con nuestro sistema operativo.
3. Ejecutar el instalador y seguir los pasos indicados.
4. Se recomienda instalarlo en la ruta predeterminada:

   `C:\xampp`

5. Una vez instalado, abrir el panel de control de XAMPP.

No es necesario iniciar Apache ni MySQL desde XAMPP para ejecutar Laravel mediante su servidor de desarrollo. Utilizaremos PHP desde la terminal.

## 2. Configurar PHP en las variables de entorno

Para poder utilizar PHP desde cualquier terminal, es necesario añadir su ubicación a las variables de entorno de Windows.

1. Buscar en Windows «Editar las variables de entorno del sistema».
2. Acceder a «Variables de entorno».
3. En el apartado de variables del sistema, seleccionar `Path`.
4. Pulsar en «Editar» y añadir la siguiente ruta:

   `C:\xampp\php`

5. Guardar los cambios y cerrar las ventanas.

Para comprobar que PHP está correctamente instalado, abrir una terminal (CMD o PowerShell) y ejecutar:

```bash
php -v
```

Si aparece la versión de PHP instalada, la configuración se ha realizado correctamente.

## 3. Instalar Composer

Composer es el gestor de dependencias que utiliza PHP. Laravel lo necesita para instalar las librerías que requiere el proyecto.

1. Acceder a https://getcomposer.org/download/.
2. Descargar el instalador de Windows (`Composer-Setup.exe`).
3. Ejecutar el instalador.
4. Cuando solicite la ubicación de PHP, seleccionar:

   `C:\xampp\php\php.exe`

5. Completar la instalación.

Para comprobar que Composer funciona correctamente, abrir una nueva terminal y ejecutar:

```bash
composer -V
```

Si aparece la versión de Composer, ya estará instalado correctamente.

## 4. Instalar PostgreSQL

El proyecto utiliza PostgreSQL como sistema de gestión de bases de datos.

1. Acceder a https://www.postgresql.org/download/.
2. Descargar el instalador correspondiente a Windows.
3. Ejecutar el instalador y seguir los pasos indicados.
4. Durante la instalación, establecer una contraseña para el usuario administrador `postgres`.
5. Recordar la contraseña, ya que será necesaria para configurar la conexión con Laravel.

Una vez instalado PostgreSQL, crear una base de datos para el proyecto llamada:

`apuntame`

Se puede realizar esta operación utilizando pgAdmin o la consola de PostgreSQL.

## 5. Descargar el proyecto

Abrir una terminal y dirigirse a la carpeta donde se quiera guardar el proyecto.

Clonar el repositorio:

```bash
git clone URL_DEL_REPOSITORIO
```

Entrar en la carpeta del proyecto:

```bash
cd Proyecto-Apuntame
```

## 6. Instalar las dependencias del proyecto

Una vez dentro de la carpeta del proyecto, ejecutar:

```bash
composer install
```

Este comando instalará todas las dependencias necesarias definidas en el archivo `composer.json`.

Es importante esperar a que finalice el proceso antes de continuar.

## 7. Configurar el archivo de entorno (.env)

Laravel utiliza el archivo `.env` para almacenar la configuración del entorno, como los datos de conexión a la base de datos.

Crear una copia del archivo de ejemplo:

```bash
copy .env.example .env
```

A continuación, abrir el archivo `.env` con un editor de código y configurar los siguientes parámetros:

```env
APP_NAME=Apuntame
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=apuntame
DB_USERNAME=postgres
DB_PASSWORD=TU_CONTRASEÑA
```

**IMPORTANTE:** Sustituir `TU_CONTRASEÑA` por la contraseña que se estableció durante la instalación de PostgreSQL.

Comprobar también que el nombre de la base de datos coincide con el que se ha creado anteriormente.

## 8. Generar la clave de la aplicación

Laravel necesita una clave de seguridad para funcionar correctamente.

Ejecutar el siguiente comando:

```bash
php artisan key:generate
```

Este comando generará automáticamente la clave de aplicación y la guardará en el archivo `.env`.

## 9. Ejecutar las migraciones

Para crear las tablas necesarias en la base de datos, importa el documento llamado cine_series.sql, que esta adjunto en el proyecto:


Laravel utilizará los archivos del proyecto para generar la estructura de la base de datos.



## 10. Iniciar el proyecto

Una vez realizados todos los pasos anteriores, ya se puede iniciar la aplicación.

Desde la carpeta raíz del proyecto, ejecutar:

```bash
php artisan serve
```

Si todo funciona correctamente, aparecerá un mensaje similar al siguiente:

```text
INFO  Server running on [http://127.0.0.1:8000].
```

Abrir el navegador y acceder a:

**http://127.0.0.1:8000**

¡Ya estará funcionando Apuntame en local!

## 11. Detener el servidor

Para detener la ejecución del proyecto, volver a la terminal donde se está ejecutando Laravel y pulsar:

`CTRL + C`

Para volver a iniciar la aplicación en otra ocasión, únicamente será necesario entrar en la carpeta del proyecto y ejecutar:

```bash
php artisan serve
```

---

## Resolución de problemas habituales

**Error: `php` no se reconoce como un comando**

Comprobar que la ruta `C:\xampp\php` está añadida correctamente a las variables de entorno y abrir una nueva terminal.

**Error: `composer` no se reconoce como un comando**

Comprobar que Composer se ha instalado correctamente y que su ruta está añadida a las variables de entorno.

**Error de conexión con PostgreSQL**

Comprobar que PostgreSQL está iniciado, que la base de datos existe y que los datos del archivo `.env` son correctos.

**Error relacionado con las dependencias**

Volver a ejecutar:

```bash
composer install
```

**Error al ejecutar las migraciones**

Comprobar que la conexión a PostgreSQL funciona y que las credenciales del archivo `.env` son correctas.

---

## Tecnologías utilizadas

- **PHP:** lenguaje de programación del lado del servidor.
- **Laravel:** framework utilizado para estructurar la aplicación.
- **Blade:** motor de plantillas utilizado para generar las vistas.
- **PostgreSQL:** sistema de gestión de bases de datos.
- **Composer:** gestor de dependencias de PHP.
- **HTML, CSS y JavaScript:** tecnologías utilizadas para la interfaz de usuario.

## Autores

Proyecto desarrollado como trabajo de final de curso del ciclo formativo de Desarrollo de Aplicaciones Multiplataforma (DAM).

Por Javier Martín García y Álvaro Colmenero Rodríguez