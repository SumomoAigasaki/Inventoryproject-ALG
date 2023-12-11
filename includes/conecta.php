<?php
//declarar variables de conexion 
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "dbinventorywarrantyalg";

// Crea una conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Verifica si la conexión fue exitosa
if (mysqli_connect_errno()) {
  die("La conexión con la base de datos falló: " . mysqli_connect_errno());
}
return $conn;
?>