<?php
session_start();

// Comprueba si $_SESSION["username"] está vacía
if (empty($_SESSION["username"])) {
  header("Location: ../templates/SignOff.php");
  exit();
}

$username = $_SESSION["username"];
$resultado = null;

// Prepara y ejecuta la consulta para obtener información del usuario
  $stmt = $conn->prepare("CALL sp_user_search('$username')");
  $stmt->execute();

  // Obtiene los resultados
  $result = $stmt->get_result();

  while ($row = $result->fetch_assoc()) {
    // Asigna las variables del resultado a la sesión activa
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

    // Obtiene los privilegios del usuario que estén activos
        $resultado = null;
        $stmt = $conn->prepare("CALL sp_findUser_privileges(?)");
        $stmt->bind_param("i", $idRol);
        $stmt->execute();

        // Obtiene los resultados
        $result = $stmt->get_result();

        $privilegios = array(); // Array principal para almacenar los privilegios

        while ($fila = $result->fetch_assoc()) {
          // Crea un array con la información del privilegio y lo agrega al array principal
          $privilegio = array(
            "permiso" => $fila["PRV_Nomenclature"],
            "modulo" => $fila["MDU_Descriptions"]
          );
          $privilegios[] = $privilegio;
        }

        $stmt->close();
        $conn->next_result();
  }
    #URL Default a cual tendran acceso
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

# Computadora
  $linksCMP = array(
    "insert_computer.php",
    "update_computer.php",
    "view_computer.php"
  );

  // Verifica si el usuario tiene el permiso "CMP"
  if (in_array('CMP', array_column($privilegios, 'permiso'))) {
    $PermisoCMP = true;
  } else {
    $PermisoCMP = false;
  }

  // Verifica si la página actual está permitida según los permisos y enlaces específicos
  if (!in_array($pagina_actual, $linksDefault) && !$PermisoCMP && in_array($pagina_actual, $linksCMP)) {
    header("Location: ../templates/404.php");
    exit();
  }

# Usuario
  $linksUSER = array(
    "insert_user.php",
    "update_user.php",
    "view_user.php"
  );

  // Verifica si el usuario tiene el permiso "USER"
  if (in_array('USER', array_column($privilegios, 'permiso'))) {
    $PermisoUSER = true;
  } else {
    $PermisoUSER = false;
  }

  // Verifica si la página actual está permitida según los permisos y enlaces específicos
  if (!in_array($pagina_actual, $linksDefault) && !$PermisoUSER && in_array($pagina_actual, $linksUSER)) {
    header("Location: ../templates/404.php");
    exit();
  }

# Software
  $linksUSER = array(
    "insert_software.php",
    "update_software.php",
    "view_software.php"
  );

  // Verifica si el usuario tiene el permiso "SFT"
  if (in_array('SFT', array_column($privilegios, 'permiso'))) {
    $PermisoSTF = true;
  } else {
    $PermisoSTF = false;
  }

  // Verifica si la página actual está permitida según los permisos y enlaces específicos
  if (!in_array($pagina_actual, $linksDefault) && !$PermisoSTF && in_array($pagina_actual, $linksUSER)) {
    header("Location: ../templates/404.php");
    exit();
  }

# Periféricos
  $linksPRL = array(
    "insert_peripherals.php",
    "update_peripherals.php",
    "view_peripherals.php"
  );

  // Verifica si el usuario tiene el permiso "PRL"
  if (in_array('PRL', array_column($privilegios, 'permiso'))) {
    $PermisoPRL = true;
  } else {
    $PermisoPRL = false;
  }

  // Verifica si la página actual está permitida según los permisos y enlaces específicos
  if (!in_array($pagina_actual, $linksDefault) && !$PermisoPRL && in_array($pagina_actual, $linksPRL)) {
    header("Location: ../templates/404.php");
    exit();
  }

# Colaborador
  $linksCBT = array(
    "insert_collaborator.php",
    "update_collaborator.php",
    "view_collaborator.php"
  );

  // Verifica si el usuario tiene el permiso "CBT"
  if (in_array('CBT', array_column($privilegios, 'permiso'))) {
    $PermisoCBT = true;
  } else {
    $PermisoCBT = false;
  }

  // Verifica si la página actual está permitida según los permisos y enlaces específicos
  if (!in_array($pagina_actual, $linksDefault) && !$PermisoCBT && in_array($pagina_actual, $linksCBT)) {
    header("Location: ../templates/404.php");
    exit();
  }

# Asignacion PC
  $linksPCA = array(
    "insert_assignment_pc.php",
    "update_assignment_pc.php",
    "view_assignment_pc.php",
    "view_mappingSoftware.php",
    "PCassignmentcontract.php"
  );

  // Verifica si el usuario tiene el permiso "PCA"
  if (in_array('PCA', array_column($privilegios, 'permiso'))) {
    $PermisoPCA = true;
  } else {
    $PermisoPCA = false;
  }

  // Verifica si la página actual está permitida según los permisos y enlaces específicos
  if (!in_array($pagina_actual, $linksDefault) && !$PermisoPCA && in_array($pagina_actual, $linksPCA)) {
    header("Location: ../templates/404.php");
    exit();
  }

# Garantia -> Warranty
  $linksWR = array(
    "insert_warranty.php",
    "update_warranty.php",
    "view_warranty.php"
  );

  // Verifica si el usuario tiene el permiso "WR"
  if (in_array('WR', array_column($privilegios, 'permiso'))) {
    $PermisoWR = true;
  } else {
    $PermisoWR = false;
  }

  // Verifica si la página actual está permitida según los permisos y enlaces específicos
  if (!in_array($pagina_actual, $linksDefault) && !$PermisoWR && in_array($pagina_actual, $linksWR)) {
    header("Location: ../templates/404.php");
    exit();
  }

# ROLES / PERMISOS
  $linksRLS = array(
    "insert_permissions.php",
    "update_permissions.php",
    "view_permissions.php"
  );

  // Verifica si el usuario tiene el permiso "RLS"
  if (in_array('RLS', array_column($privilegios, 'permiso'))) {
    $PermisoRLS = true;
  } else {
    $PermisoRLS = false;
  }

  // Verifica si la página actual está permitida según los permisos y enlaces específicos
  if (!in_array($pagina_actual, $linksDefault) && !$PermisoRLS && in_array($pagina_actual, $linksRLS)) {
    header("Location: ../templates/404.php");
    exit();
  }

# Dashboard Garantia
  $linksDWR= array(
    "dashboard_warranty.php",
    "warrantyDashboardPDF.php"
  );

  // Verifica si el usuario tiene el permiso "DWR"
  if (in_array('DWR', array_column($privilegios, 'permiso'))) {
    $PermisoDWR = true;
  } else {
    $PermisoDWR = false;
  }

  // Verifica si la página actual está permitida según los permisos y enlaces específicos
  if (!in_array($pagina_actual, $linksDefault) && !$PermisoDWR && in_array($pagina_actual, $linksDWR)) {
    header("Location: ../templates/404.php");
    exit();
  }

# Dashboard Computadoras
  $linksDCMP= array(
    "dashboard_computer.php",
    "dashboardComputerPDF.php"
  );

  // Verifica si el usuario tiene el permiso "DCMP"
  if (in_array('DCMP', array_column($privilegios, 'permiso'))) {
    $PermisoDCMP = true;
  } else {
    $PermisoDCMP = false;
  }

  // Verifica si la página actual está permitida según los permisos y enlaces específicos
  if (!in_array($pagina_actual, $linksDefault) && !$PermisoDCMP && in_array($pagina_actual, $linksDCMP)) {
    header("Location: ../templates/404.php");
    exit();
  }

// Permiso para Vista de Computadoras
  $linksRCMP= array(
    "reading_viewComputer.php"
  );

  // Verifica si el usuario tiene el permiso "RCMP"
  if (in_array('RCMP', array_column($privilegios, 'permiso'))) {
    $PermisoRCMP = true;
  } else {
    $PermisoRCMP   = false;
  }

  // Verifica si la página actual está permitida según los permisos y enlaces específicos
  if (!in_array($pagina_actual, $linksDefault) && !$PermisoRCMP && in_array($pagina_actual, $linksRCMP)) {
    header("Location: ../templates/404.php");
    exit();
  }

// Permiso para Vista de Asignacion PC
  $linksRPCA= array(
    "reading_viewAssignmentPC.php"
  );

  // Verifica si el usuario tiene el permiso "RPCA"
  if (in_array('RPCA', array_column($privilegios, 'permiso'))) {
    $PermisoRPCA = true;
  } else {
    $PermisoRPCA   = false;
  }

  // Verifica si la página actual está permitida según los permisos y enlaces específicos
  if (!in_array($pagina_actual, $linksDefault) && !$PermisoRPCA && in_array($pagina_actual, $linksRPCA)) {
    header("Location: ../templates/404.php");
    exit();
  }

// Permiso para Vista de Garantia
  $linksRWR= array(
    "reading_viewWarranty.php"
  );

  // Verifica si el usuario tiene el permiso "RWR"
  if (in_array('RWR', array_column($privilegios, 'permiso'))) {
    $PermisoRWR = true;
  } else {
    $PermisoRWR   = false;
  }

  // Verifica si la página actual está permitida según los permisos y enlaces específicos
  if (!in_array($pagina_actual, $linksDefault) && !$PermisoRWR && in_array($pagina_actual, $linksRWR)) {
    header("Location: ../templates/404.php");
    exit();
  }

// Permiso para Vista de Software
  $linksRSFT= array(
    "reading_viewSoftware.php"
  );

  // Verifica si el usuario tiene el permiso "RSFT"
  if (in_array('RSFT', array_column($privilegios, 'permiso'))) {
    $PermisoRSFT = true;
  } else {
    $PermisoRSFT = false;
  }

  // Verifica si la página actual está permitida según los permisos y enlaces específicos
  if (!in_array($pagina_actual, $linksDefault) && !$PermisoRSFT && in_array($pagina_actual, $linksRSFT)) {
    header("Location: ../templates/404.php");
    exit();
  }

// Permiso para Vista de Perifericos
    $linksRPRL= array(
      "reading_viewPeripherals.php"
    );

    // Verifica si el usuario tiene el permiso "RPRL"
    if (in_array('RPRL', array_column($privilegios, 'permiso'))) {
      $PermisoRPRL = true;
    } else {
      $PermisoRPRL = false;
    }

    // Verifica si la página actual está permitida según los permisos y enlaces específicos
    if (!in_array($pagina_actual, $linksDefault) && !$PermisoRPRL && in_array($pagina_actual, $linksRPRL)) {
      header("Location: ../templates/404.php");
      exit();
    }

// Permiso para Vista de Colaboradores
  $linksRCBT= array(
    "reading_viewColaborator.php"
  );

  // Verifica si el usuario tiene el permiso "RCBT"
  if (in_array('RCBT', array_column($privilegios, 'permiso'))) {
    $PermisoRCBT = true;
  } else {
    $PermisoRCBT   = false;
  }

  // Verifica si la página actual está permitida según los permisos y enlaces específicos
  if (!in_array($pagina_actual, $linksDefault) && !$PermisoRCBT && in_array($pagina_actual, $linksRCBT)) {
    header("Location: ../templates/404.php");
    exit();
  }
?>
