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

                    <div class="btn-group">
                        <button type="button" id="downloadImages" class="btn btn-outline-dark dropdown-toggle " data-toggle="dropdown"> <i class="far fa-file"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#"><ion-icon name="print-outline"></ion-icon>Imprimir</a>
                            <a class="dropdown-item" href="#"><i class="fa fa-file-pdf"></i> PDF</a>
                        </div>
                    </div>

                    <!-- <div class="btn-group">
                        <button type="button" class="btn btn-outline-dark dropdown-toggle " data-toggle="dropdown"> <ion-icon name="download-outline"></ion-icon>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#"><i class="fas fa-file-csv"></i> CSV</a>
                            <a class="dropdown-item" href="#"><i class="far fa-file-excel"></i> XLSX</a>
                        </div>
                    </div> -->
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
                            <h3><span id="rNuevos">datos</span></h3>
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

            <!-- Grafica Lineal -->
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Grafica Lineal- Resumen Mensual : Dispositivos con Garantía Activa y Próxima a Vencer</h3>
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
                <h4 class="modal-title">Registros con Cobertura Asignados (<span id="mNonCoverage">datos</span>)</h4>
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





<?php
require_once "../templates/footer.php";
?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
<!-- Filesaver -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<!-- <script>
   document.getElementById('downloadImages').addEventListener('click', function() {
    saveChartOnServer('lineBar', 'nombre_grafico_1.png');
    saveChartOnServer('scatterChart', 'nombre_grafico_2.png');
    saveChartOnServer('pieChart', 'nombre_grafico_3.png');
});

function saveChartOnServer(chartId, fileName) {
    var chartCanvas = document.getElementById(chartId).toDataURL('image/png');

    // Enviar los datos de la imagen al servidor usando AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../models/savedImageDashW.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log('Imagen guardada en el servidor');
        }
    };
    xhr.send('image=' + encodeURIComponent(chartCanvas) + '&filename=' + fileName);
}
</script> -->
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
<!-- <script src="../js/pages/dashboardWarranty.js"></script> -->
<script src="../js/pages/index.js"></script>