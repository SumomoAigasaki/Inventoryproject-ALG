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
  $pageName = 'Actualizar Computadora';
  $pageLink = "update_Computer.php";
  $imagepath = "resources/Computer/";
} elseif ($actualPage == 'insert_computer.php') {
  $pageName = 'Añadir Computadoras';
  $pageLink = "insert_computer.php";
  $imagepath = "resources/Computer/";
}


// USUARIO
elseif ($actualPage == 'view_user.php') {
  $pageName = 'Lista de Usuarios';
  $pageLink = "view_user.php";
} elseif ($actualPage == 'insert_user.php') {
  $pageName = 'Añadir Usuarios';
  $pageLink = "insert_user.php";
} elseif ($actualPage == 'update_user.php') {
  $pageName = 'Actualizar Usuario';
  $pageLink = "update_user.php";
}
// Software
elseif ($actualPage == 'view_software.php') {
  $pageName = 'Lista de Software';
  $pageLink = "view_software.php";
} elseif ($actualPage == 'insert_software.php') {
  $pageName = 'Añadir Software';
  $pageLink = "insert_software.php";
} elseif ($actualPage == 'update_software.php') {
  $pageName = 'Actualizar Software';
  $pageLink = "update_software.php";
}

  // perifericos
elseif ($actualPage == 'view_peripherals.php') {
  $pageName = 'Lista de Perifericos';
  $pageLink = "view_peripherals.php";
} elseif ($actualPage == 'insert_peripherals.php') {
  $pageName = 'Añadir Perifericos';
  $pageLink = "insert_peripherals.php";
} elseif ($actualPage == 'update_peripherals.php') {
  $pageName = 'Actualizar Perifericos';
  $pageLink = "update_peripherals.php";
  
   // Colaborador
}elseif ($actualPage == 'view_collaborator.php') {
  $pageName = 'Lista de Colaboradores';
  $pageLink = "view_collaborator.php";
} elseif ($actualPage == 'insert_collaborator.php') {
  $pageName = 'Añadir  Colaborador';
  $pageLink = "insert_collaborator.php";
} elseif ($actualPage == 'update_collaborator.php') {
  $pageName = 'Actualizar Colaborador';
  $pageLink = "update_collaborator.php";
}

//Asignacion De PC
  elseif ($actualPage == 'view_assignment_pc.php') {
    $pageName = 'Lista Asignación PC';
    $pageLink = "view_assignment_pc.php";
  } elseif ($actualPage == 'insert_assignment_pc.php') {
    $pageName = 'Asignación de PC';
    $pageLink = "insert_assignment_pc.php";
  } elseif ($actualPage == 'update_assignment_pc.php') {
    $pageName = 'Actualizar Asignación de PC';
    $pageLink = "update_assignment_pc.php";
  }
  //Asignacion De PC
  elseif ($actualPage == 'view_mappingSoftware.php') {
    $pageName = 'Lista de Software de Pc';
    $pageLink = "view_mappingSoftware.php";
  }

  //EXTRAS
 elseif ($actualPage == 'update_password.php') {
  $pageName = 'UpdateContra';
  $pageLink = "update_password.php.php";
} elseif ($actualPage == 'prueba.php') {
  $pageName = 'prueba';
  $pageLink = "prueba.php";
} else if ($actualPage == '404.php') {
  $pageName = '¡Ups! Página no encontrada';
  $pageLink = "404.php";
} else if ($actualPage == 'HTTP/1.0 404 Not Found') {
  header("Location: ../templates/404.php");
  $pageName = '¡Ups! Página no encontrada';
  $pageLink = "404.php";
} 

// date_default_timezone_set('America/Mexico_City');
// //variables globales 
// $todayDate = date("Y-m-d");

// echo '<script>';
// echo 'var todayDate = ' . json_encode($todayDate) . ';'; // Convertir la variable en JSON y asignarla a la variable de JavaScript
// echo '</script>';
