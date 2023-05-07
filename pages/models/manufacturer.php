<?php 
 session_start();
 $username = $_SESSION["username"] ; 

 if(!isset($_SESSION["username"])){
     header("location: ../login.php");
 }

 $resultado = null;
 $stmt =  $conn->prepare("CALL sp_manufacturer_select");
 $stmt->execute();

 // Obtiene los resultados
 $result = $stmt->get_result();
 
 while ($row = $result->fetch_assoc()) {
    $select = ($manufacturer == $row['MFC_idTbl_Manufacturer']) ? "selected=selected" : "";

	echo "<option value='".$fila['MFC_idTbl_Manufacturer']."'".$select.">".$fila['MFC_Description']."</option>";

     //$username= $row["User_Username"] ;
        $stmt->close();
    
  }
?>