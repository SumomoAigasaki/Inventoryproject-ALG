<?php
require('../../public/FPDF/fpdf.php');
include "../../includes/conecta.php";
include "../controllers/reporteDashboardComputer.php";

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

        // Portada
        $this->AddPage();
        $this->AddCustomTitle('Portada');
        $logoALG = '../../resources/Warranty/LogoALG.png'; // Ruta a la imagen local
        $this->Image($logoALG, 22, 65, 160); // Inserta el logo
        $this->Ln(90); // Agregar espacio después del contenido

        $this->SetFont('times', 'B', 32);
        $this->Cell(0, 15, utf8_decode('Resumen Ejecutivo '), 0, 1, 'C');
        $this->Cell(0, 15, utf8_decode('Recuento General de Dispositivos'), 0, 1, 'C');
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
        // 1 Introducción
        $this->SetMargins(20, 0, 22);
        $this->AddPage();
        $this->AddCustomTitle('I. Introducción');
        $this->ChapterTitle('I. Introducción');
        $this->Ln();
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 9.5, utf8_decode("El presente informe ofrece una síntesis detallada de los datos exportados del sistema INFRAG, centrándose especialmente en la reportaría relacionada con las garantías de los activos de Azucarera la Grecia, específicamente en el departamento de Soporte IT, con un enfoque particular en los dispositivos de cómputo."), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode("El análisis abarca diversas categorías de dispositivos, como los recién ingresados, el conteo general de RAMS, CPU y discos duros, así como qué dispositivos cuentan con dicha información. A lo largo de este informe, se llevará a cabo una evaluación minuciosa mediante la presentación de gráficos que incluirán imágenes y datos relevantes."), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode("Se presentarán varios tipos de gráficos, como la Gráfica de Barras - Resumen Mensual para dispositivos Laptops y Escritorio, el Gráfico de Pastel para la Distribución de Registros de Marcas en Equipos de Escritorio, el Gráfico de Pastel para la Distribución de Registros de Marcas en Equipos de Laptop, y el Gráfico de Dispersión para el Conteo de Computadoras por Localización."), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode("El propósito fundamental de este análisis es proporcionar información crucial para la toma de decisiones dentro del departamento de manera precisa y oportuna. La evaluación busca identificar acciones necesarias basadas en la realidad de los datos recopilados. Es importante destacar que este proceso se lleva a cabo anualmente, garantizando así un análisis más preciso al considerar las actividades mensuales a lo largo del año en cuestión. Este enfoque temporal permite una comprensión profunda de las tendencias y patrones que pueden influir en las decisiones estratégicas a lo largo del tiempo."), 0, 'J', 0);
        $this->excludeFromFooter = false; //Valicadion para no añadir pie de pagina a la pagina presente 



        // 2 Sección de Cards
        $this->AddPage();
        $this->AddCustomTitle('II. Sección de Cards');
        $this->SetMargins(20, 0, 22);
        $this->MultiCell(0, 1, utf8_decode(''), 0, 'J', 0);;
        $this->ChapterTitle('II. Sección de Cards');
        $this->Ln();
        $this->SetFont('times', '', 12);
        // --Informacion relevante de explicacion de los  Cards para que son y demas 
        $this->MultiCell(0, 9.5, utf8_decode("En esta sección, se presenta información detallada acerca de diversos recuentos y conteos de registros, tales como: "), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode('1.- Registros Nuevos: Se muestran los registros ingresados en los últimos tres meses con garantías vigentes, excluyendo aquellos de tipo "No Aplica".'), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode('2.- RAMS: Este apartado proporciona un recuento ordenado de las RAMS en inventario, asociadas a las computadoras. Algunos ejemplos de datos incluyen: "Ram 8GB" y "Ram 12GB".'), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode('3.- CPU: Ofrece información sobre los registros guardados con detalles del CPU que existen en el sistema.'), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode('4.- Unidades de Almacenamiento: Se realiza un conteo general de la cantidad de discos duros en el sistema, abarcando SSD, M2 y HDD.'), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode("Estos conteos se centran en registros que no están deshabilitados, proporcionando una visión clara de la situación actual de los diferentes tipos de registros dentro del sistema."), 0, 'J', 0);
        $this->AddPage('L'); // 'L' indica orientación horizontal



        // 2.1 Cards- Registros Nuevos
        $this->AddCustomTitle('II.I Cards- Registros Nuevos');
        $this->SetFont('times', 'B', 12);
        $this->ChapterTitle('II.I Cards- Registros Nuevos');
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
        $this->Cell(45, 7, utf8_decode("Fecha de Expiracion"), 'LTRB', 0, 'C', 1);
        $this->Cell(50, 7, utf8_decode("Nombre Dispositivo"), 'LTRB', 0, 'C', 1);
        $this->Cell(20, 7, utf8_decode("Marca"), 'LTRB', 0, 'C', 1);
        $this->Cell(45, 7, utf8_decode("Modelo"), 'LTRB', 0, 'C', 1);
        $this->Cell(50, 7, utf8_decode("Tipo de Garantia"), 'LTRB', 0, 'C', 1);
        $this->Ln();
        // --Extraccion de datos para la tabla de Registros Nuevos
        $exportMySql = new MySQL();

        $dataRecNew = $exportMySql->modalRecNewRegister(); // Obtiene datos desde la base de datos
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



        // 2.2 Cards- Registros de RAMS)
        $this->AddCustomTitle('II.II Cards- RAMS');
        $this->ChapterTitle('II.II Cards- RAMS');
        $this->SetFont('times', '', 12);
        $this->SetFillColor(215, 219, 221);
        // --Calcula la posición de inicio para centrar la tabla
        $paginaAncho = $this->GetPageWidth();
        $tablaAncho = 15 + 30  + 50 + 35 + 40 + 50 + 40; // Suma de los anchos de las celdas
        $posicionInicio = ($paginaAncho - $tablaAncho) / 2;
        $this->SetX($posicionInicio); // Establece la posición de inicio
        // --Tabla de Registros RAMS
        $this->Cell(15, 7, utf8_decode("ID"), 'LTRB', 0, 'C', 1);
        $this->Cell(30, 7, utf8_decode("Fecha Ingreso"), 'LTRB', 0, 'C', 1);
        $this->Cell(50, 7, utf8_decode("Nombre Dispositivo"), 'LTRB', 0, 'C', 1);
        $this->Cell(35, 7, utf8_decode("Especificaciones"), 'LTRB', 0, 'C', 1);
        $this->Cell(40, 7, utf8_decode("Localizacion"), 'LTRB', 0, 'C', 1);
        $this->Cell(50, 7, utf8_decode("Modelo"), 'LTRB', 0, 'C', 1);
        $this->Cell(40, 7, utf8_decode("Estado"), 'LTRB', 0, 'C', 1);
        $this->Ln();
        // --Extraccion de datos para la tabla de Registros RAMS
        $exportMySql = new MySQL();
        $dataRecCovUnAssig = $exportMySql->modalrecRams();  // Obtiene datos desde la base de datos
        $arrayDatos = json_decode($dataRecCovUnAssig, true); // Verifica si $dataRecNew es un array antes de intentar acceder a sus elementos

        // Verifica si $arrayDatos es un array antes de intentar acceder a sus elementos
        if (is_array($arrayDatos) && isset($arrayDatos['data']) && !empty($arrayDatos['data'])) {
            // Accede a los elementos del array
            // Intera con cada unos elementos del array
            foreach ($arrayDatos['data'] as $dato) {
                $this->SetX($posicionInicio);
                $this->Cell(15, 7, utf8_decode("" . $dato['idComputer']), 'LTRB', 0, 'C', 0);
                $this->Cell(30, 7, utf8_decode("" . $dato['fechaExpiracion']), 'LTRB', 0, 'C', 0);
                $this->Cell(50, 7, utf8_decode("" . $dato['nombreTecnico']), 'LTRB', 0, 'C', 0);
                $this->Cell(35, 7, utf8_decode("" . $dato['especificaciones']), 'LTRB', 0, 'C', 0);
                $this->Cell(40, 7, utf8_decode("" . $dato['localizacion']), 'LTRB', 0, 'C', 0);
                $this->Cell(50, 7, utf8_decode("" . $dato['marcaModelo']), 'LTRB', 0, 'C', 0);
                $this->Cell(40, 7, utf8_decode("" . $dato['estado']), 'LTRB', 0, 'C', 0);
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
        $this->Cell($tablaAncho, 7, utf8_decode("Última Línea."), 'T', 0, 'C',); //Mensaje que sale al final de la tabla
        $this->SetFont('times', '', 12);
        $this->Ln();
        $this->MultiCell(0, 10, utf8_decode("Nota:Nota: por cuestiones de espacio solo se presentan 10 registros por pagina, para mas información revisar el dashboard correspondiente."), 0, 'J', 0);


        // 2.3 Cards- CPU
        $this->AddPage('L'); // 'L' indica orientación horizontal
        $this->AddCustomTitle('II.IIICards- CPU');
        $this->ChapterTitle('II.III Cards- CPU');
        $this->SetFont('times', '', 12);
        $this->SetFillColor(215, 219, 221);
        // Calcula la posición de inicio para centrar la tabla
        $paginaAncho = $this->GetPageWidth();
        $tablaAncho = 15 + 30 + 40 + 60 + 30 + 50 + 30; // Suma de los anchos de las celdas
        $posicionInicio = ($paginaAncho - $tablaAncho) / 2;
        $this->SetX($posicionInicio);   // Establece la posición de inicio
        // --Tabla de Registros CPU
        $this->Cell(15, 7, utf8_decode("ID"), 'LTRB', 0, 'C', 1);
        $this->Cell(30, 7, utf8_decode("Fecha Ingreso"), 'LTRB', 0, 'C', 1);
        $this->Cell(40, 7, utf8_decode("Nombre Dispositivo"), 'LTRB', 0, 'C', 1);
        $this->Cell(60, 7, utf8_decode("Especificaciones"), 'LTRB', 0, 'C', 1);
        $this->Cell(30, 7, utf8_decode("Localizacion"), 'LTRB', 0, 'C', 1);
        $this->Cell(50, 7, utf8_decode("Modelo"), 'LTRB', 0, 'C', 1);
        $this->Cell(30, 7, utf8_decode("Estado"), 'LTRB', 0, 'C', 1);
        $this->Ln();
        // --Extraccion de datos para la tabla de Registros CPU
        $exportMySql = new MySQL();
        $dataRecCovUnAssig = $exportMySql->modalRecCPU();  // Obtiene datos desde la base de datos
        $arrayDatos = json_decode($dataRecCovUnAssig, true);  // Verifica si $dataRecNew es un array antes de intentar acceder a sus elementos

        // Verifica si $arrayDatos es un array antes de intentar acceder a sus elementos
        if (is_array($arrayDatos) && isset($arrayDatos['data']) && !empty($arrayDatos['data'])) {
            // Accede a los elementos del array
            // Intera con cada unos elementos del array
            foreach ($arrayDatos['data'] as $dato) {
                $this->SetX($posicionInicio);
                $this->Cell(15, 7, utf8_decode("" . $dato['idComputer']), 'LTRB', 0, 'C', 0);
                $this->Cell(30, 7, utf8_decode("" . $dato['fechaExpiracion']), 'LTRB', 0, 'C', 0);
                $this->Cell(40, 7, utf8_decode("" . $dato['nombreTecnico']), 'LTRB', 0, 'C', 0);
                $this->Cell(60, 7, utf8_decode("" . $dato['especificaciones']), 'LTRB', 0, 'C', 0);
                $this->Cell(30, 7, utf8_decode("" . $dato['localizacion']), 'LTRB', 0, 'C', 0);
                $this->Cell(50, 7, utf8_decode("" . $dato['marcaModelo']), 'LTRB', 0, 'C', 0);
                $this->Cell(30, 7, utf8_decode("" . $dato['estado']), 'LTRB', 0, 'C', 0);
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
        $this->Cell($tablaAncho, 7, utf8_decode("Última Línea."), 'T', 0, 'C',); //Mensaje que sale al final de la tabla
        $this->SetFont('times', '', 12);
        $this->Ln();
        $this->MultiCell(0, 10, utf8_decode("Nota:Nota: por cuestiones de espacio solo se presentan 10 registros por pagina, para mas información revisar el dashboard correspondiente."), 0, 'J', 0);



        // 2.4 Cards- Disco Duro
        $this->AddPage('L'); // 'L' indica orientación horizontal
        $this->AddCustomTitle('II.IV Cards- Discos Duros');
        $this->ChapterTitle('II.IV Cards- Discos Duros');
        $this->SetFont('times', '', 12);
        $this->SetFillColor(215, 219, 221);
        // Calcula la posición de inicio para centrar la tabla
        $paginaAncho = $this->GetPageWidth();
        $tablaAncho = 15 + 30 + 40 + 60 + 25 + 50 + 25; // Suma de los anchos de las celdas
        $posicionInicio = ($paginaAncho - $tablaAncho) / 2;
        $this->SetX($posicionInicio);   // Establece la posición de inicio
        // --Tabla de Registros Discos Duros
        $this->Cell(15, 7, utf8_decode("ID"), 'LTRB', 0, 'C', 1);
        $this->Cell(30, 7, utf8_decode("Fecha Ingreso"), 'LTRB', 0, 'C', 1);
        $this->Cell(40, 7, utf8_decode("Nombre Dispositivo"), 'LTRB', 0, 'C', 1);
        $this->Cell(60, 7, utf8_decode("Especificaciones"), 'LTRB', 0, 'C', 1);
        $this->Cell(25, 7, utf8_decode("Localizacion"), 'LTRB', 0, 'C', 1);
        $this->Cell(50, 7, utf8_decode("Modelo"), 'LTRB', 0, 'C', 1);
        $this->Cell(25, 7, utf8_decode("Estado"), 'LTRB', 0, 'C', 1);
        $this->Ln();
        // --Extraccion de datos para la tabla de Registros Discos Duros
        $exportMySql = new MySQL();
        $dataRecCovUnAssig = $exportMySql->modalRecDisk();  // Obtiene datos desde la base de datos
        $arrayDatos = json_decode($dataRecCovUnAssig, true);  // Verifica si $dataRecNew es un array antes de intentar acceder a sus elementos

        // Verifica si $arrayDatos es un array antes de intentar acceder a sus elementos
        if (is_array($arrayDatos) && isset($arrayDatos['data']) && !empty($arrayDatos['data'])) {
            // Accede a los elementos del array
            // Intera con cada unos elementos del array
            foreach ($arrayDatos['data'] as $dato) {
                $this->SetX($posicionInicio);
                $this->Cell(15, 7, utf8_decode("" . $dato['idComputer']), 'LTRB', 0, 'C', 0);
                $this->Cell(30, 7, utf8_decode("" . $dato['fechaExpiracion']), 'LTRB', 0, 'C', 0);
                $this->Cell(40, 7, utf8_decode("" . $dato['nombreTecnico']), 'LTRB', 0, 'C', 0);
                $this->Cell(60, 7, utf8_decode("" . $dato['especificaciones']), 'LTRB', 0, 'C', 0);
                $this->Cell(25, 7, utf8_decode("" . $dato['localizacion']), 'LTRB', 0, 'C', 0);
                $this->Cell(50, 7, utf8_decode("" . $dato['marcaModelo']), 'LTRB', 0, 'C', 0);
                $this->Cell(25, 7, utf8_decode("" . $dato['estado']), 'LTRB', 0, 'C', 0);
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
        $this->Cell($tablaAncho, 7, utf8_decode("Última Línea."), 'T', 0, 'C',); //Mensaje que sale al final de la tabla
        $this->SetFont('times', '', 12);
        $this->Ln();
        $this->MultiCell(0, 10, utf8_decode("Nota:Nota: por cuestiones de espacio solo se presentan 10 registros por pagina, para mas información revisar el dashboard correspondiente."), 0, 'J', 0);



        // 3 Análisis Gráfico
            $this->AddPage();
            $this->AddCustomTitle('III. Análisis Gráfico');
            $this->SetMargins(20, 0, 22);
            $this->MultiCell(0, 1, utf8_decode(''), 0, 'J', 0);;
            $this->ChapterTitle('III.Análisis Gráfico');
            // --Informacion relevante de explicacion de los Graficos para que son y demas 
            $this->SetFont('times', '', 12);
            $this->MultiCell(0, 9.5, utf8_decode("En esta sección, llevaremos a cabo un análisis exhaustivo de los gráficos presentados en la página web. Proporcionaremos una representación visual de cada gráfico acompañada de una tabla detallada para facilitar la interpretación de los datos. En este análisis, no se aplicarán filtros a la cantidad de registros a analizar, garantizando así una visión completa de la información."), 0, 'J', 0);
            $this->MultiCell(0, 9.5, utf8_decode('Exploraremos cuatro tipos de gráficos:'), 0, 'J', 0);
            $this->MultiCell(0, 9.5, utf8_decode('1.- Gráfica de Barras: Utilizada para comparar datos entre computadoras y laptops.'), 0, 'J', 0);
            $this->MultiCell(0, 9.5, utf8_decode('2.- Gráfico de Pastel (Escritorio): Realizaremos un recuento de tipos de marcas de dispositivos de escritorio.'), 0, 'J', 0);
            $this->MultiCell(0, 9.5, utf8_decode('3.- Gráfico de Pastel (Laptops): Realizaremos un recuento de tipos de marcas de dispositivos laptop.'), 0, 'J', 0);
            $this->MultiCell(0, 9.5, utf8_decode('4.- Gráfico de Dispersión: Se llevará a cabo un recuento de los dispositivos según su localidad, considerando si están en circulación (listos para ser asignados), obsoletos, descartables o en taller.'), 0, 'J', 0);
            $this->MultiCell(0, 9.5, utf8_decode('Este enfoque integral en la presentación de datos permitirá una comprensión más profunda de la información contenida en los gráficos, facilitando la toma de decisiones informadas basadas en los resultados del análisis.'), 0, 'J', 0);




        // 3.1 Grafico de Barra
            $this->AddPage('L');
            $this->AddCustomTitle('III.I Análisis Gráfico- Gráficos de Barra');
            $this->Ln(2);
            // Imagen del Gráfico de Barra
            $this->ChapterTitle('III.I Análisis Gráfico- Gráficos de Barra');
            $graficBarras = '../../resources/Dashboard/Computer/graficoBarra.png';
            $anchoPagina = $this->GetPageWidth(); // extraer el valor del ancho de la pagina actual
            $anchoImagen = 170; // Ajusta según el ancho de tu imagen
            $posicionInicioX = ($anchoPagina - $anchoImagen) / 2;
            $this->Image($graficBarras, $posicionInicioX, 50, $anchoImagen);
            $this->Ln(2);
            // Análisis Gráfico- Gráfico de Barra
            $this->SetY(100); // Mueve el cursor debajo de la imagen
            // Ajusta la posición para la tabla debajo de la imagen
            $posicionInicioY = $this->GetY(); // Puedes ajustar el valor según sea necesario
            $this->SetY($posicionInicioY);

            $this->SetFont('times', '', 12);
            $this->MultiCell(0, 10, utf8_decode('Datos de Analisis para Grafico de Barras:'), 0, 'J', 0);

            // Calcula la posición de inicio para centrar la tabla
            $paginaAncho = $this->GetPageWidth();
            $tablaAncho = 10 + 20 + 40 + 45 + 25 + 90; // Suma de los anchos de las celdas
            $posicionInicio = ($paginaAncho - $tablaAncho) / 2;
            $this->SetX($posicionInicio);
            // --Tabla para Gráfico de Barra
            $this->Cell(10, 7, utf8_decode("ID"), 'LTRB', 0, 'C', 1);
            $this->Cell(20, 7, utf8_decode("Fecha"), 'LTRB', 0, 'C', 1);
            $this->Cell(40, 7, utf8_decode("Nombre Dispositivo"), 'LTRB', 0, 'C', 1);
            $this->Cell(45, 7, utf8_decode("Modelo"), 'LTRB', 0, 'C', 1);
            $this->Cell(25, 7, utf8_decode("Tipo de Equipo"), 'LTRB', 0, 'C', 1);
            $this->Cell(90, 7, utf8_decode("Especificaciones"), 'LTRB', 0, 'C', 1);
            // $this->Cell(35, 7, utf8_decode("Estado"), 'LTRB', 0, 'C', 1);
            $this->Ln();
            // --Extraccion de datos para la tabla de Gráfico de Barra
            $exportMySql = new MySQL();
            $dataRecCovUnAssig = $exportMySql->modalComparativeBarGraph($yearSeleccionado); // Obtiene datos desde la base de datos
            $arrayDatos = json_decode($dataRecCovUnAssig, true); // Verifica si $dataRecNew es un array antes de intentar acceder a sus elementos
            // --Calcular espacio para salto de linea
            $inicioTabla = $this->GetY();   // Guardar la posición inicial del cursor antes del bucle
            $longitudPaginaHorizontal = 167;
            $alturaFila = 12; // Altura estimada de la fila (ajusta según sea necesario

            // *Interar cada uno de los datos extraidos
            if (is_array($arrayDatos) && isset($arrayDatos['data']) && !empty($arrayDatos['data'])) {
                // Accede a los elementos del array
                foreach ($arrayDatos['data'] as $dato) {
                    $inicioTabla += $alturaFila; // Usar la variable $alturaFila en lugar de un valor fijo
                    if ($inicioTabla >= $longitudPaginaHorizontal) { // Verificar si es necesario añadir una nueva página
                        $this->AddPage('L');
                        $inicioTabla = 0;
                        $longitudPaginaHorizontal = 113;
                        $this->pageNumberWithHeader++;
                    }
                    $this->SetX($posicionInicio);
                    $this->Cell(10, 12, utf8_decode("" . $dato['idComputer']), 'LTRB', 0, 'C', 0);
                    $this->Cell(20, 12, utf8_decode("" . $dato['fecha']), 'LTRB', 0, 'C', 0);
                    $this->Cell(40, 12, utf8_decode("" . $dato['nombreTecnico']), 'LTRB', 0, 'C', 0); // Celda para el icono
                    $this->Cell(45, 12, utf8_decode("" . $dato['modelo']), 'LTRB', 0, 'C', 0);
                    $this->Cell(25, 12, utf8_decode("" . $dato['tipoEquipo']), 'LTRB', 0, 'C', 0);
                    $this->MultiCell(90, 6, utf8_decode("" . $dato['especificaciones']), 'LTRB', 'J', 0);
                }
            } else {
                //Si no hay datos en la consulta colocar este msj
                $this->SetX($posicionInicio);
                $this->Cell(220, 6, utf8_decode("No hay datos para asignar."), 'LTRB', 0, 'C', 0);
                $this->Ln();
            }
            $this->SetX($posicionInicio);
            $this->SetFont('times', 'B', 12);
            $this->Cell($tablaAncho, 7, utf8_decode("Última Línea."), 'T', 0, 'C',); //Mensaje que sale al final de la tabla

        // 3.2 Gráfico Pastel Escritorio
            $this->AddPage('L');
            $this->AddCustomTitle('III.II Análisis Gráfico- Gráfico Pastel Escritorio');
            $this->ChapterTitle('III.II Análisis Gráfico- Gráfico Pastel Escritorio');
            $graficPastel = '../../resources/Dashboard/Computer/graficoPastelEscritorio.png';
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
            $this->MultiCell(0, 10, utf8_decode('Datos de Analisis con el tipo de dispositivo Escritorio:'), 0, 'J', 0);
            //-- Calcula la posición de inicio para centrar la tabla
            $paginaAncho = $this->GetPageWidth();
            $tablaAncho = 10  + 25 + 40 + 45 + 90 + 20; // Suma de los anchos de las celdas
            $posicionInicio = ($paginaAncho - $tablaAncho) / 2;
            $this->SetX($posicionInicio);
            // *Inicio de la tabla con posicion ya establecida 
            $this->Cell(10, 7, utf8_decode("ID"), 'LTRB', 0, 'C', 1);
            $this->Cell(25, 7, utf8_decode("Fecha Adqui."), 'LTRB', 0, 'C', 1);
            $this->Cell(40, 7, utf8_decode("Nombre Dispositivo"), 'LTRB', 0, 'C', 1);
            $this->Cell(20, 7, utf8_decode("Estado"), 'LTRB', 0, 'C', 1);
            $this->Cell(45, 7, utf8_decode("Modelo"), 'LTRB', 0, 'C', 1);
            $this->Cell(90, 7, utf8_decode(" Especificaciones"), 'LTRB', 0, 'C', 1);

            $this->Ln();
            // *Extraccion de datos de BD para la tabla de Gráfico Pastel
            $exportMySql = new MySQL();
            $dataRecCovUnAssig = $exportMySql->modalpieGraphInformationDesktop($yearSeleccionado); // Obtiene datos desde la base de datos
            $arrayDatos = json_decode($dataRecCovUnAssig, true); // Verifica si $dataRecNew es un array antes de intentar acceder a sus elementos
            //--Calcular espacio para salto de linea
            $inicioTabla = $this->GetY();   // Guardar la posición inicial del cursor antes del bucle
            $longitudPaginaHorizontal = 168;
            $alturaFila = 12; // Altura estimada de la fila (ajusta según sea necesario

            // *Interar cada uno de los datos extraidos
            if (is_array($arrayDatos) && isset($arrayDatos['data']) && !empty($arrayDatos['data'])) {  // Verifica si $arrayDatos es un array y si tiene elementos

                foreach ($arrayDatos['data'] as $dato) {
                    $inicioTabla += $alturaFila; // Usar la variable $alturaFila en lugar de un valor fijo

                    // Verificar si es necesario añadir una nueva página
                    if ($inicioTabla >= $longitudPaginaHorizontal) {
                        $this->AddPage('L');
                        $inicioTabla = 0;
                        $longitudPaginaHorizontal = 113;
                        $this->pageNumberWithHeader++;
                    }
                    $this->SetX($posicionInicio);
                    $this->Cell(10, 12, utf8_decode("" . $dato['idComputer']), 'LTRB', 0, 'C', 0);
                    $this->Cell(25, 12, utf8_decode("" . $dato['fechaAdquisicion']), 'LTRB', 0, 'C', 0);
                    $this->Cell(40, 12, utf8_decode("" . $dato['nombreTecnico']), 'LTRB', 0, 'C', 0);
                    $this->Cell(20, 12, utf8_decode("" . $dato['estado']), 'LTRB', 0, 'C', 0);
                    $this->Cell(45, 12, utf8_decode("" . $dato['modelo']), 'LTRB', 0, 'C', 0);
                    $this->MultiCell(90, 6, utf8_decode("" . $dato['especificaciones']), 'LTRB', 'J', 0);
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
            // $this->MultiCell(0, 10, utf8_decode("Nota: por cuestiones de espacio solo se visualizan 6 columnas, para mas información revisar el dashboard correspondiente."), 0, 'J', 0);

        // 3.3 Gráfico Pastel Escritorio
            $this->AddPage('L');
            $this->AddCustomTitle('III.III Análisis Gráfico- Gráfico Pastel Laptops');
            $this->ChapterTitle('III.III Análisis Gráfico- Gráfico Pastel Laptops');
            $graficPastel = '../../resources/Dashboard/Computer/graficoPastelLaptos.png';
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
            $this->MultiCell(0, 10, utf8_decode('Datos de Analisis con el tipo de dispositivo Laptops:'), 0, 'J', 0);
            //-- Calcula la posición de inicio para centrar la tabla
            $paginaAncho = $this->GetPageWidth();
            $tablaAncho = 10  + 25 + 40 + 45 + 90 + 20; // Suma de los anchos de las celdas
            $posicionInicio = ($paginaAncho - $tablaAncho) / 2;
            $this->SetX($posicionInicio);
            // *Inicio de la tabla con posicion ya establecida 
            $this->Cell(10, 7, utf8_decode("ID"), 'LTRB', 0, 'C', 1);
            $this->Cell(25, 7, utf8_decode("Fecha Adqui."), 'LTRB', 0, 'C', 1);
            $this->Cell(40, 7, utf8_decode("Nombre Dispositivo"), 'LTRB', 0, 'C', 1);
            $this->Cell(20, 7, utf8_decode("Estado"), 'LTRB', 0, 'C', 1);
            $this->Cell(45, 7, utf8_decode("Modelo"), 'LTRB', 0, 'C', 1);
            $this->Cell(90, 7, utf8_decode(" Especificaciones"), 'LTRB', 0, 'C', 1);

            $this->Ln();
            // *Extraccion de datos de BD para la tabla de Gráfico Pastel
            $exportMySql = new MySQL();
            $dataRecCovUnAssig = $exportMySql->modalpieGraphInformationLaptop($yearSeleccionado); // Obtiene datos desde la base de datos
            $arrayDatos = json_decode($dataRecCovUnAssig, true); // Verifica si $dataRecNew es un array antes de intentar acceder a sus elementos
            //--Calcular espacio para salto de linea
            $inicioTabla = $this->GetY();   // Guardar la posición inicial del cursor antes del bucle
            $longitudPaginaHorizontal = 168;
            $alturaFila = 12; // Altura estimada de la fila (ajusta según sea necesario

            // *Interar cada uno de los datos extraidos
            if (is_array($arrayDatos) && isset($arrayDatos['data']) && !empty($arrayDatos['data'])) {  // Verifica si $arrayDatos es un array y si tiene elementos

                foreach ($arrayDatos['data'] as $dato) {
                    $inicioTabla += $alturaFila; // Usar la variable $alturaFila en lugar de un valor fijo

                    // Verificar si es necesario añadir una nueva página
                    if ($inicioTabla >= $longitudPaginaHorizontal) {
                        $this->AddPage('L');
                        $inicioTabla = 0;
                        $longitudPaginaHorizontal = 113;
                        $this->pageNumberWithHeader++;
                    }
                    $this->SetX($posicionInicio);
                    $this->Cell(10, 12, utf8_decode("" . $dato['idComputer']), 'LTRB', 0, 'C', 0);
                    $this->Cell(25, 12, utf8_decode("" . $dato['fechaAdquisicion']), 'LTRB', 0, 'C', 0);
                    $this->Cell(40, 12, utf8_decode("" . $dato['nombreTecnico']), 'LTRB', 0, 'C', 0);
                    $this->Cell(20, 12, utf8_decode("" . $dato['estado']), 'LTRB', 0, 'C', 0);
                    $this->Cell(45, 12, utf8_decode("" . $dato['modelo']), 'LTRB', 0, 'C', 0);
                    $this->MultiCell(90, 6, utf8_decode("" . $dato['especificaciones']), 'LTRB', 'J', 0);
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
            


        // Gráfico de Dispersión
            $this->AddPage('L');
            $this->AddCustomTitle('III.IV Análisis Gráfico- Gráfico de Dispersión');
            $this->Ln(2);
            // --Imagen del Gráfico de Dispersión
            $this->ChapterTitle('III.IV Análisis Gráfico- Gráfico de Dispersión');
            $graficDispersion = '../../resources/Dashboard/Computer/graficoDispersion.png';
            $anchoPagina = $this->GetPageWidth(); // Centra la imagen horizontalmente
            $anchoImagen = 120; // Ajusta según el ancho de tu imagen
            $posicionInicioX = ($anchoPagina - $anchoImagen) / 2;
            $this->Image($graficDispersion,  $posicionInicioX, 50, $anchoImagen);
            $this->SetFont('times', '', 12);  // Configuracion de la fuente
            $this->SetY(110); // Mueve el cursor debajo de la imagen
            // Ajusta la posición para la tabla debajo de la imagen
            $posicionInicioY = $this->GetY() + 10; // Puedes ajustar el valor según sea necesario
            $this->SetY($posicionInicioY);
            $this->MultiCell(0, 10, utf8_decode('Datos de Analisis de Gráfico de Dispersión:'), 0, 'J', 0);
            //Tabla de los datos del Gráfico de Dispersión
            // --Calcula la posición de inicio para centrar la tabla
            $paginaAncho = $this->GetPageWidth();
            $tablaAncho = 10 + 35 + 40 + 25 + 30 +90; // Suma de los anchos de las celdas
            $posicionInicio = ($paginaAncho - $tablaAncho) / 2;
            $this->SetX($posicionInicio);
            $this->Cell(10, 7, utf8_decode("ID"), 'LTRB', 0, 'C', 1);
            $this->Cell(35, 7, utf8_decode("Fecha Adquision"), 'LTRB', 0, 'C', 1);
            $this->Cell(40, 7, utf8_decode("Nombre Tecnico"), 'LTRB', 0, 'C', 1);
            $this->Cell(25, 7, utf8_decode("Tipo Equipo"), 'LTRB', 0, 'C', 1);
            $this->Cell(30, 7, utf8_decode("Localizacion"), 'LTRB', 0, 'C', 1);
            $this->Cell(90, 7, utf8_decode("Especificaciones"), 'LTRB', 0, 'C', 1);
            $this->Ln();
            //* Extraccion de datos en la BD para el Gráfico de Dispersión
            $exportMySql = new MySQL();
            $dataRecCovUnAssig = $exportMySql->modalScatterPlotInformationLocation($yearSeleccionado); // Obtiene datos desde la base de datos
            $arrayDatos = json_decode($dataRecCovUnAssig, true); // Verifica si $dataRecNew es un array antes de intentar acceder a sus elementos
            //--Calcular espacio para salto de linea
            $inicioTabla = $this->GetY();   // Guardar la posición inicial del cursor antes del bucle
            $longitudPaginaHorizontal = 168;
            $alturaFila = 12; // Altura estimada de la fila (ajusta según sea necesario
            // *Interar cada uno de los datos extraidos
            if (is_array($arrayDatos) && isset($arrayDatos['data']) && !empty($arrayDatos['data'])) {
                foreach ($arrayDatos['data'] as $dato) {
                    $inicioTabla += $alturaFila; // Usar la variable $alturaFila en lugar de un valor fijo

                    if ($inicioTabla >= $longitudPaginaHorizontal) { // Verificar si es necesario añadir una nueva página
                        $this->AddPage('L');
                        $inicioTabla = 0;
                        $longitudPaginaHorizontal = 113;
                        $this->pageNumberWithHeader++;
                    }
                    $this->SetX($posicionInicio);
                    $this->Cell(10, 12, utf8_decode("" . $dato['idComputer']), 'LTRB', 0, 'C', 0);
                    $this->Cell(35, 12, utf8_decode("" . $dato['fechaAdquisicion']), 'LTRB', 0, 'C', 0);
                    $this->Cell(40, 12, utf8_decode("" . $dato['nombreTecnico']), 'LTRB', 0, 'C', 0);
                    $this->Cell(25, 12, utf8_decode("" . $dato['tipoEquipo']), 'LTRB', 0, 'C', 0); // Celda para el icono
                    $this->Cell(30, 12, utf8_decode("" . $dato['Localizacion']), 'LTRB', 0, 'C', 0);
                    $this->MultiCell(90, 6, utf8_decode("" . $dato['especificaciones']), 'LTRB', 'J', 0);
                   
                }
            } else {
                //Si no hay datos en la consulta colocar este msj
                $this->SetX($posicionInicio);
                $this->Cell(185, 6, utf8_decode("No hay datos para asignar."), 'LTRB', 0, 'C', 0);
                $this->Ln();
            }
            $this->SetX($posicionInicio);
            $this->SetFont('times', 'B', 12);
            $this->Cell($tablaAncho, 7, utf8_decode("Última Línea."), 'T', 0, 'C',); //Mensaje que sale al final de la tabla

        // Conclusiones y Recomendaciones
        $this->AddPage();
        $this->AddCustomTitle('IV. Conclusiones y Recomendaciones');
        $this->ChapterTitle('IV. Conclusiones y Recomendaciones');
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 9.5, utf8_decode("En conclusión, este informe proporciona una visión detallada de la situación de los activos de Azucarera la Grecia, específicamente en el departamento de Soporte IT, con un enfoque primordial en los dispositivos de cómputo y las garantías asociadas. A través de un análisis exhaustivo que abarca diversas categorías, como los recién ingresados, el conteo general de RAMS, CPU y discos duros, así como la identificación de dispositivos con esta información, se ha logrado una evaluación completa"), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode("La presentación de gráficos, como la Gráfica de Barras para dispositivos Laptops y Escritorio, el Gráfico de Pastel para la Distribución de Registros de Marcas en Equipos de Escritorio, el Gráfico de Pastel para la Distribución de Registros de Marcas en Equipos de Laptop y el Gráfico de Dispersión para el Conteo de Computadoras por Localización, ha facilitado la interpretación visual de los datos."), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode("El propósito fundamental de este análisis es proporcionar información esencial para la toma de decisiones dentro del departamento, asegurando precisión y oportunidad en la identificación de acciones necesarias basadas en la realidad de los datos recopilados. Con el enfoque temporal anual, se garantiza un análisis más preciso al considerar las actividades mensuales, lo que permite comprender en profundidad las tendencias y patrones que pueden influir en las decisiones estratégicas a lo largo del tiempo."), 0, 'J', 0);


        // Notas Finales
        $this->AddPage();
        $this->AddCustomTitle('V. Notas Finales');
        $this->ChapterTitle('V. Notas Finales');
        $inicioTabla = $this->GetY();   // Guardar la posición inicial del cursor antes del bucle
        $alturaFila = 9.5; // Altura estimada de la fila (ajusta según sea necesario)
        $inicioTabla += $alturaFila; // Usar la variable $alturaFila en lugar de un valor fijo

        $this->Ln();
        $this->SetFont('times', 'B', 14);
        $this->Cell(0, 9.5, utf8_decode("Recomendaciones:"), 0, 0, 'L',);
        $this->Ln();
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 9.5, utf8_decode("Basado en los resultados detallados presentados en este informe, se sugiere implementar las siguientes recomendaciones para optimizar la gestión de garantías de activos en el área de IT:"), 0, 'J', 0);
        $this->SetFont('times', 'B', 12);
        $this->Cell(0, 9.5, utf8_decode("1.- Optimización del Inventario:"), 0, 0, 'L',);
        $this->Ln();
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 9.5, utf8_decode("* Realizar revisiones periódicas del inventario para garantizar su precisión y actualización constante."), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode("* Implementar un sistema de seguimiento más eficiente para los dispositivos recién ingresados y aquellos con garantías vigentes."), 0, 'J', 0);
        $this->SetFont('times', 'B', 12);
        $this->Cell(0, 9.5, utf8_decode("2.- Enfoque Estratégico en Marcas y Modelos:"), 0, 0, 'L',);
        $this->Ln();
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 9.5, utf8_decode("* Considerar una evaluación más detallada de las marcas y modelos de dispositivos, especialmente aquellos que muestran mayor presencia en el inventario."), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode("* Explorar acuerdos con proveedores preferenciales para dispositivos de mayor rendimiento y durabilidad."), 0, 'J', 0);
        $this->SetFont('times', 'B', 12);
        $this->Cell(0, 9.5, utf8_decode("3.- Mejora en el Seguimiento de Ubicación:"), 0, 0, 'L',);
        $this->Ln();
        $this->SetFont('times', '', 12);
        $this->MultiCell(0, 9.5, utf8_decode("* Reforzar el seguimiento de la ubicación de los dispositivos, especialmente aquellos listos para ser asignados, obsoletos, descartables o en taller."), 0, 'J', 0);
        $this->MultiCell(0, 9.5, utf8_decode("* Adoptar tecnologías de seguimiento avanzadas para optimizar la gestión de activos."), 0, 'J', 0);
       
        $this->AddPage();
        $this->pageNumberWithHeader++;
        $this->SetFont('times', 'B', 14);
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
        $this->Ln();
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
        $this->AddPage();
        $this->pageNumberWithHeader++;
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


        $this->SetTitle(utf8_decode("Informe de Computadoras"));

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
$nombreArchivo = "InformeComputadoras" . $timestamp . ".pdf";
$pdfPath = "" . $nombreArchivo;

$pdf->Output($pdfPath, 'I');
// Accede a los elementos del array
// var_dump($alturaPag);
