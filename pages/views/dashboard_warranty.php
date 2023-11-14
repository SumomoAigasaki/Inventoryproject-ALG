<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";
?> 
<div class="content-wrapper">

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-1">
            <div class="col-sm-4">
                <h1><?php echo $pageName; ?></h1>
            </div>
            <div class="col-sm-4">
                <!--cinta de home y el nombre de la pagina -->
                <ol class="breadcrumb float-sm-right">
                    <div class="btn-group" class="col-sm-4">
                        <!--botones  de agregar  -->
                        <?php
                        if ($PermisoPRL) {
                            // Agregar la ruta al array $arrayAdd
                            $ruta = "../views/view_peripherals.php";
                            $arrayAdd[] = $ruta;

                            // Crear el botón con la ruta almacenada en la variable
                            echo "<a href=\"$ruta\"><button button type='button' class='btn btn-block btn-info'></i><span class='fa fa-arrow-circle-left'></span>   Volver</button></a>";
                        }
                        ?>
                        </button>
                    </div>
                    <!--  -->

                </ol> <!-- /.modal-dialog -->
            </div>


            <div class="col-sm-4">
                <!--cinta de home y el nombre de la pagina -->
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo $pageLink; ?>">
                            <?php echo $sectionName; ?>
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