<?php 
include 'mysqlBoardComputer.php';

//instanciar la clase
$oMySQL= new MySQL();
//variable que regrese los datos de la clase
$response="";
//concepto para atendenr solicitudes de tipo posh 
$rq= $_POST['rq'];

//identificar el tipo de request que nos estan enviando
 if($rq ==1){
    $response= $oMySQL->modalRecNewRegister();
}else if($rq ==2){
    $response= $oMySQL->modalrecRams();
}else if($rq ==3){
    $response= $oMySQL->modalRecCPU();
}else if($rq ==4){
    $response= $oMySQL->modalRecDisk();
}else if($rq ==5){
    $sp_year = $_POST['sp_year']; // Obtener el valor de 'sp_year' enviado desde JavaScript
    $response = $oMySQL->comparativeBarGraph($sp_year); // Pasar el valor al método barGraphInformation
}else if($rq ==6){
    $sp_year = $_POST['sp_year']; 
    $response= $oMySQL->modalComparativeBarGraph($sp_year);
}else if($rq ==7){
    $sp_year = $_POST['sp_year'];
    $response= $oMySQL->pieGraphInformationDesktop($sp_year);
}else if($rq ==8){
    $sp_year = $_POST['sp_year'];
    $response= $oMySQL->modalpieGraphInformationDesktop($sp_year);
}else if($rq ==9){
    $sp_year = $_POST['sp_year'];
    $response= $oMySQL->pieGraphInformationLaptop($sp_year);
}else if($rq ==10){
    $sp_year = $_POST['sp_year'];
    $response= $oMySQL->modalpieGraphInformationLaptop($sp_year);
}else if($rq ==11){
    $sp_year = $_POST['sp_year'];
    $response= $oMySQL->scatterPlotInformationLocation($sp_year);
}else if($rq ==12){
    $sp_year = $_POST['sp_year'];
    $response= $oMySQL->modalScatterPlotInformationLocation($sp_year);
}



echo $response;
?>