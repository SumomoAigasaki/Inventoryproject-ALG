<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";

function dataTableWarranty($stmt)
{
    while ($row = $stmt->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['WR_idTbl_Warranty_Registration'] . "</td>";
        echo "<td>" . $row['WR_Date_Admission'] . "</td>";
        echo "<td>" . $row['WR_Application_Number'] . "</td>";

        echo "<td>" . $row['Info'] . "</td>";
        echo "<td>";

        if (empty($row['WR_Image_Problem'])) {
            echo "<li class='list-inline-item'>
                      <img alt='Avatar' width='50' height='50' class='table-avatar img-circle' src='../../resources/Warranty/DefaultProblem.jpg'>
                    </li>" . $row['WR_Main_Problem'];
        } else {
            echo "<li class='list-inline-item'>
                      <img alt='Avatar' width='50' height='50' class='table-avatar img-circle' src='../.." . $row['WR_Image_Problem'] . "'>
                    </li>   " . $row['WR_Main_Problem'];
        }
        echo "</td>";
        echo "<td>" . $row['WR_ActionsDone'] . "</td>";
        echo "<td>" . $row['WR_Diagnosis'] . "</td>";
        echo "<td>";

        if (empty($row['WR_Image_Solution'])) {
            echo "<li class='list-inline-item'>
                      <img alt='Avatar' width='50' height='50' class='table-avatar img-circle' src='../../resources/Warranty/computadoraMantenimiento.png'>
                    </li>  <p> No se ha ingreso solucion </p>";
        } else {
            echo "<li class='list-inline-item'>
                      <img alt='Avatar' width='50' height='50' class='table-avatar img-circle' src='../.." . $row['WR_Image_Solution'] . "'>
                    </li>   " . $row['WR_Solution'];
        }
        "</td>";
        echo "<td>" . $row['WR_Observation'] . "</td>";
        // Apartado para dar color a la parte del estado 
        echo "<td>";
        if ($row['STS_Description'] == "Espera") {
            echo "<span class='text-warning'><i class='fas fa-exclamation-triangle nav-icon'></i></span> ";
        } elseif ($row['STS_Description'] == 'Sin Respuesta') {
            echo "<span class='text-muted'><i class='fas fa-comment-slash nav-icon'></i></span> ";
        } elseif ($row['STS_Description'] == "Cancelado") {
            echo "<span class='text-danger'><i class='fas fa-ban nav-icon'></i></span> ";
        } elseif ($row['STS_Description'] == "Solucionado") {
            echo "<span class='text-success'><i class='fas fa-check nav-icon'></i></span> ";
        } elseif ($row['STS_Description'] == "Deshabilitado") {
            echo "<span class='text-maroon'><i class='fas fa-trash nav-icon'></i></span> ";
        }
        echo "" . $row['STS_Description']  . "</td>";
        echo "<td>" . $row['User_Username'] . "</td>";

        $WR_ActionsDone = $row['WR_ActionsDone'];
        $WR_Diagnosis = $row['WR_Diagnosis'];
        $WR_Solution = $row['WR_Solution'];
        $WR_Image_Solution = $row['WR_Image_Solution'];
        $WR_Date_Solution = $row['WR_Date_Solution'];


        $idWR = $row['WR_idTbl_Warranty_Registration'];

        echo "</tr>";
    }
}
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
    </div><!-- Termina la cinta del nav -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form id="deleteForm" method="POST" action="">
                        </form>
                        <!-- contenido para la el datatable 1-->
                        <div class="card-header">
                            <h3 class="card-title">Listado General de Garantias del sistema <?php echo nameProject; ?> </h3>
                        </div>
                        <div class="card-body">
                            <!-- Tabla 1 -->
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha Creación Reporte</th>
                                        <th>Número de Reporte</th>
                                        <th>Computadora</th>
                                        <th>Problema Principal</th>
                                        <th>Acciones Realizadas</th>
                                        <th>Diagnóstico</th>
                                        <th>Solución</th>
                                        <th>Observaciones</th>
                                        <th>Estado</th>
                                        <th title="Usuario que hizo Registro">Usuario</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $rol = $_SESSION["RLS_idTbl_Roles"];
                                    // Verificar si el rol tiene el rol 2 (administrador) y el permiso de SFT
                                    function validar_permisos($rol, $PermisoRWR)
                                    {
                                        if ($rol == "2" || $rol == "3"  && $PermisoRWR) {
                                            return true;
                                        } else {
                                            return false;
                                        }
                                    }


                                    function obtener_registros($conn, $rol, $PermisoRWR)
                                    {
                                        include "../../includes/conecta.php";

                                        if (validar_permisos($rol, $PermisoRWR)) {

                                            // Realizar consulta para obtener todos los registros
                                            $stmt = $conn->query("CALL sp_readingWarranty()");
                                            // $query= "CALL sp_selectAllUser()";
                                            // echo $query;
                                            // Ejecutar el procedimiento almacenado
                                            // Obtener todos los resultados
                                            dataTableWarranty($stmt);
                                            $stmt->close();
                                            $conn->next_result();
                                        }
                                    }
                                    obtener_registros($conn, $rol, $PermisoRWR);
                                    ?>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha Creación Reporte</th>
                                        <th>Número de Reporte</th>
                                        <th>Computadora</th>
                                        <th>Problema Principal</th>
                                        <th>Acciones Realizadas</th>
                                        <th>Diagnóstico</th>
                                        <th>Solución</th>
                                        <th>Observaciones</th>
                                        <th>Estado</th>
                                        <th title="Usuario que hizo Registro">Usuario</th>

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
</div>

<script>
    $(function() {
        var table = $("#example1").DataTable({
            "stateSave": true,
            "responsive": true,
            "searching": true,
            "lengthChange": false,
            "autoWidth": false
        });
    });
</script>

<?php
require_once "../templates/footer.php";
?>