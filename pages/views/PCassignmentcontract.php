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
    $CT_Description= $fila["CT_Description"];
    $PCS_Description= $fila["PCS_Description"];
    $Correlativo= $fila["Correlativo"];
    $MNG_Description= $fila["MNG_Description"];
    
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

    function Body($nameUserlog, $NameCollaborator, $EmployeeCode, $EmployeePosition,$Marca,$Modelo,$Serial,$Garantia,$Meses,$todayDate,$CT_Description, $PCS_Description, $Correlativo, $MNG_Description)
    {

        //Posición: a 1,5 cm del final
        //Arial italic 8
        // Agregar el título
       $this->SetFont('times', 'I', 12);
       $this->Cell(170, 5,utf8_decode( " Marcovia-Choluteca ".$todayDate),  0, 1, 'R');
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
        $this->Cell(0, 9, "     Lic.".$nameUserlog."                       Firma de ".$NameCollaborator, 0, 1, 'C');


        $this->Ln(10);
        $this->SetFont('times', 'B', 14);
        //Número de página
        $this->Cell(0, 7, utf8_decode("Formato de asignación de equipo Personal"), 0, 1, 'C');
        $this->Ln(3);
       
            
             $this->SetFillColor(215, 219, 221 );
             $this->SetTextColor(0);
             $this->SetFont('');
           $this->SetLineWidth(.2);
           $this->SetFont('times', 'B', 12);
   
   
        $this->SetFont('times', 'B', 12);
        $this->Cell(70, 7, utf8_decode("Informacion Equipo ") , 'LTR', 0, 'C', 0);
        $this->Cell(110, 7, utf8_decode("Informacion Colaborador ") , 'LTR', 0, 'C', 0);

        $this->Ln(3);
        $this->SetFont('times', 'B', 12);
        $this->Ln(4);
        $this->Cell(32, 7, utf8_decode("Tipo de Equipo "), 'LTRB', 0, 'L', 1);
        $this->SetFont('');
        $this->Cell(38, 7, utf8_decode(" ".$CT_Description), 'LTRB', 0, 'L', 0);
        $this->SetFont('times', 'B', 12);
        $this->Cell(45, 7, utf8_decode("Nombre del Empleado "), 'LTRB', 0, 'L', 1);
        $this->SetFont('');
        $this->Cell(65, 7, utf8_decode(" ".$NameCollaborator), 'LTRB', 0, 'L', 0);


        $this->Ln(3);
        $this->SetFont('times', 'B', 12);
        $this->Ln(4);
        $this->Cell(32, 7, utf8_decode("Modelo "), 'LTRB', 0, 'L', 1);
        $this->SetFont('');
        $this->Cell(38, 7, utf8_decode(" ". $Marca ."/ " .$Modelo) , 'LTRB', 0, 'L', 0);
        $this->SetFont('times', 'B', 12);
        $this->Cell(45, 7, utf8_decode("Cargo"), 'LTRB', 0, 'L', 1);
        $this->SetFont('');
        $this->Cell(65, 7, utf8_decode(" ".$EmployeePosition) , 'LTRB', 0, 'L', 0);

        $this->Ln(3);
        $this->SetFont('times', 'B', 12);
        $this->Ln(4);
        $this->Cell(32, 7, utf8_decode("Serial "), 'LTRB', 0, 'L', 1);
        $this->SetFont('');
        $this->Cell(38, 7, utf8_decode(" ". $Serial), 'LTRB', 0, 'L', 0);
        $this->SetFont('times', 'B', 12);
        $this->Cell(45, 7, utf8_decode("Departamento "), 'LTRB', 0, 'L', 1);
        $this->SetFont('');
        $this->Cell(65, 7, utf8_decode(" ".$PCS_Description), 'LTRB', 0, 'L', 0);

        $this->Ln(3);
        $this->SetFont('times', 'B', 12);
        $this->Ln(4);
        $this->Cell(32, 7,  utf8_decode("Etiqueta N° "), 'LTRB', 0, 'L', 1);
        $this->SetFont('');
        $this->Cell(38, 7,  utf8_decode(" ". $Correlativo), 'LTRB', 0, 'L', 0);
        $this->SetFont('times', 'B', 12);
        $this->Cell(45, 7,  utf8_decode("Gerencia: "), 'LTRB', 0, 'L', 1);
        $this->SetFont('');
        $this->Cell(65, 7, " ".$MNG_Description, 'LTRB', 0, 'L', 0);
        $this->Ln(3);

       
        $this->Ln(8);
        
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 8, utf8_decode("Yo,".$NameCollaborator." como miembro perteneciente al personal de Azucacera La Grecia S.A de C.V- ALG, de ahora en adelante llamado como 'Empleado', con un contrato de duracion de ".$Meses." meses que dan inicio a apartir de la fecha de <<fecha>> , declaro por la presente que recibo el equipo mencionado anteriormente bajo las siguientes condiciones:"), 0, 'J', $fill);
        $this->MultiCell(0, 8, utf8_decode("1. Entiendo que el equipo es propiedad de ALG y me fue asignado."), 0, 'J', $fill);
        $this->MultiCell(0, 8, utf8_decode("2. El uso del equipo por parte de miembros de familia no está autorizado."), 0, 'J', $fill);
        $this->MultiCell(0, 8, utf8_decode("3. Usaré el equipo apropiadamente para fines relacionados con la oficina."), 0, 'J', $fill);
        $this->MultiCell(0, 8, utf8_decode("4. Cuidaré el equipo que me fue asignado y no lo dejaré sin supervisión en lugares inseguros."), 0, 'J', $fill);
        $this->MultiCell(0, 8, utf8_decode("5. Seré responsable por todo el daño o pérdida del equipo, causado por negligencia o abuso."), 0, 'J', $fill);
        $this->MultiCell(0, 8, utf8_decode("6. No prestaré el equipo a ningún otro individuo dentro o fuera de la empresa."), 0, 'J', $fill);
        $this->MultiCell(0, 8, utf8_decode("7. Reportaré la pérdida, o la necesidad de reparación del equipo cuando sea necesario."), 0, 'J', $fill);
        $this->MultiCell(0, 8, utf8_decode("8. No desarmaré el equipo ni cambiaré alguna de sus partes."), 0, 'J', $fill);
        $this->MultiCell(0, 8, utf8_decode("9. No retiraré o alteraré la etiqueta que contiene el número serial del equipo."), 0, 'J', $fill);
        $this->MultiCell(0, 8, utf8_decode("10. Entiendo que tanto el equipo como su contenido pueden ser inspeccionados en cualquier momento."), 0, 'J', $fill);
        $this->MultiCell(0, 8, utf8_decode("11. Me comprometo a devolver el equipo, su maletín (si es el caso), cable de energía, y todos los otros elementos que este contenga y que me fueron asignados en óptimas condiciones antes de mi último día de trabajo en ALG."), 0, 'J', $fill);
        $this->MultiCell(0, 8, utf8_decode("12. Pagaré a ALG cualquier multa que se me imponga causada por daño, desuso, negligencia o pérdida, incluyendo robo deducido por la póliza de seguro. En el caso de que no exista dicha póliza, el custodio será responsable por el costo total del equipo."), 0, 'J', $fill);
        $this->MultiCell(0, 8, utf8_decode("13. El custodio del equipo podrá obtener el paz y salvo de Servicios Generales antes de la finalización de su contrato, realizando la entrega formal al Asistente Administrativo del Proyecto quien quedará como responsable y custodio del bien firmado un nuevo formato de asignación de equipo."), 0, 'J', $fill);
        
        $this->Ln();
        $this->SetFont('');
        $this->Cell(0,8, '     ______________________________                          Fecha:'.$todayDate, '0',1,'L');
        $this->SetFont('times', 'I', 12);
        $this->Cell(0, 9, "Firma del empleado ".$NameCollaborator, 0, 1, 'L');

        $this->Ln(10);
        $this->Cell(0, 9, "Revisado por (Personal de Servicios Generales):  ", 0, 1, 'L');





    }
}

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
$pdf->SetY(35);
$pdf->Body($_SESSION["NameUserlog"], $NameCollaborator, $EmployeeCode, $EmployeePosition,$Marca,$Modelo,$Serial,$Garantia,$Meses,$todayDate,$CT_Description, $PCS_Description, $Correlativo, $MNG_Description);
// Genera un nombre de archivo único basado en la fecha y la hora actual
$timestamp = date("Y-m-d_H-i-s"); // Genera un timestamp en el formato deseado
$nombreArchivo = "Contradode_".$NameCollaborator . $timestamp . ".pdf"; // Nombre personalizado con marca de tiempo
$pdfPath = "" . $nombreArchivo; // Ruta completa con nombre de archivo

$pdf->Output($pdfPath, 'I'); // Guarda el PDF con el nombre personalizado
