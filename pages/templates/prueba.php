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
    <title><?php echo $pageName;
            echo nameWeb; ?></title>
    <!-- Archivos Base para el Dashboard -->
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../public/css/base/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../../public/css/base/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../../public/css/base/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../../public/css/base/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../public/css/base/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../../public/css/base/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../../public/css/base/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../../public/css/base/summernote-bs4.min.css">
    <!-- ./Archivos Base para el Dashboard -->
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="../../public/css/ekko-lightbox/ekko-lightbox.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../public/css/toastr.min.css">
    <!-- Agrega jQuery y jQuery UI a tu página -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <!-- daterange picker -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="../../public/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../public/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../public/css/buttons.bootstrap4.min.css">
    <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../../public/css/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
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
        <!-- /.navbar -->


        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index.php" class="brand-link">
                <img src="../../public/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"> <?php echo nameProject; ?> </span>
            </a>
            <!-- Sidebar detecta -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <?php
                        $ImgProfile = $_SESSION["User_img"];
                        if (empty($ImgProfile) || $ImgProfile == "/resources/User/") {
                            // La variable está vacía
                            $ImgProfile = "/resources/User/default.png";
                        }
                        ?>
                        <img src="../../<?php echo $ImgProfile ?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            <?php echo  $_SESSION["User_Username"];
                            ?>
                        </a>
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
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>Dashboard </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Computadoras por area</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Computadoras Ingresadas recientemente</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Garantia vigentes</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="../views/explorer.php" class="nav-link">
                                <i class="nav-icon fas fa-folder-open"></i>
                                <p>Master Data </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Software</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Perifericos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Colaboradores</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="../views/explorer.php" class="nav-link">
                                <i class="nav-icon fa fa-database"></i>
                                <p> Transaction </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="../views/view_computer.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Computadoras</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Asignar PC</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Garantia</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon  fa fa-shield-alt"></i>
                                <p>Security </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Usuario</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="../templates/SignOff.php" class="nav-link">
                                <i class="nav-icon   fas fa-arrow-right"></i>
                                <!--<i class="fa-solid fa-arrow-right-from-bracket"></i> -->
                                <p>Cerrar Sesion </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../views/explorer.php" class="nav-link">
                                <i class="nav-icon fas fa-globe"></i>
                                <p>Explorar </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!--- NAV-->
        <!-- ---------------------------------------------------------------------------- -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <h1><?php echo $pageName; ?></h1>
                        </div>
                        <div class="col-sm-2">
                            <!--cinta donde va el boton de + -->
                            <ol class="breadcrumb float-sm-left">
                                <div class="btn-group" class="col-sm-3">
                                    <!--botones  de agregar  -->
                                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="modal" data-target=".bd-example-modal-lg" title="Agegar Nuevos (as)">
                                        <span class="fa fa-plus"></span>
                                    </button>
                                </div>
                                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" style="text-align:center">Crear Nuevos</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <!-- pages/views/computer.php -->
                                                <a class="btn btn-app" href="../views/computer.php">
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
                                                    <i class="fa fa-mouse"></i>Perifericos
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
                            </ol>
                        </div><!-- /.modal -->
                        <div class="col-sm-4">
                            <!--cinta de home y el nombre de la pagina -->
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo $pageLink; ?>">
                                        <?php echo $pageName; ?>
                                    </a></li>
                                <li class="breadcrumb-item active">
                                    <?php echo nameProject; ?>
                                </li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div> <!-- /.container-fluid -->
            </section><!-- /.content-header-->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- -------------------------------------------------------------------------------------- -->
                    <?php function dataTableComputer($stmt)
                    {
                        while ($row = $stmt->fetch_assoc()) {
                            echo "
                                <tr> 
                                <td>" . $row['CMP_idTbl_Computer'] . "</td>
                                <td>" . $row['CMP_Inventory_Date'] . "</td>
                                <td>" . $row['MFC_Description'] . "</td>
                                ";
                            if (empty($row['CMP_Image'])) {
                                echo "<td> <li class='list-inline-item'>
                                <img alt='Avatar' width='50' height='50'  class='table-avatar  img-circle' src='../../resources/Computer/default.jpg ' >         
                                </li></td>";
                            } else {
                                echo "<td> <li class='list-inline-item'>
                                <img alt='Avatar' width='50' height='50'  class='table-avatar  img-circle' src='../.." . $row['CMP_Image'] . " ' >         
                                </li></td>";
                            }
                            echo "
                                <td>" . $row['CMP_Technical_Name'] . "</td>
                                <td>" . $row['MDL_Description'] . "</td>
                                <td>" . $row['CT_Description'] . "</td>
                                <td>" . $row['CMP_Servitag'] . "</td>
                                <td>" . $row['CMP_License'] . "</td>
                                <td>" . $row['CMP_Motherboard'] . "</td>
                                <td>" . $row['CMP_Acquisition_Date'] . "</td>
                                <td>" . $row['CMP_Warranty_Expiration'] . "</td>
                                <td>" . $row['TG_Description'] . "</td>
                                <td>" . $row['CMP_Warranty_Year'] . "</td>
                                <td>" . $row['STS_Description'] . "</td>
                                <td>" . $row['LCT_Description'] . "</td>
                                <td>" . $row['CMP_Observations'] . "</td>
                                <td>" . $row['CMP_Report'] . "</td>
                                <td>" . $row['User_Username'] . "</td>
                                <td align='center'>";

                            // Verificamos si tiene permiso para actualizar
                            if (isset($_SESSION["U-CMP"]) && $_SESSION["U-CMP"]) {
                                echo '<a href="../views/uComputer.php?p=' . $row['CMP_idTbl_Computer'] . '" class="btn btn-outline-primary btn-sm" title="Editar Registro"><i class="fas fa-pencil-alt"></i></a>';
                            } else {
                                echo '';
                            }

                            if (isset($_SESSION["D-CMP"]) && $_SESSION["D-CMP"]) {
                                echo '<button class="btn btn-outline-danger btn-sm btnDeleteCMP"  title="Eliminar Registro" name="btnDeleteCMP" id="btnDeleteCMP" data-id="' . $row['CMP_idTbl_Computer'] . '"><i class="fas fa-trash-alt"></i></button> </td>';
                            } else {
                                echo '';
                            }

                            echo "</tr>";
                        }
                    } ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <!-- contenido para la el datatable 1-->
                                <div class="card-header">
                                    <h3 class="card-title">Listado General de Computadoras del sistema <?php echo nameProject; ?> </h3>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha Inventario</th>
                                                <th>Marca</th>
                                                <th>Imagen</th>
                                                <th>Nomb. Tecnico</th>
                                                <th>Modelo</th>
                                                <th>Tipo PC</th>
                                                <th>Serial</th>
                                                <th>Licencia</th>
                                                <th>Motherboard</th>
                                                <th>Fecha Adquisición</th>
                                                <th>Fecha Limite Garantia</th>
                                                <th>Tipo Garantia</th>
                                                <th>Año limite Garantia</th>
                                                <th>Estado</th>
                                                <th>Localizacion</th>
                                                <th>Observaciones</th>
                                                <th>Imagen de Reporte</th>
                                                <th>Usuario</th>
                                                <th>Opciones</th>

                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php

                                            // Validar permiso VR-CMP
                                            $permisoVRCMP = isset($_SESSION["VR-CMP"]) && $_SESSION["VR-CMP"];

                                            // Validar permiso VA-CMP
                                            $permisoVACMP = isset($_SESSION["VA-CMP"]) && $_SESSION["VA-CMP"];

                                            //Valido si tiene el permiso de ver todos los registros 
                                            if ($permisoVRCMP) {
                                                $stmt = $conn->query("CALL sp_selectAllComputers()");
                                                // Ejecutar el procedimiento almacenado
                                                // Obtener todos los resultados
                                                dataTableComputer($stmt);
                                                $stmt->close();
                                                $conn->next_result();
                                            }
                                            //Registros solo Activos 
                                            else if ($permisoVACMP) {
                                                $stmt = $conn->query("CALL sp_selectActiveComputers()");
                                                // Ejecutar el procedimiento almacenado
                                                // Obtener todos los resultados
                                                dataTableComputer($stmt);
                                                $stmt->close();
                                                $conn->next_result();
                                            }
                                            //si tiene ambos permisos


                                            else if ($permisoVRCMP && $permisoVACMP) {
                                                $stmt = $conn->query("CALL sp_selectAllComputers()");
                                                // Ejecutar el procedimiento almacenado
                                                // Obtener todos los resultados
                                                dataTableComputer($stmt);

                                                $stmt->close();
                                                $conn->next_result();
                                            }
                                            //si no tiene ninguno
                                            else {
                                                // Al menos uno de los permisos no está activo;
                                            }
                                            ?>
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha Inventario</th>
                                                <th>Marca</th>
                                                <th>Imagen</th>
                                                <th>Nomb. Tecnico</th>
                                                <th>Modelo</th>
                                                <th>Tipo PC</th>
                                                <th>Serial</th>
                                                <th>Licencia</th>
                                                <th>Motherboard</th>
                                                <th>Fecha Adquisición</th>
                                                <th>Fecha Limite Garantia</th>
                                                <th>Tipo Garantia</th>
                                                <th>Año limite Garantia</th>
                                                <th>Estado</th>
                                                <th>Localizacion</th>
                                                <th>Observaciones</th>
                                                <th>Imagen de Reporte</th>
                                                <th>Usuario</th>
                                                <th>Opciones</th>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <script>
                        $(function() {
                            var table = $("#example1").DataTable({
                                "stateSave": true,
                                "responsive": true,
                                "searching": true,
                                "lengthChange": false,
                                "autoWidth": false,
                                dom: 'Bfrtip',

                                "columnDefs": [{
                                    "targets": [18], // Ajusta el índice según la columna de 'Opciones' en tu DataTable
                                    "createdCell": function(td, cellData, rowData, row, col) {
                                        var Estado = rowData[14]; // Ajusta el índice según la columna del estado en tu DataTable

                                        // Deshabilitar eventos en las filas con estado 'Inactivo'
                                        if (Estado === 'Inactivo(a)') {
                                            $(td).find('a').off('click').addClass('disabled');
                                            $(td).find('button').off('click').prop('disabled', true).addClass('disabled');
                                        }
                                    }
                                }],

                                "buttons": [{


                                    extend: 'colvis',
                                    text: '<i class="fas fa-eye"></i>',
                                    titleAttr: 'Habilitar',
                                    className: 'btn btn-info'
                                }]
                            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


                        });

                        $('#example1').on('click', 'button.btnDeleteCMP', function() {
                            var id = $(this).data('id');

                            // Mostrar Sweet Alert
                            Swal.fire({
                                title: "Eliminar registro",
                                text: "¿Estás seguro de eliminar este registro?",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Si, Quier Elimnarlo!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire("Registro eliminado",
                                        "El registro ha sido eliminado correctamente",
                                        "success");


                                }
                            })

                        });
                    </script>

                    <!-- ----------------------------------------------------------------------------------------------- -->
                </div>
                <!-- /.content-wrapper -->

            </section>
            <!-- /.content -->
        
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 0.1
            </div>
            <strong>Copyright &copy; 2022-2023 <a href="https://productoresdeazucarhonduras.com/ingenios/compania-azucarera-la-grecia/">.<?php echo companyName; ?></a>.</strong>All rights reserved.
        </footer>
       

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div><!-- ./wrapper -->
    </div>
        <!-- /.content-wrapper -->
    <!-- SWEETALERT -->
    <script src='../../public/js/sweetalert2/sweetalert2.min.js'></script>

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
    <!-- Ekko Lightbox -->
    <script src="../../public/css/ekko-lightbox/ekko-lightbox.min.js"></script>

</body>
</html>