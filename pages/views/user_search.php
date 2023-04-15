<?php
    include "../../includes/conecta.php";

    $username= $_SESSION["User_Username"] ; 
  

    $resultado = null;
    $stmt =  $conecta->prepare("CALL sp_user_search('$username')");
    $stmt->execute();

    // Obtiene los resultados
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $_SESSION["User_Username"] =  $row["User_Username"] ;
        //$username= $row["User_Username"] ;
        $stmt->close();
       
     }
  
     // Cierra la conexión

    


?>