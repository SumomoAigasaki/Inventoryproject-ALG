<?php
   session_start();
   // Comprueba si $_SESSION["username"] está vacía
    if(empty($_SESSION["username"])) {
        header("Location: ../login.php");
        exit();
    }

   $username = $_SESSION["username"] ; 
   $resultado = null;
   $stmt =  $conn->prepare("CALL sp_user_search('$username')");
   $stmt->execute();   

   // Obtiene los resultados
   $result = $stmt->get_result();
  
   while ($row = $result->fetch_assoc()) {
   
       $_SESSION["User_Username"] =  $row["User_Username"];
       $_SESSION["User_idTbl_User"] =  $row["User_idTbl_User"];
       $stmt->close();
       $conn->next_result();

       $idUser = $_SESSION["User_idTbl_User"]; 
       $estadosDB = 2;
    
       //vamos a obtener los privilegios del usuario que estes activos 
       $resultado = null;
       $stmt = $conn->prepare("CALL sp_findUser_privileges(?, ?)");
        $stmt->bind_param("ii", $idUser, $estadosDB);
        $stmt->execute();
  
      // Obtiene los resultados
       $result = $stmt->get_result();
       
       while ($fila = $result->fetch_assoc())
        {
            //$_SESSION[$fila["PRV_Nomenclature"]];
           $_SESSION[$fila["PRV_Nomenclature"]]=true;
        //$privilegio=$fila["PRV_Nomenclature"];
          // echo "<script> document.write('$privilegio');</script>";
        }
        $stmt->close();
        $conn->next_result();

       //$username= $row["User_Username"] ;
          
      
    } 
  
?>