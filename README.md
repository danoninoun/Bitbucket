Fase IAW 1 – Desarrollo del formulario PHP

Este proyecto es una pequeña aplicación web desarrollada en PHP para gestionar el alta de empleados de una empresa. El objetivo principal es practicar la validación de formularios, la modularización de código (separando lógica y vista) y el manejo de estructuras de datos básicas (arrays).


Características:

Formulario de Alta: Permite introducir nombre, apellidos, DNI, correo, teléfono, fecha de alta, provincia, sede y departamento.

Validación:
  
  -Validación en cliente mediante atributos HTML (required, tipos de input).
  
  -Validación robusta en servidor (PHP) para DNI (algoritmo del módulo 23), formato de correo y teléfono.

Persistencia de datos: Si hay un error en el envío, el formulario "recuerda" los datos introducidos para que el usuario no tenga que escribirlos de nuevo (función old).

Modularidad: Código organizado en funciones y archivos separados.

Estructura del Proyecto:

    Bitbucket/

      │  ├── public/
        
      │  │   ├── index.php
        
      │  │   └── style.css
        
      │  │   
        
      │  └── src/
        
      │      ├── datos.php
            
      │      ├── validaciones.php
            
      │      └── vistas.php
      README.md


Cómo ejecutarlo

  1.Para probar la aplicación en local, necesitas tener instalado PHP.

  2.Abre una terminal en la carpeta raíz del proyecto.
  
  3.Ejecuta el servidor interno de PHP apuntando a la carpeta public:
  
      php -S localhost:8000 -t public
  
  4.Abre tu navegador web y entra en la siguiente dirección:
  
    http://localhost:8000
