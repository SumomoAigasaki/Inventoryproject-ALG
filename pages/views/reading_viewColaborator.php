<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";

function dataTableCollaborator($stmt)
{
    while ($row = $stmt->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['CBT_idTbl_Collaborator'] . "</td>";
        echo "<td>" . $row['CBT_Employee_Code'] . "</td>";
        echo "<td>" . $row['NTL_Description'] . "</td>";
        echo "<td>" . $row['Grade'] . "</td>";
        echo "<td>";
        if (empty($row['CBT_Image'])) {
            echo "<li class='list-inline-item'>
                      <img alt='Avatar' width='50' height='50' class='table-avatar img-circle' src='../../resources/User/default.png'>
                    </li>" . $row['NAME'];
        } else {
            echo "<li class='list-inline-item'>
                      <img alt='Avatar' width='50' height='50' class='table-avatar img-circle' src='../.." . $row['CBT_Image'] . "'>
                    </li>   " . $row['NAME'];
        }
        echo "</td>";
        echo "<td>" . $row['GD_Description'] . "</td>";
        echo "<td>" . $row['CBT_Address'] . "</td>";
        echo "<td>" . $row['CBT_Phone_Number'] . "</td>";
        echo "<td>" . $row['CBT_Birth_Date'] . "</td>";
        echo "<td>" . $row['MNG_Description'] . "</td>";
        echo "<td>" . $row['PCS_Description'] . "</td>";
        echo "<td>" . $row['CBT_employee_position'] . "</td>";
        echo "<td>" . $row['TCNT_Description'] . "</td>";
        echo "<td>" . $row['CBT_Date_Hire_Start'] . "</td>";
        echo "<td>" . $row['CBT_Hiring_Months'] . "</td>";
        echo "<td>" . $row['CBT_Inventory_Date'] . "</td>";
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
                            <h3 class="card-title">Listado General de Colaboradores del sistema <?php echo nameProject; ?> </h3>
                        </div>
                        <div class="card-body">
                            <!-- Tabla 1 -->
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Código de empleado</th>
                                        <th>Nacionalidad</th>
                                        <th>Grado de Est.</th>
                                        <th>Nombre Completo</th>
                                        <th>Género</th>
                                        <th>Dirección</th>
                                        <th>Número de teléfono</th>
                                        <th>Fecha de nacimiento</th>
                                        <th>Gestión</th>
                                        <th>Proceso</th>
                                        <th>Cargo</th>
                                        <th>Tipo Contratación</th>
                                        <th>Fecha Contratación</th>
                                        <th>Meses Contratación</th>
                                        <th>Fecha inventario</th>
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
                                            $stmt = $conn->query("CALL sp_readingcollaborator()");
                                            // $query= "CALL sp_selectAllUser()";
                                            // echo $query;
                                            // Ejecutar el procedimiento almacenado
                                            // Obtener todos los resultados
                                            dataTableCollaborator($stmt);
                                            $stmt->close();
                                            $conn->next_result();
                                        }
                                    }
                                    obtener_registros($conn, $rol, $PermisoRPRL);
                                    ?>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Código de empleado</th>
                                        <th>Nacionalidad</th>
                                        <th>Grado de Est.</th>
                                        <th>Nombre Completo</th>
                                        <th>Género</th>
                                        <th>Dirección</th>
                                        <th>Número de teléfono</th>
                                        <th>Fecha de nacimiento</th>
                                        <th>Gestión</th>
                                        <th>Proceso</th>
                                        <th>Cargo</th>
                                        <th>Tipo Contratación</th>
                                        <th>Fecha Contratación</th>
                                        <th>Meses Contratación</th>
                                        <th>Fecha inventario</th>
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