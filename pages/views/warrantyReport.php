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
       //Posición: a 1,5 cm del final
      $logoUrl = '../../resources/Warranty/LogoALG.png'; // Ruta a la imagen local
      $this->Image($logoUrl, 15, 16, 50); // Inserta el logo
  
      $this->SetFont('times', 'I', 9);
  
      // Salto de línea
      $this->Ln(40);
  }

    //Pie de página
    function Footer()
    {
        // Establecer la posición y el tamaño de la página
        $this->SetY(-40);
        $this->SetMargins(15, 0, 15);
        $this->SetFont('times', 'I', 8);
    
        // Iconos con coordenadas absolutas
        $telefono = '../../resources/Warranty/telefono.png';
        $this->Image($telefono, 25, $this->GetY() + 2.5, 4);
        $direccion = '../../resources/Warranty/internet(1).png';
        $this->Image($direccion, 25, $this->GetY() + 13, 4);
        $localizacion = '../../resources/Warranty/localizacion.png';
        $this->Image($localizacion, 25, $this->GetY() + 23, 4);
    
        // Texto con coordenadas absolutas
        $this->SetTextColor(0, 0, 0); // Color negro para el texto
        $this->SetY(-40);
        $this->SetX(35);
        $this->Cell(0, 5, utf8_decode("+(504) 2705-3900 "), 0, 0, 'L', 0);
        $this->Ln();
        $this->SetX(35);
        $this->Cell(0, 3, utf8_decode("+(504) 3333-3333 "), 0, 0, 'L', 0);
        $this->Ln(6);

        $this->SetX(35);
        $this->Cell(0, 5, utf8_decode("gerenciageneral@lagreciahn.com"), 0, 0, 'L', );
        $this->Ln();
        $this->SetX(35);
        $this->Cell(0, 3, utf8_decode("www.lagreciahn.com"), 0, 0, 'L', );
        $this->Ln(6);

        $this->SetX(35);
        $this->Cell(0, 5, utf8_decode("Kilómetro 21, Carretera hacia Cedeño"), 0, 0, 'L', 0);
        $this->Ln();
        $this->SetX(35);
        $this->Cell(0, 3, utf8_decode("Marcovia, Choluteca, Honduras C.A"), 0, 0, 'L', 0);
       
        $this->SetX(35);
        $this->SetFont('times', 'I', 11);
        $this->MultiCell(155, 0, 'Pagina ' . $this->PageNo() . ' de {nb}','', 'R',false);
    }

    function TablarReporte($header,$todayDate,$NombreCompleto,$PCS_Description,$CBT_employee_position,$CT_Description,$MFC_Description,$MDL_Description,$CMP_Serial,$CMP_Servitag,$ticket,$CMP_Technical_Name,$WR_Date_Admission,
    $WR_Main_ProblemPDF,$WR_ActionsDonePDF,$WR_DiagnosisPDF,$WR_SolutionPDF,$STS_DescriptionPDF)
    {
      $this->SetY(34); // Ajustar posición para dejar espacio para la firma
      $this->SetMargins(15, 0, 15);
       // Agregar el título
       $this->SetFont('times', 'I', 12);
       $this->Cell(170, 5,utf8_decode( " Marcovia-Choluteca ".$todayDate),  0, 1, 'R');
        // Agregar el título
        $this->SetFont('times', 'B', 14);
        $this->Cell(0, 18, utf8_decode("Ficha tecnica de reclamación de la garantía"), 0, 1, 'C');
        // Guardar márgenes
        $margenIzquierdo = ($this->GetPageWidth() - 160) / 2;

        //Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(202, 207, 210);
        $this->SetTextColor(28, 40, 51);
        $this->SetDrawColor(98, 101, 103);
        $this->SetLineWidth(.2);
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
            $this->SetFillColor(215, 219, 221 );
            $this->SetTextColor(0);
            $this->SetFont('');
            $fill = false;
          
            $fill = !$fill;
            $this->SetFont('times', 'B', 12);
            $this->Cell(80, 7, "Tipo de Equipo: ", 'LTRB', 0, 'L', 1);
            $this->SetFont('');
            $this->Cell(80, 7, " ".$CT_Description, 'LTRB', 0, 'L', 0);
            $fill = true;
            $this->Ln();

            $fill = !$fill;
            $this->SetFont('times', 'B', 12);
            $this->Cell(80, 7, "Marca: ", 'LTRB', 0, 'L',1);
            $this->SetFont('');
            $this->Cell(80, 7, " ".$MFC_Description , 'LTRB', 0, 'L', 0);
            $fill = false;
            $this->Ln();

            $fill = !$fill;
            $this->SetFont('times', 'B', 12);
            $this->Cell(80, 7, "Modelo: ", 'LTRB', 0, 'L', 1);
            $this->SetFont('');
            $this->Cell(80, 7, " ". $MDL_Description, 'LTRB', 0, 'L', 0);
            $fill = true;
            $this->Ln();

            $fill = !$fill;
            $this->SetFont('times', 'B', 12);
            $this->Cell(80, 7, "Numero de Serie: ", 'LTRB', 0, 'L', 1);
            $this->SetFont('');
            $this->Cell(80, 7, " ".$CMP_Serial, 'LTRB', 0, 'L', 0);
            $fill = false;
            $this->Ln();

            $fill = !$fill;
            $this->SetFont('times', 'B', 12);
            $this->Cell(80, 6, "Numero de Servitag: ", 'LTRB', 0, 'L', 1);
            $this->SetFont('');
            $this->Cell(80, 6, " " .$CMP_Servitag, 'LTRB', 0, 'L', 0);
            $fill = true;
            $this->Ln();

            $fill = !$fill;
            $this->SetFont('times', 'B', 12);
            $this->Cell(80, 6, "Numero de Orden de Trabajo: ", 'LTRB', 0, 'L', 1);
            $this->SetFont('');
            $this->Cell(80, 6, " " .$ticket, 'LTRB', 0, 'L', 0);
            $fill = false;
            $this->Ln();
            
            $fill = !$fill;
            $this->SetFont('times', 'B', 12);
            $this->Cell(80, 7, "Nombre Tecnico del Pc: ", 'LTRB', 0, 'L', 1);
            $this->SetFont('');
            $this->Cell(80, 7, " ".$CMP_Technical_Name, 'LTRB', 0, 'L', 0);
            $fill = true;
            $this->Ln();

            $fill = !$fill;
            $this->SetFont('times', 'B', 12);
            $this->Cell(80, 7, "Fecha Creacion Reporte: ", 'LTRB', 0, 'L', 1);
            $this->SetFont('');
            $this->Cell(80, 7, "".$WR_Date_Admission, 'LTRB', 0, 'L', 0);
            $fill = false;
            $this->Ln();
            $this->Cell(160, 0, '', 'T');
            


        $this->SetFont('times', 'IB', 12);
        $this->Cell(-160,18, utf8_decode("Información General del Reporte"), 0, 1, 'C');
                
            for ($o = 0; $o <=0; $o++){
                $this->SetFillColor(242, 243, 244);
                $this->SetTextColor(0);
                $this->SetFont('');
                //Datos
                $fill = true;
                $this->SetFont('times', 'B', 12);
                $this->Cell(160, 7, "A. Descripcion del Fallo/Problema", 'LTR', 0, 'L', $fill);
                $this->Ln();
                
                $fill = !$fill;
                $this->SetFont('times', 'B', 12);
                $this->SetFont('');
                $this->MultiCell(160, 9, utf8_decode("".$WR_Main_ProblemPDF), 'LTR', 'J', $fill);
                $fill = false;

                $fill = true;
                $this->SetFont('times', 'B', 12);
                $this->Cell(160, 6, "B.Acciones Previas Realizadas ", 'LTR', 0, 'L', $fill);
                $this->Ln();
                
                $fill = !$fill;
                $this->SetFont('times', 'B', 12);
                $this->SetFont('');
                $this->MultiCell(160, 9, utf8_decode("".$WR_ActionsDonePDF), 'LTR', 'J', $fill);
                $fill = false;

                $fill = true;
                $this->SetFont('times', 'B', 12);
                $this->Cell(160, 6, "C.Evaluacion y Diagnostico ", 'LTR', 0, 'L', $fill);
                $this->Ln();
                
                $fill = !$fill;
                $this->SetFont('times', 'B', 12);
                $this->SetFont('');
                $this->MultiCell(160, 9, utf8_decode("".$WR_DiagnosisPDF), 'LTR', 'J', $fill);
                $fill = false;

                $fill = true;
                $this->SetFont('times', 'B', 12);
                $this->Cell(160, 6, "D.Solucion al problema ", 'LTR', 0, 'L', $fill);
                $this->Ln();
                
                $fill = !$fill;
                $this->SetFont('times', 'B', 12);
                $this->SetFont('');
                $this->MultiCell(160, 9,utf8_decode("".$WR_SolutionPDF), 'LTR', 'J', $fill);
                $fill = false;

                $fill = true;
                $this->SetFont('times', 'B', 12);
                $this->Cell(160, 6, "E.Conclusiones de conformidad ", 'LTR', 0, 'L', $fill);
                $this->Ln();
               
                $fill = !$fill;
                $this->SetFont('times', 'B', 12);
                $this->SetFont('');
                if ($STS_DescriptionPDF == "Solucionado") {
                $this->MultiCell(160, 9, utf8_decode("Problema resuelto de manera satisfactorio, se cumplieron los términos de la garantía.") ,'LTRB', 'J', $fill);
                  } else if ($STS_DescriptionPDF == "Espera") {
                $this->MultiCell(160, 9,utf8_decode("El problema está en proceso por lo tanto el folio está abierto todavía no se le ha dado solución por favor esperar a que los técnicos se acerquen para poder cerrar el caso.") ,'LTRB', 'J', $fill);
                  } else if ($STS_DescriptionPDF == "Sin Respuesta") {
                    $this->MultiCell(160, 9,utf8_decode("El problema no tuvo respuesta volver a hacer el reporte para dar seguimiento."),'LTRB', 'J', $fill);
                  } else if ($STS_DescriptionPDF == "Cancelado") {
                    $this->MultiCell(160, 9,utf8_decode("El problema no se resolvió porque hubo problemas con la gestión por lo cual no se le pudo dar seguimiento.") ,'LTRB', 'J', $fill);
                  } else if ($STS_DescriptionPDF == "Deshabilitado") {
                    $this->MultiCell(160, 9,utf8_decode("El Registro actualmente se encuentra Deshabilidato del Sistema, por lo tanto no es como que cuente con alguna cobertura conforme de la garantia.") ,'LTRB', 'J', $fill);
                  }
               
                $fill = false;

                $this->Cell(160, 0, '', 'T');
              

            }
            $this->Ln(10);
            $this->SetFont('times', '', 12);
            $this->MultiCell(160, 5, utf8_decode("NOTA: Al firmar este documento, se acepta que la información presentada es precisa y confirma que el problema o caso ha sido resuelto en conjunto con la empresa responsable de la reclamación de la garantía. La firma valida la exactitud de los datos proporcionados y la conclusión satisfactoria del asunto."), '', 'J', $fill);
            $this->Ln(25);
            $this->SetFont('');
            $this->SetFont('times', 'IB', 12);
            $this->MultiCell(170, 9, "Lic. ".$NombreCompleto,'', 'R', $fill);
            $this->SetFont('times', 'I', 12);
            $this->MultiCell(170, 0, $CBT_employee_position.", Azucarera La Grecia",'', 'R', $fill);
            $this->Ln(3);


    }
}
// ... (código previo)

$pdf = new PDF();
// Establecer márgenes
$topMargin = 35; // Margen superior en unidades de medida del PDF
$bottomMargin = 35; // Margen inferior en unidades de medida del PDF
$leftMargin = 15; // Margen izquierdo en unidades de medida del PDF
$rightMargin = 15; // Margen derecho en unidades de medida del PDF
$pdf->SetMargins($leftMargin, $topMargin, $rightMargin); // Configura los márgenes izquierdo, derecho, y superior
$pdf->SetAutoPageBreak(true, $bottomMargin); // Activa el salto automático de página con un margen inferior

//Títulos de las columnas
$header = array('Descripcion de Campos', 'Informacion');
$pdf->AliasNbPages();
//Segunda página
$pdf->AddPage();
$pdf->SetY(50);
$pdf->TablarReporte($header,$todayDate,$NombreCompleto,$PCS_Description,$CBT_employee_position,$CT_Description,$MFC_Description,$MDL_Description,$CMP_Serial,$CMP_Servitag,$ticket,$CMP_Technical_Name,$WR_Date_Admission,
$WR_Main_ProblemPDF,$WR_ActionsDonePDF,$WR_DiagnosisPDF,$WR_SolutionPDF,$STS_DescriptionPDF);
// Genera un nombre de archivo único basado en la fecha y la hora actual
$timestamp = date("Y-m-d_H-i-s"); // Genera un timestamp en el formato deseado
$nombreArchivo = "ReporteGarantiade_".$ticket.".-" . $timestamp . ".pdf"; // Nombre personalizado con marca de tiempo
$pdfPath = "" . $nombreArchivo; // Ruta completa con nombre de archivo

$pdf->Output($pdfPath, 'I'); // Guarda el PDF con el nombre personalizado

?>