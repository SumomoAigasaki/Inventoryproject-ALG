<?php
require_once  "../../includes/conecta.php";
require_once  "../models/user_search.php";
require('../../public/FPDF/fpdf.php');

//obtendremos lA VARIABLE QUE PASAMOS POR METODO get 
$idWR = $_GET['p'];
// Preparar la llamada al procedimiento almacenado
$stmt = $conn->query("CALL sp_dataContract('$idWR')");
while ($fila = $stmt->fetch_assoc()) {
    //optenemos las variables del select y la asignamos a la session activa
    $NameCollaborator =  $fila["NameCollaborator"];
    $EmployeeCode =  $fila["EmployeeCode"];
    $EmployeePosition =  $fila["EmployeePosition"];
    $Marca =  $fila["Marca"];
    $Modelo =  $fila["Modelo"];
    $Serial = $fila["Serial"];
    $Garantia = $fila["Garantia"];
    $Meses = $fila["Meses"];
}

$todayDate = date("Y-m-d");
$fechaObj = new DateTime($todayDate);
$fechaObj->setTimezone(new DateTimeZone('America/Mexico_City'));
$numeroMes = $fechaObj->format('n');

// Define un array con los nombres de los meses en español
$meses = [
    'enero',
    'febrero',
    'marzo',
    'abril',
    'mayo',
    'junio',
    'julio',
    'agosto',
    'septiembre',
    'octubre',
    'noviembre',
    'diciembre'
];

$mes = $meses[$numeroMes - 1];  //
$todayDate = $fechaObj->format('d') . " de " . $mes . " del " . $fechaObj->format('Y');


class PDF extends FPDF
{
    //Cabecera de página
    function Header()
    {
        $logoUrl = '../../resources/Warranty/LogoALG.png'; // Ruta a la imagen local
        // $imgData = getBase64Image($logoUrl);
        $this->Image($logoUrl, 13, 8, 45, 20, "PNG"); // Ajusta los parámetros según sea necesario (x, y, ancho, alto)
        //Arial bold 15
        $this->SetFont('times', 'B', 11);
        $this->Cell(115);
        $this->Cell(60, 3, "Azucarera la Grecia S.A de C.V");
        $this->SetFont('times', 'I', 9);
        $this->Ln(3);
        $this->Cell(105);
        // se agrega utf8_decode para solucionar el problema con los acentos
        $this->Cell(60, 6, utf8_decode("Kilómetro 21, Carretera hacia Cedeño"));
        $this->Ln(3);
        $this->Cell(115);
        $this->Cell(60, 8, "Marcovia, Choluteca, Honduras C.A");
        $this->Ln(3);
        $this->Cell(102);
        $this->Cell(60, 10, "Tel: 2705-3900 / Correo: info@azucareralagrecia.com",);

        //Salto de línea
        $this->Ln(20);
    }

    //Pie de página
    function Footer()
    {

        //Posición: a 1,5 cm del final
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('times', 'I', 10);
        //Número de página
        $this->Cell(70, 10, "Informe distribuido por el sistema INFRAG");
        $this->Ln(4);
        $this->SetFont('times', 'IB', 10);
        $this->Cell(70, 9, "Contrato Version: 0.1");

        $this->Cell(180, 8, 'Pagina ' . $this->PageNo() . 'de {nb}', 0, 0, 'C');
    }

    function Body($nameUserlog, $NameCollaborator, $EmployeeCode, $EmployeePosition,$Marca,$Modelo,$Serial,$Garantia,$Meses,$todayDate)
    {

        //Posición: a 1,5 cm del final
        //Arial italic 8
        $this->SetFont('times', 'B', 14);
        //Número de página
        $this->Cell(0, 10, utf8_decode("CONTRATO DE ASIGNACIÓN DE EQUIPO DE CÓMPUTO"), 0, 1, 'C');
        
        $this->Ln(2);
        $this->SetFont('times', 'B', 12);
        $this->Cell(0, 8, utf8_decode("a. Partes Contratantes"), 0, 1, 'L');

        $fill = false;
        $this->Ln(2);
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 8, utf8_decode("Azucarera la Grecia S.A de C.V, en adelante denominada 'La Empresa,' representada en este contrato por el sistema de INFRAG con el usuario representante: " . $nameUserlog . ", con domicilio en Kilometro 21, Carretera hacía Cedeño,Marcovia, Choluteca . "), 0, 'J', $fill);
         

        $fill = false;
        $this->Ln(4);
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 8, utf8_decode("" . $NameCollaborator . " en adelante denominado 'El Empleado,' con número de identificación dentro de la empresa '" . $EmployeeCode . "', con el cargo de: '" . $EmployeePosition . "' en La Empresa."), 0, 'J', $fill);
   
   
        $this->Ln(4);
        $this->SetFont('times', 'B', 12);
        $this->Cell(0, 8, utf8_decode("b. Antecedentes"), 0, 1, 'L');

        $fill = false;
        $this->Ln(2);
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 8, utf8_decode("La Empresa proporciona equipos de cómputo, en este caso, una computadora personal (PC), para su uso por parte del Empleado en el desempeño de sus funciones laborales"), 0, 'J', $fill);
         
        $this->Ln(4);
        $this->SetFont('times', 'B', 12);
        $this->Cell(0, 8, utf8_decode("c.Cláusulas"), 0, 1, 'L');

        $fill = false;
        $this->Ln(2);
        $this->SetFont('times', 'IB', 12);
        $this->Cell(0, 8, utf8_decode(" 1. Asignación del Equipo de Cómputo"), 0, 1, 'L');
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 8, utf8_decode("    La Empresa asigna al Empleado una computadora personal (PC) con las siguientes características:"), 0, 'J', $fill);
            $this->Cell(160, 0, '', 'T');    
            $this->Ln();
            $fill = TRUE;
            $fill = !$fill;
            $this->SetFont('times', 'B', 12);
            
            $this->Cell(80, 6, "Marca y modelo: ", 'LR', 0, 'C', $fill);
            $this->SetFont('');
            $this->Cell(80, 6," ". $Marca ." | " .$Modelo, 'LR', 0, 'C', $fill);
            $fill = TRUE;
            $this->Ln();

            $fill = !$fill;
            $this->SetFont('times', 'B', 12);
            $this->Cell(80, 6, utf8_decode("Número de serie: "), 'LR', 0, 'C', $fill);
            $this->SetFont('');
            $this->Cell(80, 6,$Serial, 'LR', 0, 'C', $fill);
            $fill = TRUE;
            $this->Ln();

            $fill = !$fill;
            $this->SetFont('times', 'B', 12);
            $this->Cell(80, 6, utf8_decode("Tipo de garantía: "), 'LR', 0, 'C', $fill);
            $this->SetFont('');
            $this->Cell(80, 6,utf8_decode($Garantia), 'LR', 0, 'C', $fill);
            $fill = TRUE;
            $this->Ln();
            $this->Cell(160, 0, '', 'T');  


            
        $this->Ln(3);
        $this->SetFont('times', 'IB', 12);
        $this->Cell(0, 8, utf8_decode(" 2. Uso del Equipo de Cómputo"), 0, 1, 'L');

        $fill = false;
        $this->Ln(2);
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 8, utf8_decode("    2.1 El Empleado utilizará el equipo de cómputo exclusivamente para fines laborales relacionados con las responsabilidades asignadas por La Empresa."), 0, 'J', $fill);
        $this->MultiCell(0, 8, utf8_decode("    2.2 El Empleado se compromete a utilizar el equipo de manera responsable y a mantenerlo en buen estado. Cualquier daño o pérdida deberá ser reportado de inmediato a la persona o departamento designado por La Empresa."), 0, 'J', $fill);
        $this->MultiCell(0, 8, utf8_decode("    2.3 El Empleado se compromete a no instalar software no autorizado ni a realizar modificaciones en la configuración del equipo sin la autorización expresa de La Empresa."), 0, 'J', $fill);
         
        $this->Ln(4);
        $this->SetFont('times', 'IB', 12);
        $this->Cell(0, 8, utf8_decode(" 3. Responsabilidad por el Equipo de Cómputo"), 0, 1, 'L');

        $fill = false;
        $this->Ln(2);
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 8, utf8_decode("    3.1 La Empresa se reserva el derecho de monitorear y auditar el uso del equipo de cómputo en cualquier momento."), 0, 'J', $fill);
        $this->MultiCell(0, 8, utf8_decode("    3.2 El Empleado es responsable de garantizar la seguridad del equipo y no deberá dejarlo desatendido en ningún momento."), 0, 'J', $fill);
        
        $this->Ln(3);
        $this->SetFont('times', 'IB', 12);
        $this->Cell(0, 8, utf8_decode(" 4. Mantenimiento y Reparacione"), 0, 1, 'L');

        $fill = false;
        $this->Ln(2);
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 8, utf8_decode("La Empresa se encargará del mantenimiento y las reparaciones necesarias del equipo de cómputo. El Empleado deberá reportar cualquier problema o mal funcionamiento de manera oportuna."), 0, 'J', $fill);
        
        $this->Ln(3);
        $this->SetFont('times', 'IB', 12);
        $this->Cell(0, 8, utf8_decode(" 5. Devolución del Equipo de Cómputo"), 0, 1, 'L');

        $fill = false;
        $this->Ln(2);
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 8, utf8_decode("Al término de la relación laboral con La Empresa, el Empleado deberá devolver el equipo de cómputo en las mismas condiciones en las que lo recibió, salvo el desgaste normal por el uso."), 0, 'J', $fill);
        
        $this->Ln(3);
        $this->SetFont('times', 'IBU', 12);
        $this->Cell(0, 8, utf8_decode(" 6. Confidencialidad"), 0, 1, 'L');

        $fill = false;
        $this->Ln(2);
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 8, utf8_decode("El Empleado se compromete a mantener la confidencialidad de la información almacenada en el equipo de cómputo y a no divulgar información confidencial de La Empresa. "), 0, 'J', $fill);
         
        $this->Ln(3);
        $this->SetFont('times', 'IB', 12);
        $this->Cell(0, 8, utf8_decode("7. Duración del Contrato"), 0, 1, 'L');

        $fill = false;
        $this->Ln(2);
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 8, utf8_decode("Este contrato de asignación de equipo de cómputo entrará en vigor a partir de la fecha de firma y tendrá una duración de  ". $Meses . " mes(es), sujeto a las condiciones de empleo del Empleado en La Empresa."), 0, 'J', $fill);
        
        $this->Ln();
        $this->SetFont('times', 'B', 12);
        $this->Cell(0,15, utf8_decode("Firma de las partes:"), 0, 1, 'C');    
        
        $this->Ln();
        $this->SetFont('');
        $this->Cell(0,8, '_____________________________              ______________________________ ', '0',1,'C');
        $this->SetFont('times', 'I', 12);
        $this->Cell(0, 9, "     Firma de ".$nameUserlog."                       Firma de ".$NameCollaborator, 0, 1, 'C');




    }
}

$pdf = new PDF();
// Establecer márgenes
$topMargin = 10; // Margen superior en unidades de medida del PDF
$bottomMargin = 30; // Margen inferior en unidades de medida del PDF
$pdf->SetMargins(20, $topMargin, 20); // Configura los márgenes izquierdo, derecho, y superior
$pdf->SetAutoPageBreak(true, $bottomMargin); // Activa el salto automático de página con un margen inferior

//Títulos de las columnas
$header = array('Descripcion de Campos', 'Informacion');
$pdf->AliasNbPages();
//Segunda página
$pdf->AddPage();
$pdf->SetY(35);
$pdf->Body($_SESSION["NameUserlog"], $NameCollaborator, $EmployeeCode, $EmployeePosition,$Marca,$Modelo,$Serial,$Garantia,$Meses,$todayDate);
// Genera un nombre de archivo único basado en la fecha y la hora actual
$timestamp = date("Y-m-d_H-i-s"); // Genera un timestamp en el formato deseado
$nombreArchivo = "Contradode_".$NameCollaborator . $timestamp . ".pdf"; // Nombre personalizado con marca de tiempo
$pdfPath = "" . $nombreArchivo; // Ruta completa con nombre de archivo

$pdf->Output($pdfPath, 'I'); // Guarda el PDF con el nombre personalizado
