<?php
include 'mysql.php';

$OMySQL= new MySQL();
$OMySQL->getPieChartData();

// Llamar a la función para obtener el JSON
$datosEnJSON = $OMySQL->getPieChartData();;

  // Decodificar el JSON a un array asociativo
  $datosDecodificados = json_decode($datosEnJSON, true);

  // Mostrar en pantalla o en la consola usando print_r o var_dump para visualizar la estructura del array
  echo "<pre>";
  print_r($datosDecodificados); // o var_dump($datosDecodificados);
  echo "</pre>";

//   // Si estás trabajando en la línea de consola, puedes usar var_dump directamente
//   var_dump($datosDecodificados);
?>