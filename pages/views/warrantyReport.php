<?php
require('../../public/FPDF/fpdf.php');
include "../../includes/conecta.php";
//obtendremos lA VARIABLE QUE PASAMOS POR METODO get 
$idWR = $_GET['p'];
// Preparar la llamada al procedimiento almacenado
$stmt = $conn->query("CALL sp_reportWarranty('$idWR')");
while ($fila = $stmt->fetch_assoc()) {
  //optenemos las variables del select y la asignamos a la session activa
  $WR_idTbl_Warranty_Registration   = $fila["WR_idTbl_Warranty_Registration"];
  $NombreCompleto =  $fila["NombreCompleto"];
  $PCS_Description   = $fila["PCS_Description"];
  $CT_Description   = $fila["CT_Description"];
  $CMP_Technical_Name  = $fila["CMP_Technical_Name"];
  $CBT_Employee_Code =  $fila["CBT_Employee_Code"];
  $CMP_Acquisition_Date =  $fila["CMP_Acquisition_Date"];
  $TG_Description = $fila["TG_Description"];
  $CMP_Warranty_Expiration = $fila["CMP_Warranty_Expiration"];
  $CMP_Serial = $fila["CMP_Serial"];
  $CMP_Servitag = $fila["CMP_Servitag"];
  $MDL_Description = $fila["MDL_Description"];
  $MFC_Description = $fila["MFC_Description"];
  $CBT_employee_position = $fila["CBT_employee_position"];
  $ticket = $fila["ticket"];
  $WR_Date_Admission = $fila["WR_Date_Admission"];
  $WR_Main_ProblemPDF = $fila["WR_Main_Problem"];
  $WR_ActionsDonePDF = $fila["WR_ActionsDone"];
  $WR_DiagnosisPDF = $fila["WR_Diagnosis"];
  $WR_SolutionPDF = $fila["WR_Solution"];
  $STS_DescriptionPDF = $fila["STS_Description"];
  $firma = $fila["firma"];
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


class ReportW extends FPDF
{

 // Variable de clase para almacenar la firma
 public $firma;
 public $ticket;
 // ... (otros métodos y funciones)

 // Método para establecer la firma desde fuera de la clase
 public function setFirma($firma,$ticket) {
     $this->firma = $firma;
     $this->ticket = $ticket;
 }

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
    $firma= $this->firma;
    $ticket =  $this->ticket;

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
    $this->Cell(0, 5, utf8_decode("gerenciageneral@lagreciahn.com"), 0, 0, 'L',);
    $this->Ln();
    $this->SetX(35);
    $this->Cell(0, 3, utf8_decode("www.lagreciahn.com"), 0, 0, 'L',);
    $this->Ln(6);

    $this->SetX(35);
    $this->Cell(0, 5, utf8_decode("Kilómetro 21, Carretera hacia Cedeño"), 0, 0, 'L', 0);
    $this->Ln();
    $this->SetX(35);
    $this->Cell(0, 3, utf8_decode("Marcovia, Choluteca, Honduras C.A"), 0, 0, 'L', 0);


    $this->Ln();
    $this->SetX(35);
    $this->MultiCell(155, -0, 'Reporte #'.$ticket.', hecho por: '.$firma, '', 'R', false);
    $this->SetX(35);
    $this->SetFont('times', 'I', 11);
    $this->MultiCell(160, -15, 'Pagina ' . $this->PageNo() . ' de {nb}', '', 'R', false);
   
  }

  function TablarReporte(
    $header,
    $todayDate,
    $NombreCompleto,
    $PCS_Description,
    $CBT_employee_position,
    $CT_Description,
    $MFC_Description,
    $MDL_Description,
    $CMP_Serial,
    $CMP_Servitag,
    $ticket,
    $CMP_Technical_Name,
    $WR_Date_Admission,
    $WR_Main_ProblemPDF,
    $WR_ActionsDonePDF,
    $WR_DiagnosisPDF,
    $WR_SolutionPDF,
    $STS_DescriptionPDF, 
    $firma
  ) {
    // $this->SetY(34); // Ajustar posición para dejar espacio para la firma
    $this->SetMargins(40, 35, 15);
    // Agregar el título
    $this->SetFont('times', 'I', 12);
    $this->Cell(170, 5, utf8_decode(" Marcovia-Choluteca " . $todayDate),  0, 1, 'R');
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
    $this->SetFillColor(215, 219, 221);
    $this->SetTextColor(0);
    $this->SetFont('');
    $fill = false;

    $fill = !$fill;
    $this->SetFont('times', 'B', 12);
    $this->Cell(80, 7, "Tipo de Equipo: ", 'LTRB', 0, 'L', 1);
    $this->SetFont('');
    $this->Cell(80, 7, " " . $CT_Description, 'LTRB', 0, 'L', 0);
    $fill = true;
    $this->Ln();

    $fill = !$fill;
    $this->SetFont('times', 'B', 12);
    $this->Cell(80, 7, "Marca: ", 'LTRB', 0, 'L', 1);
    $this->SetFont('');
    $this->Cell(80, 7, " " . $MFC_Description, 'LTRB', 0, 'L', 0);
    $fill = false;
    $this->Ln();

    $fill = !$fill;
    $this->SetFont('times', 'B', 12);
    $this->Cell(80, 7, "Modelo: ", 'LTRB', 0, 'L', 1);
    $this->SetFont('');
    $this->Cell(80, 7, " " . $MDL_Description, 'LTRB', 0, 'L', 0);
    $fill = true;
    $this->Ln();

    $fill = !$fill;
    $this->SetFont('times', 'B', 12);
    $this->Cell(80, 7, "Numero de Serie: ", 'LTRB', 0, 'L', 1);
    $this->SetFont('');
    $this->Cell(80, 7, " " . $CMP_Serial, 'LTRB', 0, 'L', 0);
    $fill = false;
    $this->Ln();

    $fill = !$fill;
    $this->SetFont('times', 'B', 12);
    $this->Cell(80, 6, "Numero de Servitag: ", 'LTRB', 0, 'L', 1);
    $this->SetFont('');
    $this->Cell(80, 6, " " . $CMP_Servitag, 'LTRB', 0, 'L', 0);
    $fill = true;
    $this->Ln();

    $fill = !$fill;
    $this->SetFont('times', 'B', 12);
    $this->Cell(80, 6, "Numero de Orden de Trabajo: ", 'LTRB', 0, 'L', 1);
    $this->SetFont('');
    $this->Cell(80, 6, " " . $ticket, 'LTRB', 0, 'L', 0);
    $fill = false;
    $this->Ln();

    $fill = !$fill;
    $this->SetFont('times', 'B', 12);
    $this->Cell(80, 7, "Nombre Tecnico del Pc: ", 'LTRB', 0, 'L', 1);
    $this->SetFont('');
    $this->Cell(80, 7, " " . $CMP_Technical_Name, 'LTRB', 0, 'L', 0);
    $fill = true;
    $this->Ln();

    $fill = !$fill;
    $this->SetFont('times', 'B', 12);
    $this->Cell(80, 7, "Fecha Creacion Reporte: ", 'LTRB', 0, 'L', 1);
    $this->SetFont('');
    $this->Cell(80, 7, "" . $WR_Date_Admission, 'LTRB', 0, 'L', 0);
    $fill = false;
    $this->Ln();
    $this->Cell(160, 0, '', 'T');

    $this->Ln(4);
    // $this->SetFont('times', '', 12);
    // $this->MultiCell(160, 5, utf8_decode("Es de suma importancia destacar que los datos meticulosamente consignados en la tabla anterior son fundamentales para respaldar de manera precisa y detallada la conclusión del caso correspondiente al informe de garantía."), '', 'J', $fill);
    // $this->Ln(2);
    // $this->MultiCell(160, 5, utf8_decode("Es crucial aclarar que, si bien la información presentada anteriormente se refiere a un caso específico y ha sido recopilada con meticulosidad para sustentar esa situación particular, la siguiente tabla continúa con el seguimiento o desarrollo de dicho caso. Aunque los datos de esta nueva tabla difieren en contenido y enfoque, mantienen una coherencia y continuidad con respecto a la información previamente presentada."), '', 'J', $fill);
    // $this->Ln(2);

    $this->SetFont('times', 'B', 12);
    $this->Cell(160, 18, utf8_decode("Información General del Reporte"), 0, 1, 'C');


    $this->SetLeftMargin($margenIzquierdo);
    $this->SetX($margenIzquierdo);
    for ($o = 0; $o <= 0; $o++) {
      $this->SetFillColor(242, 243, 244);
      $this->SetTextColor(0);
      $this->SetFont('');
      //Datos
      $this->SetFont('times', 'B', 12);
      $this->Cell(160, 7, "A. Descripcion del Fallo/Problema", 'LTRB', 0, 'L', 1);
      $this->Ln();
      $this->SetFont('times', 'B', 12);
      $this->SetFont('');
      $this->MultiCell(160, 9, utf8_decode("" . $WR_Main_ProblemPDF), 'LTRB', 'J', 0);

      $this->SetFont('times', 'B', 12);
      $this->Cell(160, 6, "B.Acciones Previas Realizadas ", 'LTRB', 0, 'L', 1);
      $this->Ln();
      $this->SetFont('times', 'B', 12);
      $this->SetFont('');
      $this->MultiCell(160, 9, utf8_decode("" . $WR_ActionsDonePDF), 'LTRB', 'J', 0);

      $this->SetFont('times', 'B', 12);
      $this->Cell(160, 6, "C.Evaluacion y Diagnostico ", 'LTRB', 0, 'L', 1);
      $this->Ln();
      $this->SetFont('times', 'B', 12);
      $this->SetFont('');
      $this->MultiCell(160, 9, utf8_decode("" . $WR_DiagnosisPDF), 'LTRB', 'J', 0);

      $this->SetFont('times', 'B', 12);
      $this->Cell(160, 6, "D.Solucion al problema ", 'LTRB', 0, 'L', 1);
      $this->Ln();
      $this->SetFont('times', 'B', 12);
      $this->SetFont('');
      $this->MultiCell(160, 9, utf8_decode("" . $WR_SolutionPDF), 'LTRB', 'J', 0);

      $this->SetFont('times', 'B', 12);
      $this->Cell(160, 9, "E.Conclusiones de conformidad ", 'LTRB', 0, 'L', 1);
      $this->SetFont('');
      $this->Ln();

      $this->SetFont('times', '', 12);
      if ($STS_DescriptionPDF == "Solucionado") {
        $this->MultiCell(160, 9, utf8_decode("Problema resuelto de manera satisfactorio, se cumplieron los términos de la garantía."), 'LTRB', 'J', 0);
      } else if ($STS_DescriptionPDF == "Espera") {
        $this->MultiCell(160, 9, utf8_decode("El problema está en proceso por lo tanto el folio está abierto todavía no se le ha dado solución por favor esperar a que los técnicos se acerquen para poder cerrar el caso."), 'LTRB', 'J', 0);
      } else if ($STS_DescriptionPDF == "Sin Respuesta") {
        $this->MultiCell(160, 9, utf8_decode("El problema no tuvo respuesta volver a hacer el reporte para dar seguimiento."), 'LTRB', 'J', 0);
      } else if ($STS_DescriptionPDF == "Cancelado") {
        $this->MultiCell(160, 9, utf8_decode("El problema no se resolvió porque hubo problemas con la gestión por lo cual no se le pudo dar seguimiento."), 'LTRB', 'J', 0);
      } else if ($STS_DescriptionPDF == "Deshabilitado") {
        $this->MultiCell(160, 9, utf8_decode("El Registro actualmente se encuentra Deshabilidato del Sistema, por lo tanto no es como que cuente con alguna cobertura conforme de la garantia."), 'LTRB', 'J', 0);
      }

      $fill = false;

      $this->Ln(10);
      $this->SetFont('times', '', 12);
      $this->MultiCell(160, 5, utf8_decode("La fiabilidad y precisión de la información contenida en esta tabla son un pilar fundamental para garantizar la transparencia y la validez del proceso de reclamación de garantía. Los detalles presentes en esta sección son la base sobre la cual se fundamenta la resolución satisfactoria del problema o caso en colaboración con la empresa responsable de la reclamación de la garantía."), '', 'J', 0);
      $this->Ln(4);
      $this->MultiCell(180, 5, utf8_decode("Al momento de firmar este documento, se confirma y valida la exactitud de los datos proporcionados en la tabla adjunta, reconociendo así su importancia crítica en la conclusión exitosa del asunto. La firma denota la aceptación de que la información previa presentada es precisa y esencial para sustentar la conclusión satisfactoria del caso en cuestión, validando la estrecha colaboración y el esfuerzo conjunto para resolver eficazmente la reclamación de la garantía."), '', 'J', 0);
    }

    $this->Ln(30);
    $this->SetFont('');
    $this->SetFont('times', 'IB', 12);
    $this->MultiCell(170, 9, "" . $firma, '', 'R',0);
    $this->SetFont('times', 'I', 12);
    $this->MultiCell(170, 0, $CBT_employee_position . ", Azucarera La Grecia", '', 'R', 0);
    $this->Ln(3);
  }
}

$pdf = new ReportW();
// Establecer márgenes, configuración de página y activar el salto automático de página
$topMargin = 35; // Margen superior en unidades de medida del PDF
$bottomMargin = 42; // Margen inferior en unidades de medida del PDF
$leftMargin = 15; // Margen izquierdo en unidades de medida del PDF
$rightMargin = 15; // Margen derecho en unidades de medida del PDF
$pdf->SetMargins($leftMargin, $topMargin, $rightMargin); // Configura los márgenes izquierdo, derecho, y superior
$pdf->SetAutoPageBreak(true, $bottomMargin); // Activa el salto automático de página con un margen inferior

$header = array('Descripcion de Campos', 'Informacion');
$pdf->AliasNbPages();
// Pasar la firma a la instancia de la clase PDF
$pdf->setFirma($firma,$ticket);
// Primera página
$pdf->AddPage();
$pdf->SetY(35);
$pdf->TablarReporte(
  $header,
  $todayDate,
  $NombreCompleto,
  $PCS_Description,
  $CBT_employee_position,
  $CT_Description,
  $MFC_Description,
  $MDL_Description,
  $CMP_Serial,
  $CMP_Servitag,
  $ticket,
  $CMP_Technical_Name,
  $WR_Date_Admission,
  $WR_Main_ProblemPDF,
  $WR_ActionsDonePDF,
  $WR_DiagnosisPDF,
  $WR_SolutionPDF,
  $STS_DescriptionPDF,
  $firma
);


// Genera el PDF
$timestamp = date("Y-m-d_H-i-s");
$nombreArchivo = "ReporteGarantiade_".$ticket.$timestamp . ".pdf";
$pdfPath = "" . $nombreArchivo;
$pdf->Output($pdfPath, 'I'); // Guarda el PDF con el nombre personalizado
?>