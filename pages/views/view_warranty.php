<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";
require('../../public/FPDF/fpdf.php');

// echo('<pre>');
// var_dump($privilegios);
// echo('</pre>');
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<script>
  function generarPDF(technicalName, todayDate, nombreCompleto, employeeCode, serial, servitag, marca, modelo, mainproblem, actionsDone, Diagnosis, Solutions, acquisitionDate, garantia, warrantyExpiration, status) {
    // Obtener el contenido del reporte
    console.log("Dentro del evento");
    console.log("Valor de Reporte de la Garantis:", technicalName, todayDate, nombreCompleto, employeeCode, serial, servitag, marca, modelo, mainproblem, actionsDone, Diagnosis, Solutions, acquisitionDate, garantia, warrantyExpiration, status);
    // Eliminar espacios en blanco al principio y al final del nombre
    technicalName = technicalName.trim();
    todayDate = todayDate.trim();
    nombreCompleto = nombreCompleto.trim();
    employeeCode = employeeCode.trim();
    serial = serial.trim();
    servitag = servitag.trim();
    marca = marca.trim();
    modelo = modelo.trim();
    mainproblem = mainproblem.trim();
    actionsDone = actionsDone.trim();
    Diagnosis = Diagnosis.trim();
    Solutions = Solutions.trim();
    acquisitionDate = acquisitionDate.trim();
    garantia = garantia.trim();
    warrantyExpiration = warrantyExpiration.trim();
    status = status.trim();

    // Obtener el contenido del reporte
    var contratoElement = document.getElementById('reporte');



    if (!contratoElement) {
      console.error('El elemento con ID "reporte" no existe.');
      return;
    }

    // Obtener el contenido del reporte como HTML
    var contratoHTML = contratoElement.innerHTML;
    // Obtener el elemento que contiene el nombre del colaborador
    var technicalNameElement = document.querySelector('.technicalName');
    var todayDateElement = document.querySelector('.todayDate');
    var nombreCompletoElement = document.querySelector('.nombreCompleto');
    var employeeCodeElement = document.querySelector('.employeeCode');
    var serialElement = document.querySelector('.serial');

    var servitagElement = document.querySelector('.servitag');
    var marcaElement = document.querySelector('.marca');
    var modeloElement = document.querySelector('.modelo');
    var mainProblemElement = document.querySelector('.mainProblem');
    var actionsDoneElement = document.querySelector('.actionsDone');

    var DiagnosisElement = document.querySelector('.Diagnosis');
    var SolutionElement = document.querySelector('.Solution');
    var acquisitionDateElement = document.querySelector('.acquisitionDate');
    var garantiaElement = document.querySelector('.garantia');
    var warrantyExpirationElement = document.querySelector('.warrantyExpiration');
    var statusElemnt = document.querySelector('.status');

    // Verificar si se encontró el elemento
    if (technicalNameElement && todayDateElement && nombreCompletoElement && employeeCodeElement && serialElement &&
      servitagElement && marcaElement && modeloElement && mainProblemElement && actionsDoneElement &&
      DiagnosisElement && SolutionElement && acquisitionDateElement && garantiaElement && warrantyExpirationElement && statusElemnt) {
      // Cambiar el contenido del elemento con el nuevo nombre
      technicalNameElement.textContent = technicalName;
      todayDateElement.textContent = todayDate;
      nombreCompletoElement.textContent = nombreCompleto;
      employeeCodeElement.textContent = employeeCode;
      serialElement.textContent = serial;

      servitagElement.textContent = servitag;
      marcaElement.textContent = marca;
      modeloElement.textContent = modelo;
      mainProblemElement.textContent = mainproblem;
      actionsDoneElement.textContent = actionsDone;

      DiagnosisElement.textContent = Diagnosis;
      SolutionElement.textContent = Solutions;
      acquisitionDateElement.textContent = acquisitionDate;
      garantiaElement.textContent = garantia;
      warrantyExpirationElement.textContent = warrantyExpiration;


      if (status == "Solucionado") {
        statusElemnt.textContent = 'Problema resuelto de manera satisfactorio, se cumplieron los términos de la garantía.';
      } else if (status == "Espera") {
        statusElemnt.textContent = 'El problema está en proceso por lo tanto el folio está abierto todavía no se le ha dado solución por favor esperar a que los técnicos se acerquen para poder cerrar el caso.';
      } else if (status == "Sin Respuesta") {
        statusElemnt.textContent = "El problema no tuvo respuesta volver a hacer el reporte para dar seguimiento. ";
      } else if (status == "Cancelado") {
        statusElemnt.textContent = "El problema no se resolvió porque hubo problemas con la gestión por lo cual no se le pudo dar seguimiento. ";
      } else if (status == "Deshabilitado") {
        statusElemnt.textContent = "El Registro actualmente se encuentra Deshabilidato del Sistema, por lo tanto no es como que cuente con alguna cobertura conforme de la garantia.";
      }

    }

    console.log("Contrato HTML después de sustituciones:", contratoHTML);

    var contratoHTML = document.getElementById('reporte').innerHTML;
    // Obtener el contenido del reporte
    var contratoHTML = contratoElement.innerHTML;
    // Eliminar etiquetas HTML del contenido
    var contenidoLimpio = contratoHTML.replace(/<\/?[^>]+(>|$)/g, "");

    // Crear un nuevo objeto jsPDF con configuraciones personalizadas
    var pdf = new jsPDF({
      orientation: 'portrait', // Orientación del papel ('portrait' o 'landscape')
      unit: 'cm', // Unidades de medida ('mm', 'cm', 'in', 'px')
      format: 'letter', // Tamaño del papel ('a3', 'a4', 'letter', etc.)
      marginLeft: 2.5, // Márgen izquierdo en centímetros
      marginRight: 2.5, // Márgen derecho en centímetros
      marginTop: 2.5, // Márgen superior en centímetros
      marginBottom: 2.5 // Márgen inferior en centímetros
    });

    //ENCABEZADO
    // Agregar el encabezado personalizado

    function addHeader() {
      var logoUrl = '../../resources/Warranty/LogoALG.png'; // Ruta a la imagen local
      var imgData = getBase64Image(logoUrl);
      pdf.addImage(imgData, 'PNG', 2.5, 0.5, 4.5, 2); // Ajusta los parámetros según sea necesario (x, y, ancho, alto)
      pdf.setFontSize(11);
      pdf.text("Azucarera la Grecia S.A de C.V", 14, 1);
      pdf.setFontSize(9);
      pdf.text("Kilómetro 21, Carretera hacia Cedeño, Marcovia", 13, 1.5);
      pdf.text("Marcovia, Choluteca, Honduras C.A", 14, 2);
      pdf.text("Tel: 2705-3900 / Correo: info@azucareralagrecia.com", 12, 2.5);
    }

    

    // Cambiar el tipo de letra y tamaño de fuente
    pdf.setFont("helvetica"); // Cambia "helvetica" al nombre del tipo de letra deseado
    pdf.setFontSize(12); // Tamaño de fuente

    // Dividir y procesar el contenido limpio en líneas
    var lines = pdf.splitTextToSize(contenidoLimpio, 16);

    // Agregar cada línea al PDF
    // Llamar a la función addHeader() antes de agregar el contenido

    var y = 3; // Posición vertical inicial
    for (var i = 0; i < lines.length; i++) {
      pdf.setFontStyle('bold');
      pdf.text(2.5, 2.5, lines[0], {
        align: 'center'
      });
      pdf.setFontStyle('normal'); // Restaurar el estilo de fuente normal
      if (y + 0.5 > pdf.internal.pageSize.height - 2.5) {
        pdf.addPage(); // Agregar una nueva página cuando el contenido se desborda
        y = 2.5; // Reiniciar la posición vertical
      }
      pdf.text(2.5, y, lines[i], {
        align: 'justify'
      });
      y += 0.5; // Aumentar la posición vertical
    }

    var totalPages = 1; // Establece el número total de páginas inicialmente en 1

    // Agregar pie de página
    function addFooter() {
      pdf.setFontSize(10);
      pdf.setTextColor(100);
      pdf.text(
        'Informe distribuido por el sistema INFRAG',
        2.5,
        pdf.internal.pageSize.getHeight() - 1
      );
      pdf.text(
        'Página ' + i + ' de ' + totalPages,
        pdf.internal.pageSize.getWidth() - 2.5,
        pdf.internal.pageSize.getHeight() - 1, {
        align: 'right'
        }
      );
    }

    // Al final, antes de generar el PDF, calcula el número total de páginas
    totalPages = pdf.internal.getNumberOfPages();

    for (var i = 1; i <= totalPages; i++) {
      pdf.setPage(i);
      addHeader();
      addFooter();
    }
    // Abre la vista previa de impresión del navegador
    pdf.output('dataurlnewwindow');
    // Genera el PDF
    pdf.save('nombre_archivo.pdf');
  

    var nombreCompletoElement = document.querySelector('.nombreCompleto');

    // Obtener el contenido del párrafo
    var colaborador = nombreCompletoElement.textContent;

    // Verifica si el valor se ha obtenido correctamente
    console.log('Valor de colaborador:', colaborador);
  }

  // Función para convertir la imagen a base64
  function getBase64Image(imgUrl) {
    var img = new Image();
    img.src = imgUrl;
    var canvas = document.createElement("canvas");
    canvas.width = img.width;
    canvas.height = img.height;
    var ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);
    var dataURL = canvas.toDataURL("image/png");
    return dataURL;
  }
  //FECHA
  document.addEventListener("DOMContentLoaded", function() {
    function obtenerFechaEnLetras() {
      const meses = [
        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
      ];

      const fechaActual = new Date();
      const dia = fechaActual.getDate();
      const mes = meses[fechaActual.getMonth()];
      const año = fechaActual.getFullYear();

      return `${dia} de ${mes} del ${año}`;
    }

    // Obtenemos la referencia a la etiqueta <p> por su id
    const parrafoFecha = document.getElementById("fecha");

    // Llamamos a la función para obtener la fecha en letras
    const fechaEnLetras = obtenerFechaEnLetras();

    // Asignamos el valor al contenido de la etiqueta <p>
    parrafoFecha.textContent = fechaEnLetras;
  });
</script>
<?php
function dataTableUser($stmt)
{
  while ($row = $stmt->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['WR_idTbl_Warranty_Registration'] . "</td>";
    echo "<td>" . $row['WR_Inventory_Date'] . "</td>";
    echo "<td>" . $row['WR_Application_Number'] . "</td>";
    echo "<td>" . $row['WR_Date_Admission'] . "</td>";
    echo "<td>" . $row['Info'] . "</td>";
    echo "<td>";

    if (empty($row['WR_Image_Problem'])) {
      echo "<li class='list-inline-item'>
                      <img alt='Avatar' width='50' height='50' class='table-avatar img-circle' src='../../resources/Warranty/default.jpg'>
                    </li>" . $row['WR_Main_Problem'];
    } else {
      echo "<li class='list-inline-item'>
                      <img alt='Avatar' width='50' height='50' class='table-avatar img-circle' src='../.." . $row['WR_Image_Problem'] . "'>
                    </li>   " . $row['WR_Main_Problem'];
    }
    echo "</td>";
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
    echo "" . $row['STS_Description']  . "</td>";
    echo "<td>" . $row['User_Username'] . "</td>";

    $WR_ActionsDone = $row['WR_ActionsDone'];
    $WR_Diagnosis = $row['WR_Diagnosis'];
    $WR_Solution = $row['WR_Solution'];
    $WR_Image_Solution = $row['WR_Image_Solution'];
    $WR_Date_Solution = $row['WR_Date_Solution'];

    include "../../includes/conecta.php";
    $idWR = $row['WR_idTbl_Warranty_Registration'];
    $newstmt =  $conn->prepare("CALL sp_reportWarranty('$idWR')");
    $newstmt->execute();

    // Obtiene los resultados
    $result = $newstmt->get_result();

    while ($fila = $result->fetch_assoc()) {
      //optenemos las variables del select y la asignamos a la session activa
      $NombreCompleto =  $fila["NombreCompleto"];
      $CMP_Technical_Name  = $fila["CMP_Technical_Name"];
      $CBT_Address =  $fila["CBT_Address"];
      $Nacionalidad =  $fila["Nacionalidad"];
      $CBT_Employee_Code =  $fila["CBT_Employee_Code"];
      $CMP_Acquisition_Date =  $fila["CMP_Acquisition_Date"];
      $TG_Description = $fila["TG_Description"];
      $CMP_Warranty_Expiration = $fila["CMP_Warranty_Expiration"];
      $CMP_Serial = $fila["CMP_Serial"];
      $CMP_Servitag = $fila["CMP_Servitag"];
      $MDL_Description = $fila["MDL_Description"];
      $MFC_Description = $fila["MFC_Description"];
      $WR_Main_ProblemPDF = $fila["WR_Main_Problem"];
      $WR_ActionsDonePDF = $fila["WR_ActionsDone"];
      $WR_DiagnosisPDF = $fila["WR_Diagnosis"];
      $WR_SolutionPDF = $fila["WR_Solution"];
      $STS_DescriptionPDF = $fila["STS_Description"];
    }
    date_default_timezone_set('America/Mexico_City');
    $todayDate = date("Y-m-d");

    echo "<td align='center'> 
            <a href='../views/update_collaborator.php?p=" . $row['WR_idTbl_Warranty_Registration'] . "' class='btn btn-outline-primary btn-sm' title='Editar Registro'>
              <i class='fas fa-pencil-alt'></i>
            </a>
          

            <button class='btn  btn-outline-info btn-sm ImprimirReporte' title='Imprimir Contrato' name='ImprimirReporte' id='ImprimirReporte' onclick=\"return generarPDF('" . $CMP_Technical_Name . "', '" . $todayDate . "', '" . $NombreCompleto . "','" . $CBT_Employee_Code . "','" . $CMP_Serial . "','" . $CMP_Servitag . "','" . $MFC_Description . "','" . $MDL_Description . "','" . $WR_Main_ProblemPDF . "','" . $WR_ActionsDonePDF . "','" . $WR_DiagnosisPDF . "','" . $WR_SolutionPDF . "','" . $CMP_Acquisition_Date . "','" . $TG_Description . "','" . $CMP_Warranty_Expiration . "', '" . $STS_DescriptionPDF . "');\">
            <i class='fas fa-folder'></i>
            </button>
  <div id='reporte' style='display: none;'>              
                   <h1>                   <b>Informe de Reporte Técnico en Garantía </p> </h1>
                                  
<p><b>.--INFORME DE GARANTÍA DEL PRODUCTO/EQUIPO</b> </p>
<p>Para :<p class='nombreCompleto'>" . $NombreCompleto . "</p> .-Responsable de Hacer el reporte-. </p>
<p>Área de IT Software de Azucarera la Grecia S.A de C.V</p>
<p>Kilómetro 21, Carretera hacia Cedeño </p>
<p>Marcovia, Choluteca, Honduras C.A</p>

<p><b>.--CÓDIGO DE COLABORADOR:<p class='employeeCode'>" . $CBT_Employee_Code . "</p></b></p> 
<p><b>.--NUMERO DE GARANTÍA: <p class='serial'>" . $CMP_Serial . "</p></b></p>

<p><b>.--DESCRIPCIÓN DEL PRODUCTO GARANTIZADO:</b> </p>
<p> Nombre Tecnico del ordenador: <p class='technicalName'>" . $CMP_Technical_Name . "</p> </p>
<p> Servitag :<p class='servitag'>" . $CMP_Servitag . "</p> </p>
<p> Marca y Modelo: <p class='marca'>" . $MFC_Description . "</p>, <p class='modelo'>" . $MDL_Description . "</p>  </p>

<p><b>.--DESCRIPCIÓN DEL PROBLEMA REPORTADO</b> </p>
<p class='mainProblem'>" . $WR_Main_ProblemPDF . "</p>

<p><b>.--ACCIONES REALIZADAS</b></p>
<p class='actionsDone'>" . $WR_ActionsDonePDF . "</p>

<p><b>.--EVALUACIÓN DE GARANTÍA </b></p>
<p>El producto fue adquirido <p class='acquisitionDate'> <b>" . $CMP_Acquisition_Date . "</b>.</p>
<p>Con una tipo de garantía :<p class='garantia'> <b>" . $TG_Description . "</b>.</p> </p>
<p>La cual expira en <p class='warrantyExpiration'> <b>" . $CMP_Warranty_Expiration . "</b></p></p>
<p>fecha que estamos actualmente <p class='todayDate'><b>" . $todayDate . "</b></p> </p>


<p><b>.--DIAGNOSTICOS Y REPARACIÓN. </b></p>
<p class='Diagnosis'>" . $WR_DiagnosisPDF . "</p>

<p><b>.--SOLUCIÓN DEL PROBLEMA.  </b></p>
<p class='Solution'>" . $WR_SolutionPDF . "</p>

<p><b>.--CONCLUSION.</b></p>

<p class='status'>" . $STS_DescriptionPDF . "</p>


<p>Informe distribuido por el sistema INFRAG </p>
<p>Fecha De entrega del informe <p id='fecha'></p> en Marcovia, Choluteca. </p>




<p><b>           ATENTAMENTE:</b></p>



<p>                                          __________________________</p>
<p class='nombreCompleto'>                                                          " . $NombreCompleto . "</p>



              </div>


            <button class='btn btn-outline-danger btn-sm btnDeleteCMP' title='Eliminar Registro' name='btnDeletWR' id='btnDeletWR' data-id='" . $row['WR_idTbl_Warranty_Registration'] . "'>
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
                    <th>Fecha Inventario</th>
                    <th>Número de Reporte</th>
                    <th>Fecha Creación Reporte</th>
                    <th>Computadora</th>
                    <th>Problema Principal </th>
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
                    <th>Fecha Inventario</th>
                    <th>Número de Reporte</th>
                    <th>Fecha Creación Reporte</th>
                    <th>Computadora</th>
                    <th>Problema Principal </th>
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
function deleteUser()
{
  global $conn; // Utilizar la variable $conn en el ámbito de la función

  if (isset($_POST['id'])) {
    $id = $_POST["id"];

    $stmt = $conn->prepare("CALL sp_deleteCollaborator(?)");
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
            window.location.href = "view_collaborator.php";
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
              window.location.href = "view_collaborator.php";
            });
          }
        });
      }
    });

  });
</script>