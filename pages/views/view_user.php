<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";

// echo('<pre>');
// var_dump($privilegios);
// echo('</pre>');

function dataTableUser($stmt)
{
  while ($row = $stmt->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['User_idTbl_User'] . "</td>";
    echo "<td>" . $row['Nombre_completo'] . "</td>";
    echo "<td>";
    if (empty($row['User_img'])) {
      echo "<li class='list-inline-item'>
                      <img alt='Avatar' width='50' height='50' class='table-avatar img-circle' src='../../resources/User/default.png'>
                    </li>" . $row['User_Username'];
    } else {
      echo "<li class='list-inline-item'>
                      <img alt='Avatar' width='50' height='50' class='table-avatar img-circle' src='../.." . $row['User_img'] . "'>
                    </li>   " . $row['User_Username'];
    }
    echo "</td>";
    echo "<td>" . $row['User_Email'] . "</td>";
    echo "<td>" . $row['STS_Description'] . "</td>";
    echo "<td>" . $row['RLS_Description'] . "</td>";
    echo "<td align='center'> 
            <a href='../views/update_user.php?p=" . $row['User_idTbl_User'] . "' class='btn btn-outline-primary btn-sm' title='Editar Registro'>
              <i class='fas fa-pencil-alt'></i>
            </a>
            <button class='btn btn-outline-danger btn-sm btnDeleteCMP' title='Eliminar Registro' name='btnDeleteUSER' id='btnDeleteUSER' data-id='" . $row['User_idTbl_User'] . "'>
              <i class='fas fa-trash-alt'></i>
            </button>
          </td>";
    echo "</tr>";
  }
}

?>


<div class="content-wrapper">

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
              if ($PermisoUSER) {
                // Agregar la ruta al array $arrayAdd
                $ruta = "../views/insert_user.php";
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
              <h3 class="card-title">Listado General de Usuario del sistema <?php echo nameProject; ?> </h3>
            </div>

            <div class="card-body">
              <!-- Tabla 1 -->
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre Colaborador </th>
                    <th>Nombre de Usuario</th>
                    <th>Email/Correo Electronico</th>
                    <th>Estado</th>
                    <th>Rol</th>
                    <th>Opciones</th>

                  </tr>
                </thead>
                <tbody>

                  <?php
                  $rol = $_SESSION["RLS_idTbl_Roles"];
                  // Verificar si el rol tiene el rol 2 (administrador) y el permiso de SFT
                  function validar_permisos($rol, $PermisoUSER)
                  {
                    if ($rol == "2" && $PermisoUSER) {
                      return true;
                    } else {
                      return false;
                    }
                  }


                  function obtener_registros($conn, $rol, $PermisoUSER)
                  {
                    include "../../includes/conecta.php";

                    if (validar_permisos($rol, $PermisoUSER)) {

                      // Realizar consulta para obtener todos los registros
                      $stmt = $conn->query("CALL sp_selectAllUser()");
                      // $query= "CALL sp_selectAllUser()";
                      // echo $query;
                      // Ejecutar el procedimiento almacenado
                      // Obtener todos los resultados
                      dataTableUser($stmt);
                      $stmt->close();
                      $conn->next_result();
                    } else {
                      // Realizar consulta para obtener solo registros activos
                      $stmt = $conn->query("CALL sp_selectActiveUser()");
                      // $query= "CALL CALL sp_selectActiveUser()";
                      // echo $query;
                      // Ejecutar el procedimiento almacenado
                      // Obtener todos los resultados
                      dataTableUser($stmt);
                      $stmt->close();
                      $conn->next_result();
                    }
                  }
                  obtener_registros($conn, $rol, $PermisoUSER);
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Nombre Colaborador </th>
                    <th>Nombre de Usuario</th>
                    <th>Email/Correo Electronico</th>
                    <th>Estado</th>
                    <th>Rol</th>
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

    $stmt = $conn->prepare("CALL sp_deleteUser(?)");
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
    $stmt->bind_result($idU);
    $stmt->fetch();
    // Cerrar el statement
    $stmt->close();
    // Avanzar al siguiente conjunto de resultados si hay varios
    $conn->next_result();

    if ($idU > 0) {
      echo '<script>
          setTimeout(function() {
            window.location.href = "view_user.php";
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

  $('#example1').on('click', 'button.btnDeleteCMP', function() {
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
              window.location.href = "view_user.php";
            });
          }
        });
      }
    });

  });
</script>