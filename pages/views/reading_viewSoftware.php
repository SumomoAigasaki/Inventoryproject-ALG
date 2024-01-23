<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";

function dataTableSoftware($stmt)
{
  while ($row = $stmt->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['SFT_idTbl_Software'] . "</td>";
    echo "<td>";
    if (empty($row['SFT_Image'])) {
      echo "<li class='list-inline-item'>
                      <img alt='Avatar' width='50' height='50' class='table-avatar img-circle' src='../../resources/Software/default.jpg'>
                    </li>";
    } else {
      echo "<li class='list-inline-item'>
                      <img alt='Avatar' width='50' height='50' class='table-avatar img-circle' src='../.." . $row['SFT_Image'] . "'>
                    </li>";
    }
    echo "</td>";
    echo "<td>" . $row['SFT_Software_Name'] . "</td>";
    echo "<td>" . $row['MFS_Description'] . "</td>";
    echo "<td>" . $row['SFT_Version_Installe'] . "</td>";
    echo "<td>" . $row['SFT_Serial'] . "</td>";
    echo "<td>" . $row['STP_Description'] . "</td>";
    echo "<td>" . $row['LC_Description'] . "</td>";
    echo "<td>" . $row['CTG_Description'] . "</td>";
    echo "<td>" . $row['SFT_Inventory_Date'] . "</td>";
    echo "<td>" . $row['SFT_Observations'] . "</td>";
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
                            <h3 class="card-title">Listado General de Software del sistema <?php echo nameProject; ?> </h3>
                        </div>
                        <div class="card-body">
                            <!-- Tabla 1 -->
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                    <th>#</th>
                                        <th>Imagen</th>
                                        <th>Nombre Software </th>
                                        <th>Fabricante del Software</th>
                                        <th>Version de Instalación</th>
                                        <th>Licensia/Serial</th>
                                        <th>Tipo de Software</th>
                                        <th>Clasificacion de Licencia</th>
                                        <th>Categoria</th>
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
                                    function validar_permisos($rol, $PermisoRSFT)
                                    {
                                        if ($rol == "2" || $rol == "3"  && $PermisoRSFT) {
                                            return true;
                                        } else {
                                            return false;
                                        }
                                    }


                                    function obtener_registros($conn, $rol, $PermisoRSFT)
                                    {
                                        include "../../includes/conecta.php";

                                        if (validar_permisos($rol, $PermisoRSFT)) {

                                            // Realizar consulta para obtener todos los registros
                                            $stmt = $conn->query("CALL sp_readingSoftware()");
                                            // $query= "CALL sp_selectAllUser()";
                                            // echo $query;
                                            // Ejecutar el procedimiento almacenado
                                            // Obtener todos los resultados
                                            dataTableSoftware($stmt);
                                            $stmt->close();
                                            $conn->next_result();
                                        }
                                    }
                                    obtener_registros($conn, $rol, $PermisoRSFT);
                                    ?>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Imagen</th>
                                        <th>Nombre Software </th>
                                        <th>Fabricante del Software</th>
                                        <th>Version de Instalación</th>
                                        <th>Licensia/Serial</th>
                                        <th>Tipo de Software</th>
                                        <th>Clasificacion de Licencia</th>
                                        <th>Categoria</th>
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