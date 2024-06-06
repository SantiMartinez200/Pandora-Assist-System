# Instalación de la Aplicación Web.

### PASO 1: Instalación de Tecnologías
Instalar Laragon completo, la versión de PHP debe ser 8.1.10
***
Instalar NODEjs.
***
Instalar composer en Laragon -> Bin -> Php
***
### PASO 2 Clonar
Bajar el archivo .zip  o clonar este repositorio.
***
### PASO 3 Archivos de Configuracion & URL.
Copiar y Pegar el archivo ".env.example", renombrar la copia a ".env", configurar credenciales de BD 
***
Cambiar la URL a una personalizada de laragon "{app}.test" o utilizar Localhost, 127.0.0.1, http://localhost.
***
### PASO 4 Correr las Dependencias.

Abrir la carpeta de la aplicación con la terminal de Laragon, correr los siguientes comandos: 
***
	```
    composer Install 
	php artisan key:generate 
	npm install 
	npm run dev 
	php artisan migrate --seed (Esto creará registros básicos para la previsualización de la aplicación)
    ```
***
## Usuario y Registro.
La semilla "--seed" generará el siguiente **(y único)** usuario administrador.
***
	-Usuario: javierparra@gmail.com
 ***
	-Contraseña: root


#### AVISO IMPORTANTE.
  Para el correcto funcionamiento de los Reportes de PDF / Excel y el filtrado de alumnos para la carga de asistencias, luego de ejecutar el --seed, ir a la base de datos, tabla ('years') y cambiar los posibles años que generó el seeder, mediante el siguiente formato:

## ID: 1, year: Primero, created_at:(CualesQuiera), updated_at:(CualesQuiera)
## ID: 2, year: Segundo, created_at:(CualesQuiera), updated_at:(CualesQuiera)
## ID: 3, year: Tercero, created_at:(CualesQuiera), updated_at:(CualesQuiera)

  De lo contrario, se repetirán los años en las opciones de selección y habrá confusiones y errores.
	

