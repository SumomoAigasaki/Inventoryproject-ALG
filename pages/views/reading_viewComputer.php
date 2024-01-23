<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";
function dataTableComputer($stmt)
{
    while ($row = $stmt->fetch_assoc()) {
        echo "
                <tr> 
                <td>" . $row['CMP_idTbl_Computer'] . "</td>
                <td>" . $row['CMP_Acquisition_Date'] . "</td>
                <td>" . $row['MFC_Description'] . "</td>
                ";
        if (empty($row['CMP_Image']) || $row['CMP_Image'] == "/resources/Computer/") {
            echo "<td><li class='list-inline-item'>
                      <img alt='Avatar' width='50' height='50' class='table-avatar img-circle' src='../../resources/Computer/default.jpg'>         
                  </li></td>";
        } else {
            echo "<td><li class='list-inline-item'>
                      <img alt='Avatar' width='50' height='50' class='table-avatar img-circle' src='../.." . $row['CMP_Image'] . "'>         
                  </li></td>";
        }
        echo "
                <td>" . $row['CMP_Technical_Name'] . "</td>
                <td>" . $row['MDL_Description'] . "</td>
                <td>" . $row['CT_Description'] . "</td>
                <td>" . $row['CMP_Servitag'] . "</td>
                <td>" . $row['CMP_License'] . "</td>
                <td>" . $row['CMP_Serial'] . "</td>
                <td>" . $row['Especificaciones'] . "</td>                
                <td>" . $row['SistemaOperativo'] . "</td>
                <td>" . $row['CMP_Warranty_Expiration'] . "</td>
                <td>" . $row['TG_Description'] . "</td>
                <td>" . $row['STS_Description'] . "</td>
                <td>" . $row['LCT_Description'] . "</td>
                <td>" . $row['CMP_Observations'] . "</td>
                <td>" . $row['CMP_Report'] . "</td>
                <td>" . $row['User_Username'] . "</td>
               
            </tr>";
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
                            <h3 class="card-title">Listado General de Computadoras del sistema <?php echo nameProject; ?> </h3>
                        </div>
                        <div class="card-body">
                            <!-- Tabla 1 -->
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha Adquisición</th>
                                        <th>Marca</th>
                                        <th>Imagen</th>
                                        <th>Nomb. Tecnico</th>
                                        <th>Modelo</th>
                                        <th>Tipo PC</th>
                                        <th>Servitag</th>
                                        <th>Licencia</th>
                                        <th>serial</th>
                                        <th>Especificaciones</th>
                                        <th>Sistema Operativo</th>
                                        <th>Fecha Limite Garantia</th>
                                        <th>Tipo Garantia</th>
                                        <th>Estado</th>
                                        <th>Localizacion</th>
                                        <th>Observaciones</th>
                                        <th>Imagen de Reporte</th>
                                        <th title="Usuario Realizó Registro">Usuario</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $rol = $_SESSION["RLS_idTbl_Roles"];
                                    // Verificar si el rol tiene el rol 2 (administrador) y el permiso de SFT
                                    function validar_permisos($rol, $PermisoRCMP)
                                    {
                                        if ($rol == "2" || $rol == "3"  && $PermisoRCMP) {
                                            return true;
                                        } else {
                                            return false;
                                        }
                                    }


                                    function obtener_registros($conn, $rol, $PermisoRCMP)
                                    {
                                        include "../../includes/conecta.php";

                                        if (validar_permisos($rol, $PermisoRCMP)) {

                                            // Realizar consulta para obtener todos los registros
                                            $stmt = $conn->query("CALL sp_readingComputer()");
                                            // $query= "CALL sp_selectAllUser()";
                                            // echo $query;
                                            // Ejecutar el procedimiento almacenado
                                            // Obtener todos los resultados
                                            dataTableComputer($stmt);
                                            $stmt->close();
                                            $conn->next_result();
                                        }
                                    }
                                    obtener_registros($conn, $rol, $PermisoRCMP);
                                    ?>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha Adquisición</th>
                                        <th>Marca</th>
                                        <th>Imagen</th>
                                        <th>Nomb. Tecnico</th>
                                        <th>Modelo</th>
                                        <th>Tipo PC</th>
                                        <th>Servitag</th>
                                        <th>Licencia</th>
                                        <th>serial</th>
                                        <th>Especificaciones</th>
                                        <th>Sistema Operativo</th>
                                        <th>Fecha Limite Garantia</th>
                                        <th>Tipo Garantia</th>
                                        <th>Estado</th>
                                        <th>Localizacion</th>
                                        <th>Observaciones</th>
                                        <th>Imagen de Reporte</th>
                                        <th title="Usuario Realizó Registro">Usuario</th>

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
</script>

<?php
require_once "../templates/footer.php";
?>