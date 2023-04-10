<?php
//declarar variables de conexion 

$sevidor= "localhost";
$usuario= "root"; 
$password= "admin123";
$bd= "dbinventorywarrantyalg";

$conecta=mysqli_connect($sevidor, $usuario, $password, $bd);
if($conecta->connect_error){
    die ("Error a conectar la base de datos de la pagina".$conecta->connect_error);
}else{
    echo "Success ";
    echo "";
}
?>