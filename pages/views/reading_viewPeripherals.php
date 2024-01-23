<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";

function dataTablePeripherals($stmt)
{
     while ($row = $stmt->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['PRL_idTbl_Peripherals'] . "</td>";
    echo "<td>" . $row['PRL_Name'] . "</td>";
    echo "<td>" . $row['BRD_Description'] . "</td>";
    echo "<td>" . $row['CPT_Description'] . "</td>";
    echo "<td>" . $row['PRL_Main_Description'] . "</td>";
    echo "<td>" . $row['CPD_Description'] . "</td>";
    echo "<td>" . $row['LCT_Description'] . "</td>";
    echo "<td>" . $row['PRL_Inventory_Date'] . "</td>";
    echo "<td>" . $row['PRL_Observations'] . "</td>";
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
                            <h3 class="card-title">Listado General de Perifericos del sistema <?php echo nameProject; ?> </h3>
                        </div>
                        <div class="card-body">
                            <!-- Tabla 1 -->
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre Perifico </th>
                                        <th>Marca</th>
                                        <th>Tipo de Componente</th>
                                        <th>Descripcion Principal</th>
                                        <th>Especificaciones</th>
                                        <th>Localización</th>
                                        <th>Fecha de Ingreso</th>
                                        <th>Observaciones</th>
                                        <th title="Usuario que hizo Registro">Usuario</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $rol = $_SESSION["RLS_idTbl_Roles"];
                                    // Verificar si el rol tiene el rol 2 (administrador) y el permiso de SFT
                                    function validar_permisos($rol, $PermisoRPRL)
                                    {
                                        if ($rol == "2" || $rol == "3"  && $PermisoRPRL) {
                                            return true;
                                        } else {
                                            return false;
                                        }
                                    }


                                    function obtener_registros($conn, $rol, $PermisoRPRL)
                                    {
                                        include "../../includes/conecta.php";

                                        if (validar_permisos($rol, $PermisoRPRL)) {

                                            // Realizar consulta para obtener todos los registros
                                            $stmt = $conn->query("CALL sp_readingPeripherals()");
                                            // $query= "CALL sp_selectAllUser()";
                                            // echo $query;
                                            // Ejecutar el procedimiento almacenado
                                            // Obtener todos los resultados
                                            dataTablePeripherals($stmt);
                                            $stmt->close();
                                            $conn->next_result();
                                        }
                                    }
                                    obtener_registros($conn, $rol, $PermisoRPRL);
                                    ?>

                                </tbody>
                                <tfoot>
                                    <tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre Perifico </th>
                                        <th>Marca</th>
                                        <th>Tipo de Componente</th>
                                        <th>Descripcion Principal</th>
                                        <th>Especificaciones</th>
                                        <th>Localización</th>
                                        <th>Fecha de Ingreso</th>
                                        <th>Observaciones</th>
                                        <th title="Usuario que hizo Registro">Usuario</th>
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
<?php
require_once "../templates/footer.php";
?>
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

