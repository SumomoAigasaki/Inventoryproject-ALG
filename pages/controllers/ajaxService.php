<?php 
include 'mysql.php';
//instanciar la clase
$oMySQL= new MySQL();
//variable que regrese los datos de la clase
$response="";
//concepto para atendenr solicitudes de tipo posh 
$rq= $_POST['rq'];

//identificar el tipo de request que nos estan enviando
if($rq ==1){
    $response= $oMySQL->getCardsNew();
}else if($rq ==2){
    $response= $oMySQL->getCardsWarrantyfull();
}else if($rq ==3){
    $response= $oMySQL->getCardsNonCoverage();
}else if($rq ==4){
    $response= $oMySQL->getCardsrUpcoming();
}else if($rq ==5){
    $response= $oMySQL->sp_DashboardWarrantyGraph();
}else if($rq ==6){
    $response= $oMySQL->getScatterPlotData();
}else if($rq ==7){
    $response= $oMySQL->getPieChartData();
}

echo $response;
?>