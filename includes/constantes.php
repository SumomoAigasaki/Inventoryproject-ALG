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
  $sectionName = 'Transaction';
  $pageLink = "view_computer.php";
} elseif ($actualPage == 'update_computer.php') {
  $pageName = 'Actualizar Computadora';
  $pageLink = "update_Computer.php";
  $sectionName = 'Transaction';
  $imagepath = "resources/Computer/";
} elseif ($actualPage == 'insert_computer.php') {
  $pageName = 'Añadir Computadoras';
  $pageLink = "insert_computer.php";
  $sectionName = 'Transaction';
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
} elseif ($actualPage == 'view_collaborator.php') {
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
  $pageName = 'Listado de PC asignadas';
  $pageLink = "view_assignment_pc.php";
} elseif ($actualPage == 'insert_assignment_pc.php') {
  $pageName = 'Asignación de PC';
  $pageLink = "insert_assignment_pc.php";
} elseif ($actualPage == 'update_assignment_pc.php') {
  $pageName = 'Actualizar Asignación de PC';
  $pageLink = "update_assignment_pc.php";
} elseif ($actualPage == 'PCassignmentcontract.php') {
  $pageName = 'Contrato de Asignación de PC';
  $pageLink = "PCassignmentcontract.php";
}
//Asignacion De PC
elseif ($actualPage == 'view_mappingSoftware.php') {
  $pageName = 'Lista de Software de Pc';
  $pageLink = "view_mappingSoftware.php";
}
//Garantia
elseif ($actualPage == 'view_warranty.php') {
  $pageName = 'Listado de reportes de Garantia ';
  $pageLink = "view_warranty.php";
} elseif ($actualPage == 'insert_warranty.php') {
  $pageName = 'Registro de Reporte Garantia';
  $pageLink = "insert_warranty.php";
} elseif ($actualPage == 'update_warranty.php') {
  $pageName = 'Actualizar Registro de Reporte de Garantia';
  $pageLink = "update_warranty.php";
} elseif ($actualPage == 'warrantyReport.php') {
  $pageName = 'Reporte de Garantia';
  $pageLink = "update_warranty.php";
}

//Roles
elseif ($actualPage == 'view_permissions.php') {
  $pageName = 'Listado de los permisos por rol ';
  $pageLink = "view_warrpermissions";
} elseif ($actualPage == 'insert_permissions.php') {
  $pageName = 'Registro de Permisos';
  $pageLink = "insert_permissions.php";
} elseif ($actualPage == 'update_permissions.php') {
  $pageName = 'Actualizar Permisos';
  $pageLink = "update_permissions.php";
}


//Dashboard
elseif ($actualPage == 'dashboard_computer.php') {
  $pageName = 'Dashboard Computadoras ';
  $sectionName = 'Dashboard';
  $pageLink = "dashboard_computer.php";
}

elseif ($actualPage == 'dashboard_warranty.php') {
  $pageName = 'Dashboard Garantia ';
  $sectionName = 'Dashboard';
  $pageLink = "dashboard_warranty.php";
}

//Lectura de computadoras
  elseif ($actualPage == 'reading_viewComputer.php') {
    $pageName = 'Vista de Computadoras';
    $sectionName = 'Vista Computradoras';
    $pageLink = "reading_viewComputer.php";
  }


//Lectura de Asignacion pc
  elseif ($actualPage == 'reading_viewAssignmentPC.php') {
    $pageName = 'Vista de Asignación de Computadoras';
    $sectionName = 'Vista Asignación  de Computadoras';
    $pageLink = "reading_viewAssignmentPC.php";
  }

//Lectura de Garantia
  elseif ($actualPage == 'reading_viewWarranty.php') {
    $pageName = 'Vista de Garantias';
    $sectionName = 'Vista  Garantias';
    $pageLink = "reading_viewWarranty.php";
  }

//Lectura de software
elseif ($actualPage == 'reading_viewSoftware.php') {
  $pageName = 'Vista de Software';
  $sectionName = 'Vista Software';
  $pageLink = "reading_viewSoftware.php";
}

//Lectura de Perifericos
elseif ($actualPage == 'reading_viewPeripherals.php') {
  $pageName = 'Vista de Perifericos';
  $sectionName = 'Vista Perifericos';
  $pageLink = "reading_viewPeripherals.php";
}


//Lectura de Colaboradores
elseif ($actualPage == 'reading_viewColaborator.php') {
  $pageName = 'Vista de Colaboradores';
  $sectionName = 'Vista Colaboradores';
  $pageLink = "reading_viewColaborator.php";
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

?>
