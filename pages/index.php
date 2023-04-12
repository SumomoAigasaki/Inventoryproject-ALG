<?php
//valida si el usuario existe y al no existir lo manda al login
session_start();
if(!isset($_SESSION["username"])){
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Prueba</title>
  </head>
  <body>
    Prueba
  </body>
</html>

<?php 
session_destroy();
?>
