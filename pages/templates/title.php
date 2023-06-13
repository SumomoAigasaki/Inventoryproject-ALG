<?php
require_once "menu.php";

//validaremos si tiene el permiso de SFT para agg al formulario de software
$arrayAdd = array();
$arrayUpdate = array();

if (isset($privilegios["User"])) {
    $arrayAdd[] = "../views/insert_user.php";
    $arrayUpdate = "../views/update_user.php";
} else if (isset($privilegios["CMP"])) {
    $arrayAdd = "../views/insert_computer.php";
    $arrayUpdate = "../views/update_computer.php";
}



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
                            <?php
                            if (isset($privilegios["User"])) {
                                // Buscar el índice del valor "../views/insert_user.php" en $arrayAdd
                                $indice = array_search("../views/insert_user.php", $arrayAdd);

                                // Crear el botón si se encuentra en $arrayAdd
                                if ($indice !== false) {
                                    $ruta = $arrayAdd[$indice];
                                    echo "<a href=\"$ruta\"><button>Añadir usuario</button></a>";
                                }
                            }
                            ?>
                            </button>
                        </div>
                        <!--  -->

                        <!-- /.modal-dialog -->
                </div>
                </ol>
            </div>

            <!-- /.modal -->
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


<!-- Main content -->
<section class="content">
    <div class="container-fluid">