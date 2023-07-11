<?php
//Archivo donde se madnaran a llamar las constantes
const BASE_URL = 'http://localhost/Inventoryproject-ALG/';

const nameWeb = ' | Sistema para la Gestión y Control de Inventario en Departamento IT de ALG';
const nameProject = "INFRAG";
const companyName = "Azucarera la Grecia S.A de C.V ";


// voy a validar el nombre de las paginas PHP para guardar la informacion en una variable
//actualPage sirve para determinar en que pagina estamos actualmente
$actualPage = basename($_SERVER['PHP_SELF']);
if ($actualPage == 'index.php') {
  //nombre de pagina
  $pageName = 'Inicio';
  //link de pagina
  $pageLink = "index.php";
} elseif ($actualPage == 'contact.php') {
  $pageName = "Contacto";
  $pageLink = "";
} elseif ($actualPage == 'login.php') {
  $pageName = 'Inicio de Sesion';
  $pageLink = "login.php";
} elseif ($actualPage == 'user.php') {
  $pageName = 'Usuario';
  $pageLink = "user.php";
} elseif ($actualPage == 'readComputer.php') {
  $pageName = 'Lista de Computadoras';
  $pageLink = "readComputer.php";
} elseif ($actualPage == 'what_is.php') {
  $pageName = 'Que es';
  $pageLink = "what_is.php";
} elseif ($actualPage == 'explorer.php') {
  $pageName = 'Explorar';
  $pageLink = "explorer.php";
  //COMPUTADORA
} elseif ($actualPage == 'view_computer.php') {
  $pageName = 'Lista de Computadoras';
  $pageLink = "view_computer.php";
} elseif ($actualPage == 'update_computer.php') {
  $pageName = 'Computadora';
  $pageLink = "update_Computer.php";
  $imagepath = "resources/Computer/";
} elseif ($actualPage == 'insert_computer.php') {
  $pageName = 'Computadoras';
  $pageLink = "insert_computer.php";
  $imagepath = "resources/Computer/";
}


// USUARIO
elseif ($actualPage == 'view_user.php') {
  $pageName = 'Lista de Usuarios';
  $pageLink = "view_user.php";
} elseif ($actualPage == 'insert_user.php') {
  $pageName = 'Usuarios';
  $pageLink = "insert_user.php";
} elseif ($actualPage == 'update_user.php') {
  $pageName = 'Usuario';
  $pageLink = "update_user.php";
} elseif ($actualPage == 'update_password.php') {
  $pageName = 'UpdateContra';
  $pageLink = "update_password.php.php";
} elseif ($actualPage == 'prueba.php') {
  $pageName = 'prueba';
  $pageLink = "prueba.php";
} else if ($actualPage == '404.php') {
  $pageName = '¡Ups! Página no encontrada';
  $pageLink = "404.php";
}

// date_default_timezone_set('America/Mexico_City');
// //variables globales 
// $todayDate = date("Y-m-d");

// echo '<script>';
// echo 'var todayDate = ' . json_encode($todayDate) . ';'; // Convertir la variable en JSON y asignarla a la variable de JavaScript
// echo '</script>';
