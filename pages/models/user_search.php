<?php
session_start();
// Comprueba si $_SESSION["username"] está vacía
if (empty($_SESSION["username"])) {
  header("Location: ../templates/SignOff.php");
  exit();
}

$username = $_SESSION["username"];
$resultado = null;
$stmt =  $conn->prepare("CALL sp_user_search('$username')");
$stmt->execute();

// Obtiene los resultados
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
  //optenemos las variables del select y la asignamos a la session activa
  $_SESSION["User_Username"] =  $row["User_Username"];
  $_SESSION["User_idTbl_User"] =  $row["User_idTbl_User"];
  $_SESSION["User_img"] =  $row["User_img"];
  $_SESSION["RLS_idTbl_Roles"] =  $row["RLS_idTbl_Roles"];
  $_SESSION["STS_idTbl_Status"] =  $row["STS_idTbl_Status"];
  $_SESSION["NameUserlog"]= $row["NameUserlog"];
  
  $_SESSION['user_EmployeePosition']=$row["EmployeePosition"];
  $_SESSION['firmaUser']=$row["firma"];

  $stmt->close();
  $conn->next_result();

  $idRol = $_SESSION["RLS_idTbl_Roles"];
  $estadosDB = 2;

  //vamos a obtener los privilegios del usuario que estes activos 
  $resultado = null;
  $stmt = $conn->prepare("CALL sp_findUser_privileges(?)");
  $stmt->bind_param("i", $idRol);
  $stmt->execute();

  // Obtiene los resultados
  $result = $stmt->get_result();

  $privilegios = array(); // Array principal para almacenar los privilegios

  while ($fila = $result->fetch_assoc()) {
    $privilegio = array(
      "permiso" => $fila["PRV_Nomenclature"],
      "modulo" => $fila["MDU_Descriptions"]
    );
    $privilegios[] = $privilegio; // Agregar el privilegio al array principal
  }

  $stmt->close();
  $conn->next_result();

  // Ahora $privilegios contiene todos los valores devueltos por el procedimiento almacenado

  // Puedes acceder a los valores de esta manera:
  // foreach ($privilegios as $privilegio) {
  //   echo $privilegio["permiso"] . ", " . $privilegio["modulo"] . "<br>";
  // }
}

$linksDefault = array(
  "index.php",
  "404.php",
  "login.php",
  "update_password.php",
  "menu.php",
  "nav.php",
  "footer.php"
);

$pagina_actual = basename($_SERVER["PHP_SELF"]); // Obtener el nombre de la página actual


#COMPUTADORA

$linksCMP = array(
  "insert_computer.php",
  "update_computer.php",
  "view_computer.php"
);

if (in_array('CMP', array_column($privilegios, 'permiso'))) {
  $PermisoCMP = true;
} else{
  $PermisoCMP = false;
}

// var_dump($privilegios);
// var_dump($linksCMP);
// var_dump($PermisoCMP);


if (!in_array($pagina_actual, $linksDefault) && !$PermisoCMP && in_array($pagina_actual, $linksCMP)) {
  // Si la página actual no está en la lista de enlaces por defecto, el usuario no tiene el permiso "CMP" y la página actual no está permitida
  header("Location: ../templates/404.php");
  exit();
}

// #USUARIO

$linksUSER = array(
  "insert_user.php",
  "update_user.php",
  "view_user.php"
);

if (in_array('USER', array_column($privilegios, 'permiso'))) {
  $PermisoUSER = true;
} else {
  $PermisoUSER = false;
}

if (!in_array($pagina_actual, $linksDefault) && !$PermisoUSER && in_array($pagina_actual, $linksUSER)) {
  // Si la página actual no está en la lista de enlaces por defecto, el usuario no tiene el permiso "USER" y la página actual no está permitida
  header("Location: ../templates/404.php");
  exit();
}

//SOFTWARE
// #SFT

$linksUSER = array(
  "insert_software.php",
  "update_software.php",
  "view_software.php"
);

if (in_array('SFT', array_column($privilegios, 'permiso'))) {
  $PermisoSTF = true;
} else {
  $PermisoSTF = false;
}

if (!in_array($pagina_actual, $linksDefault) && !$PermisoSTF && in_array($pagina_actual, $linksUSER)) {
  // Si la página actual no está en la lista de enlaces por defecto, el usuario no tiene el permiso "USER" y la página actual no está permitida
  header("Location: ../templates/404.php");
  exit();
}

//PERIFERICOS
// #PRL

$linksPRL = array(
  "insert_peripherals.php",
  "update_peripherals.php",
  "view_peripherals.php"
);

if (in_array('PRL', array_column($privilegios, 'permiso'))) {
  $PermisoPRL = true;
} else {
  $PermisoPRL = false;
}

if (!in_array($pagina_actual, $linksDefault) && !$PermisoPRL && in_array($pagina_actual, $linksPRL)) {
  // Si la página actual no está en la lista de enlaces por defecto, el usuario no tiene el permiso "USER" y la página actual no está permitida
  header("Location: ../templates/404.php");
  exit();
}

//COLABORADOR
// #CBT

$linksCBT = array(
  "insert_collaborator.php",
  "update_collaborator.php",
  "view_collaborator.php"
);

if (in_array('CBT', array_column($privilegios, 'permiso'))) {
  $PermisoCBT = true;
} else {
  $PermisoCBT = false;
}

if (!in_array($pagina_actual, $linksDefault) && !$PermisoCBT && in_array($pagina_actual, $linksCBT)) {
  // Si la página actual no está en la lista de enlaces por defecto, el usuario no tiene el permiso "USER" y la página actual no está permitida
  header("Location: ../templates/404.php");
  exit();
}

//Asignacion PC
// #PCA

$linksPCA = array(
  "insert_assignment_pc.php",
  "update_assignment_pc.php",
  "view_assignment_pc.php",
  "view_mappingSoftware.php",
  "PCassignmentcontract.php"
);

if (in_array('PCA', array_column($privilegios, 'permiso'))) {
  $PermisoPCA = true;
} else {
  $PermisoPCA = false;
}

if (!in_array($pagina_actual, $linksDefault) && !$PermisoPCA && in_array($pagina_actual, $linksPCA)) {
  // Si la página actual no está en la lista de enlaces por defecto, el usuario no tiene el permiso "USER" y la página actual no está permitida
  header("Location: ../templates/404.php");
  exit();
}

//Garantia -> Warranty
// #WR

$linksWR = array(
  "insert_warranty.php",
  "update_warranty.php",
  "view_warranty.php", 
  "warrantyReport.php"
);

if (in_array('WR', array_column($privilegios, 'permiso'))) {
  $PermisoWR = true;
} else {
  $PermisoWR = false;
}

if (!in_array($pagina_actual, $linksDefault) && !$PermisoWR && in_array($pagina_actual, $linksWR)) {
  // Si la página actual no está en la lista de enlaces por defecto, el usuario no tiene el permiso "USER" y la página actual no está permitida
  header("Location: ../templates/404.php");
  exit();
}




#ROLES / PERMISOS
$linksRLS = array(
  "insert_permissions.php",
  "update_permissions.php",
  "view_permissions.php"
);

if (in_array('RLS', array_column($privilegios, 'permiso'))) {
  $PermisoRLS = true;
} else {
  $PermisoRLS = false;
}
if (!in_array($pagina_actual, $linksDefault) && !$PermisoRLS && in_array($pagina_actual, $linksRLS)) {
  // Si la página actual no está en la lista de enlaces por defecto, el usuario no tiene el permiso "USER" y la página actual no está permitida
  header("Location: ../templates/404.php");
  exit();
}

//Permiso para Vista de Computadoras
$linksRCMP= array(
  "reading_viewComputer.php"
);

if (in_array('RCMP', array_column($privilegios, 'permiso'))) {
  $PermisoRCMP = true;
} else {
  $PermisoRCMP   = false;
}
if (!in_array($pagina_actual, $linksDefault) && !$PermisoRCMP && in_array($pagina_actual, $linksRCMP)) {
  // Si la página actual no está en la lista de enlaces por defecto, el usuario no tiene el permiso "USER" y la página actual no está permitida
  header("Location: ../templates/404.php");
  exit();
}

//Permiso para Vista de Asignacion PC
$linksRPCA= array(
  "reading_viewAssignmentPC.php"
);

if (in_array('RPCA', array_column($privilegios, 'permiso'))) {
  $PermisoRPCA = true;
} else {
  $PermisoRPCA   = false;
}
if (!in_array($pagina_actual, $linksDefault) && !$PermisoRPCA && in_array($pagina_actual, $linksRPCA)) {
  // Si la página actual no está en la lista de enlaces por defecto, el usuario no tiene el permiso "USER" y la página actual no está permitida
  header("Location: ../templates/404.php");
  exit();
}

//Permiso para Vista de Garantia
$linksRWR= array(
  "reading_viewWarranty.php"
);

if (in_array('RWR', array_column($privilegios, 'permiso'))) {
  $PermisoRWR = true;
} else {
  $PermisoRWR   = false;
}
if (!in_array($pagina_actual, $linksDefault) && !$PermisoRWR && in_array($pagina_actual, $linksRWR)) {
  // Si la página actual no está en la lista de enlaces por defecto, el usuario no tiene el permiso "USER" y la página actual no está permitida
  header("Location: ../templates/404.php");
  exit();
}

//Permiso para Vista de Software
$linksRSFT= array(
  "reading_viewSoftware.php"
);

if (in_array('RSFT', array_column($privilegios, 'permiso'))) {
  $PermisoRSFT = true;
} else {
  $PermisoRSFT   = false;
}
if (!in_array($pagina_actual, $linksDefault) && !$PermisoRSFT && in_array($pagina_actual, $linksRSFT)) {
  // Si la página actual no está en la lista de enlaces por defecto, el usuario no tiene el permiso "USER" y la página actual no está permitida
  header("Location: ../templates/404.php");
  exit();
}

//Permiso para Vista de Perifericos
$linksRPRL= array(
  "reading_viewPeripherals.php"
);

if (in_array('RPRL', array_column($privilegios, 'permiso'))) {
  $PermisoRPRL = true;
} else {
  $PermisoRPRL   = false;
}
if (!in_array($pagina_actual, $linksDefault) && !$PermisoRPRL && in_array($pagina_actual, $linksRPRL)) {
  // Si la página actual no está en la lista de enlaces por defecto, el usuario no tiene el permiso "USER" y la página actual no está permitida
  header("Location: ../templates/404.php");
  exit();
}


//Permiso para Vista de Colaboradores
$linksRCBT= array(
  "reading_viewColaborator.php"
);

if (in_array('RCBT', array_column($privilegios, 'permiso'))) {
  $PermisoRCBT = true;
} else {
  $PermisoRCBT   = false;
}
if (!in_array($pagina_actual, $linksDefault) && !$PermisoRCBT && in_array($pagina_actual, $linksRCBT)) {
  // Si la página actual no está en la lista de enlaces por defecto, el usuario no tiene el permiso "USER" y la página actual no está permitida
  header("Location: ../templates/404.php");
  exit();
}
