<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";
function dataTableAsignment($stmt)
{
    while ($row = $stmt->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['PCA_idTbl_PC_Assignment'] . "</td>";
        echo "<td>" . $row['PCA_Date_Assignment'] . "</td>";
        echo "<td>" . $row['colaborador'] . "</td>";
        echo "<td>" . $row['areaTrabajo'] . "</td>";        
        echo "<td>" . $row['Computadora'] . "</td>";
        echo "<td>" . $row['Softwares'] . "</td>";
        echo "<td>" . $row['PCA_Return_Date'] . "</td>";
        echo "<td>" . $row['PCA_Observations'] . "</td>";
        echo "<td>" . $row['PCA_Inventory_Date'] . "</td>";
        echo "<td>" . $row['User_Username'] . "</td>";
        echo "<td>" . $row['STS_Description'] . "</td>";
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
                            <h3 class="card-title">Listado General de Asignacion de PC del sistema <?php echo nameProject; ?> </h3>
                        </div>
                        <div class="card-body">
                            <!-- Tabla 1 -->
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha de Asignación</th>
                                        <th>Colaborador Asignado</th>
                                        <th>Area de trabajo</th>
                                        <th>Computadora</th>
                                        <th title="Software instalados">Software</th>
                                        <th>Fecha de Retorno</th>
                                        <th>Observaciones</th>
                                        <th>Fecha inventario</th>
                                        <th title="Usuario Realizó Registro">Usuario</th>
                                        <th>Estado</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $rol = $_SESSION["RLS_idTbl_Roles"];
                                    // Verificar si el rol tiene el rol 2 (administrador) y el permiso de SFT
                                    function validar_permisos($rol, $PermisoRPCA)
                                    {
                                        if ($rol == "2" || $rol == "3"  && $PermisoRPCA) {
                                            return true;
                                        } else {
                                            return false;
                                        }
                                    }


                                    function obtener_registros($conn, $rol, $PermisoRPCA)
                                    {
                                        include "../../includes/conecta.php";

                                        if (validar_permisos($rol, $PermisoRPCA)) {

                                            // Realizar consulta para obtener todos los registros
                                            $stmt = $conn->query("CALL sp_readingAssignmentePC()");
                                            // $query= "CALL sp_selectAllUser()";
                                            // echo $query;
                                            // Ejecutar el procedimiento almacenado
                                            // Obtener todos los resultados
                                            dataTableAsignment($stmt);
                                            $stmt->close();
                                            $conn->next_result();
                                        }
                                    }
                                    obtener_registros($conn, $rol, $PermisoRPCA);
                                    ?>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha de Asignación</th>
                                        <th>Colaborador Asignado</th>
                                        <th>Area de trabajo</th>
                                        <th>Computadora</th>                                        
                                        <th title="Software instalados">Software</th>
                                        <th>Fecha de Retorno</th>
                                        <th>Observaciones</th>
                                        <th>Fecha inventario</th>
                                        <th title="Usuario Realizó Registro">Usuario</th>
                                        <th>Estado</th>

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