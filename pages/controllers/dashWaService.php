<?php 
include 'mysqlBoardWa.php';

//instanciar la clase
$oMySQL= new MySQL();
//variable que regrese los datos de la clase
$response="";
//concepto para atendenr solicitudes de tipo posh 
$rq= $_POST['rq'];

//identificar el tipo de request que nos estan enviando
 if($rq ==1){
    $response= $oMySQL->modalRecNew();
}else if($rq ==2){
    $response= $oMySQL->modalCovUnAsig();
}else if($rq ==3){
    $response= $oMySQL->modalRecNonCov();
}else if($rq ==4){
    $response= $oMySQL->modalRecSoonExp();
}
//cambiar las consultas por las validaciones de los anhos 
else if($rq ==5){
    $sp_year = $_POST['sp_year']; // Obtener el valor de 'sp_year' enviado desde JavaScript
    $response = $oMySQL->barGraphInformation($sp_year); // Pasar el valor al método barGraphInformation
}else if($rq ==6){
    $sp_year = $_POST['sp_year']; // Obtener el valor de 'sp_year' enviado desde JavaScript
    $response= $oMySQL->modalBarGraphInformation($sp_year);
}else if($rq ==7){
    $sp_year = $_POST['sp_year'];
    $response= $oMySQL->scatterPlotInformation($sp_year);
}else if($rq ==8){
    $sp_year = $_POST['sp_year'];
    $response= $oMySQL->modalScatterPlotInformation($sp_year);
}else if($rq ==9){
    $sp_year = $_POST['sp_year'];
    $response= $oMySQL->pieGraphInformation($sp_year);
}else if($rq ==10){
    $sp_year = $_POST['sp_year'];
    $response= $oMySQL->modalpieGraphInformation($sp_year);
}



echo $response;
?>