<?php
include "../../includes/conecta.php";


// Verificar si se envió el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Recuperar los valores del formulario
  $username =$_POST['username'];
  $password =$_POST['password']; 
  
  // Llamar al procedimiento almacenado para validar el usuario y la contraseña
  $resultado = null;
  $conecta->query("CALL sp_validate_user('$username','$password', @resultado)");
  $resultado = $conecta->query("SELECT @resultado")->fetch_assoc()["@resultado"];
  
  // Verificar el resultado del procedimiento almacenado 
  if ($resultado == 1) {
      // Usuario y contraseña son correctos, redirigir a la página de bienvenida
      session_start();
      $_SESSION['username'] = $username;
      //echo "LOGIN SUCCESS";
      //echo "<script>window.location='../index.php; </script>";
      header("Location: ../index.php");
      exit();
  } else {
      // Usuario y/o contraseña son incorrectos, mostrar un mensaje de error
      //echo "LOGIN ERROR";
     // $error = "Usuario y/o contraseña incorrectos.";
       echo "<script> alert ('Credenciales erroneas, A continuación sera redirigido al inicio de sesion');
       window.location='../login.php'
       </script>";
      
  }
}
?>