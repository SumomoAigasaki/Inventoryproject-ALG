<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";
// $opciones = false;

//Parte de codigo se hace de manera extra para no tener que entrar al metodo o funcion y que se haca al cargar la pagina 
//y esta misma tenga el conocimiento si tendra la columna de opciones o no desde el momento que esta se carga
// $idMS = $_GET['p'];
// Realizar consulta para obtener todos los registros
// $stmt = $conn->query("CALL sp_selectAllMappingSoftware($idMS)");
// $existingOptions  = array(); // Aquí almacenaremos los datos de la segunda consulta

// while ($fila = $stmt->fetch_assoc()) {
//   if ($fila['STS_Description'] == "Desintalado") {
//     $opciones = true;
//   }
// }
// $stmt->close();
// $conn->next_result();


function dataTableUser($stmt)
{

  while ($row = $stmt->fetch_assoc()) {
    //  echo '<pre>';
    //  print_r($row);
    //  echo '</pre>';
    // $Computadora = $row['Computadora'];
    echo "<tr>";
    echo "<td>" . $row['MS_idtbl_mapping_softwarecol'] . "</td>";
    echo "<td>" . $row['MS_Inventory_Date'] . "</td>";
    echo "<td>" . $row['Software'] . "</td>";
    echo "<td>" . $row['MS_Instalation_date'] . "</td>";
    echo "<td>" . $row['STS_Description'] . "</td>";
    echo "<td>" . $row['User_Username'] . "</td>";
    // echo "<td align='center'> ";
    // if ($row['STS_Description'] == "Desintalado") {
    //   echo "
    //   <button class='btn btn-outline-success btn-sm btnDeleteCMP' title='Activar registro' name='btnDeleteCBT' id='btnDeleteCBT' data-id='" . $row['MS_idtbl_mapping_softwarecol'] . "'>
    //   <i class='fas fa-wrench'></i>
    //          </button>";
    // }
    // echo"</td>";

    echo "</tr>";
  }
}

//PARA OBTENEER EL VALOR DE COMPUTADORA
$idMS = $_GET['p'];
$stmt = $conn->query("CALL sp_selectAllMappingSoftware($idMS)");
if ($stmt->num_rows > 0) {
  while ($row = $stmt->fetch_assoc()) {
      $computerid = $row['CMP_idTbl_Computer'];
      $computername = $row['CMP_Technical_Name'];
      $computadoraValue = $row['Datos'];
  }
} else {
  $computerid = "Datos no disponibles";
  $computername = "Datos no disponibles" ;
  $computadoraValue ="Datos no disponibles" ;
  // Asigna valores predeterminados para $computername y $computadoraValue si es necesario
}
$stmt->close();
$conn->next_result();
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
                $ruta = "../views/view_assignment_pc.php";
                $arrayAdd[] = $ruta;

                // Crear el botón con la ruta almacenada en la variable
                echo "<a href=\"$ruta\"><button button type='button' class='btn btn-block btn-info'></i><span class='fa fa-arrow-circle-left'></span>   Volver</button></a>";
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
            <li class="breadcrumb-item"><a href="<?php echo $pageLink; ?>">
                <?php echo $pageName; ?>
              </a></li>
            <li class="breadcrumb-item active">
              <?php echo nameProject; ?>
            </li>
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
              <h3 class="card-title">Lista de los software del pc Registrado en el sistema <?php echo nameProject; ?> </h3>
            </div>
            <div class="card-body">
            </div>
            <!-- /.card-body -->

            <div class="card-body">
              <!-- Tabla 1 -->
              <table id="example1" class="table table-bordered table-striped">
                <h3> Registro de dispostivo #: <b><?php echo $computerid ?></b> guardado como: <b><?php echo $computername ?></b> <?php echo $computadoraValue ?> </h3>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Fecha de Inventario</th>
                    <th>Software Instalado</th>
                    <th>Fecha de Instalacion</th>

                    <th>Estado</th>
                    <th>Usuario</th>
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

                    // if (validar_permisos($rol, $PermisoPCA)) {
                    //   if ($opciones) {
                    //     echo "<th>Opciones</th>";
                    //   }
                    // }
                    ?>
                    <!-- <th>Opciones</th> -->

                  </tr>
                </thead>
                <tbody>

                  <?php



                  function obtener_registros($conn, $rol, $PermisoPCA)
                  {
                    include "../../includes/conecta.php";

                    if (validar_permisos($rol, $PermisoPCA)) {
                      $idMS = $_GET['p'];
                      // Realizar consulta para obtener todos los registros
                      $stmt = $conn->query("CALL sp_selectAllMappingSoftware($idMS)");
                      // $query= "CALL sp_selectAllUser()";
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
                    <th>Fecha de Inventario</th>
                    <th>Software Instalado</th>
                    <th>Fecha de Instalacion</th>
                    <th>Estado</th>
                    <th>Usuario</th>
                    <?php
                    // if (validar_permisos($rol, $PermisoPCA)) {
                    //   if ($opciones) {
                    //     echo "<th>Opciones</th>";
                    //   }
                    // }
                    ?>
                    <!-- <th>Opciones</th> -->

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

<?php
// Función para eliminar un usuario
function deleteUser()
{
  global $conn; // Acceso a la variable de conexión global $conn

  if (isset($_POST['id'])) { // Verifica si se ha enviado un parámetro 'id' mediante POST
    $id = $_POST["id"];

    // Preparar una llamada a un procedimiento almacenado con un parámetro
    $stmt = $conn->prepare("CALL sp_UpdateSelectMappingSoftware(?)");
    $stmt->bind_param("s", $id); // Vincular el parámetro 'id' al procedimiento almacenado

    $stmt->execute(); // Ejecutar el procedimiento almacenado

    if ($stmt->error) { // Verificar errores en la ejecución
      error_log("Error en la ejecución del procedimiento almacenado: " . $stmt->error);
    }

    // Obtener el resultado del procedimiento almacenado
    $stmt->bind_result($idU);
    $stmt->fetch();

    $stmt->close(); // Cerrar el statement
    $conn->next_result(); // Avanzar al siguiente conjunto de resultados si los hay

    if ($idU > 0) { // Si se realizó con éxito y se afectaron filas
      // Mostrar un script JavaScript después de un retraso de 10 segundos
      echo '<script>
          setTimeout(function() {
            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get("p");

            if (id !== null) {
              // Redirigir a otra página con el parámetro "p"
              window.location.href = "view_mappingSoftware.php?p="+ id;
            }
          }, 10000);
        </script>';
    }
  }
}

// Llamar a la función deleteUser
deleteUser();
?>


<script>
  // Inicializar DataTable
  $(function() {
    var table = $("#example1").DataTable({
      "stateSave": true,
      "responsive": true,
      "searching": true,
      "lengthChange": false,
      "autoWidth": false
    });
  });

  // Manejar el clic en un botón con la clase 'btnDeleteCMP'
  $('#example1').on('click', 'button.btnDeleteCMP', function() {
    var id = $(this).data('id');

    // Mostrar un cuadro de diálogo de confirmación usando SweetAlert
    Swal.fire({
      title: "Actualizar registro",
      text: "¿Estás seguro que deseas cambiar el estado a Instalado este registro N: " + id + "?",
      icon: "info",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Quiero Instalarlo!'
    }).then((result) => {
      if (result.isConfirmed) { // Si el usuario confirma
        $('#deleteId').val(id);

        // Realizar una solicitud AJAX para actualizar el registro
        $.ajax({
          type: "POST",
          url: window.location.href, // URL actual de la página
          data: {
            id: id
          }, // Datos a enviar al servidor
          success: function(response) {
            // Mostrar un cuadro de diálogo de éxito y redirigir después de confirmar
            Swal.fire("Registro Instalado", "El registro ha sido actualizado correctamente", "success").then(() => {
              // Redirigir a otra página con el parámetro 'p'
              var urlParams = new URLSearchParams(window.location.search);
              var id = urlParams.get("p");

              if (id !== null) {
                window.location.href = "view_mappingSoftware.php?p=" + id;
              }
            });
          }
        });
      }
    });
  });
</script>