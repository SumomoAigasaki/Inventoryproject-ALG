<?php
//declarar variables de conexion 
$servername = "localhost";
$username = "root";
$password = "admin123";
$dbname = "dbinventorywarrantyalg";

// Crea una conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica si la conexión fue exitosa
if ($conn->connect_error) {
  die("La conexión con la base de datos falló: " . $conn->connect_error);
}
?>