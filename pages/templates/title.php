<?php
require_once "menu.php";
?>
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
                        <button type="button" class="btn btn-success dropdown-toggle"  data-toggle="modal" data-target=".bd-example-modal-lg" title="Agegar Nuevos (as)">
                            <span class="fa fa-plus"></span>
                        </button>
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
                <a class="btn btn-app" href="<?php echo BASE_URL?>pages/views/computer.php">
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
<!-- /.modal -->

<section class="content">
    <div class="container-fluid">