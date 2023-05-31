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
                <td>" . $row['CMP_Image'] . "</td>
                <td>" . $row['CMP_Technical_Name'] . "</td>
                <td>" . $row['MDL_Description'] . "</td>
                <td>" . $row['CT_Description'] . "</td>
                <td>" . $row['CMP_Servitag'] . "</td>
                <td>" . $row['CMP_License'] . "</td>
                <td>" . $row['CMP_Motherboard'] . "</td>
                <td>" . $row['CMP_Acquisition_Date'] . "</td>
                <td>" . $row['CMP_Warranty_Expiration'] . "</td>
                <td>" . $row['CMP_Warranty_Year'] . "</td>
                <td>" . $row['STS_Description'] . "</td>
                <td>" . $row['LCT_Description'] . "</td>
                <td>" . $row['CMP_Observations'] . "</td>
                <td>" . $row['CMP_Report'] . "</td>
                <td>" . $row['User_Username'] . "</td>
                <td align='center'>";

    // Verificamos si tiene permiso para actualizar
    if (isset($_SESSION["U-CMP"]) && $_SESSION["U-CMP"]) {
      echo '<a href="../views/uComputer.php?p=' . $row['CMP_idTbl_Computer'] . '" class="btn btn-outline-primary btn-sm" title="Editar Registro"><i class="fas fa-edit"></i></a>';
    } else {
      echo '';
    }

    if (isset($_SESSION["D-CMP"]) && $_SESSION["D-CMP"]) {
      echo '<button class="btn btn-outline-danger btn-sm" title="Eliminar Registro"><i class="fas fa-trash-alt"></i></button> </td>';
    } else {
      echo '';
    }

    echo "</tr>";
  }
}

?>
<!-- DataTables -->
<link rel="stylesheet" href="../../public/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../../public/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="../../public/css/buttons.bootstrap4.min.css">

  <div class="card card-primary card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0">
      <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
        <li class="nav-item">
          <!--Boton del Nav para Computadoras-->
          <a class="nav-link active" id="custom-tabs-four-computer-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Computadoras</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Messages</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Settings</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="tab-content" id="custom-tabs-four-tabContent">
        <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-computer-tab">
          <!-- contenido para la el datatable 1-->
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Listado General de Computadoras del sistema <?php echo nameProject; ?> </h3>
                  </div>
                  <div class="card-body">
                    <!-- Tabla 1 -->
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Num.</th>
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
                          <th>Num.</th>
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
                <!-- /.card -->
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
          Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.
        </div>
        <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
          Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
        </div>
        <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
          Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis.
          <div>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.card -->
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
              extend: 'pdfHtml5',
              text: '<i class="fas fa-file-pdf"></i>',
              titleAttr: 'Exportar a PDF',
              className: 'btn btn-danger',
              orientation: "landscape",
              pageSize: "LETTER",
              title: 'Reporte General de Computadoras Registras en INFRAG | Sistema para la Gestión y Control de Inventario en Departamento IT de ALG',

              exportOptions: {
                columns: ':visible',
                modifier: {
                  page: 'all'
                }
              },

              customize: function(doc) {
                doc.pageMargins = [40, 40, 40, 40];
                doc.defaultStyle.fontSize = 10;
                doc.styles.tableHeader.fontSize = 10;
                doc.styles.title.fontSize = 11;

                // Remove spaces around page title
                doc.content[0].text = doc.content[0].text.trim();
                doc['header'] = (function() {
                  return {
                    columns: [
                      'Azucarera La Grecia S.A de C.V',
                      {
                        alignment: 'right',
                        text: [todayDate]
                      }
                    ],
                    margin: [15, 15]

                  }
                });
                doc.content[0].text = doc.content[0].text.trim();
                // Create a footer
                doc['footer'] = (function(page, pages) {
                  return {
                    columns: [
                      'Información Confidencial del Departamento IT   Prohibido la distribución, copia(as) de este documento',
                      {
                        // This is the right column
                        alignment: 'right',
                        text: ['page ', {
                          text: page.toString()
                        }, ' of ', {
                          text: pages.toString()
                        }]
                      }
                    ],
                    margin: [15, 0]
                  }
                });

              }
            },
            {
              extend: 'csv',
              text: '<i class="fas fa-file-csv"></i> <style> btn {background-color: #FCFCFC}</style>',
              className: 'btn bg-olive',
              titleAttr: 'Exportar CSV'

            },

            {
              extend: 'excelHtml5',
              text: '<i class="fas fa-file-excel"></i>',
              className: 'btn btn-success',
              titleAttr: 'Exportar a Excel'
            },
            {
              extend: 'print',
              text: '<i class="fas fa-print"></i>',
              titleAttr: 'Imprimir',
              className: 'btn btn-secondary',
              messageTop: 'This print was produced using the Print button for DataTables',

              exportOptions: {
                columns: ':visible'
              }
            },

            {
              extend: 'colvis',
              text: '<i class="fas fa-eye"></i>',
              titleAttr: 'Imprimir',
              className: 'btn btn-info'
            }

          ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');



      });
    </script>

    <?php
    require_once "../templates/footer.php";
    ?>