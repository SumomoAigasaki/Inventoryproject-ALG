<?php 
//Archivo donde se madnaran a llamar las constantes
const nameWeb = ' | Sistema para la Gestión y Control de Inventario en Departamento IT de ALG' ;
const nameProject= "INFRAG";
const companyName= "Azucarera la Grecia S.A de C.V ";


// voy a validar el nombre de las paginas PHP para guardar la informacion en una variable
//actualPage sirve para determinar en que pagina estamos actualmente
$actualPage = basename($_SERVER['PHP_SELF']);

if ($actualPage == 'index.php') {
  //nombre de pagina
  $pageName = "Inicio";
  //link de pagina
  $pageLink ="index.php";
} elseif ($actualPage == 'contact.php') {
  $pageName = "Contacto";
  $pageLink = "";
}elseif ($actualPage == 'login.php') {
    $pageName = 'Inicio de Sesion';
    $pageLink = "login.php";
  }elseif ($actualPage == 'user.php') {
    $pageName = 'Usuario';
    $pageLink = "user.php";
  }elseif ($actualPage == 'computer.php') {
    $pageName = 'Computadoras';
    $pageLink = "computer.php";
    $imagepath = "resources/Computer/";
  }elseif($actualPage == 'what_is.php'){
    $pageName = 'Que es';
    $pageLink = "what_is.php";
  }

else {
  $pageName = 'Error 404';
}


date_default_timezone_set('America/Mexico_City');
//variables globales 
$todayDate = date("yy-mm-dd");
?>