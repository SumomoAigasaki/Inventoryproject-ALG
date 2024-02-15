<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";
require('../../public/FPDF/fpdf.php');

// echo('<pre>');
// var_dump($privilegios);
// echo('</pre>');
?>


<?php
function dataTableUser($stmt)
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
    echo "<td>" . $row['WR_Date_Solution'] . "</td>";
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
    echo  $row['STS_Description']  . "</td>";
    echo "<td>" . $row['User_Username'] . "</td>";
    echo "<td align='center'> 
      <a href='../views/update_warranty.php?p=" . $row['WR_idTbl_Warranty_Registration'] . "' class='btn btn-outline-primary btn-sm' title='Editar Registro'>
        <i class='fas fa-pencil-alt'></i>
      </a>
      <a href='../views/warrantyReport.php?p=" . $row['WR_idTbl_Warranty_Registration'] . "' class='btn btn-outline-info btn-sm' title='Imprimir Reporte Tecnico' target='_blank'>
        <i class='fas fa-file-alt'></i>
      </a>
      <button class='btn btn-outline-danger btn-sm btnDeleteWR' title='Eliminar Registro' name='btnDeleteUSER' id='btnDeleteUSER' data-id='" . $row['WR_idTbl_Warranty_Registration'] . "'>
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
              if ($PermisoWR) {
                // Agregar la ruta al array $arrayAdd
                $ruta = "../views/insert_warranty.php";
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
              <h3 class="card-title">Listado General de Colabores del sistema <?php echo nameProject; ?> </h3>
            </div>

            <div class="card-body">
              <!-- Tabla 1 -->
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Número de Reporte</th>
                    <th>Fecha Creación Reporte</th>
                    <th>Computadora</th>
                    <th>Problema Principal </th>
                    <th>Acciones Realizadas</th>
                    <th>Diagnostico </th>
                    <th>Solucion </th>
                    <th>Fecha de Solucion </th>
                    <th>Observaciones</th>
                    <th>Estado</th>
                    <th>Usuario</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  $rol = $_SESSION["RLS_idTbl_Roles"];
                  // Verificar si el rol tiene el rol 2 (administrador) y el permiso de SFT
                  function validar_permisos($rol, $PermisoWR)
                  {
                    if ($rol == "2" && $PermisoWR) {
                      return true;
                    } else {
                      return false;
                    }
                  }


                  function obtener_registros($conn, $rol, $PermisoWR)
                  {
                    include "../../includes/conecta.php";

                    if (validar_permisos($rol, $PermisoWR)) {

                      // Realizar consulta para obtener todos los registros
                      $stmt = $conn->query("CALL sp_selectAllWarranty()");
                      // $query= "CALL sp_selectAllUser()";
                      // echo $query;
                      // Ejecutar el procedimiento almacenado
                      // Obtener todos los resultados
                      dataTableUser($stmt);
                      $stmt->close();
                      $conn->next_result();
                    } else {
                      // Realizar consulta para obtener solo registros activos
                      $stmt = $conn->query("CALL sp_selectActiveWarranty()");
                      // $query= "CALL CALL sp_selectActiveUser()";
                      // echo $query;
                      // Ejecutar el procedimiento almacenado
                      // Obtener todos los resultados
                      dataTableUser($stmt);
                      $stmt->close();
                      $conn->next_result();
                    }
                  }
                  obtener_registros($conn, $rol, $PermisoWR);
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Número de Reporte</th>
                    <th>Fecha Creación Reporte</th>
                    <th>Computadora</th>
                    <th>Problema Principal </th>
                    <th>Acciones Realizadas</th>
                    <th>Diagnostico </th>
                    <th>Solucion </th>
                    <th>Fecha de Solucion </th>
                    <th>Observaciones</th>
                    <th>Estado</th>
                    <th>Usuario</th>
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
function deleteRegister()
{
  global $conn; // Utilizar la variable $conn en el ámbito de la función

  if (isset($_POST['id'])) {
    $id = $_POST["id"];

    $stmt = $conn->prepare("CALL sp_deleteWarranty(?)");
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
    $stmt->bind_result($idWR);
    $stmt->fetch();
    // Cerrar el statement
    $stmt->close();
    // Avanzar al siguiente conjunto de resultados si hay varios
    $conn->next_result();

    if ($idWR > 0) {
      echo '<script>
          setTimeout(function() {
            window.location.href = "view_warranty.php";
          }, 10000);
        </script>';
    }
  }
}

// Llamar a la función deleteComputer
deleteRegister();
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

  $('#example1').on('click', 'button.btnDeleteWR', function() {
    var id = $(this).data('id');

    // Mostrar Sweet Alert
    Swal.fire({
      title: "Eliminar registro",
      text: "¿Estás seguro de eliminar este registro N: " + id + "?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Quiero Eliminarlo!'
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
              window.location.href = "view_warranty.php";
            });
          }
        });
      }
    });

  });
</script>