<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";


function dataTableUser($stmt)
{
  $contador = 1; // Variable para contar
  $currentRol = null; // Variable para almacenar el rol actual
  $firstIteration = true; // Variable para rastrear la primera iteración


  while ($row = $stmt->fetch_assoc()) {

    echo "<tr ";
    if ($row['RLS_Description'] !== $currentRol) {
      echo " class='special-row'";
      // echo"<p>num ES igual al conteo" .$lineNumber." -- ".$border ." yes </p>";
    }

    echo ">";
    echo "<td>" . $contador . "</td>";
    // Verificar si el rol actual es diferente al rol del registro actual
    if ($row['RLS_Description'] !== $currentRol) {
      // Imprimir una fila para mostrar el rol y establecer el colspan

      echo "<td  align='center'>  <a href='../views/update_permissions.php?p=" . $row['RLS_idTbl_Roles'] . "' class='btn btn-outline-primary btn-sm' title='Editar Permisos del Rol " . $row['RLS_idTbl_Roles'] . " '>
        <i class='fas fa-pencil-alt'></i> 
        </a> <b>" . $row['RLS_Description'] . "</b></td>";
      $currentRol = $row['RLS_Description']; // Actualizar el rol actual
      $firstIteration = true; // Reiniciar la variable para la próxima iteración del mismo rol
    } else {
      // Si el rol es el mismo, pero no es la primera iteración, imprimir una fila con todas las celdas vacías
      if (!$firstIteration) {
        for ($i = 0; $i < 10; $i++) {
          echo "<td> </td>";
        }
      }
      echo "<td> </td>";
    }

    // echo "<td align='center'> 
    //               <a href='../views/update_permissions.php?p=" . $row['RLS_idTbl_Roles'] . "' class='btn btn-outline-primary btn-sm' title='Editar Permisos del Rol " . $row['RLS_idTbl_Roles'] . " '>
    //                   <i class='fas fa-pencil-alt'></i> 
    //               </a> " . $row['RLS_Description'] . "
    //             </td>";

    echo "<td align='center'> <b>" . $row['MDU_Descriptions'] . "</b></td>";
    echo "<td>" . $row['PRV_Name'] . "</td>";
    echo "<td>" . $row['PRV_Descriptions'] . "</td>";
    echo "<td>" . $row['USP_Inventory_Date'] . "</td>";
    echo "<td>" . $row['STS_Description'] . "</td>";
    echo "<td>" . $row['User_Username'] . "</td>";

    echo "<td align='center'>";
    if ($row['STS_Description'] == "Deshabilitado") {
      echo " <button class='btn btn-outline-danger btn-sm btnDeleteUSP disabled' title='Eliminar Permiso' name='btnDeleteUserP' id='btnDeleteUserP' data-id='" . $row['USP_IDtbl_user_privileges'] . "'>
          <i class='fas fa-trash-alt'></i>
        </button>";
    } else {
      echo " <button class='btn btn-outline-danger btn-sm btnDeleteUSP ' title='Eliminar Permiso' name='btnDeleteUserP' id='btnDeleteUserP' data-id='" . $row['USP_IDtbl_user_privileges'] . "'>
          <i class='fas fa-trash-alt'></i>
        </button>";
    }
    echo "</td>";
    echo "</tr>";
    $contador++; // Incrementar el contador
  }
}







?>

<div class="content-wrapper">
  <style>
    table.dataTable tbody tr.special-row td {
      border-top: 2px solid #595B5C;
      /* Cambia el grosor de la línea inferior de las celdas de los datos para la fila especial */
    }
  </style>
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
              if ($PermisoRLS) {
                // Agregar la ruta al array $arrayAdd
                $ruta = "../views/insert_permissions.php";
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
  </div>


  <!-- Main content -->
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
              <h3 class="card-title">Listado General de Perifericos/Componentes del sistema <?php echo nameProject; ?> </h3>
            </div>

            <div class="card-body">
              <!-- Tabla 1 -->
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Rol</th>
                    <th>Módulo</th>
                    <th>Privilegio</th>
                    <th>Descripción del Privilegio</th>
                    <th>Fecha de Ingreso</th>
                    <th>Estado</th>
                    <th>Usuario</th>
                    <th>Eliminar</th>

                  </tr>
                </thead>
                <tbody>

                  <?php
                  function obtener_registros($conn)
                  {
                    include "../../includes/conecta.php";



                    // Realizar consulta para obtener todos los registros
                    $stmt = $conn->query("CALL sp_selectAllPermissions()");
                    // Ejecutar el procedimiento almacenado
                    // Obtener todos los resultados

                    // dataTableUser($stmt, $ListSelectRol, $rol);
                    dataTableUser($stmt);
                    $stmt->close();
                    $conn->next_result();
                  }
                  obtener_registros($conn);
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Rol</th>
                    <th>Módulo</th>
                    <th>Privilegio</th>
                    <th>Descripción del Privilegio</th>
                    <th>Fecha de Ingreso</th>
                    <th>Estado</th>
                    <th>Usuario</th>
                    <th>Eliminar</th>
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

    $stmt = $conn->prepare("CALL sp_deleteUserPrivilege(?)");
    // Mandamos los parametros y los input que seran enviados al PA O SP
    $stmt->bind_param("s", $id); // Ejecutar el procedimiento almacenado

    $stmt->execute();
    // echo '<pre>';
    // $query = "CALL sp_deleteUserPrivilege('$id')";
    // echo $query;
    // echo '</pre>';

    if ($stmt->error) {
      error_log("Error en la ejecución del procedimiento almacenado: " . $stmt->error);
    }
    // Obtener el número de filas afectadas por el insert
    $stmt->bind_result($idU);
    $stmt->fetch();
    // Cerrar el statement
    $stmt->close();
    // Avanzar al siguiente conjunto de resultados si hay varios
    $conn->next_result();

    if ($idU > 0) {
      echo '<script>
          setTimeout(function() {
            window.location.href = "view_permissions.php";
          }, 10000);
        </script>';
    }
  }
}

// Llamar a la función deleteComputer si el formulario se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  deleteUser();
}
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

  $('#example1').on('click', 'button.btnDeleteUSP', function() {
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
              window.location.href = "view_permissions.php";
            });
          }
        });
      }
    });

  });
</script>