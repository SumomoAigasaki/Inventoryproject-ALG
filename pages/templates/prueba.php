<?php
require_once "../../includes/conecta.php";
require_once "../../includes/constantes.php";
include "../models/user_search.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $pageName; echo nameWeb; ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../public/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../../public/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../../public/css/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../../public/css/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../public/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../../public/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../../public/css/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../../public/css/summernote-bs4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../public/css/toastr.min.css">
    <!-- Agrega jQuery y jQuery UI a tu página -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <!-- daterange picker -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../templates/index.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- Main Sidebar Container menu -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index.php" class="brand-link">
                <img src="../../public/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"> <?php echo nameProject; ?> </span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../../public/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"> <?php echo  $_SESSION["User_Username"];?></a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <li class="nav-item ">
                            <a href="../views/explorer.php" class="nav-link">
                                <i class="nav-icon fas fa-globe"></i>
                                <p>Explorar </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>Reportes </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon   fas  fa-crown"></i>
                                <p>Privilegios </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="../templates/SignOff.php" class="nav-link">
                                <i class="nav-icon   fas fa-arrow-right"></i>
                                <!--<i class="fa-solid fa-arrow-right-from-bracket"></i> -->
                                <p>Cerrar Sesion </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.nav -->
            </div>
            <!-- /.div -->
        </aside>
         <!-- /.aside -->

        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1><?php echo $pageName; ?></h1>
                        </div>
                        <div class="col-sm-3">
                            <!--cinta de home y el nombre de la pagina -->
                            <ol class="breadcrumb float-sm-right">
                                <div class="btn-group" class="col-sm-3">
                                    <!--botones  de agregar  -->
                                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="modal" data-target="#modal-default" title="Crear Bienes">
                                        <span class="fa fa-plus"></span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" class="btn btn-default" >Agregar Nuevos (as) </a>
                                    </div>
                                </div>
                            </ol>
                        </div>
                        <div class="col-sm-3">
                            <!--cinta de home y el nombre de la pagina -->
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo $pageLink; ?>">
                                        <?php echo $pageName; ?>
                                    </a></li>
                                <li class="breadcrumb-item active">
                                    <?php echo nameProject; ?>
                                </li>
                            </ol>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                </div>
            </section>


            <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" style="text-align:center">Crear Nuevos</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <!-- pages/views/computer.php -->
                            <a class="btn btn-app" href="<?php echo BASE_URL ?>pages/views/computer.php">
                                <i class="fas fa-desktop"></i> Computadoras
                            </a>

                            <a class="btn btn-app" style="Margin:0px,0px,50px,50px;">
                                <i class="fab fa-uncharted"></i> Software
                            </a>

                            <a class="btn btn-app" href="../views/user.php">
                                <i class="fas fa-user-plus"></i> Usuario
                            </a>

                            <a class="btn btn-app" style="Margin:0px,0px,50px,50px;">
                                <i class="fas fa-laptop"></i> Asignar Pc
                            </a>

                            <a class="btn btn-app" style="Margin:0px,0px,50px,50px;">
                                <i class="fas fa-certificate"></i> Garantia
                            </a>
                        </div>

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <section class="content">
                <div class="container-fluid">
                    <section class="content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-primary card-outline card-tabs">
                                    <div class="card-header">
                                        <h3 class="card-title">Formulario para Registrar Computadoras</h3>
                                    </div>

                                    <!-- form start -->
                                    <form role="form" action="computer.php" method="POST" name="formInsertCMP" id="formInsertCMP" class="form-horizontal">
                                        <div class="card-body">
                                            <label class="form-check-label" for="exampleCheck2" style="padding-bottom: 5px;"> A continuación se le pedirá que <b> Ingrese</b> los siguientes datos:</label>
                                            <!-- Input ocultos  -->
                                            <input type="hidden" class="form-control" id="todayDate" name="todayDate" placeholder="<?php echo $todayDate ?>">
                                            <input type="hidden" class="form-control" id="accion" name="accion" placeholder="">
                                            <div class="row" style="padding-top:10px; padding-bottom:10px;">
                                                <!-- Fecha de Compra -->
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Fecha de Compra:</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control datepicker-input" name="acquisitionDate" id="acquisitionDate">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- MARCA -->
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label>Marca: </label>
                                                        <?php
                                                        #Se procede a llamar al procedimiento almacenado que se llama sp_manufacturer_select,con la variable que almancena "cnn" la base de datos 
                                                        $resultado = mysqli_query($conn, "CALL sp_manufacturer_select()"); ?>
                                                        <select class="form-control" id="manufacturerSelect" name="select_manufacturer" onchange="filtrarModelos()">
                                                            <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                                <option value="<?php echo $row['MFC_idTbl_Manufacturer']; ?>"><?php echo $row['MFC_Description']; ?></option>
                                                            <?php }
                                                            #NOTA
                                                            #CADA QUE QUIERA HACER UNA NUEVA CONSULTA CON PROCEDIMIENTOS ALMACENADOS ESTOS EL RESULTADO SE CIERRA Y LA VARIABLE DE LA CONECCION SE PREPARA PARA EL NUEVO RESULTADO
                                                            # QUE TENDRA ABAJO
                                                            $resultado->close();
                                                            $conn->next_result();
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- MODELOS  -->
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Modelo : </label>
                                                        <input type="text" id="lookModels" placeholder="Buscar modelo en especifico" class="form-control">
                                                        <?php $resultado = mysqli_query($conn, "CALL sp_model_select()"); ?>
                                                        <select class="form-control" id="modelSelect" name="select_model">
                                                            <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                                <option value="<?php echo $row['MDL_idTbl_Model']; ?>" data-manufacturer="<?php echo $row['MFC_idTbl_Manufacturer']; ?>"><?php echo $row['MDL_Description']; ?></option>
                                                            <?php }
                                                            #NOTA
                                                            #CADA QUE QUIERA HACER UNA NUEVA CONSULTA CON PROCEDIMIENTOS ALMACENADOS ESTOS EL RESULTADO SE CIERRA Y LA VARIABLE DE LA CONECCION SE PREPARA PARA EL NUEVO RESULTADO
                                                            # QUE TENDRA ABAJO
                                                            $resultado->close();
                                                            $conn->next_result();
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- TIPO DE COMPUTADORA -->
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Tipo de Computadora : </label>
                                                        <?php $resultado = mysqli_query($conn, "CALL sp_computerType_select()"); ?>
                                                        <select class="form-control" id="computerTypes" name="select_computerType">
                                                            <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                                <option value="<?php echo $row['CT_idTbl_Computer_Type']; ?>"><?php echo $row['CT_Description']; ?></option>
                                                            <?php }
                                                            #NOTA
                                                            #CADA QUE QUIERA HACER UNA NUEVA CONSULTA CON PROCEDIMIENTOS ALMACENADOS ESTOS EL RESULTADO SE CIERRA Y LA VARIABLE DE LA CONECCION SE PREPARA PARA EL NUEVO RESULTADO
                                                            # QUE TENDRA ABAJO
                                                            $resultado->close();
                                                            $conn->next_result();
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Comienzo fila 2 -->
                                            <div class="row" style="padding-bottom:10px;">
                                                <!-- Nombre Tecnico-->
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Nombre Técnico: </label>
                                                        <input type="text" class="form-control" name="txt_nombre" id="nombre" maxlength="45" value="<?php echo (isset($nombres) ? $nombres : ""); ?>" placeholder="ASSET2023-0#">
                                                    </div>
                                                </div>
                                                <!-- Servitag-->
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Servitag: </label>
                                                        <input type="text" class="form-control" name="txt_servitag" id="servitag" maxlength="45" value="<?php echo (isset($servitags) ? $servitags : ""); ?>" placeholder="FKCX???">
                                                    </div>
                                                </div>
                                                <!-- Fecha limite garantia -->
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Fecha Límite Garantía:</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control datepicker-input" name="warrantyExpiration" id="warrantyExpiration" onchange="actualizarAnio()">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Anho limite garantia -->
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Año Limite Garantía: </label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" min="2000" max="2050" name="yearExpiration" id="yearExpiration" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Comienzo fila 3 -->
                                            <div class="row" style="padding-bottom:10px;">
                                                <!-- Lincencia -->
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Licencia: </label>
                                                        <input type="text" class="form-control" name="txt_licence" id="licence" maxlength="60" value="<?php echo (isset($licenses) ? $licenses : ""); ?>" placeholder="CMCDN-?????-?????-?????-?????">
                                                    </div>
                                                </div>
                                                <!-- Tarjeta Madre -->
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Tarjeta Madre: </label>
                                                        <input type="text" class="form-control" name="txt_motherboard" id="motherboard" maxlength="60" value="<?php echo (isset($motherboards) ? $motherboards : ""); ?>" placeholder="0W3XW5-A00">
                                                    </div>
                                                </div>
                                                <!-- Estado de la computadora  -->
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Estado del Computador: </label>
                                                        <?php $resultado = mysqli_query($conn, "CALL sp_status_select()"); ?>
                                                        <select class="form-control" id="status" name="select_statu">
                                                            <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                                <option value="<?php echo $row['STS_idTbl_Status']; ?>"><?php echo $row['STS_Description']; ?></option>
                                                            <?php }
                                                            #NOTA
                                                            #CADA QUE QUIERA HACER UNA NUEVA CONSULTA CON PROCEDIMIENTOS ALMACENADOS ESTOS EL RESULTADO SE CIERRA Y LA VARIABLE DE LA CONECCION SE PREPARA PARA EL NUEVO RESULTADO
                                                            # QUE TENDRA ABAJO
                                                            $resultado->close();
                                                            $conn->next_result();
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- Localizacion -->
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Localizacion del Computador : </label>
                                                        <?php $resultado = mysqli_query($conn, "CALL sp_location_select"); ?>
                                                        <select class="form-control" id="locations" name="select_location">
                                                            <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                                <option value="<?php echo $row['LCT_idTbl_Location']; ?>"><?php echo $row['LCT_Description']; ?></option>
                                                            <?php }
                                                            #NOTA
                                                            #CADA QUE QUIERA HACER UNA NUEVA CONSULTA CON PROCEDIMIENTOS ALMACENADOS ESTOS EL RESULTADO SE CIERRA Y LA VARIABLE DE LA CONECCION SE PREPARA PARA EL NUEVO RESULTADO
                                                            # QUE TENDRA ABAJO
                                                            $resultado->close();
                                                            $conn->next_result();
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Comienzo fila 4 -->
                                            <div class="row">
                                                <!-- IMAGEN -->
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label>Imagen: </label>
                                                        <input type="file" name="img_Comp" id="imageComp">
                                                        <input type="submit" value="Upload">
                                                    </div>
                                                </div>
                                                <!-- Observaciones -->
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Observaciones: </label>
                                                        <textarea type="text" class="form-control" name="txt_observation" id="observation" maxlength="100" value="<?php echo (isset($observations) ? $observations : ""); ?>"> </textarea>
                                                    </div>
                                                </div>
                                                <!-- Boton guardar -->
                                                <div class="col-sm-2" style="padding-top:40px;">
                                                    <button type="button" class="btn btn-block btn-info" id="buttonInsert" onclick='return validate_data();'>Guardar</button>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                            </div>
                                            <!-- /.card body -->
                                        </div>
                                        <!-- /.form-->
                                    </form>
                                    <!-- /.card card-primary card-outline -->

                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
            <script>
                function filtrarModelos() {
                    // Obtener el valor seleccionado en el primer select
                    var manufacturerSeleccionado = document.getElementById("manufacturerSelect").value;

                    // Obtener todos los options del segundo select
                    var opcionesModelos = document.getElementById("modelSelect").options;

                    // Obtenr el texto del segundo seletc
                    var contenidoModelo = document.getElementsByTagName("option");

                    // Recorrer todas las opciones y ocultar las que no pertenecen al fabricante seleccionado
                    for (var i = 1; i < opcionesModelos.length; i++) {
                        var modelo = opcionesModelos[i];
                        if (modelo.getAttribute("data-manufacturer") == manufacturerSeleccionado || manufacturerSeleccionado == "") {
                            modelo.style.display = "";
                        } else {
                            modelo.style.display = "none";
                        }
                    }

                    // Si no hay modelos disponibles para el fabricante seleccionado, mostrar un mensaje en el segundo select
                    if (document.querySelectorAll("#modelSelect option[style='display: none;']").length === opcionesModelos.length - 1) {
                        document.getElementById("modelSelect").innerHTML = "<option value=''>No hay modelos disponibles para este fabricante</option>";
                    }
                }

                $(function() {
                    $(".datepicker-input").datepicker({
                        dateFormat: "yy-mm-dd"
                    });
                });

                // Vincula el input de búsqueda con el select ded models 
                $(document).ready(function() {
                    $('#lookModels').on('keyup', function() {
                        var texto = $(this).val().toLowerCase();
                        $('#modelSelect option').filter(function() {
                            return $(this).text().toLowerCase().indexOf(texto) > -1;
                        }).prop('selected', true);
                    });
                });

                document.addEventListener('DOMContentLoaded', function() {
                    const formInsert = document.getElementById('formInsertCMP');
                    const btnInsert = document.getElementById('buttonInsert');
                    btnInsert.addEventListener('click', function() {
                        formInsert.reset();
                    });
                });
            </script>

            <!-- Copyright -->
            <footer class="text text-white" style="background-color: #fff;">
                <div class="text text-dark p-3" style="background-color: #fff;  padding: 1rem;color:#869099;">
                    <div class="float-right d-none d-sm-block" style="color:#869099;">
                        <b>Version</b> 1.0
                    </div>
                    <div style="color:#869099;">
                        <strong>Copyright &copy; 2022-2023 <a href="https://productoresdeazucarhonduras.com/ingenios/compania-azucarera-la-grecia/">.<?php echo companyName; ?></a>.</strong>
                        All rights reserved.
                    </div>

                </div>


                <aside class="control-sidebar control-sidebar-dark">
                    <!-- Control sidebar content goes here -->
                </aside>
                <!-- /.control-sidebar -->
        </div>

        <!-- jQuery -->
        <script src="../../public/js/jquery.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="../../public/js/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <!-- Bootstrap 4 -->
        <script src="../../public/js/bootstrap.bundle.min.js"></script>
        <!-- DataTables  & Plugins -->
        <script src="../../public/js/jquery.dataTables.min.js"></script>
        <script src="../../public/js/dataTables.bootstrap4.min.js"></script>
        <script src="../../public/js/dataTables.responsive.min.js"></script>
        <script src="../../public/js/responsive.bootstrap4.min.js"></script>
        <script src="../../public/js/dataTables.buttons.min.js"></script>
        <script src="../../public/js/buttons.bootstrap4.min.js"></script>
        <script src="../../public/js/jszip.min.js"></script>
        <script src="../../public/js/pdfmake.min.js"></script>
        <script src="../../public/js/vfs_fonts.js"></script>
        <script src="../../public/js/buttons.html5.min.js"></script>
        <script src="../../public/js/buttons.print.min.js"></script>
        <script src="../../public/js/buttons.colVis.min.js"></script>

        <!-- JQVMap -->
        <script src="../../public/js/jquery.vmap.min.js"></script>
        <script src="../../public/js/jquery.vmap.usa.js"></script>
        <!-- jQuery Knob Chart -->
        <script src="../../public/js/jquery.knob.min.js"></script>
        <!-- daterangepicker -->
        <script src="../../public/js/moment.min.js"></script>
        <script src="../../public/js/daterangepicker.js"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="../../public/js/tempusdominus-bootstrap-4.min.js"></script>
        <!-- Summernote -->
        <script src="../../public/js/summernote-bs4.min.js"></script>
        <!-- overlayScrollbars -->
        <script src="../../public/js/jquery.overlayScrollbars.min.js"></script>
        <!-- AdminLTE App -->
        <script src="../../public/js/adminlte.js"></script>

</body>

</html>