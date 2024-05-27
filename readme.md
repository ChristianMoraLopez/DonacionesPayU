# Proyecto de Donaciones con PayU

Este proyecto es una aplicación web simple para simular el proceso de donaciones utilizando la plataforma de pagos PayU. La donación en esta página es ficticia, pero si deseas hacer una donación real, puedes hacerlo haciendo clic en el botón verde proporcionado.

[Acceder a la Página de Donaciones](https://donacionespayu-3gbz36ec.b4a.run/index.php)

## Donaciones Reales

Si deseas realizar una donación real, haz clic en el siguiente botón:

[![Botón de Donación](https://ecommerce.payulatam.com/img-secure-2015/boton_pagar_mediano.png)](https://biz.payulatam.com/B0f65017F0BD626)

## Uso de Composer

Este proyecto utiliza Composer para gestionar las dependencias de PHP. En particular, Composer se utiliza para incluir la biblioteca de PayU en el proyecto.

### Instalación de Composer

Si no tienes Composer instalado, sigue las instrucciones en [getcomposer.org](https://getcomposer.org/download/) para instalarlo en tu sistema.

### Instalación de Dependencias

Después de clonar este repositorio, ejecuta el siguiente comando en la terminal para instalar las dependencias necesarias:

```
composer install
```

Este comando leerá el archivo `composer.json` y descargará las bibliotecas especificadas en el directorio `vendor`.

### ¿Cómo Muestra Esto que Se Utiliza Composer?

La presencia del archivo `composer.json` en este repositorio indica que el proyecto utiliza Composer para gestionar sus dependencias. Cuando ejecutas `composer install`, Composer lee este archivo y descarga las bibliotecas necesarias, en este caso, la biblioteca de PayU, que se utiliza en el proyecto para procesar los pagos.

## Estructura del Proyecto

- `index.php`: Contiene el formulario de donación y el proceso de pago utilizando la API de PayU.
- `src/procesar_pago.php`: Maneja la lógica de procesamiento de pagos y la comunicación con la API de PayU.
- `vendor/`: Directorio generado por Composer que contiene las dependencias de PHP.

## Tecnologías Utilizadas

- PHP
- HTML
- JavaScript

## Contribuir

¡Siéntete libre de contribuir con mejoras a este proyecto! Puedes hacerlo creando pull requests o reportando problemas en la sección de issues.

## Créditos

Este proyecto fue creado por Christian Mora  como parte de Capacitación en OET PHP.
