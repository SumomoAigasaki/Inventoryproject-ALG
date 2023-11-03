<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";
$rol = $_SESSION["RLS_idTbl_Roles"];
// Verificar si el rol tiene el rol 2 (administrador) y el permiso de PRL   
function validar_permisos($rol, $PermisoRLS)
{
  if ($rol == "2" && $PermisoRLS) {
    return true;
  } else {
    return false;
  }
}



function dataTableUser($stmt, $countRoles)
{
  $previousRLSDescription = null; // Inicializa un array vacío para almacenar los valores únicos.
  $previusMDUDescriptions = null;
  $lineNumber = "1"; // Inicializa un contador de líneas.
  $position = 0; // Inicializa la variable de posición fuera del bucle para que no se reinicie en cada iteración.
  $border = 0;
  $idrol = 0;

  while ($row = $stmt->fetch_assoc()) {
    echo "<tr";
    if ($row['USP_IDtbl_user_privileges'] == $border) {
      echo " class='special-row'";
      // echo"<p>num ES igual al conteo" .$lineNumber." -- ".$border ." yes </p>";
    }
    echo ">";
    echo "<td>" . $row['USP_IDtbl_user_privileges'] . "</td>";

    // Iterar sobre cada elemento del array $countRoles y verificar la condición para cada uno de ellos
    if (isset($countRoles[$lineNumber]) && $countRoles[$lineNumber]['id'] == $row['USP_IDtbl_user_privileges']) {
      $conteo = $countRoles[$lineNumber]['conteo']; // Obtener el valor 'conteo' del primer elemento del array
      $cr_CountRoles = strval(ceil($conteo / 2));

      // Aumentar la posición en función de la mitad del conteo
    }

    if ($lineNumber === $position) {
      echo "<td align='center'> 
              <button href='../views/update_peripherals.php?p=" . $row['USP_IDtbl_user_privileges'] . "' class='btn btn-outline-primary btn-sm' title='Editar Permisos del Rol " . $idrol . " '>
                  <i class='fas fa-pencil-alt'></i>
              </button>
            </td>";

      echo "<td align='center'><b>" . $idrol . " " . $row['RLS_Description'] . "</b></td>";
    } else {
      echo "<td></td>";
      echo "<td></td>"; // Espacio en blanco si RLS_Description se repite
    }

    $cr_CountRoles = null; // Inicializar la variable antes del bucle
    $previousCount = 0; // Inicializa una variable para almacenar el 'conteo' anterior



    foreach ($countRoles as $countRole) {
      // Verifica si el 'USP_IDtbl_user_privileges' actual coincide con el 'id' en el arreglo $countRoles
      if ($row['USP_IDtbl_user_privileges'] == $countRole['id']) {
        // Obtiene el valor 'conteo' del elemento actual del arreglo
        $conteo = $countRole['conteo'];
        // Calcula la mitad de 'conteo' y lo convierte en una cadena
        $cr_CountRoles = strval(ceil($conteo / 2));

        $idrol = $countRole['id'];
        $totalCount =$countRole['total'];

        // Almacenar el resultado de la función array_key_exists en una variable

        // Verifica si 'id' existe en el array actual
        //array key devuelve valores boleanos 
        // $firstArrayValue = array_key_exists('id', $countRole);
        $firstArrayValue = $countRoles[0]['id'];

        // En esta linea de codigo se quiere acceder a los datos de manera dinamica atravez de conteo y la variable cr_countRoles
        //para obtener la posicion ya que por medio de este obtendremos la mitad de donde se debe colocar la palabra de admin 

        // Verifica si el 'id' es el primer valor
        if ($idrol == $firstArrayValue) {

          // Si el 'id' es 1, calcula la posición basada en 0 y 'cr_CountRoles' y muestra un mensaje correspondiente
          $position = 0 + $cr_CountRoles;
          $border = 0 + $conteo;
          //  echo "primer valor   " . $idrol . " === " . $firstArrayValue;
          //  echo '.-1 LINEA A IMPRIMIR:' . $position . "\n .-   ";

        } elseif ($idrol >= $firstArrayValue) {
          // Si el rol es mayor que el primer numero del array entonces entrara a 
          //obtenemos el conteo del array anterior y le sumamos lo que esta dentro de la varibale
          $position = $countRoles[$previousCount]['conteo'] + $cr_CountRoles;
          
          //validacion para imprimir el border en la posicion que se deberia 
            if ( $conteo < $totalCount ){
              // echo"<p><b>conteo es menor que el total registros</b></p>";
              //Variable para guardar el valor de la resta
              $valueRemaining=abs(($countRoles[$previousCount]['conteo'] + $conteo) -$totalCount); 

              // echo"<p>posicion: ".$valor."   numero total de filas:".$totalCount."</p>";
              // echo"<p>valor restante es: ". $valueRemaining."</p>";
              $border = ($countRoles[$previousCount]['conteo']+$valueRemaining) + $conteo;

            }
            elseif  ( $conteo === $totalCount ){
              // echo"<p></p><b>conteo es igual que el total registros</b></p>";
              $border = $countRoles[$previousCount]['conteo'] + $conteo;
            }
        }

        echo "</p>";
        $previousCount++; // Aumenta 'previousCount' en preparación para la siguiente iteración
        break; // Romper el bucle si se encuentra una coincidencia
      }
    }

    if ($previusMDUDescriptions == $row['MDU_Descriptions']) {
      echo "<td></td>"; // Espacio en blanco si RLS_Description se repite
    } else {
      echo "<td align='center'> <b>" . $row['MDU_Descriptions'] . "</b></td>";
      $previusMDUDescriptions = $row['MDU_Descriptions'];
    }

    echo "<td>" . $row['PRV_Name'] . "</td>";
    echo "<td>" . $row['PRV_Descriptions'] . "</td>";
    echo "<td>" . $row['USP_Inventory_Date'] . "</td>";
    echo "<td>" . $row['STS_Description'] . "</td>";
    echo "<td>" . $row['User_Username'] . "</td>";

    echo "<td align='center'> 
            <button class='btn btn-outline-danger btn-sm btnDeleteUSP' title='Eliminar Permiso' name='btnDeleteUserP' id='btnDeleteUserP' data-id='" . $row['USP_IDtbl_user_privileges'] . "'>
              <i class='fas fa-trash-alt'></i>
            </button>
          </td>";
    echo "</tr>";
    $lineNumber++;
  }
}




if (validar_permisos($rol, $PermisoRLS)) {
  $countRoles = array();
  $stmt = $conn->query("CALL sp_countRoles()");
  while ($fila = $stmt->fetch_assoc()) {
    $countRole = array(
      "id" => $fila['USP_IDtbl_user_privileges'],
      "rol" => $fila['RLS_Description'],
      "conteo" => $fila['countRoles']
    );
    $countRoles[] = $countRole;
  }
  $stmt->close();
  $conn->next_result();

  $stmt = $conn->query("CALL sp_totalCountUSP()");
  while ($row = $stmt->fetch_assoc()) {
    $totalCount = $row['TotalCount'];
    if (!empty($countRoles)) {
      foreach ($countRoles as &$countRole) {
        $countRole["total"] = $totalCount; // Agrega 'total' como una nueva clave en cada elemento del array $countRoles
      }
    }
  }
} else {

  $countRoles = array();

  $stmt = $conn->query("CALL sp_countRolesActivos()");
  while ($fila = $stmt->fetch_assoc()) {
    $countRole = array(
      "id" => $fila['USP_IDtbl_user_privileges'],
      "rol" => $fila['RLS_Description'],
      "conteo" => $fila['countRoles']
    );
    $countRoles[] = $countRole;
  }
  $stmt->close();
  $conn->next_result();

  $stmt = $conn->query("CALL sp_totalCountUSP()");
  while ($row = $stmt->fetch_assoc()) {
    $totalCount = $row['TotalCount'];
    if (!empty($countRoles)) {
      foreach ($countRoles as &$countRole) {
        $countRole["total"] = $totalCount; // Agrega 'total' como una nueva clave en cada elemento del array $countRoles
      }
    }
  }
}


?>

<div class="content-wrapper">
  <style>
    table.dataTable tbody tr.special-row td {
      border-bottom: 2px solid #adb5bd;
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
                    <th>Actualizar</th>
                    <th>Rol </th>
                    <th>Modulo</th>
                    <th>Privilegio</th>
                    <th>Descripcion del Privilegio</th>
                    <th>Fecha de Ingreso</th>
                    <th>Estado</th>
                    <th>Usuario</th>
                    <th>Eliminar</th>
                  </tr>
                </thead>
                <tbody>

                  <?php


                  function obtener_registros($conn, $rol, $PermisoRLS, $countRoles)
                  {
                    include "../../includes/conecta.php";

                    if (validar_permisos($rol, $PermisoRLS)) {

                      // Realizar consulta para obtener todos los registros
                      $stmt = $conn->query("CALL sp_selectAllPermissions()");
                      // $query= "CALL sp_selectAllUser()";
                      // echo $query;
                      // Ejecutar el procedimiento almacenado
                      // Obtener todos los resultados
                      dataTableUser($stmt, $countRoles);
                      $stmt->close();
                      $conn->next_result();
                    } else {
                      // Realizar consulta para obtener solo registros activos
                      $stmt = $conn->query("CALL sp_selectActivePermissions ()");
                      // $query= "CALL CALL sp_selectActiveUser()";
                      // echo $query;
                      // Ejecutar el procedimiento almacenado
                      // Obtener todos los resultados
                      dataTableUser($stmt, $countRoles);
                      $stmt->close();
                      $conn->next_result();
                    }
                  }
                  obtener_registros($conn, $rol, $PermisoPRL, $countRoles);
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Actualizar</th>
                    <th>Rol </th>
                    <th>Modulo</th>
                    <th>Privilegio</th>
                    <th>Descripcion del Privilegio</th>
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