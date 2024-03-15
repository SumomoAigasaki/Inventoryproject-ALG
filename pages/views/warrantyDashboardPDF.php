<?php
require('../../public/FPDF/fpdf.php');
include "../../includes/conecta.php";
include "../controllers/reWarrantyMySql.php";

// include('../js/pages/reportWarranty.js');
//Obtenemos la variable que pasamos tras la url con metodo get 

// Recibir y procesar los datos enviados desde JavaScript
$yearSeleccionado = $_GET['year'];

class warrantyPDF extends FPDF
{

    protected $pageNumber = 1; // Número de página actual para las secciones sin encabezado ni pie de página
    public $pageNumberWithHeader = 1; // Número de página actual para las secciones con encabezado y pie de página
    public $index = []; // Array para almacenar el índice dinámico
    public $excludeFromHeader = false; // Variable para controlar la exclusión
    public $excludeFromFooter = false; // Variable para controlar la exclusión
    public $estadoIcon = '';
    // Crea una instancia de la clase Consultas

    function Header()
    {
        // $this->SetFillColor(226, 60, 25); // Establece el color de fondo del pie de página (en este caso, naranja)
        // // Dibuja un rectángulo con el color de fondo que cubre solo el área del encabezado
        // $this->Rect(0, 0, $this->GetPageWidth(), 40, 'F');


        // Encabezado común para todas las páginas (excepto las primeras)
        if (!$this->excludeFromHeader) {
            $this->SetFont('Arial', 'B', 12);
            //Posición: a 1,5 cm del final
            $logoUrl = '../../resources/Warranty/LogoALG.png'; // Ruta a la imagen local
            $this->Image($logoUrl, 15, 16, 50); // Inserta el logo

            $this->SetFont('times', 'I', 9);

            // Salto de línea
            $this->Ln(40);
        }
    }


    function Footer()
    {

        if ($this->pageNumberWithHeader >= 2 & !$this->excludeFromFooter) { // Se inicia desde la página 2 y en donde exclude.. sea falso


            // Establecer la posición y el tamaño de la página
            $this->SetY(-40);
            $this->SetMargins(25, 0, 20);
            $this->SetFont('times', 'I', 8);
            $this->SetX(20);
            // Iconos con coordenadas relativas a los márgenes
            $telefono = '../../resources/Warranty/telefono.png';
            $this->Image($telefono, $this->GetX() + 10, $this->GetY() + 2.5, 4);
            $direccion = '../../resources/Warranty/internet(1).png';
            $this->Image($direccion, $this->GetX() + 10, $this->GetY() + 13.5, 4);
            $localizacion = '../../resources/Warranty/localizacion.png';
            $this->Image($localizacion, $this->GetX() + 10, $this->GetY() + 24.5, 4);

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


            // Posiciona el cursor en la esquina superior derecha

            $this->SetX(10);
            $this->SetY(-15);
            $this->SetFont('times', 'I', 12);
            $totalPages = $this->AliasNbPages(); // Obtener el número total de páginas
            echo $totalPages;
            // Obtener el número de página actual
            $currentPage = $this->pageNumberWithHeader - 2;
            $this->Cell(0, 10, utf8_decode('Página ' . $currentPage), 0, 0, 'R', 0);
            // $this->Cell(325, 10,  utf8_decode('Página ' . $currentPage), 0, 0, 'C');
            $this->SetY(0);
        }
    }

    function GenerateIndex()
    {
        // $this->SetY();

        $this->excludeFromHeader = true;
        $this->AddPage();
        $this->SetY(40);
        $this->SetMargins(25, 0, 20);


        $this->SetFont('Times', 'B', 16);
        $this->Cell(0, 10, utf8_decode('Índice'), 0, 1);
        $this->Ln(5); // Agregar espacio

        $this->SetFont('Times', '', 12);
        foreach ($this->index as $entry) {
            $this->Cell(0, 10, $entry['title'] . utf8_decode(' - Pág. ') . $entry['page'], 0, 1);
        }
        $this->excludeFromFooter = true;
        // $this->excludeFromHeaderFooter = false; // Restaurar para otras páginas
    }

    function AddCustomTitle($title)
    {
        // $this->AddPage();
        $this->SetFont('times', 'B', 14);
        $this->SetTitle($title); // Establecer el título de la página
        $this->pageNumber++; // Incrementar el número de página para las secciones sin encabezado ni pie de página
        $this->pageNumberWithHeader++; // Incrementar el número de página para las secciones con encabezado y pie de página


    }

    function ChapterTitle($title)
    {
        $this->SetFont('times', 'B', 14);

        $this->Cell(0, 7, utf8_decode($title), 0, 0, 'C', 0);
        $this->Ln(); // Agregar espacio después del título
        // Agregar al índice

        // Obtener el número de página actual
        $currentPage = $this->pageNumberWithHeader - 2;
        $this->index[] = ['title' => utf8_decode($title), 'page' => $currentPage];
    }

    function ChapterBody($content)
    {
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 10, utf8_decode($content));
        $this->Ln(); // Agregar espacio después del contenido
    }



    function Portada($yearSeleccionado)
    {
        function traducirMes($mes)
        {
            $meses = array(
                'January' => 'Enero',
                'February' => 'Febrero',
                'March' => 'Marzo',
                'April' => 'Abril',
                'May' => 'Mayo',
                'June' => 'Junio',
                'July' => 'Julio',
                'August' => 'Agosto',
                'September' => 'Septiembre',
                'October' => 'Octubre',
                'November' => 'Noviembre',
                'December' => 'Diciembre'
            );

            return $meses[$mes];
        }


        // Obtener la fecha actual
        $fecha_actual = strftime('%B %Y');

        // Obtener el nombre del mes en español
        $nombre_mes_espanol = traducirMes(strftime('%B'));
        $this->excludeFromHeader = true;
        // // Portada
        $this->AddPage();
        $this->AddCustomTitle('Portada');
        //  $this->ChapterBody('Contenido de la Portada');

        $logoALG = '../../resources/Warranty/LogoALG.png'; // Ruta a la imagen local
        $this->Image($logoALG, 22, 65, 160); // Inserta el logo
        $this->Ln(90); // Agregar espacio después del contenido

        $this->SetFont('times', 'B', 32);
        $this->Cell(0, 15, utf8_decode('Resumen Ejecutivo '), 0, 1, 'C');
        $this->Cell(0, 15, utf8_decode('Dispositivos con Garantía'), 0, 1, 'C');
        $this->Cell(0, 15, utf8_decode('del Año ' . $yearSeleccionado), 0, 1, 'C');
        $this->Ln(8);


        $this->SetFont('times', 'I', 22);
        $this->Cell(0, 10, utf8_decode('Actualización Anual,  '), 0, 1, 'C');
        $this->Cell(0, 10, utf8_decode('Realizada en ' . $nombre_mes_espanol . strftime(' de %Y')), 0, 1, 'C');


        // $this->Cell(0, 10, utf8_decode(''), 0, 1, 'C');
        $this->Ln(10);
        $this->SetFont('times', '', 15);
        $this->Cell(0, 8, utf8_decode('Preparado por el Equipo de Soporte IT'), 0, 1, 'C');
        $this->Cell(0, 8, utf8_decode('Azucarera La Grecia'), 0, 1, 'C');
        $this->Ln(10);
        $this->Cell(0, 10,  utf8_decode('Emitido el: ' . date('d/m/Y')), 0, 1, 'C');

        $this->excludeFromFooter = true;
        // Restaurar la exclusión para el cuerpo del documento
        $this->CuerpoPDF($yearSeleccionado);
        //  $this->excludeFromHeaderFooter = true; // Excluir encabezado y pie de página para la portada

    }

    function CuerpoPDF($yearSeleccionado)
    {
        $this->SetY(-40);
        $this->excludeFromHeader = false; //Valicadion para no añadir encabezado de pagina a la pagina presente 
        // Introducción
        $this->SetMargins(20, 0, 22);
        $this->AddPage();
        $this->AddCustomTitle('Introducción');
        $this->ChapterTitle('Introducción');
        $this->Ln();
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 9.5, utf8_decode("El presente informe aborda de manera concisa la exposición de datos exportados del sistema INFRAG, centrándose específicamente en la reportaría relacionada con las garantías de los activos de la empresa en el departamento de Soporte IT de Azucarera la Grecia, con énfasis en los dispositivos de cómputo. Este análisis engloba diversas categorías de dispositivos, tales como los recién ingresados, aquellos con cobertura no asignada, registros sin cobertura asignada, y registros próximos a vencer con estados de activo o en circulación."), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode("A lo largo del informe, se llevará a cabo una evaluación detallada mediante la presentación de gráficos que incluirán imágenes y datos relevantes. Entre los tipos de gráficos a mostrar se encuentran: Gráficos de Barras que resumen mensualmente la cantidad de dispositivos con garantía activa y próxima a vencer; Gráficos de Dispersión que representan la cantidad de computadoras ubicadas por gerencia; y Gráficos de Pastel que ilustran la distribución de registros por tipo de garantía."), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode("El propósito principal de este análisis es proporcionar información crucial para la toma de decisiones dentro del departamento, de manera precisa y oportuna. Esta evaluación busca identificar las acciones necesarias basadas en la realidad de los datos recopilados. Cabe destacar que este proceso se realiza anualmente, lo que garantiza un análisis más preciso al considerar las actividades mensuales a lo largo del año en cuestión. Este enfoque temporal permite una comprensión profunda de las tendencias y patrones que pueden influir en las decisiones estratégicas a lo largo del tiempo."), 0, 'J', 0);
        $this->excludeFromFooter = false; //Valicadion para no añadir pie de pagina a la pagina presente 



        // Sección de Cards
        $this->AddPage();
        $this->AddCustomTitle('Sección de Cards');
        $this->SetMargins(20, 0, 22);
        $this->MultiCell(0, 1, utf8_decode(''), 0, 'J', 0);;
        $this->ChapterTitle('Sección de Cards');
        $this->Ln();
        $this->SetFont('times', '', 12);
        // --Informacion relevante de explicacion de los  Cards para que son y demas 
        $this->MultiCell(0, 9.5, utf8_decode("En esta sección, se presenta información detallada acerca de diversos recuentos y conteos de registros como ser de:"), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode('1.- Registros Nuevos: Aquí se muestran los registros ingresados en los últimos tres meses con garantías vigentes, excluyendo aquellos de tipo "No Aplica" y "Apple sin cobertura."'), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode('2.- Registros con Cobertura Sin Asignar (Full): Este apartado proporciona el recuento de registros activos sin asignar en el sistema y con garantías vigentes, excluyendo las de tipo "No Aplica" y "Apple-Sin Garantía.'), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode('3.- Registros sin Cobertura (en uso): Ofrece información sobre dispositivos actualmente en uso sin cobertura vigente y con estado activo.'), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode('4.- Registros próximos a vencer (Activos o en Circulación): Se solicita y muestra los registros próximos a vencer, con estados activos o en circulación, excluyendo garantías de tipo "No Aplica" y "Apple-Sin Garantía.'), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode("Estos conteos se enfocan en registros que no estén deshabilitados, proporcionando una visión clara de la situación actual de los diferentes tipos de registros dentro del sistema"), 0, 'J', 0);
        $this->AddPage('L'); // 'L' indica orientación horizontal



        // Cards- Registros Nuevos
        $this->AddCustomTitle('Cards- Registros Nuevos');
        $this->SetFont('times', 'B', 12);
        $this->ChapterTitle('Cards- Registros Nuevos');
        $this->SetFont('times', '', 12);
        $this->SetFillColor(215, 219, 221);
        // Calcula la posición de inicio para centrar la tabla
        $paginaAncho = $this->GetPageWidth();
        $tablaAncho = 15 + 45 + 45 + 50 + 20 + 45 + 50; // Suma de los anchos de las celdas
        $posicionInicio = ($paginaAncho - $tablaAncho) / 2;
        $this->SetX($posicionInicio); // Establece la posición de inicio
        // --Tabla de Registros Nuevos
        $this->Cell(15, 7, utf8_decode("ID"), 'LTRB', 0, 'C', 1);
        $this->Cell(45, 7, utf8_decode("Fecha de Ingreso"), 'LTRB', 0, 'C', 1);
        $this->Cell(45, 7, utf8_decode("Fecha Venc. Garantía"), 'LTRB', 0, 'C', 1);
        $this->Cell(50, 7, utf8_decode("Nombre Dispositivo"), 'LTRB', 0, 'C', 1);
        $this->Cell(20, 7, utf8_decode("Marca"), 'LTRB', 0, 'C', 1);
        $this->Cell(45, 7, utf8_decode("Modelo"), 'LTRB', 0, 'C', 1);
        $this->Cell(50, 7, utf8_decode("Tipo Garantía"), 'LTRB', 0, 'C', 1);
        $this->Ln();
        // --Extraccion de datos para la tabla de Registros Nuevos
        $exportMySql = new MySQL();

        $dataRecNew = $exportMySql->RecNew(); // Obtiene datos desde la base de datos
        $arrayDatos = json_decode($dataRecNew, true); // Verifica si $dataRecNew es un array antes de intentar acceder a sus elementos

        // Verifica si $arrayDatos es un array antes de intentar acceder a sus elementos
        if (is_array($arrayDatos) && isset($arrayDatos['data']) && !empty($arrayDatos['data'])) {
            // Accede a los elementos del array
            // Intera con cada unos elementos del array
            foreach ($arrayDatos['data'] as $dato) {
                $this->SetX($posicionInicio);
                $this->Cell(15, 7, utf8_decode("" . $dato['idComputer']), 'LTRB', 0, 'C', 0);
                $this->Cell(45, 7, utf8_decode("" . $dato['fechaAdquisicion']), 'LTRB', 0, 'C', 0);
                $this->Cell(45, 7, utf8_decode("" . $dato['fechaExpiracion']), 'LTRB', 0, 'C', 0);
                $this->Cell(50, 7, utf8_decode("" . $dato['nombreTecnico']), 'LTRB', 0, 'C', 0);
                $this->Cell(20, 7, utf8_decode("" . $dato['manofacturacion']), 'LTRB', 0, 'C', 0);
                $this->Cell(45, 7, utf8_decode("" . $dato['modelo']), 'LTRB', 0, 'C', 0);
                $this->Cell(50, 7, utf8_decode("" . $dato['tipoGarantía']), 'LTRB', 0, 'C',);
                $this->Ln();
            }
        } else {
            //Si no hay datos en la consulta colocar este msj
            $this->SetX($posicionInicio);
            $this->Cell(220, 6, utf8_decode("No hay datos para asignar."), 'LTRB', 0, 'C', 0);
            $this->Ln();
        }
        $this->SetFont('times', 'B', 12);
        $this->Cell(258, 7, utf8_decode("Última Línea."), 'T', 0, 'C',); //Mensaje que sale al final de la tabla
        $this->SetFont('times', '', 12);
        $this->Ln();
        $this->MultiCell(0, 10, utf8_decode("Nota:Nota: por cuestiones de espacio solo se presentan 10 registros por pagina, para mas información revisar el dashboard correspondiente."), 0, 'J', 0);
        $this->AddPage('L'); // 'L' indica orientación horizontal



        // Cards- Registros con Cobertura Sin Asignar (Full)
        $this->AddCustomTitle('Cards- Registros con Cobertura Sin Asignar (Full)');
        $this->ChapterTitle('Cards- Registros con Cobertura Sin Asignar (Full)');
        $this->SetFont('times', '', 12);
        $this->SetFillColor(215, 219, 221);
        // --Calcula la posición de inicio para centrar la tabla
        $paginaAncho = $this->GetPageWidth();
        $tablaAncho = 15 + 45  + 50 + 30 + 45 + 60; // Suma de los anchos de las celdas
        $posicionInicio = ($paginaAncho - $tablaAncho) / 2;
        $this->SetX($posicionInicio); // Establece la posición de inicio
        // --Tabla de Registros con Cobertura Sin Asignar (Full)
        $this->Cell(15, 7, utf8_decode("ID"), 'LTRB', 0, 'C', 1);
        $this->Cell(45, 7, utf8_decode("Fecha Venc. Garantía"), 'LTRB', 0, 'C', 1);
        $this->Cell(50, 7, utf8_decode("Nombre Dispositivo"), 'LTRB', 0, 'C', 1);
        $this->Cell(30, 7, utf8_decode("Marca"), 'LTRB', 0, 'C', 1);
        $this->Cell(45, 7, utf8_decode("Modelo"), 'LTRB', 0, 'C', 1);
        $this->Cell(76, 7, utf8_decode("Tipo Garantía"), 'LTRB', 0, 'C', 1);
        $this->Ln();
        // --Extraccion de datos para la tabla de Registros con Cobertura Sin Asignar (Full)
        $exportMySql = new MySQL();
        $dataRecCovUnAssig = $exportMySql->recCovUnAssig();  // Obtiene datos desde la base de datos
        $arrayDatos = json_decode($dataRecCovUnAssig, true); // Verifica si $dataRecNew es un array antes de intentar acceder a sus elementos

        // Verifica si $arrayDatos es un array antes de intentar acceder a sus elementos
        if (is_array($arrayDatos) && isset($arrayDatos['data']) && !empty($arrayDatos['data'])) {
            // Accede a los elementos del array
            // Intera con cada unos elementos del array
            foreach ($arrayDatos['data'] as $dato) {
                $this->SetX($posicionInicio);
                $this->Cell(15, 7, utf8_decode("" . $dato['idComputer']), 'LTRB', 0, 'C', 0);
                $this->Cell(45, 7, utf8_decode("" . $dato['fechaExpiracion']), 'LTRB', 0, 'C', 0);
                $this->Cell(50, 7, utf8_decode("" . $dato['nombreTecnico']), 'LTRB', 0, 'C', 0);
                $this->Cell(30, 7, utf8_decode("" . $dato['manofacturacion']), 'LTRB', 0, 'C', 0);
                $this->Cell(45, 7, utf8_decode("" . $dato['modelo']), 'LTRB', 0, 'C', 0);
                $this->Cell(76, 7, utf8_decode("" . $dato['tipoGarantía']), 'LTRB', 0, 'C', 0);
                $this->Ln();
            }
        } else {
            //Si no hay datos en la consulta colocar este msj
            $this->SetX($posicionInicio);
            $this->Cell(220, 6, utf8_decode("No hay datos para asignar."), 'LTRB', 0, 'C', 0);
            $this->Ln();
        }
        $this->SetFont('times', 'B', 12);
        $this->Cell(258, 7, utf8_decode("Última Línea."), 'T', 0, 'C',); //Mensaje que sale al final de la tabla
        $this->SetFont('times', '', 12);
        $this->Ln();
        $this->MultiCell(0, 10, utf8_decode("Nota:Nota: por cuestiones de espacio solo se presentan 10 registros por pagina, para mas información revisar el dashboard correspondiente."), 0, 'J', 0);


        // Cards- Registros sin Cobertura (en uso)
        $this->AddPage('L'); // 'L' indica orientación horizontal
        $this->AddCustomTitle('Cards- Registros sin Cobertura (en uso)');
        $this->ChapterTitle('Cards- Registros sin Cobertura (en uso)');
        $this->SetFont('times', '', 12);
        $this->SetFillColor(215, 219, 221);
        // Calcula la posición de inicio para centrar la tabla
        $paginaAncho = $this->GetPageWidth();
        $tablaAncho = 15 + 45 + 45 + 50 + 50 + 45; // Suma de los anchos de las celdas
        $posicionInicio = ($paginaAncho - $tablaAncho) / 2;
        $this->SetX($posicionInicio);   // Establece la posición de inicio
        // --Tabla de Registros sin Cobertura (en uso)
        $this->Cell(15, 7, utf8_decode("ID"), 'LTRB', 0, 'C', 1);
        $this->Cell(45, 7, utf8_decode("Fecha Asignacion"), 'LTRB', 0, 'C', 1);
        $this->Cell(45, 7, utf8_decode("Fecha Retorno"), 'LTRB', 0, 'C', 1);
        $this->Cell(50, 7, utf8_decode("Nombre Colaborador"), 'LTRB', 0, 'C', 1);
        $this->Cell(50, 7, utf8_decode("Nombre Dispositivo"), 'LTRB', 0, 'C', 1);
        $this->Cell(45, 7, utf8_decode("Fecha Venc. Garantía"), 'LTRB', 0, 'C', 1);
        $this->Ln();
        // --Extraccion de datos para la tabla de Registros sin Cobertura (en uso)
        $exportMySql = new MySQL();
        $dataRecCovUnAssig = $exportMySql->RecNonCov();  // Obtiene datos desde la base de datos
        $arrayDatos = json_decode($dataRecCovUnAssig, true);  // Verifica si $dataRecNew es un array antes de intentar acceder a sus elementos

        // Verifica si $arrayDatos es un array antes de intentar acceder a sus elementos
        if (is_array($arrayDatos) && isset($arrayDatos['data']) && !empty($arrayDatos['data'])) {
            // Accede a los elementos del array
            // Intera con cada unos elementos del array
            foreach ($arrayDatos['data'] as $dato) {
                $this->SetX($posicionInicio);
                $this->Cell(15, 7, utf8_decode("" . $dato['idAsignacionPc']), 'LTRB', 0, 'C', 0);
                $this->Cell(45, 7, utf8_decode("" . $dato['fechaAsignacion']), 'LTRB', 0, 'C', 0);
                $this->Cell(45, 7, utf8_decode("" . $dato['fechaDevolucion']), 'LTRB', 0, 'C', 0);
                $this->Cell(50, 7, utf8_decode("" . $dato['nombreColaborador']), 'LTRB', 0, 'C', 0);
                $this->Cell(50, 7, utf8_decode("" . $dato['nombreTecnico']), 'LTRB', 0, 'C', 0);
                $this->Cell(45, 7, utf8_decode("" . $dato['fechaExpiracion']), 'LTRB', 0, 'C', 0);
                $this->Ln();
            }
        } else {
            //Si no hay datos en la consulta colocar este msj
            $this->SetX($posicionInicio);
            $this->Cell(220, 6, utf8_decode("No hay datos para asignar."), 'LTRB', 0, 'C', 0);
            $this->Ln();
        }
        $this->SetX($posicionInicio);
        $this->SetFont('times', 'B', 12);
        $this->Cell(250, 7, utf8_decode("Última Línea."), 'T', 0, 'C',); //Mensaje que sale al final de la tabla
        $this->SetFont('times', '', 12);
        $this->Ln();
        $this->MultiCell(0, 10, utf8_decode("Nota:Nota: por cuestiones de espacio solo se presentan 10 registros por pagina, para mas información revisar el dashboard correspondiente."), 0, 'J', 0);



        //Cards- Registros próximos a vencer (Activos o en Circulación)
        $this->AddPage('L'); // 'L' indica orientación horizontal
        $this->AddCustomTitle('Cards- Registros próximos a vencer (Activos o en Circulación)');
        $this->ChapterTitle('Cards- Registros próximos a vencer (Activos o en Circulación)');
        $this->SetFont('times', 'B', 12);
        $this->SetFont('times', '', 12);
        $this->SetFillColor(215, 219, 221);
        // Calcula la posición de inicio para centrar la tabla
        $paginaAncho = $this->GetPageWidth();
        $tablaAncho = 15 + 45 + 15 + 50 + 20 + 45 + 80; // Suma de los anchos de las celdas
        $posicionInicio = ($paginaAncho - $tablaAncho) / 2;
        // Establece la posición de inicio
        $this->SetX($posicionInicio);
        // --Tabla de Registros próximos a vencer (Activos o en Circulación)
        $this->Cell(15, 7, utf8_decode("ID"), 'LTRB', 0, 'C', 1);
        $this->Cell(45, 7, utf8_decode("Fecha Venc. Garantía"), 'LTRB', 0, 'C', 1);
        $this->Cell(15, 7, utf8_decode("Esta."), 'LTRB', 0, 'C', 1);
        $this->Cell(50, 7, utf8_decode("Nombre Dispositivo"), 'LTRB', 0, 'C', 1);
        $this->Cell(20, 7, utf8_decode("Marca"), 'LTRB', 0, 'C', 1);
        $this->Cell(45, 7, utf8_decode("Modelo"), 'LTRB', 0, 'C', 1);
        $this->Cell(80, 7, utf8_decode("Tipo Garantía"), 'LTRB', 0, 'C', 1);
        $this->Ln();
        // --Extraccion de datos para la tabla de Registros próximos a vencer (Activos o en Circulación)
        $exportMySql = new MySQL();
        $dataRecCovUnAssig = $exportMySql->RecSoonExp(); // Obtiene datos desde la base de datos
        $arrayDatos = json_decode($dataRecCovUnAssig, true);   // Verifica si $dataRecNew es un array antes de intentar acceder a sus elementos

        // Verifica si $arrayDatos es un array antes de intentar acceder a sus elementos
        if (is_array($arrayDatos) && isset($arrayDatos['data']) && !empty($arrayDatos['data'])) {
            // Accede a los elementos del array
            // *Interar cada uno de los datos extraidos
            foreach ($arrayDatos['data'] as $dato) {
                $this->estadoIcon = ''; // Inicializa variable:guardara la imagen que se colocara en el campo establecido 

                // si el estado es 2 quiere decir que es un estado que esta activo sin asignar
                // si el estado es 9 quiere decir que es un estado que esta circulando por lo tanto ya se asigno
                if ($dato['estado'] == 2) {
                    $checkPNG = "../../resources/Dashboard/exclamation-triangle-solid.png";
                    $this->estadoIcon = $this->Image($checkPNG, 78, $this->GetY() + 1, 5);
                } else if ($dato['estado'] == 9) {
                    $circulandoPNG = '../../resources/Dashboard/check-circle-solid.png';
                    $this->estadoIcon = $this->Image($circulandoPNG, 78, $this->GetY() + 1, 5);
                }
                // --Asignacion de datos en las filas
                $this->SetX($posicionInicio);
                $this->Cell(15, 7, utf8_decode("" . $dato['idComputer']), 'LTRB', 0, 'C', 0);
                $this->Cell(45, 7, utf8_decode("" . $dato['fechaExpiracion']), 'LTRB', 0, 'C', 0);
                $this->Cell(15, 7, utf8_decode(""), 'LTRB', 0, 'C', 0); // Celda para el icono
                $this->Cell(50, 7, utf8_decode("" . $dato['nombreTecnico']), 'LTRB', 0, 'C', 0);
                $this->Cell(20, 7, utf8_decode("" . $dato['manofacturacion']), 'LTRB', 0, 'C', 0);
                $this->Cell(45, 7, utf8_decode("" . $dato['modelo']), 'LTRB', 0, 'C', 0);
                $this->Cell(80, 7, utf8_decode("" . $dato['tipoGarantía']), 'LTRB', 0, 'C', 0);
                $this->Ln();
            }
        } else {
            //Si no hay datos en la consulta colocar este msj
            $this->SetX($posicionInicio);
            $this->Cell(220, 6, utf8_decode("No hay datos para asignar."), 'LTRB', 0, 'C', 0);
            $this->Ln();
        }
        $this->SetX($posicionInicio);
        $this->SetFont('times', 'B', 12);
        $this->Cell(270, 7, utf8_decode("Última Línea."), 'T', 0, 'C',); //Mensaje que sale al final de la tabla
        $this->SetFont('times', '', 12);
        $this->Ln();
        $this->MultiCell(0, 9.5, utf8_decode("Nota #1: por cuestiones de espacio solo se presentan 10 registros por pagina, para mas información revisar el dashboard correspondiente."), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode("Nota #2: Nomenclatura de Iconos para estado.Triangulo con signo de Exclamación representa activo (Dispositivo sin Asignar),Circulo con un Check representa circulación (Dispositivo Asignado)."), 0, 'J', 0);



        // Análisis Gráfico
        $this->AddPage();
        $this->AddCustomTitle('Análisis Gráfico');
        $this->SetMargins(20, 0, 22);
        $this->MultiCell(0, 1, utf8_decode(''), 0, 'J', 0);;
        $this->ChapterTitle('Análisis Gráfico');
        // --Informacion relevante de explicacion de los Graficos para que son y demas 
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 9.5, utf8_decode("En esta sección, llevaremos a cabo un análisis exhaustivo de los gráficos presentados en la página web. Para ello, proporcionaremos una representación visual de cada gráfico acompañada de una tabla detallada para facilitar la interpretación de los datos. En este análisis, no se aplicará ningún filtro a la cantidad de registros a analizar, garantizando así una visión completa de la información."), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode('Los tres tipos de gráficos que exploraremos son los siguientes:'), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode('1.- Gráficos de Barra: Este tipo de gráfico se utilizará para realizar comparativas entre datos que cuentan con garantías vigentes durante todo el año. Se examinará cuántos registros vencen en cada mes, y la tabla correspondiente presentará los registros ordenados por su fecha de vencimiento a lo largo del año.'), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode('2.- Gráfico de Dispersión: En este caso, se realizará un recuento de la asignación de dispositivos de cómputo en cada área a lo largo del año. La tabla asociada proporcionará información detallada sobre esta distribución, ofreciendo una visión más completa del gráfico de dispersión.'), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode('3.- Gráfico Pastel: Aquí se llevará a cabo un recuento de los dispositivos que vencen en el año, filtrados por el tipo de garantía que poseen. Se agruparán y contarán según esta clasificación, y la tabla resultante mostrará los dispositivos del análisis ordenados por tipo de garantía para una fácil referencia.'), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode('Este enfoque integral en la presentación de datos permitirá una comprensión más profunda de la información contenida en los gráficos, facilitando la toma de decisiones informadas basadas en los resultados del análisis.'), 0, 'J', 0);



        // Grafico de Barra
        $this->AddPage('L');
        $this->AddCustomTitle('Análisis Gráfico- Gráficos de Barra');
        $this->Ln(2);
        // Imagen del Gráfico de Barra
        $this->ChapterTitle('Análisis Gráfico- Gráficos de Barra');
        $graficBarras = '../../resources/Dashboard/Garantias/graficoBarra.png';
        $anchoPagina = $this->GetPageWidth(); // extraer el valor del ancho de la pagina actual
        $anchoImagen = 170; // Ajusta según el ancho de tu imagen
        $posicionInicioX = ($anchoPagina - $anchoImagen) / 2;
        $this->Image($graficBarras, $posicionInicioX, 50, $anchoImagen);
        $this->Ln(2);
        // Análisis Gráfico- Gráfico de Barra
        $this->SetY(110); // Mueve el cursor debajo de la imagen
        // Ajusta la posición para la tabla debajo de la imagen
        $posicionInicioY = $this->GetY() ; // Puedes ajustar el valor según sea necesario
        $this->SetY($posicionInicioY);

        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 10, utf8_decode('Datos de Analisis para Grafico de Barras:'), 0, 'J', 0);

        // Calcula la posición de inicio para centrar la tabla
        $paginaAncho = $this->GetPageWidth();
        $tablaAncho = 10 + 40 + 40 + 50 + 80; // Suma de los anchos de las celdas
        $posicionInicio = ($paginaAncho - $tablaAncho) / 2;
        $this->SetX($posicionInicio);
        // --Tabla para Gráfico de Barra
        $this->Cell(10, 7, utf8_decode("ID"), 'LTRB', 0, 'C', 1);
        $this->Cell(40, 7, utf8_decode("Fecha Vencimiento"), 'LTRB', 0, 'C', 1);
        $this->Cell(40, 7, utf8_decode("Nombre Dispositivo"), 'LTRB', 0, 'C', 1);
        $this->Cell(50, 7, utf8_decode("Marca & Modelo"), 'LTRB', 0, 'C', 1);
        $this->Cell(80, 7, utf8_decode("Tipo Garantía"), 'LTRB', 0, 'C', 1);
        $this->Ln();
        // --Extraccion de datos para la tabla de Gráfico de Barra
        $exportMySql = new MySQL();
        $dataRecCovUnAssig = $exportMySql->modalBarGraphInformation($yearSeleccionado); // Obtiene datos desde la base de datos
        $arrayDatos = json_decode($dataRecCovUnAssig, true); // Verifica si $dataRecNew es un array antes de intentar acceder a sus elementos
        // --Calcular espacio para salto de linea
        $inicioTabla = $this->GetY();   // Guardar la posición inicial del cursor antes del bucle
        $longitudPaginaHorizontal = 167;
        $alturaFila = 6; // Altura estimada de la fila (ajusta según sea necesario

        // *Interar cada uno de los datos extraidos
        if (is_array($arrayDatos) && isset($arrayDatos['data']) && !empty($arrayDatos['data'])) {
            // Accede a los elementos del array
            foreach ($arrayDatos['data'] as $dato) {
                $inicioTabla += $alturaFila; // Usar la variable $alturaFila en lugar de un valor fijo
                if ($inicioTabla >= $longitudPaginaHorizontal) { // Verificar si es necesario añadir una nueva página
                    $this->AddPage('L');
                    $inicioTabla = 0;
                    $longitudPaginaHorizontal = 125;
                    $this->pageNumberWithHeader++;
                }
                $this->SetX($posicionInicio);
                $this->Cell(10, 6, utf8_decode("" . $dato['idComputer']), 'LTRB', 0, 'C', 0);
                $this->Cell(40, 6, utf8_decode("" . $dato['fechaExpiracion']), 'LTRB', 0, 'C', 0);
                $this->Cell(40, 6, utf8_decode("" . $dato['nombreTecnico']), 'LTRB', 0, 'C', 0); // Celda para el icono
                $this->Cell(50, 6, utf8_decode("" . $dato['manofacturacion'] . " - " . $dato['modelo']), 'LTRB', 0, 'C', 0);
                $this->Cell(80, 6, utf8_decode("" . $dato['tipoGarantía']), 'LTRB', 0, 'C', 0);
                $this->Ln();
            }
        } else {
            //Si no hay datos en la consulta colocar este msj
            $this->SetX($posicionInicio);
            $this->Cell(220, 6, utf8_decode("No hay datos para asignar."), 'LTRB', 0, 'C', 0);
            $this->Ln();
        }
        $this->SetX($posicionInicio);
        $this->SetFont('times', 'B', 12);
        $this->Cell(220, 7, utf8_decode("Última Línea."), 'T', 0, 'C',); //Mensaje que sale al final de la tabla



        // Gráfico de Dispersión
        $this->AddPage();
        $this->AddCustomTitle('Análisis Gráfico- Gráfico de Dispersión');
        $this->Ln(2);
        // --Imagen del Gráfico de Dispersión
        $this->ChapterTitle('Análisis Gráfico- Gráfico de Dispersión');
        $graficDispersion = '../../resources/Dashboard/Garantias/graficoDispersion.png';
        $anchoPagina = $this->GetPageWidth(); // Centra la imagen horizontalmente
        $anchoImagen = 130; // Ajusta según el ancho de tu imagen
        $posicionInicioX = ($anchoPagina - $anchoImagen) / 2;
        $this->Image($graficDispersion,  $posicionInicioX, 50, $anchoImagen);
        $this->SetFont('times', '', 12);  // Configuracion de la fuente
        $this->SetY(110); // Mueve el cursor debajo de la imagen
        // Ajusta la posición para la tabla debajo de la imagen
        $posicionInicioY = $this->GetY() + 18; // Puedes ajustar el valor según sea necesario
        $this->SetY($posicionInicioY);
        $this->MultiCell(0, 10, utf8_decode('Datos de Analisis de Gráfico de Dispersión:'), 0, 'J', 0);
        //Tabla de los datos del Gráfico de Dispersión
        // --Calcula la posición de inicio para centrar la tabla
        $paginaAncho = $this->GetPageWidth();
        $tablaAncho = 10 + 35 + 30 + 30 + 80; // Suma de los anchos de las celdas
        $posicionInicio = ($paginaAncho - $tablaAncho) / 2;
        $this->SetX($posicionInicio);
        $this->Cell(10, 6, utf8_decode("ID"), 'LTRB', 0, 'C', 1);
        $this->Cell(35, 6, utf8_decode("Fecha Asignacion"), 'LTRB', 0, 'C', 1);
        $this->Cell(30, 6, utf8_decode("Gerencia"), 'LTRB', 0, 'C', 1);
        $this->Cell(30, 6, utf8_decode("Proceso"), 'LTRB', 0, 'C', 1);
        $this->Cell(40, 6, utf8_decode("Nombre Colaborador"), 'LTRB', 0, 'C', 1);
        $this->Cell(40, 6, utf8_decode("Nombre Dispositivo"), 'LTRB', 0, 'C', 1);
        $this->Ln();
        //* Extraccion de datos en la BD para el Gráfico de Dispersión
        $exportMySql = new MySQL();
        $dataRecCovUnAssig = $exportMySql->modalScatterPlotInformation($yearSeleccionado); // Obtiene datos desde la base de datos
        $arrayDatos = json_decode($dataRecCovUnAssig, true); // Verifica si $dataRecNew es un array antes de intentar acceder a sus elementos
        //--Calcular espacio para salto de linea
        $inicioTabla = $this->GetY();   // Guardar la posición inicial del cursor antes del bucle
        $longitudPaginaHorizontal = 237;
        $alturaFila = 7; // Altura estimada de la fila (ajusta según sea necesario
        // *Interar cada uno de los datos extraidos
        if (is_array($arrayDatos) && isset($arrayDatos['data']) && !empty($arrayDatos['data'])) {
            foreach ($arrayDatos['data'] as $dato) {
                $inicioTabla += $alturaFila; // Usar la variable $alturaFila en lugar de un valor fijo

                if ($inicioTabla >= $longitudPaginaHorizontal) { // Verificar si es necesario añadir una nueva página
                    $this->AddPage('L');
                    $inicioTabla = 0;
                    $longitudPaginaHorizontal = 174;
                    $this->pageNumberWithHeader++;
                }
                $this->SetX($posicionInicio);
                $this->Cell(10, 7, utf8_decode("" . $dato['idPCAsigment']), 'LTRB', 0, 'C', 0);
                $this->Cell(35, 7, utf8_decode("" . $dato['fechaAsignacion']), 'LTRB', 0, 'C', 0);
                $this->Cell(30, 7, utf8_decode("" . $dato['Gerencia']), 'LTRB', 0, 'C', 0); // Celda para el icono
                $this->Cell(30, 7, utf8_decode("" . $dato['Area']), 'LTRB', 0, 'C', 0);
                $this->Cell(40, 7, utf8_decode("" . $dato['NombreColaborador']), 'LTRB', 0, 'C', 0);
                $this->Cell(40, 7, utf8_decode("" . $dato['nombreTecnico']), 'LTRB', 0, 'C', 0);
                $this->Ln();
            }
        } else {
            //Si no hay datos en la consulta colocar este msj
            $this->SetX($posicionInicio);
            $this->Cell(185, 6, utf8_decode("No hay datos para asignar."), 'LTRB', 0, 'C', 0);
            $this->Ln();
        }
        $this->SetX($posicionInicio);
        $this->SetFont('times', 'B', 12);
        $this->Cell(185, 7, utf8_decode("Última Línea."), 'T', 0, 'C',); //Mensaje que sale al final de la tabla



        // Gráfico Pastel
        $this->AddPage('L');
        $this->AddCustomTitle('Análisis Gráfico- Gráfico Pastel');
        $this->ChapterTitle('Análisis Gráfico- Gráfico Pastel');
        $graficPastel = '../../resources/Dashboard/Garantias/graficoPastel.png';
        // Imagen del Gráfico Pastel
        //-- Centra la imagen horizontalmente
        $anchoPagina = $this->GetPageWidth();
        $anchoImagen = 120; // Ajusta según el ancho de tu imagen
        $posicionInicioX = ($anchoPagina - $anchoImagen) / 2;
        $this->Image($graficPastel, $posicionInicioX, 50, $anchoImagen);
        $this->Ln(2);
        $this->SetFont('times', '', 12);
        //-- Mueve el cursor debajo de la imagen
        $this->SetY(110);
        // Ajusta la posición para la tabla debajo de la imagen
        $posicionInicioY = $this->GetY() + 10; // Puedes ajustar el valor según sea necesario
        $this->SetY($posicionInicioY);
        $this->MultiCell(0, 10, utf8_decode('Datos de Analisis:'), 0, 'J', 0);
        //-- Calcula la posición de inicio para centrar la tabla
        $paginaAncho = $this->GetPageWidth();
        $tablaAncho = 10  + 70 + 70 + 85 + 30; // Suma de los anchos de las celdas
        $posicionInicio = ($paginaAncho - $tablaAncho) / 2;
        $this->SetX($posicionInicio);
        // *Inicio de la tabla con posicion ya establecida 
        $this->Cell(10, 7, utf8_decode("ID"), 'LTRB', 0, 'C', 1);
        $this->Cell(70, 7, utf8_decode("Tipo garantia"), 'LTRB', 0, 'C', 1);
        $this->Cell(40, 7, utf8_decode("Nombre Dispositivo"), 'LTRB', 0, 'C', 1);
        $this->Cell(30, 7, utf8_decode("Servitag"), 'LTRB', 0, 'C', 1);
        $this->Cell(85, 7, utf8_decode("Licensia"), 'LTRB', 0, 'C', 1);
        $this->Cell(30, 7, utf8_decode("Fecha V. Garan."), 'LTRB', 0, 'C', 1);
        $this->Ln();
        // *Extraccion de datos de BD para la tabla de Gráfico Pastel
        $exportMySql = new MySQL();
        $dataRecCovUnAssig = $exportMySql->modalpieGraphInformation($yearSeleccionado); // Obtiene datos desde la base de datos
        $arrayDatos = json_decode($dataRecCovUnAssig, true); // Verifica si $dataRecNew es un array antes de intentar acceder a sus elementos
        //--Calcular espacio para salto de linea
        $inicioTabla = $this->GetY();   // Guardar la posición inicial del cursor antes del bucle
        $longitudPaginaHorizontal = 168;
        $alturaFila = 7; // Altura estimada de la fila (ajusta según sea necesario

        // *Interar cada uno de los datos extraidos
        if (is_array($arrayDatos) && isset($arrayDatos['data']) && !empty($arrayDatos['data'])) {  // Verifica si $arrayDatos es un array y si tiene elementos

            foreach ($arrayDatos['data'] as $dato) {
                $inicioTabla += $alturaFila; // Usar la variable $alturaFila en lugar de un valor fijo

                // Verificar si es necesario añadir una nueva página
                if ($inicioTabla >= $longitudPaginaHorizontal) {
                    $this->AddPage('L');
                    $inicioTabla = 0;
                    $longitudPaginaHorizontal = 125;
                    $this->pageNumberWithHeader++;
                }
                $this->SetX($posicionInicio);
                $this->Cell(10, 7, utf8_decode("" . $dato['idComputer']), 'LTRB', 0, 'C', 0);
                $this->Cell(70, 7, utf8_decode("" . $dato['tipoGarantia']), 'LTRB', 0, 'C', 0);
                $this->Cell(40, 7, utf8_decode("" . $dato['nombreTecnico']), 'LTRB', 0, 'C', 0);
                $this->Cell(30, 7, utf8_decode("" . $dato['servitag']), 'LTRB', 0, 'C', 0);
                $this->Cell(85, 7, utf8_decode("" . $dato['licensia']), 'LTRB', 0, 'C', 0);
                $this->Cell(30, 7, utf8_decode("" . $dato['fechaExpiracion']), 'LTRB', 0, 'C', 0);
                $this->Ln();
            }
        } else {
            $this->SetX($posicionInicio);
            $this->Cell(220, 6, utf8_decode("No hay datos para asignar."), 'LTRB', 0, 'C', 0);
            $this->Ln();
        }
        $this->SetFont('times', 'B', 12);
        $this->SetX($posicionInicio);
        $this->Cell($tablaAncho, 7, utf8_decode("Última Línea."), 'T', 0, 'C',); //Mensaje que sale al final de la tabla
        $this->SetFont('times', '', 12);
        $this->Ln();
        $this->MultiCell(0, 10, utf8_decode("Nota: por cuestiones de espacio solo se visualizan 6 columnas, para mas información revisar el dashboard correspondiente."), 0, 'J', 0);



        // Conclusiones y Recomendaciones
        $this->AddPage();
        $this->AddCustomTitle('Conclusiones y Recomendaciones');
        $this->ChapterTitle('Conclusiones y Recomendaciones');
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 9.5, utf8_decode("En conclusión, la exhaustiva revisión de los datos exportados del sistema INFRAG sobre las garantías de activos, específicamente los dispositivos de cómputo en el área de Soporte IT de Azucarera la Grecia, ha proporcionado una visión detallada y completa de la situación actual. Hemos explorado aspectos clave, desde los dispositivos recién ingresados hasta aquellos con cobertura no asignada, registros sin cobertura asignada y registros próximos a vencer."), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode("A través de la presentación y análisis de gráficos, incluyendo resúmenes mensuales de dispositivos con garantía activa y próxima a vencer, dispersión de computadoras por gerencia y la distribución de registros por tipo de garantía, hemos identificado patrones y tendencias esenciales."), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode("Estos insights ofrecen una base sólida para la toma de decisiones dentro del departamento, permitiendo acciones precisas y puntuales. La atención a la temporalidad anual en este análisis mejora la precisión al considerar las actividades mensuales a lo largo del año, brindando una comprensión más profunda de las dinámicas cambiantes y facilitando la planificación estratégica."), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode("En última instancia, este informe no solo cumple con el propósito de proporcionar información relevante para la toma de decisiones, sino que también establece un marco sólido para futuras evaluaciones y ajustes continuos en el manejo de garantías de activos, contribuyendo así al rendimiento óptimo del departamento en el tiempo."), 0, 'J', 0);


        // Notas Finales
        $this->AddPage();
        $this->AddCustomTitle('Notas Finales');
        $this->ChapterTitle('Notas Finales');
        $inicioTabla = $this->GetY();   // Guardar la posición inicial del cursor antes del bucle
        $alturaFila = 9.5; // Altura estimada de la fila (ajusta según sea necesario)
        $inicioTabla += $alturaFila; // Usar la variable $alturaFila en lugar de un valor fijo

        $this->Ln();
        $this->SetFont('times', 'B', 14);
        $this->Cell(0, 9.5, utf8_decode("Recomendaciones:"), 0, 0, 'L',);
        $this->Ln();
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 9.5, utf8_decode("Basado en los resultados detallados presentados en este informe, se sugiere implementar las siguientes recomendaciones para optimizar la gestión de garantías de activos en el área de IT:"), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode("* Establecer un proceso más eficiente para asignar cobertura de las garantias a dispositivos recién ingresados."), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode("* Mejorar la asignación de recursos para reducir la cantidad de registros sin cobertura que esten asignados."), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode("* Implementar estrategias proactivas para abordar registros próximos a vencer que esten activo o en circulación"), 0, 'J', 0);
        $this->SetFont('times', 'B', 14);
        $this->Ln();
        $this->Cell(0, 9.5, utf8_decode("Perspectiva a Futuro:"), 0, 0, 'l',);
        $this->Ln();
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 9.5, utf8_decode("Considerando las tendencias emergentes en la gestión de activos, se recomienda explorar tecnologías de seguimiento más avanzadas y evaluar la viabilidad de hacer nuevas gestiones a las garantías."), 0, 'J', 0);
        $this->SetFont('times', 'B', 14);
        $this->Ln();
        $this->Cell(0, 9.5, utf8_decode("Agradecimientos y Colaboraciones:"), 0, 0, 'L',);
        $this->Ln();
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 9.5, utf8_decode("Extendemos nuestro agradecimiento a todos los equipos y personas involucradas en la recopilación y análisis de datos, así como a aquellos que brindaron asesoramiento técnico y apoyo logístico. Su contribución ha sido fundamental para el éxito de este informe."), 0, 'J', 0);
        $this->SetFont('times', 'B', 14);
        $this->AddPage();
        $this->pageNumberWithHeader++;
        $this->Cell(0, 9.5, utf8_decode("Limitaciones y Áreas de Mejora:"), 0, 0, 'L',);
        $this->Ln();
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 9.5, utf8_decode("Es importante tener en cuenta que este informe se basa en los datos disponibles hasta la fecha de corte. Futuros análisis podrían beneficiarse de la inclusión de datos en tiempo real y una mayor colaboración interdepartamental para abordar posibles limitaciones en la recopilación de información."), 0, 'J', 0);
        $this->Ln();
        $this->SetFont('times', 'B', 14);
        $this->Cell(0, 9.5, utf8_decode("Próximos Pasos:"), 0, 0, 'L',);
        $this->Ln();
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 9.5, utf8_decode("Se sugiere la implementación inmediata de las recomendaciones proporcionadas para mejorar la eficiencia y la efectividad en la gestión de garantías. Además, considerar futuros análisis detallados sobre la eficacia de estas medidas y evaluar la necesidad de capacitaciones adicionales para el personal involucrado."), 0, 'J', 0);
        $this->SetFont('times', 'B', 14);
        $this->Ln();
        $this->Cell(0, 9.5, utf8_decode("Contactos Relevantes:"), 0, 0, 'L',);
        $this->Ln();
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 9.5, utf8_decode("Para consultas adicionales o aclaraciones, no dude en ponerse en contacto con Desarrolladores de INFRAG."), 0, 'J', 0);
        $this->Ln();

        // Obtener la fecha actual
        $fecha_actual = strftime('%B %Y');

        // Obtener el nombre del mes en español
        $nombre_mes_espanol = traducirMes(strftime('%B'));
        $this->SetFont('times', 'B', 14);
        $this->Cell(0, 9.5, utf8_decode("Fecha de Revisión:"), 0, 0, 'l',);
        $this->Ln();
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 9.5, utf8_decode('Este informe fue generado con datos hasta Diciembre ' . $yearSeleccionado . '. Se recomienda una revisión periódica para garantizar la vigencia de la información y la adaptación a cambios en el entorno tecnológico. La próxima revisión se sugiere para Enero del Siguiente año.'), 0, 'J', 0);


        $this->SetTitle(utf8_decode("Informe de Garantía"));

        $this->GenerateIndex();
    }
}

$pdf = new warrantyPDF();
$pdf->AliasNbPages();


// Establecer márgenes aquí antes de agregar contenido
$topMargin = 40;
$bottomMargin = 42;
$leftMargin = 30;
$rightMargin = 30;
$pdf->SetMargins($leftMargin, $topMargin, $rightMargin);
$pdf->SetAutoPageBreak(true, $bottomMargin);

$pdf->Portada($yearSeleccionado);

// Generar el PDF
$timestamp = date("Y-m-d_H-i-s");
$nombreArchivo = "InformeGarantia" . $timestamp . ".pdf";
$pdfPath = "" . $nombreArchivo;

$pdf->Output($pdfPath, 'I');
// Accede a los elementos del array
// var_dump($alturaPag);
