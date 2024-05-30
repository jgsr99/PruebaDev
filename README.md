# PruebaDev
ABM/CRUD (Alta, Baja lógica, Baja física y Modificacion) de registros de Usuarios.

Este sistema con las necesidades expuestas en la prueba técnica se desarrollo en un entorno php laravel donde en el archivo app estan las configuraciones de la base de datos en la carpeta core y en el archivo settings.php donde se definen también el metodo de cargar las carpetas con nombre global para que todo el proyecto de pueda ejecutar de la mejor manera, utilice un programa llamado prepros que me simula un servidor donde se ejecutan las actualizaciones automaticamente en el servidor local donde en ese mismo archivo se define en la linea 10 y 11 en la 10 se habilita con True(activo) y con False(desactivo) y el puerto del servidor que es el 8848 por defecto.

En app se encuentra la lógica del controller donde esta toda la logica del backend en laravel y los models que es la logica de la base de datos donde se hacen las consulta, actualizaciones, eliminaciones y toda clase de logica sql para este caso.

ya en la carpeta templates estan las vistas y los includes ya que realice la prueba en un modelo MVC donde en los includes esta toda la logica de scripts, styles, sidebar o barra lateral, topbar o barra superior, las variaciones minimas para la parte del login-recuperar contraseña-actualizar contraseña y ya en las vistas la logica de cada una de las vistas y su componentes para funcionar al 100%.

Como plus y añadidura se utiliza el servidor de correos con php para la suspension de correos o quitar la suspension se informe al correo registrado y de igual manera para crear una verificación a la hora de ingresar por primera vez al sito.

Atentamente: Juan Guillermo Soto Rincón
