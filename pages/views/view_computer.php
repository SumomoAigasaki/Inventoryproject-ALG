<?php
require_once "../templates/title.php";



function dataTableComputer($stmt)
{
  while ($row = $stmt->fetch_assoc()) {
    echo "
                <tr> 
                <td>" . $row['CMP_idTbl_Computer'] . "</td>
                <td>" . $row['CMP_Inventory_Date'] . "</td>
                <td>" . $row['MFC_Description'] . "</td>
                ";
    if (empty($row['CMP_Image'])) {
      echo "<td> <li class='list-inline-item'>
                  <img alt='Avatar' width='50' height='50'  class='table-avatar  img-circle' src='../../resources/Computer/default.jpg ' >         
                  </li></td>";
    } else {
      echo "<td> <li class='list-inline-item'>
                  <img alt='Avatar' width='50' height='50'  class='table-avatar  img-circle' src='../.." . $row['CMP_Image'] . " ' >         
                  </li></td>";
    }
    echo "
                <td>" . $row['CMP_Technical_Name'] . "</td>
                <td>" . $row['MDL_Description'] . "</td>
                <td>" . $row['CT_Description'] . "</td>
                <td>" . $row['CMP_Servitag'] . "</td>
                <td>" . $row['CMP_License'] . "</td>
                <td>" . $row['CMP_Motherboard'] . "</td>
                <td>" . $row['CMP_Acquisition_Date'] . "</td>
                <td>" . $row['CMP_Warranty_Expiration'] . "</td>
                <td>" . $row['TG_Description'] . "</td>
                <td>" . $row['CMP_Warranty_Year'] . "</td>
                <td>" . $row['STS_Description'] . "</td>
                <td>" . $row['LCT_Description'] . "</td>
                <td>" . $row['CMP_Observations'] . "</td>
                <td>" . $row['CMP_Report'] . "</td>
                <td>" . $row['User_Username'] . "</td>
                <td align='center'>";

    // Verificamos si tiene permiso para actualizar
    if (isset($_SESSION["U-CMP"]) && $_SESSION["U-CMP"]) {
      echo '<a href="../views/uComputer.php?p=' . $row['CMP_idTbl_Computer'] . '" class="btn btn-outline-primary btn-sm" title="Editar Registro"><i class="fas fa-pencil-alt"></i></a>';
    } else {
      echo '';
    }

    if (isset($_SESSION["D-CMP"]) && $_SESSION["D-CMP"]) {
      echo '<button class="btn btn-outline-danger btn-sm btnDeleteCMP"  title="Eliminar Registro" name="btnDeleteCMP" id="btnDeleteCMP" data-id="' . $row['CMP_idTbl_Computer'] . '"><i class="fas fa-trash-alt"></i></button> </td>';
    } else {
      echo '';
    }

    echo "</tr>";
  }
}

?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <form id="deleteForm" method="POST" action="">
        <input type="hidden" name="id" id="deleteId">
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
              <th>Fecha Inventario</th>
              <th>Marca</th>
              <th>Imagen</th>
              <th>Nomb. Tecnico</th>
              <th>Modelo</th>
              <th>Tipo PC</th>
              <th>Serial</th>
              <th>Licencia</th>
              <th>Motherboard</th>
              <th>Fecha Adquisición</th>
              <th>Fecha Limite Garantia</th>
              <th>Tipo Garantia</th>
              <th>Año limite Garantia</th>
              <th>Estado</th>
              <th>Localizacion</th>
              <th>Observaciones</th>
              <th>Imagen de Reporte</th>
              <th>Usuario</th>
              <th>Opciones</th>

            </tr>
          </thead>
          <tbody>

            <?php

            // Validar permiso VR-CMP
            $permisoVRCMP = isset($_SESSION["VR-CMP"]) && $_SESSION["VR-CMP"];

            // Validar permiso VA-CMP
            $permisoVACMP = isset($_SESSION["VA-CMP"]) && $_SESSION["VA-CMP"];

            //Valido si tiene el permiso de ver todos los registros 
            if ($permisoVRCMP) {
              $stmt = $conn->query("CALL sp_selectAllComputers()");
              // Ejecutar el procedimiento almacenado
              // Obtener todos los resultados
              dataTableComputer($stmt);
              $stmt->close();
              $conn->next_result();
            }
            //Registros solo Activos 
            else if ($permisoVACMP) {
              $stmt = $conn->query("CALL sp_selectActiveComputers()");
              // Ejecutar el procedimiento almacenado
              // Obtener todos los resultados
              dataTableComputer($stmt);
              $stmt->close();
              $conn->next_result();
            }
            //si tiene ambos permisos


            else if ($permisoVRCMP && $permisoVACMP) {
              $stmt = $conn->query("CALL sp_selectAllComputers()");
              // Ejecutar el procedimiento almacenado
              // Obtener todos los resultados
              dataTableComputer($stmt);

              $stmt->close();
              $conn->next_result();
            }
            //si no tiene ninguno
            else {
              // Al menos uno de los permisos no está activo;
            }
            ?>
          </tbody>
          <tfoot>
            <tr>
              <th>#</th>
              <th>Fecha Inventario</th>
              <th>Marca</th>
              <th>Imagen</th>
              <th>Nomb. Tecnico</th>
              <th>Modelo</th>
              <th>Tipo PC</th>
              <th>Serial</th>
              <th>Licencia</th>
              <th>Motherboard</th>
              <th>Fecha Adquisición</th>
              <th>Fecha Limite Garantia</th>
              <th>Tipo Garantia</th>
              <th>Año limite Garantia</th>
              <th>Estado</th>
              <th>Localizacion</th>
              <th>Observaciones</th>
              <th>Imagen de Reporte</th>
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
<!-- /.card -->

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
          data: {id: id}, // Datos a enviar al servidor
          success: function(response) {
          Swal.fire("Registro eliminado", "El registro ha sido eliminado correctamente", "success").then(() => {
            // Redireccionar después de mostrar el SweetAlert
            window.location.href = "view_computer.php";
          });
        }
      });
    }
  });

});
</script>
<?php
function deleteComputer()
{
  global $conn; // Utilizar la variable $conn en el ámbito de la función

  if (isset($_POST['id'])) {
    $id = $_POST["id"];

    if ($_SESSION["U-CMP"]) {
      $stmt = $conn->prepare("CALL sp_deleteComputer(?)");
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
      $stmt->bind_result($idC);
      $stmt->fetch();
      // Cerrar el statement
      $stmt->close();
      // Avanzar al siguiente conjunto de resultados si hay varios
      $conn->next_result();

      if ($idC > 0) {
        echo '<script>
          setTimeout(function() {
            window.location.href = "view_computer.php";
          }, 10000);
        </script>';
      }
    }
  }
}

// Llamar a la función deleteComputer
deleteComputer();
?>

<?php
require_once "../templates/footer.php";
?>