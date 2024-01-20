<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";

// Devolver los datos en formato JSON con codificación UTF-8
// echo json_encode($ArrayRecordsTypeGuarantee, JSON_UNESCAPED_UNICODE);
?>
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-1">
                <div class="col-sm-6">
                    <h1><?php echo $pageName; ?></h1>
                </div>
                <div class="col-sm-6">
                    <!--cinta de home y el nombre de la pagina -->
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="../templates/index.php">
                                Inicio
                            </a></li>
                        <li class="breadcrumb-item active">
                            <?php echo $pageName; ?>
                        </li>
                    </ol>
                    <!-- /.col -->
                </div>
            </div>
            <!-- /.row -->
        </div>

        <div class="container-fluid">
            <div class="row mb-1 justify-content-center">
                <div class="col-sm-4">
                </div>

                <div class="col-sm-4  text-center ">
                    <button type="button" id="downloadImages" class="btn btn-outline-dark ReportPDf"> <i class="fa fa-file-pdf"></i> PDF</a>
                    </button>
                </div>

                <div class="col-sm-4">
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>


    <section class=" content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box" style="background-color: #008000; color: white;">
                        <div class="inner">
                            <!-- -->
                            <h3><span id="rNuevos">00</span></h3>
                            <p> Registros Nuevos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modal-xl-newRegister">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box" style="background-color: #003F6D; color: white;">
                        <div class="inner">
                            <!-- <h3>53<sup style="font-size: 20px">%</sup></h3> -->
                            <h3><span id="rCoverage">00</span></h3>

                            <p>Registros con Cobertura Sin Asignar<b>(Full)</b></p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-signal"></i>
                        </div>
                        <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modal-xl-Coverage">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box" style="background-color: #145A2A; color: white;">
                        <div class="inner">
                            <h3><span id="rNonCoverage">000</span></h3>

                            <p>Registros sin Cobertura <b>(en uso)</b></p>
                        </div>
                        <div class="icon">
                            <i class="far fa-hand-point-up"></i>
                        </div>
                        <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modal-xl-Uncovered">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box " style="background-color: #132C48; color: white;">
                        <div class="inner">
                            <h3><span id="rUpcoming">0</span></h3>

                            <p>Registros prox. Vencer <b>(Act. o en Circula.)</b></p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-times"></i>
                        </div>
                        <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modal-xl-Expired">Más Información<i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- cinta de botones-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title m-0">Filtro para los Años de:</h3>
                                <div class="card-body justify-content-center d-flex flex-wrap">
                                    <?php
                                    // Preparar la llamada al procedimiento almacenado
                                    $stmt = $conn->query("CALL sp_filterYearsWarranty()");
                                    while ($row = $stmt->fetch_assoc()) {
                                        $year = $row['Warranty_Year'];
                                        echo "<button type='submit' class='btn btn-outline-success filtro-year'  style='margin-right: 5px;' name='year' value='$year' id='boton_$year'>$year</button>";
                                    }
                                    $stmt->close();
                                    $conn->next_result();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Grafica de Barras -->
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Grafica de Barras- Resumen Mensual : Dispositivos con Garantía Activa y Próxima a Vencer</h3>
                                <a href="" data-toggle="modal" data-target="#modal-xl-LineBar">Más Información</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="lineBar" style="max-height: 450px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Gráfico de Dispersión - Cantidad de Computadoras ubicadas por Gerencia</h3>
                                <a href="" data-toggle="modal" data-target="#modal-xl-Scatter">Más Información</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="scatterChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Gráfico de Pastel: Distribución de Registros por Tipo de Garantía</h3>
                                <a href="" data-toggle="modal" data-target="#modal-xl-Pastel">Más Información</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
</div>

<script>
    //Validacion para el boton del PDF
    $(document).ready(function() {
        $('.ReportPDf').on('click', function(event) {
            event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace

            // Obtener el año seleccionado desde localStorage
            var yearSeleccionado = localStorage.getItem('yearSeleccionado');

            // Crear el enlace con el valor de yearSeleccionado
            var enlacePDF = "../views/warrantyDashboardPDF.php?year=" + yearSeleccionado;

            // Redirigir a la página de PDF con el año en la URL
            // window.location.href = enlacePDF;
            // Abrir el PDF en una nueva ventana
            window.open(enlacePDF, '_blank');
        });
        //filtro para enviar los años al RQ
        $(".filtro-year").click(function() {
            var idBoton = $(this).attr('id');
            var yearSeleccionado = idBoton.split('_')[1];

            var yaSeleccionado = $(this).hasClass('seleccionado');

            if (!yaSeleccionado) {
                localStorage.removeItem('yearSeleccionado'); // Eliminar el año del almacenamiento local

                // Si el botón no estaba seleccionado, marcarlo como seleccionado
                $(".filtro-year").removeClass('seleccionado');
                $(this).addClass('seleccionado');
                localStorage.setItem('yearSeleccionado', yearSeleccionado);
                console.log('Año seleccionado enviado al servidor: ' + yearSeleccionado);

                // Recargar la página después de 2 segundos (2000 milisegundos)
                setTimeout(function() {
                    location.reload();
                }, 2000);
            }

        });
    });
</script>

<!-- Modal de lista de nuevos registros -->
<div class="modal fade" id="modal-xl-newRegister">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Registros Nuevos (<span id="mNuevos">datos</span>) </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha de Ingreso</th>
                            <th>Fecha Vencimiento Garantía</th>
                            <th>Nombre de Dispositivo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Tipo de Garantia</th>
                        </tr>
                    </thead>
                    <tbody>

                        <!-- Puedes agregar más filas según sea necesario -->
                    </tbody>
                </table>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>

<!-- Modal de lista de con Cobertura Sin Asignar-->
<div class="modal fade" id="modal-xl-Coverage">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Registros con Cobertura Sin Asignar (FULL) (<span id="mCoverage">datos</span>)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha Vencimiento Garantía</th>
                            <th>Nombre de Dispositivo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Tipo de Garantia</th>
                        </tr>
                    </thead>
                    <tbody>

                        <!-- Puedes agregar más filas según sea necesario -->
                    </tbody>
                </table>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>

<!-- Modal de lista de Registros con Cobertura Asignadosr-->
<div class="modal fade" id="modal-xl-Uncovered">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Registros sin Cobertura Asignados (<span id="mNonCoverage">datos</span>)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha de Asignacion</th>
                            <th>Fecha de Retorno</th>
                            <th>Nombre de Colaborador</th>
                            <th>Nombre de Dispositivo</th>
                            <th>Fecha Expiro Garantia</th>
                        </tr>
                    </thead>
                    <tbody>

                        <!-- Puedes agregar más filas según sea necesario -->
                    </tbody>
                </table>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>

<!-- Modal de lista de Registros prox. Vencer Activos y Circulando-->
<div class="modal fade" id="modal-xl-Expired">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Registros prox. Vencer Activos y Circulando (<span id="mUpcoming">datos</span>)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha Vencimiento Garantía</th>
                            <th>Estado</th>
                            <th>Nombre de Dispositivo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Tipo de Garantia</th>
                        </tr>
                    </thead>
                    <tbody>

                        <!-- Puedes agregar más filas según sea necesario -->
                    </tbody>
                </table>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>

<!-- Modal de lista de Grafica Lineal -->
<div class="modal fade" id="modal-xl-LineBar">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reporte de Grafica Lineal- Resumen Mensual : Dispositivos con Garantía Activa y Próxima a Vencer (<span id="dataCountLinel">datos</span>) </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha Vencimiento Garantía</th>
                            <th>Nombre de Dispositivo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Tipo de Garantia</th>
                        </tr>
                    </thead>
                    <tbody>

                        <!-- Puedes agregar más filas según sea necesario -->
                    </tbody>
                </table>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>

<!-- Modal de lista d eGrafica Dispersion Cantidad de Computadoras ubicadas por Gerencia-->
<div class="modal fade" id="modal-xl-Scatter">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reporte de Cantidad de Computadoras ubicadas por Gerencia (<span id="dataCountScatter">datos</span>) </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha de Asignación</th>
                            <th>Gerencia</th>
                            <th>Proceso</th>
                            <th>Nombre Colaborador</th>
                            <th>Nombre Tecnico Pc</th>

                        </tr>
                    </thead>
                    <tbody>

                        <!-- Puedes agregar más filas según sea necesario -->
                    </tbody>
                </table>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>

<!-- Modal de lista de Gráfico de Pastel: Distribución de Registros por Tipo de Garantía-->
<div class="modal fade" id="modal-xl-Pastel">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reporte de Distribución de Registros por Tipo de Garantía (<span id="dataCountPie">datos</span>) </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-footer justify-content-between">
                    <a data-toggle="modal" data-target="#modal-xl-informacion" style="color: #3494F9;">Leer Información de Tipos de Garantía</a>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha de Adquisicion</th>
                            <th>Tipo de Garantia</th>
                            <th>Nombre de Dispositivo</th>
                            <th>Servitag</th>
                            <th>Licensia</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Fecha Vencimiento Garantía</th>
                        </tr>
                    </thead>
                    <tbody>

                        <!-- Puedes agregar más filas según sea necesario -->
                    </tbody>
                </table>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>


<!-- Modal de Descripcion de Tipos de garantia-->
<div class="modal fade" id="modal-xl-informacion">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Información de los Tipos de Garantía </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Este espacio ha sido creado con el propósito de brindar explicaciones más detalladas sobre el alcance y cobertura de cada una de las garantías. Nuestra intención es proporcionar una comprensión exhaustiva de los beneficios y protecciones que ofrecen, asegurando así una experiencia informada y transparente para nuestros colaboradores.entre ellas tenemos:</p>
                <p><b>1. No Aplica:</b> Esta categoría de garantía indica que el dispositivo no cuenta con ninguna garantía vigente. En consecuencia, se considera un dispositivo sin cobertura.</p>
                <p><b>2.- Lenovo- Servicio de transporte o de entrega: </b> Cobertura de las piezas y de la mano de obra de reparación en la que el cliente es responsable del envío (incluido el embalaje) o la entrega a un proveedor de garantía o centro de reparación autorizado.</p>
                <p><b>3.- Recogida y devolución o recogida por mensajería: </b> Cobertura de las piezas y de la mano de obra de reparación en la que la mano de obra se proporciona in situ en su lugar de trabajo. Es posible que tenga que llevar el producto a un punto de envío, como por ejemplo una oficina de correos. El servicio de atención le informará de lo que debe hacer.</p>
                <p><b>4.- Lenovo- Servicio in situ: </b> Cobertura de las piezas y de la mano de obra de reparación en la que la mano de obra se proporciona in situ en su lugar de trabajo. <br> • Si Lenovo determina que el defecto o el problema del producto está cubierto por la garantía de producto y no se puede resolver por teléfono, se enviará a un técnico, normalmente al siguiente día laborable. <br>La ampliación de garantía in situ + instalación técnica de CRU (Piezas que el cliente puede sustituir) amplía su cobertura para incluir la instalación in situ por parte de un técnico de las piezas CRU.</p>
                <p><b>5.- Lenovo- Servicio de garantia internacional: </b> Cobertura de reparación de equipos diseñada para aquellos clientes que necesitan una reparación en garantía crítica durante sus viajes internacionales www.lenovo.com/internationalwarranty</p>
                <p><b>Nota:</b> Para obtener más información sobre la garantía de Lenovo, te invitamos a <a href="https://static.lenovo.com/shop/emea/content/pdf/services-warranty/personal/Warranty-Services_CB_EMEA_es.pdf" target="_blank">visitar la página oficial</a>.</p>
                <p><b>6.- Garantia Dell Basica: </b>Este nivel de servicio ofrece cobertura de soporte telefónico en horario laboral ante problemas de hardware, excluyendo fines de semana y festivos. El contatco 24x7x365 se da solamente via Internet mediante chat y correo electrónico. <br> Para obtener más información sobre esta garantía, te invitamos a leer <a href="https://i.dell.com/sites/csdocuments/Legal_Docs/en/us/basic-hardware-service-commercial-sd-en.pdf" target="_blank">PDF de la pagina oficial</a></p>
                <p><b>7.- Garantia Dell ProSupport</b> Un solo punto de contacto con acceso a expertos altamente cualificados las 24 horas del dia, los 7 dias de la semana, festivos incluidos. La cobertura, además de hardware, se da también sobre aplicaciones y sistemas operativos OEM de Dell. Tambien contempla: Desplazamiento de un técnico in situ o el envio de piezas de repuesto al domicilio comercial del cliente (dependiendo del tiempo de respuesta contratado) para realizar las reparaciones necesarias. En el caso de problemas comunes, este nivel de servicio da asistencia remota con la conexión a su equipo por parte de un técnico de Dell. Asistencia de configuración para la conexión a una red simple.
                    Acceso a foros de asistencia técnica en línea 24×7.<br> Para obtener más información sobre esta garantía, te invitamos a leer<a href="https://www.dell.com/es-es/dt/services/support-services/prosupport-client-suite.htm" target="_blank"> PDF de la pagina oficial</a></p>
                <p><b>8.-Garantia Dell Prosupport Plus</b> ProSupport Plus es asistencia a nivel empresarial diseñada para mejorar de manera dinámica el rendimiento y la estabilidad de sus sistemas críticos por medio de inteligencia ambiental y de la experiencia adecuada para su organización.
                    Se ha diseñado no solo para conseguir una recuperación más rápida de los problemas, sino también para ayudarle a adelantarse a ellos antes de que sucedan. Tendrá la libertad de adoptar tecnologías complejas con confianza, sabiendo que los mejores recursos de Dell estarán con usted en cada paso del camino. <br> Para saber mas sobre este servicio te invitamos a leer. <a href="https://i.dell.com/sites/csdocuments/Legal_Docs/en/us/dell-prosupport-plus-for-pcs-and-tablets-sd-en-amer.pdf" target="_blank"> PDF de la pagina de DELL</a></p>
                <p><b>Nota:</b> para un mejor entendimiento de las garantias se proporciona cuadro comparativo entre las 3 antes mencionadas <a href="https://iberiza.es/resources/pc-support-services-1.png" target="_blank">Ver imagen</a></p>
                <p><b>9.- Garantia HP Limitada </b> <br>
                    <b>10.- Periodo HP de Garantia Limitada</b>El periodo de Garantía Limitada para este producto de hardware de HP es de 3 años para piezas, 3 años de mano de obra, 3 años de servicio a domicilio. El periodo de Garantía Limitada comienza en la fecha de la compra o el arrendamiento a HP, o a partir de la fecha en que HP realiza la instalación El recibo de la compra o el albarán de entrega, que muestra la fecha de compra o arrendamiento del producto. <br> Para un mejor entendimiento te invitamos a leer <a href="http://h10032.www1.hp.com/ctg/Manual/c00729261" target="_blank">PDF HP </a>
                </p>
                <p><b>11.- Apple- Garantia Limitada de un (1) Año</b> Apple garantiza el producto de hardware y los accesorios marca Apple que están dentro del empaque original (“Producto Apple”) contra defectos de materiales y de mano de obra, cuando se usan habitualmente de acuerdo con las pautas publicadas de Apple, durante un período de UN (1) AÑO desde la fecha de compra original por el comprador usuario final (“Período de garantía”). <br>Te invitamos a leer los terminos de Garantía limitada de un (1) año, en la <a href="https://www.apple.com/legal/warranty/products/warranty-alac-spanish.html" target="_blank"> pagina oficial de APPLE</a> </p>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>



<?php
require_once "../templates/footer.php";
?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
<!-- Filesaver -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script>
    document.getElementById('downloadImages').addEventListener('click', function() {
        saveChartOnServer('lineBar', 'graficoBarra.png');
        saveChartOnServer('scatterChart', 'graficoDispersion.png');
        saveChartOnServer('pieChart', 'graficoPastel.png');
    });

    function saveChartOnServer(chartId, fileName) {
        var chartCanvas = document.getElementById(chartId).toDataURL('image/png');

        // Enviar los datos de la imagen al servidor usando AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../models/savedImageDashW.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log('Imagen guardada en el servidor: ' + fileName);
            }
        };
        xhr.send('image=' + encodeURIComponent(chartCanvas) + '&filename=' + fileName);
    }
</script>



<!-- <script>
  $.widget.bridge('uibutton', $.ui.button)
</script> -->
<!-- archivo donde obtiene los datos de algunos charts -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../js/pages/dashboardWarranty.js"></script>
<!-- <script src="../js/pages/index.js"></script> -->