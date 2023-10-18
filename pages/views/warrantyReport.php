<?php
require('../../public/FPDF/fpdf.php');
include "../../includes/conecta.php";
//obtendremos lA VARIABLE QUE PASAMOS POR METODO get 
$idWR= $_GET['p'];
// Preparar la llamada al procedimiento almacenado
$stmt = $conn->query("CALL sp_reportWarranty('$idWR')");
while ($fila = $stmt->fetch_assoc()) {
    //optenemos las variables del select y la asignamos a la session activa
    $WR_idTbl_Warranty_Registration	 = $fila["WR_idTbl_Warranty_Registration"];
    $NombreCompleto =  $fila["NombreCompleto"];
    $PCS_Description	 = $fila["PCS_Description"];
    $CT_Description	 = $fila["CT_Description"];
    $CMP_Technical_Name  = $fila["CMP_Technical_Name"];
    $CBT_Employee_Code =  $fila["CBT_Employee_Code"];
    $CMP_Acquisition_Date =  $fila["CMP_Acquisition_Date"];
    $TG_Description = $fila["TG_Description"];
    $CMP_Warranty_Expiration = $fila["CMP_Warranty_Expiration"];
    $CMP_Serial = $fila["CMP_Serial"];
    $CMP_Servitag = $fila["CMP_Servitag"];
    $MDL_Description = $fila["MDL_Description"];
    $MFC_Description = $fila["MFC_Description"];
    $CBT_employee_position= $fila["CBT_employee_position"];
    $ticket = $fila["ticket"];
    $WR_Date_Admission = $fila["WR_Date_Admission"];
    $WR_Main_ProblemPDF = $fila["WR_Main_Problem"];
    $WR_ActionsDonePDF = $fila["WR_ActionsDone"];
    $WR_DiagnosisPDF = $fila["WR_Diagnosis"];
    $WR_SolutionPDF = $fila["WR_Solution"];
    $STS_DescriptionPDF = $fila["STS_Description"];
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
  
  $mes = $meses[$numeroMes-1];  //
  $todayDate = $fechaObj->format('d')." de ".$mes." del ".$fechaObj->format('Y');


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
        $this->Cell(70, 9, "Reporte Version: 0.1");

        $this->Cell(180, 8, 'Pagina ' . $this->PageNo() . 'de {nb}', 0, 0, 'C');
    }

    function TablarReporte($header,$todayDate,$NombreCompleto,$PCS_Description,$CBT_employee_position,$CT_Description,$MFC_Description,$MDL_Description,$CMP_Serial,$CMP_Servitag,$ticket,$CMP_Technical_Name,$WR_Date_Admission,
    $WR_Main_ProblemPDF,$WR_ActionsDonePDF,$WR_DiagnosisPDF,$WR_SolutionPDF,$STS_DescriptionPDF)
    {
        // Agregar el título
        $this->SetFont('times', 'B', 14);
        $this->Cell(0, 20, utf8_decode("Informe de Reporte Técnico en Garantías"), 0, 1, 'C');
        // Guardar márgenes
        $margenIzquierdo = ($this->GetPageWidth() - 160) / 2;

        //Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(202, 207, 210);
        $this->SetTextColor(28, 40, 51);
        $this->SetDrawColor(98, 101, 103);
        $this->SetLineWidth(.3);
        $this->SetFont('times', 'B', 12);

        //Centrar tabla
        $this->SetLeftMargin($margenIzquierdo);
        $this->SetX($margenIzquierdo);


        //Cabecera
        //TABLA PRINCIPAL PARA EL INFORME

        for ($i = 0; $i < count($header); $i++)
            $this->Cell(80, 8, $header[$i], 1, 0, 'C', 1);
            $this->Ln();

            //Restauración de colores y fuentes
            $this->SetFillColor(242, 243, 244);
            $this->SetTextColor(0);
            $this->SetFont('');
            //Datos
            $fill = false;
            $this->SetFont('times', 'B', 12);
            $this->Cell(80, 6, "Ubicacion/Fecha de Informe:", 'LR', 0, 'L', $fill);
            $this->SetFont('');
            $this->Cell(80, 6, " Marcovia | ".$todayDate, 'LR', 1, 'L', $fill);
            // Agregar una línea al final
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Line($x, $y, $x + 160, $y);
            $this->Ln();
            $this->Ln();
            $this->Line($x, $y + 11.7, $x + 160, $y + 11.7);

            $fill = !$fill;
            $this->SetFont('times', 'B', 12);
            $this->Cell(80, 6, "Nombre de Colaborador: ", 'LR', 0, 'L', $fill);
            $this->SetFont('');
            $this->Cell(80, 6, " ".$NombreCompleto, 'LR', 0, 'L', $fill);
            $fill = true;
            $this->Ln();

            $fill = !$fill;
            $this->SetFont('times', 'B', 12);
            $this->Cell(80, 6, "Proceso/Area de Trabajo: ", 'LR', 0, 'L', $fill);
            $this->SetFont('');
            $this->Cell(80, 6," ". $PCS_Description ." | " .$CBT_employee_position, 'LR', 0, 'L', $fill);
            $fill = false;
            $this->Ln();

            $fill = !$fill;
            $this->SetFont('times', 'B', 12);
            $this->Cell(80, 6, "Tipo de Equipo: ", 'LR', 0, 'L', $fill);
            $this->SetFont('');
            $this->Cell(80, 6, " ".$CT_Description, 'LR', 0, 'L', $fill);
            $fill = true;
            $this->Ln();

            $fill = !$fill;
            $this->SetFont('times', 'B', 12);
            $this->Cell(80, 6, "Marca: ", 'LR', 0, 'L', $fill);
            $this->SetFont('');
            $this->Cell(80, 6, " ".$MFC_Description , 'LR', 0, 'L', $fill);
            $fill = false;
            $this->Ln();

            $fill = !$fill;
            $this->SetFont('times', 'B', 12);
            $this->Cell(80, 6, "Modelo: ", 'LR', 0, 'L', $fill);
            $this->SetFont('');
            $this->Cell(80, 6, " ". $MDL_Description, 'LR', 0, 'L', $fill);
            $fill = true;
            $this->Ln();

            $fill = !$fill;
            $this->SetFont('times', 'B', 12);
            $this->Cell(80, 6, "Numero de Serie: ", 'LR', 0, 'L', $fill);
            $this->SetFont('');
            $this->Cell(80, 6, " ".$CMP_Serial, 'LR', 0, 'L', $fill);
            $fill = false;
            $this->Ln();

            $fill = !$fill;
            $this->SetFont('times', 'B', 12);
            $this->Cell(80, 6, "Numero de Servitag: ", 'LR', 0, 'L', $fill);
            $this->SetFont('');
            $this->Cell(80, 6, " " .$CMP_Servitag, 'LR', 0, 'L', $fill);
            $fill = true;
            $this->Ln();

            $fill = !$fill;
            $this->SetFont('times', 'B', 12);
            $this->Cell(80, 6, "Numero de Orden de Trabajo: ", 'LR', 0, 'L', $fill);
            $this->SetFont('');
            $this->Cell(80, 6, " " .$ticket, 'LR', 0, 'L', $fill);
            $fill = false;
            $this->Ln();
            
            $fill = !$fill;
            $this->SetFont('times', 'B', 12);
            $this->Cell(80, 6, "Nombre Tecnico del Pc: ", 'LR', 0, 'L', $fill);
            $this->SetFont('');
            $this->Cell(80, 6, " ".$CMP_Technical_Name, 'LR', 0, 'L', $fill);
            $fill = true;
            $this->Ln();

            $fill = !$fill;
            $this->SetFont('times', 'B', 12);
            $this->Cell(80, 6, "Fecha en que se creo el reporte: ", 'LR', 0, 'L', $fill);
            $this->SetFont('');
            $this->Cell(80, 6, " ".$WR_Date_Admission, 'LR', 0, 'L', $fill);
            $fill = false;
            $this->Ln();
            $this->Cell(160, 0, '', 'T');
            


    $this->SetFont('times', 'B', 14);
    $this->Cell(-160,25, utf8_decode("Informe General del Reporte"), 0, 1, 'C');
            
            for ($o = 0; $o <=0; $o++){
                $this->SetFillColor(242, 243, 244);
                $this->SetTextColor(0);
                $this->SetFont('');
                //Datos
                $fill = true;
                $this->Line($x, $y + 96.8, $x + 160, $y + 96.8);
                $this->SetFont('times', 'B', 12);
                $this->Cell(160, 6, "A. Descripcion del Fallo/Problema", 'LR', 0, 'L', $fill);
                $this->Ln();
                
                $fill = !$fill;
                $this->SetFont('times', 'B', 12);
                $this->SetFont('');
                $this->MultiCell(160, 9, utf8_decode( "".$WR_Main_ProblemPDF), 'LR', 'J', $fill);
                $fill = false;

                $fill = true;
                $this->SetFont('times', 'B', 12);
                $this->Cell(160, 6, "B.Acciones Previas Realizadas ", 'LR', 0, 'L', $fill);
                $this->Ln();
                
                $fill = !$fill;
                $this->SetFont('times', 'B', 12);
                $this->SetFont('');
                $this->MultiCell(160, 9, utf8_decode("".$WR_ActionsDonePDF), 'LR', 'J', $fill);
                $fill = false;

                $fill = true;
                $this->SetFont('times', 'B', 12);
                $this->Cell(160, 6, "C.Evaluacion y Diagnostico ", 'LR', 0, 'L', $fill);
                $this->Ln();
                
                $fill = !$fill;
                $this->SetFont('times', 'B', 12);
                $this->SetFont('');
                $this->MultiCell(160, 9, utf8_decode("".$WR_DiagnosisPDF), 'LR', 'J', $fill);
                $fill = false;

                $fill = true;
                $this->SetFont('times', 'B', 12);
                $this->Cell(160, 6, "D.Solucion al problema ", 'LR', 0, 'L', $fill);
                $this->Ln();
                
                $fill = !$fill;
                $this->SetFont('times', 'B', 12);
                $this->SetFont('');
                $this->MultiCell(160, 9,utf8_decode( "".$WR_SolutionPDF), 'LR', 'J', $fill);
                $fill = false;

                $fill = true;
                $this->SetFont('times', 'B', 12);
                $this->Cell(160, 6, "E.Conclusiones de conformidad ", 'LR', 0, 'L', $fill);
                $this->Ln();
               
                $fill = !$fill;
                $this->SetFont('times', 'B', 12);
                $this->SetFont('');
                if ($STS_DescriptionPDF == "Solucionado") {
                $this->MultiCell(160, 9, utf8_decode("Problema resuelto de manera satisfactorio, se cumplieron los términos de la garantía.") ,'LR', 'J', $fill);
                  } else if ($STS_DescriptionPDF == "Espera") {
                $this->MultiCell(160, 9,utf8_decode("El problema está en proceso por lo tanto el folio está abierto todavía no se le ha dado solución por favor esperar a que los técnicos se acerquen para poder cerrar el caso.") ,'LR', 'J', $fill);
                  } else if ($STS_DescriptionPDF == "Sin Respuesta") {
                    $this->MultiCell(160, 9,utf8_decode( "El problema no tuvo respuesta volver a hacer el reporte para dar seguimiento."),'LR', 'J', $fill);
                  } else if ($STS_DescriptionPDF == "Cancelado") {
                    $this->MultiCell(160, 9,utf8_decode( "El problema no se resolvió porque hubo problemas con la gestión por lo cual no se le pudo dar seguimiento.") ,'LR', 'J', $fill);
                  } else if ($STS_DescriptionPDF == "Deshabilitado") {
                    $this->MultiCell(160, 9,utf8_decode("El Registro actualmente se encuentra Deshabilidato del Sistema, por lo tanto no es como que cuente con alguna cobertura conforme de la garantia.") ,'LR', 'J', $fill);
                  }
               
                $fill = false;

                $this->Cell(160, 0, '', 'T');
                $this->Ln();

            }

          
            $this->Ln();
            $this->SetFont('times', 'B', 12);
            $this->Cell(0,15, utf8_decode("Atentamente:"), 0, 1, 'C');    
            
            $this->Ln();
            $this->SetFont('');
            $this->Cell(0,8, '________________________________', '0',1,'C');
            $this->SetFont('times', 'B', 12);
            $this->Cell(0, 9, "Firma de ".$NombreCompleto, 0, 1, 'C');
        


    }
}

$pdf = new PDF();
// Establecer márgenes
$topMargin = 10; // Margen superior en unidades de medida del PDF
$bottomMargin = 30; // Margen inferior en unidades de medida del PDF
$pdf->SetMargins(10, $topMargin, 10); // Configura los márgenes izquierdo, derecho, y superior
$pdf->SetAutoPageBreak(true, $bottomMargin); // Activa el salto automático de página con un margen inferior

//Títulos de las columnas
$header = array('Descripcion de Campos', 'Informacion');
$pdf->AliasNbPages();
//Segunda página
$pdf->AddPage();
$pdf->SetY(35);
$pdf->TablarReporte($header,$todayDate,$NombreCompleto,$PCS_Description,$CBT_employee_position,$CT_Description,$MFC_Description,$MDL_Description,$CMP_Serial,$CMP_Servitag,$ticket,$CMP_Technical_Name,$WR_Date_Admission,
$WR_Main_ProblemPDF,$WR_ActionsDonePDF,$WR_DiagnosisPDF,$WR_SolutionPDF,$STS_DescriptionPDF);
// Genera un nombre de archivo único basado en la fecha y la hora actual
$timestamp = date("Y-m-d_H-i-s"); // Genera un timestamp en el formato deseado
$nombreArchivo = "ReporteGarantiade_".$ticket.".-" . $timestamp . ".pdf"; // Nombre personalizado con marca de tiempo
$pdfPath = "" . $nombreArchivo; // Ruta completa con nombre de archivo

$pdf->Output($pdfPath, 'I'); // Guarda el PDF con el nombre personalizado

?>