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
        <!-- /.container-fluid -->
    </div>


    <section class="content">
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

            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Grafica Lineal- Gráfico de Tendencia: Estado de Dispositivos por Vigencia de Garantía</h3>
                                <!-- <a href="javascript:void(0);">View Report</a> -->
                            </div>
                        </div>
                        <div class="card-body">
                            <!--  <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">820</span>
                                    <span>Visitors Over Time</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                        <i class="fas fa-arrow-up"></i> 12.5%
                                    </span>
                                    <span class="text-muted">Since last week</span>
                                </p>
                            </div>

                            <div class="position-relative mb-4">
                                <canvas id="visitors-chart" height="200"></canvas>
                            </div>-->

                            <div class="position-relative mb-4" id="">
                                <canvas id="lineBar" height="85"></canvas>
                            </div>
                            <!-- <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> This Week
                                </span>

                                <span>
                                    <i class="fas fa-square text-gray"></i> Last Week
                                </span>
                            </div>  -->
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
                                <a href="" data-toggle="modal" data-target="#modal-xl-Scatter">Vista de Reporte</a>
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
                                <h3 class="card-title">Grafica Pastel-Cantidad de registros con tipo de garantía</h3>
                                <a href="" data-toggle="modal" data-target="#modal-xl-Pastel">Vista de Reporte</a>
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
                <h4 class="modal-title">Registros Nuevos</h4>
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

<!-- Modal de lista de con Cobertura Sin Asignar-->
<div class="modal fade" id="modal-xl-Coverage">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Registros con Cobertura Sin Asignar (FULL)</h4>
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
                <h4 class="modal-title">Registros con Cobertura Asignados</h4>
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
                <h4 class="modal-title">Registros prox. Vencer Activos y Circulando</h4>
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

<!-- Modal de lista deGrafica Pastel-Cantidad de registros con tipo de garantía-->
<div class="modal fade" id="modal-xl-Pastel">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reporte de Cantidad de registros con tipo de garantía </h4>
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

<!-- Modal de lista d eGrafica Dispersion Cantidad de Computadoras ubicadas por Gerencia-->
<div class="modal fade" id="modal-xl-Scatter">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reporte de Cantidad de Computadoras ubicadas por Gerencia </h4>
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
                            <th>Nombre Colaborador</th>
                            <th>Nombre Tecnico Pc</th>
                            <th>Gerencia</th>
                            <th>Proceso</th>
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


<!-- <script>
  $.widget.bridge('uibutton', $.ui.button)
</script> -->
<!-- archivo donde obtiene los datos de algunos charts -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="../js/pages/dashboardWarranty.js"></script> -->
<script src="../js/pages/index.js"></script>