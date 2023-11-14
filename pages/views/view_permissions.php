<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";


function dataTableUser($stmt, $ListSelectRol, $rol)
{

  $previousRLSDescription = null; // Inicializa un array vacío para almacenar los valores únicos.
  $previusMDUDescriptions = null;
  $lineNumber = "1"; // Inicializa un contador de líneas.
  $position = 0; // Inicializa la variable de posición fuera del bucle para que no se reinicie en cada iteración.
  $border = 0;
  $currentId = 0;
  $currentIdRol = 0;
  $countLine = 0; //conteo de lineas o saltos me ayudara  

  while ($row = $stmt->fetch_assoc()) {

    $countLine++;

    echo "<tr";

    if ($countLine == $border) {
      echo " class='special-row'";
      // echo"<p>num ES igual al conteo" .$lineNumber." -- ".$border ." yes </p>";
    }
    echo ">";
    echo "<td>" . $countLine . "</td>";

    // Iterar sobre cada elemento del array $ListSelectRol y verificar la condición para cada uno de ellos
    if (isset($ListSelectRol[$lineNumber]) && $ListSelectRol[$lineNumber]['id'] == $countLine) {
      $currenteConteo = $ListSelectRol[$lineNumber]['conteo']; // Obtener el valor 'conteo' del primer elemento del array
      $getHalfCount = strval(ceil($currenteConteo / 2));

      // Aumentar la posición en función de la mitad del conteo
    }

    if ($lineNumber === $position) {
      echo "<td align='center'> 
                <a href='../views/update_permissions.php?p=" . $row['RLS_Description'] . "' class='btn btn-outline-primary btn-sm' title='Editar Permisos del Rol " . $currentIdRol . " '>
                    <i class='fas fa-pencil-alt'></i>
                </a>
              </td>";

      echo "<td align='center'><b>" . $currentIdRol . " " . $row['RLS_Description'] . "</b></td>";
    } else {
      echo "<td></td>";
      echo "<td></td>"; // Espacio en blanco si RLS_Description se repite
    }

    $getHalfCount = null; // Inicializar la variable antes del bucle
    $previousCount = 0; // Inicializa una variable para almacenar el 'conteo' anterior



    foreach ($ListSelectRol as $idValueListRol) {
      // Verifica si el 'USP_IDtbl_user_privileges' actual coincide con el 'id' en el arreglo $countRoles
      //Declaro varibale para obtener la lista de los ids 
      if ($countLine == $idValueListRol['id']) {

        // Obtiene el valor 'conteo' del elemento actual del arreglo
        //declaramos variables para obtener los datos actuales del Arreglo
        $currentId = $idValueListRol['id'];
        $currentIdRol = $idValueListRol['idRol'];
        $currentRol = $idValueListRol['rol'];
        $currenteConteo = $idValueListRol['conteo'];
        $currentTotalRegister = $idValueListRol['totalRegistros'];



        //formula para obtener la mitad de la variable currenteConteo
        $getHalfCount = strval(ceil($currenteConteo / 2));
        // Almacenar el resultado de la función array_key_exists en una variable

        // Verifica si 'id' existe en el array actual
        //array key devuelve valores boleanos 
        // $firstArrayValue = array_key_exists('id', $countRole);

        // Obtener el primer valor del array de ids

        $ListSelectId = array_column($ListSelectRol, 'id');
        $listIdRol = array_column($ListSelectRol, 'id');
        $firstArrayValue = strval($listIdRol[0]);

        foreach ($listIdRol as $index => $id) {
          if ($id == $currentId) {
            // echo "Valor de la lista: <br>"; // Esta línea imprimirá el valor de $id en cada iteración.
            // print_r($listIdRol);
            // echo "Valor de id: " . $id . "<br>"; // Esta línea imprimirá el valor de $id en cada iteración.
            // Obtener el índice del primer valor en el array
            $previousCount = array_search($firstArrayValue, $ListSelectId);

            // echo "</pre>";
            // echo "-----------------------------------<br>";
            // echo "valores de la lista<br>";
            // print_r($listIdRol);

            // echo "Valor comparativo: " . $firstArrayValue . "<br>";
            // echo "IdRol: " . $id . "<br>";
            // echo "valor previo del array: " . $previousCount . "<br>";
            if ($id === $firstArrayValue) {

              if ($index === 0) {
                // echo "<br>";
                // echo "ID es Igual al Primer Campo: " . $id . "<br>";
                $position = 0 + $getHalfCount;
                $border = 0 + $currenteConteo;
              }
            } elseif ($id >= $firstArrayValue) {
              // echo "<br>";
              // echo "ID (" . $id . ")es MAYOR que Primer Campo:" . $id . " <br>";
              // Resto de tu lógica condicional
              $position = $ListSelectRol[$previousCount]['conteo'] + $getHalfCount;
              if ($currenteConteo < $currentTotalRegister) {

                $valueRemaining = abs(($ListSelectRol[$previousCount]['conteo'] + $currenteConteo) - $currentTotalRegister);
                // echo "total de rengoles: " . $currentTotalRegister . "<br>";
                // echo "Valor Restante: " . $valueRemaining . "<br>";
                $border = ($ListSelectRol[$previousCount]['conteo'] + $valueRemaining) + $currenteConteo;
              } elseif ($currenteConteo === $currentTotalRegister) {
                $border = $ListSelectRol[$previousCount]['conteo'] + $currenteConteo;
              }
            }
            // echo "<br>";

            // echo "Posición de texto en: " . $position . "<br>";
            // echo "Borde en : " . $border . "<br>";
          }
        }

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

    $lineNumber++;
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

                  $rol = $_SESSION["RLS_idTbl_Roles"];
                  // Verificar si el rol tiene el rol 2 (administrador) y el permiso de PRL   
                  // function validar_permisos($rol, $PermisoRLS)
                  // {
                  //   // echo  "rol  " . $rol . "<br />";
                  //   // echo  "permiso  " . $PermisoRLS . "<br />";

                  //   if ($rol == "2" && $PermisoRLS) {
                  //     return true;
                  //   } else {
                  //     return false;
                  //   }
                  // }


                  function obtener_registros($conn, $rol, $PermisoRLS)
                  {
                    include "../../includes/conecta.php";

                    //declaro la variable del array 
                    //Lista del select de Roles
                    $ListSelectRol = array();


                    $stmt = $conn->query("CALL sp_countRoles()");

                    while ($fila = $stmt->fetch_assoc()) {
                      $dataSelectRol = array(
                        "id" => $fila['USP_IDtbl_user_privileges'],
                        "idRol" => $fila['RLS_idTbl_Roles'],
                        "rol" => $fila['RLS_Description'],
                        "conteo" => $fila['countRoles'],
                        "totalRegistros" => $fila['TotalCount']
                      );
                      $ListSelectRol[] = $dataSelectRol;
                    }
                    $stmt->close();
                    $conn->next_result();



                    // Realizar consulta para obtener todos los registros
                    $stmt = $conn->query("CALL sp_selectAllPermissions()");
                    // Ejecutar el procedimiento almacenado
                    // Obtener todos los resultados

                    dataTableUser($stmt, $ListSelectRol, $rol);
                    $stmt->close();
                    $conn->next_result();

                    // if (validar_permisos($rol, $PermisoRLS)) {
                    //   // Codigo para Todos los Roles


                    // }
                    //  else {
                    //   // Codigo para Roles Activos

                    //   $stmt = $conn->query("CALL sp_countRolesActivos()");

                    //   while ($fila = $stmt->fetch_assoc()) {
                    //     $dataSelectRol = array(
                    //       "id" => $fila['USP_IDtbl_user_privileges'],
                    //       "rol" => $fila['RLS_Description'],
                    //       "conteo" => $fila['countRoles'],
                    //       "totalRegistros" => $fila['TotalCount']
                    //     );
                    //     $ListSelectRol[] = $dataSelectRol;
                    //   }
                    //   $stmt->close();
                    //   $conn->next_result();


                    //   // Realizar consulta para obtener solo registros activos
                    //   $stmt = $conn->query("CALL sp_selectActivePermissions ()");

                    //   // Ejecutar el procedimiento almacenado
                    //   // Obtener todos los resultados
                    //   dataTableUser($stmt, $ListSelectRol);
                    //   $stmt->close();
                    //   $conn->next_result();
                    // }
                  }
                  obtener_registros($conn, $rol, $PermisoRLS);
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