# Instrucciones para correr el proyecto cimat-test en Mac OS, Windows y Linux
Este archivo README.md contiene las instrucciones para configurar y ejecutar el proyecto. A continuación, se detallan los pasos necesarios para instalar y ejecutar el proyecto.

## Requisitos previos
Antes de comenzar, asegúrese de tener instalados los siguientes requisitos previos en su sistema:

PHP >= 7.3
Composer
Node.js >= 10.x
npm
MySQL o cualquier otro motor de bases de datos compatible con Laravel

## Crear base de datos
Abrir la línea de comandos de MySQL y ejecutar los siguientes comandos

```sql
CREATE DATABASE test;

USE test;

CREATE TABLE ECOBICI (
  id INT NOT NULL AUTO_INCREMENT,
  Genero_Usuario VARCHAR(10),
  Edad_Usuario INT,
  Bici INT,
  Ciclo_Estacion_Retiro INT,
  Fecha_Retiro DATE,
  Hora_Retiro VARCHAR(10),
  Ciclo_Estacion_Arribo INT,
  Fecha_Arribo DATE,
  Hora_Arribo VARCHAR(10),
  PRIMARY KEY (id)
);
```

## Clonar el repositorio
Para empezar, clone el repositorio del proyecto Laravel en su sistema. Para hacer esto, ejecute el siguiente comando en la terminal:

```bash
git clone https://github.com/iChema/cimat-test.git
```

## Instalar dependencias
Una vez que se haya clonado el repositorio, acceda a la carpeta del proyecto Laravel y ejecute el siguiente comando en la terminal para instalar las dependencias del proyecto:

```bash
cd cimat-test
composer install
npm install
```

## Configurar el archivo .env
Laravel utiliza un archivo .env para almacenar la configuración de la aplicación, como las credenciales de la base de datos y la información de la aplicación. Lo excluí del .gitignore para que pueda ser usado.


## Ejecutar el servidor
Finalmente, ejecutar el servidor de desarrollo de Laravel para ver la aplicación en su navegador. Para hacer esto, ejecute el siguiente comando en la terminal:

```bash
php artisan serve
```

La aplicación debería estar disponible en http://localhost:8000.

## Nota adicional para Windows
Si está usando Windows, puede encontrar algunos problemas con la instalación de dependencias en la terminal. En ese caso, debe descargar XAMPP, y agregar la dirección de PHP en la variable de entorno PATH en las configuraciones del sistema. Luego, debe ejecutar los comandos previamente mencionados.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).