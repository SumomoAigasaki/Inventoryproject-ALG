<?php 
include 'reWarrantyMySql.php';

//instanciar la clase
$oMySQL= new MySQL();
//variable que regrese los datos de la clase
$response="";
//concepto para atendenr solicitudes de tipo posh 
$rq= $_POST['rq'];

//identificar el tipo de request que nos estan enviando
 if($rq ==1){
    $response= $oMySQL->RecNew();
}
?>