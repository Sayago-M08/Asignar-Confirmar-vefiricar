<?php
session_start();
session_unset();   // Libera todas las variables de sesión
session_destroy(); // Destruye la sesión en el servidor

header("Location: ../login.php?msj=sesion_cerrada");
exit();
?>