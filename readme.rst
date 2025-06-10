Eternals Vibes - Instrucciones de Despliegue
============================================

Este proyecto ha sido desarrollado con CodeIgniter y está preparado para desplegarse en cualquier servidor compatible con PHP y MySQL.

Pasos para desplegar el proyecto
--------------------------------

1. **Copiar el proyecto al servidor**

   Descarga o clona este repositorio, y copia todos los archivos en el directorio deseado de tu servidor web (por ejemplo: ``/var/www/html/`` o ``htdocs`` en XAMPP).

2. **Configurar la URL base**

   Edita el archivo ``application/config/config.php`` y modifica la siguiente línea:

   .. code-block:: php

      $config['base_url'] = '';

   Sustitúyela por la URL correspondiente:

   - Para entorno local:

     .. code-block:: php

        $config['base_url'] = 'http://localhost/eternalsvibes/';

   - Para servidor en producción:

     .. code-block:: php

        $config['base_url'] = 'https://www.tudominio.com/';

3. **Configurar la base de datos**

   Abre el archivo ``application/config/database.php`` y configura los siguientes parámetros con los datos de tu entorno:

   .. code-block:: php

      'hostname' => 'localhost',
      'username' => 'TU_USUARIO',
      'password' => 'TU_CONTRASEÑA',
      'database' => 'NOMBRE_DE_LA_BD',

4. **Importar la base de datos**

   Accede a phpMyAdmin (u otra herramienta de gestión MySQL), crea una base de datos con el nombre que has configurado y luego importa el archivo SQL proporcionado (por ejemplo: ``eternalsvibes.sql``).

5. **Finalizar despliegue**

   Asegúrate de que:

   - El servidor tiene habilitado PHP y MySQL.
   - El directorio ``uploads/`` tiene permisos de lectura y escritura recursivos.
   - Si utilizas Apache, el módulo ``mod_rewrite`` está habilitado para soportar URLs limpias.

¡Listo! Ya puedes acceder a tu aplicación desde el navegador.
