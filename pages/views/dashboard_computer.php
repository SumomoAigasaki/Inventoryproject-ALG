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
                            <h3><span id="cRams">00</span></h3>

                            <p>RAMS</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-memory"></i>
                        </div>
                        <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modal-xl-Rams">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box" style="background-color: #145A2A; color: white;">
                        <div class="inner">
                            <h3><span id="cCpu">000</span></h3>

                            <p>CPU</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modal-xl-CPU">Más Información <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box " style="background-color: #132C48; color: white;">
                        <div class="inner">
                            <h3><span id="rDisco">0</span></h3>

                            <p>Unidades de Almacenamiento <b>Discos Duros</b></p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-hdd"></i>
                        </div>
                        <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modal-xl-Disk">Más Información<i class="fas fa-arrow-circle-right"></i></a>
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
                                    $stmt = $conn->query("CALL sp_filterYearsComputer()");
                                    while ($row = $stmt->fetch_assoc()) {
                                        $year = $row['Acquisition_Date'];
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
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Grafica de Barras- Resumen Mensual : Dispositivos Laptops y Escritorio</h3>
                                <a href="" data-toggle="modal" data-target="#modal-xl-LineBar">Más Información</a>
                            </div>
                        </div>
                        <div class="card-body" style="max-height: 350px; overflow: hidden;">
                            <div class="embed-responsive embed-responsive-16by9">
                                <canvas id="lineBar" class="embed-responsive-item" style="max-height: 300px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Gráfico de Pastel: Distribución de Registros de Marcas en Equipos de Escritorio</h3>
                                <a href="" data-toggle="modal" data-target="#modal-xl-PastelEscritorio">Más Información</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="pieChartDesktop" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Gráfico de Pastel: Distribución de Registros de Marcas en Equipos de Laptop</h3>
                                <a href="" data-toggle="modal" data-target="#modal-xl-PastelLaptop">Más Información</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="pieChartLaptop" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Gráfico de Dispersión - Conteo de Computadoras por Localizacion</h3>
                                <a href="" data-toggle="modal" data-target="#modal-xl-ScatterLocation">Más Información</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="scatterChartLocation" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
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
            var enlacePDF = "../views/DashboardComputerPDF.php?year=" + yearSeleccionado;

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
                            <th>Fecha de Adquisicion</th>
                            <th>Nombre de Dispositivo</th>
                            <th>Marca&Modelo</th>
                            <th>Tipo de Garantia</th>
                            <th>Estado</th>
                            <th>Usuario</th>
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

<!-- Modal de lista de RAM-->
<div class="modal fade" id="modal-xl-Rams">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Registros de Dispositivos y RAM's (<span id="mRams">datos</span>)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha Adquision</th>
                            <th>Nombre de Dispositivo</th>
                            <th>Especificacion</th>
                            <th>Marca & Modelo</th>
                            <th>Tipo de Garantia</th>
                            <th>Localizacion</th>
                            <th>Estado</th>
                            <th>Usuario</th>
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

<!-- Modal de lista de Registros CPU-->
<div class="modal fade" id="modal-xl-CPU">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Registros de Dispositivos y CPU's(<span id="mCpu">datos</span>)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha Adquision</th>
                            <th>Nombre de Dispositivo</th>
                            <th>Especificacion</th>
                            <th>Marca & Modelo</th>
                            <th>Tipo de Garantia</th>
                            <th>Localizacion</th>
                            <th>Estado</th>
                            <th>Usuario</th>
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

<!-- Modal de lista de Registros DISCO-->
<div class="modal fade" id="modal-xl-Disk">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Registros de Dispositivos y Discos Duros (<span id="mDisk">datos</span>)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha Adquision</th>
                            <th>Nombre de Dispositivo</th>
                            <th>Especificacion</th>
                            <th>Marca & Modelo</th>
                            <th>Tipo de Garantia</th>
                            <th>Localizacion</th>
                            <th>Estado</th>
                            <th>Usuario</th>
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
                <h4 class="modal-title">Reporte de Grafica Lineal- Resumen Mensual : Resumen Mensual : Dispositivos Laptops y Escritorio (<span id="dataCountLinel">datos</span>) </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha Adquisicion</th>
                            <th>Nombre de Dispositivo</th>
                            <th>Tipo de Dispositivo</th>
                            <th>Modelo</th>
                            <th>Sevitag</th>
                            <th>Especificaciones</th>
                            <th>Estado</th>
                            <th>Usuario</th>
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
<!-- Modal de lista de Gráfico de Pastel: Distribución de Registros Escritorio-->
<div class="modal fade" id="modal-xl-PastelEscritorio">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reporte de Distribución de Registros de Marcas en Equipos de Escritorio(<span id="dataCountPie">datos</span>) </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha de Adquisicion</th>
                            <th>Nombre de Dispositivo</th>
                            <th>Modelo</th>
                            <th>Especificaciones</th>
                            <th>Estado</th>
                            <th>Usuario</th>
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
<!-- Modal de lista de Gráfico de Pastel: Distribución de Registros Laptos-->
<div class="modal fade" id="modal-xl-PastelLaptop">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reporte de Distribución de Registros de Marcas en Equipos de Escritorio(<span id="dataCountPieLaptos">datos</span>) </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha de Adquisicion</th>
                            <th>Nombre de Dispositivo</th>
                            <th>Modelo</th>
                            <th>Especificaciones</th>
                            <th>Estado</th>
                            <th>Usuario</th>
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
<div class="modal fade" id="modal-xl-ScatterLocation">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reporte de Cantidad de Computadoras por Localizacion(<span id="dataCountScatter">datos</span>) </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha de Adquisicion</th>
                            <th>Nombre Tecnico Pc</th>
                            <th>Tipo de Equipo</th>
                            <th>Localizacion</th>
                            <th>Modelo</th>
                            <th>Especificaciones</th>
                            <th>Estado</th>
                            <th>Usuario</th>
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






<?php
require_once "../templates/footer.php";
?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
<!-- Filesaver -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script>
    document.getElementById('downloadImages').addEventListener('click', function() {
        saveChartOnServer('lineBar', 'graficoBarra.png');
        saveChartOnServer('pieChartDesktop', 'graficoPastelEscritorio.png');
        saveChartOnServer('pieChartLaptop', 'graficoPastelLaptos.png');
        saveChartOnServer('scatterChartLocation', 'graficoDispersion.png');

    });

    function saveChartOnServer(chartId, fileName) {
        var chartCanvas = document.getElementById(chartId).toDataURL('image/png');

        // Enviar los datos de la imagen al servidor usando AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../models/savedImageDashboardComputer.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log('Imagen guardada en el servidor: ' + fileName);
            }
        };
        xhr.send('image=' + encodeURIComponent(chartCanvas) + '&filename=' + fileName);
    }
</script>



<script src="../js/pages/dashboardComputer.js"></script>