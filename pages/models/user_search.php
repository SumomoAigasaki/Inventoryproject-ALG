<?php
   session_start();
   // Comprueba si $_SESSION["username"] está vacía
    if(empty($_SESSION["username"])) {
        header("Location: ../templates/SignOff.php");
        exit();
    }

   $username = $_SESSION["username"] ; 
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
       
       while ($fila = $result->fetch_assoc())
        {
            //$_SESSION[$fila["PRV_Nomenclature"]];
            $privilegios[$fila["PRV_Nomenclature"]] = true;
           // $privilegio= $fila["PRV_Nomenclature"];
          // echo "<script> document.write('$privilegio');</script>";
        }
        $stmt->close();
        $conn->next_result();

       //$username= $row["User_Username"] ;
          
      
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

if(array_key_exists('CMP', $privilegios)){
  $PermisoCMP= true;
}else
{ $PermisoCMP= false;}

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

if(array_key_exists('USER', $privilegios)){
  $PermisoUSER= true;
}else
{ $PermisoUSER= false;}

if (!in_array($pagina_actual, $linksDefault) && !$PermisoUSER && in_array($pagina_actual, $linksUSER)) {
  // Si la página actual no está en la lista de enlaces por defecto, el usuario no tiene el permiso "USER" y la página actual no está permitida
   header("Location: ../templates/404.php");
   exit();
}

?>