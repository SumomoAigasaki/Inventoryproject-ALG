<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";

?>

<?php

function dataTableUser($stmt)
{
  while ($row = $stmt->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['PCA_idTbl_PC_Assignment'] . "</td>";
    echo "<td>" . $row['PCA_Date_Assignment'] . "</td>";
    echo "<td>" . $row['colaborador'] . "</td>";
    echo "<td>" . $row['Computadora'] . "</td>";
    echo "<td>" . $row['PCA_Return_Date'] . "</td>";
    echo "<td>" . $row['PCA_Observations'] . "</td>";
    echo "<td>" . $row['PCA_Inventory_Date'] . "</td>";
    echo "<td>" . $row['User_Username'] . "</td>";
    echo "<td>" . $row['STS_Description'] . "</td>";

    echo "<td align='center'> 
            <a href='../views/update_assignment_pc.php?p=" . $row['PCA_idTbl_PC_Assignment'] . "' class='btn btn-outline-primary btn-sm' title='Editar Registro'>
              <i class='fas fa-pencil-alt'></i>
            </a>
            <a href='../views/view_mappingSoftware.php?p=" . $row['PCA_idTbl_PC_Assignment'] . "' class='btn btn-outline-info btn-sm' title='Más Información'>
            <i class='fas fa-info'></i>
            </a>";
    if ($row['STS_Description'] == "Activo(a)") {
    echo"  <a  href='../views/PCassignmentcontract.php?p=" . $row['PCA_idTbl_PC_Assignment'] . "' class='btn btn-outline-dark btn-sm imprimirContrato' title='Imprimir Contrato' name='imprimirContrato' id='imprimirContrato' >
              <i class='fa fa-file-contract'></i>
            </a>";
            }
     echo"     <button class='btn btn-outline-danger btn-sm btnDeletePCA' title='Eliminar Registro' name='btnDeletePCA' id='btnDeletePCA' data-id='" . $row['PCA_idTbl_PC_Assignment'] . "'>
              <i class='fas fa-trash-alt'></i>
            </button>
          </td>";
    echo "</tr>";
  }
}
?>

<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-4">
          <h1><?php echo $pageName; ?></h1>
        </div>
        <div class="col-sm-4">
          <!--cinta de home y el nombre de la pagina -->
          <ol class="breadcrumb float-sm-right">
            <div class="btn-group" class="col-sm-4">
              <!--botones  de agregar  -->
              <?php
              if ($PermisoCBT) {
                // Agregar la ruta al array $arrayAdd
                $ruta = "../views/insert_assignment_pc.php";
                $arrayAdd[] = $ruta;

                // Crear el botón con la ruta almacenada en la variable
                echo "<a href=\"$ruta\"><button button type='button' class='btn btn-success'><span class='fa fa-plus'></span> Agregar</button></a>";
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
            <p class="breadcrumb-item"><a href="<?php echo $pageLink; ?>">
                <?php echo $pageName; ?>
              </a></p>
            <p class="breadcrumb-item active">
              <?php echo nameProject; ?>
            </p>
          </ol>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>



  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <form id="deleteForm" method="POST" action="">
              <input type="hidden" name="id" id="deleteId">
            </form>
            <!-- contenido para la el datatable 1-->
            <div class="card-header">
              <h3 class="card-title">Listado General de las PC Asignadas en el sistema <?php echo nameProject; ?> </h3>
            </div>
            <div class="card-body">
            </div>
            <!-- /.card-body -->

            <div class="card-body">
              <!-- Tabla 1 -->
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Fecha de Asignación</th>
                    <th>Colaborador Asignado</th>
                    <th>Computadora</th>
                    <th>Fecha de Retorno</th>
                    <th>Observaciones</th>
                    <th>Fecha inventario</th>
                    <th>Usuario</th>
                    <th>Estado</th>
                    <th>Opciones</th>

                  </tr>
                </thead>
                <tbody>

                  <?php
                  $rol = $_SESSION["RLS_idTbl_Roles"];
                  // Verificar si el rol tiene el rol 2 (administrador) y el permiso de SFT
                  function validar_permisos($rol, $PermisoPCA)
                  {
                    if ($rol == "2" && $PermisoPCA) {
                      return true;
                    } else {
                      return false;
                    }
                  }


                  function obtener_registros($conn, $rol, $PermisoPCA)
                  {
                    include "../../includes/conecta.php";

                    if (validar_permisos($rol, $PermisoPCA)) {

                      // Realizar consulta para obtener todos los registros
                      $stmt = $conn->query("CALL sp_selectAllPCAssignment()");
                      // $query= "CALL sp_selectAllUser()";
                      // echo $query;
                      // Ejecutar el procedimiento almacenado
                      // Obtener todos los resultados
                      dataTableUser($stmt);
                      $stmt->close();
                      $conn->next_result();
                    } else {
                      // Realizar consulta para obtener solo registros activos
                      $stmt = $conn->query("CALL sp_selectActivePCAssignment()");
                      // $query= "CALL CALL sp_selectActiveUser()";
                      // echo $query;
                      // Ejecutar el procedimiento almacenado
                      // Obtener todos los resultados
                      dataTableUser($stmt);
                      $stmt->close();
                      $conn->next_result();
                    }
                  }
                  obtener_registros($conn, $rol, $PermisoPCA);
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Fecha de Asignación</th>
                    <th>Colaborador Asignado</th>
                    <th>Computadora</th>
                    <th>Fecha de Retorno</th>
                    <th>Observaciones</th>
                    <th>Fecha inventario</th>
                    <th>Usuario</th>
                    <th>Estado</th>
                    <th>Opciones</th>
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
include "../templates/footer.php";
?>
</div>

<?php
function deleteUser()
{
  global $conn; // Utilizar la variable $conn en el ámbito de la función

  if (isset($_POST['id'])) {
    $id = $_POST["id"];

    $stmt = $conn->prepare("CALL sp_deleteAssigmentPC(?)");
    // Mandamos los parametros y los input que seran enviados al PA O SP
    $stmt->bind_param("s", $id); // Ejecutar el procedimiento almacenado

    $stmt->execute();
    // $query = "CALL sp_deleteComputer('$id')";
    // echo $query;
    // echo '<pre>';

    if ($stmt->error) {
      error_log("Error en la ejecución del procedimiento almacenado: " . $stmt->error);
    }
    // Obtener el número de filas afectadas por el insert
    $stmt->bind_result($idPCA);
    $stmt->fetch();
    // Cerrar el statement
    $stmt->close();
    // Avanzar al siguiente conjunto de resultados si hay varios
    $conn->next_result();

    if ($idPCA > 0) {
      echo '<script>
          setTimeout(function() {
            window.location.href = "view_assignment_pc.php";
          }, 10000);
        </script>';
    }
  }
}

// Llamar a la función deleteComputer
deleteUser();
?>

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

  $('#example1').on('click', 'button.btnDeletePCA', function() {
    var id = $(this).data('id');

    // Mostrar Sweet Alert
    Swal.fire({
      title: "Eliminar registro",
      text: "¿Estás seguro de eliminar este registro N: " + id + "?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Quiero Elimnarlo!'
    }).then((result) => {
      if (result.isConfirmed) {
        $('#deleteId').val(id);

        $.ajax({
          type: "POST",
          url: window.location.href, // URL actual de la página
          data: {
            id: id
          }, // Datos a enviar al servidor
          success: function(response) {
            Swal.fire("Registro eliminado", "El registro ha sido eliminado correctamente", "success").then(() => {
              // Redireccionar después de mostrar el SweetAlert
              window.location.href = "view_assignment_pc.php";
            });
          }
        });
      }
    });

  });
</script>