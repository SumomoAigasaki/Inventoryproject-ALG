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
       $_SESSION["User_Username"] =  $row["User_Username"] ;
       //$username= $row["User_Username"] ;
          $stmt->close();
      
    } 
  
?>