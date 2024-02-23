<?php
// Inicia la sesión
session_start();

// Destruye la sesión actual
session_destroy();

// Redirige al usuario a la página de inicio de sesión (login.php)
header("Location:../login.php");

// Finaliza el script, evita que se ejecuten más instrucciones después de la redirección
exit();
?>
