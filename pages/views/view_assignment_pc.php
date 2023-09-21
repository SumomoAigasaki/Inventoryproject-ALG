<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";
require('../../public/FPDF/fpdf.php');

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<script>
  function generarPDF(name, user,codeuser,cargo,marca,modelo,serial, garantia) {
    // Obtener el contenido del contrato
    console.log("Dentro del evento");
    console.log("Valor de colaborador:", name, user, codeuser, cargo,marca,modelo,serial,garantia);
    // Eliminar espacios en blanco al principio y al final del nombre
    name = name.trim();
    user = user.trim();
    codeuser = codeuser.trim();
    cargo= cargo.trim();
    marca= marca.trim();
    modelo=modelo.trim();
    serial= serial.trim();
    garantia= garantia.trim();

    // Obtener el contenido del contrato
    var contratoElement = document.getElementById('contrato');



    if (!contratoElement) {
      console.error('El elemento con ID "contrato" no existe.');
      return;
    }

    // Obtener el contenido del contrato como HTML
    var contratoHTML = contratoElement.innerHTML;
    // Obtener el elemento que contiene el nombre del colaborador
    var colaboradorElement = document.querySelector('.namecolaborador');
    var userElement = document.querySelector('.nameuser');
    var codeuserElement = document.querySelector('.numeroIdentificación');
    var cargoElement = document.querySelector('.EmployeePosition');
    var marcaElement = document.querySelector('.marca');
    var modeloElement = document.querySelector('.modelo');
    var serialElement = document.querySelector('.serie');
    var garantiaElement = document.querySelector('.garantia');
    var firmacolaboradorElement = document.querySelector('.firmacolaborador');
    

    // Verificar si se encontró el elemento
    if (colaboradorElement && userElement && codeuserElement && cargoElement && marcaElement && modeloElement && serialElement && garantiaElement && firmacolaboradorElement ) {
      // Cambiar el contenido del elemento con el nuevo nombre
      colaboradorElement.textContent = name;
      userElement.textContent = user;
      codeuserElement.textContent = codeuser;   
      cargoElement.textContent = cargo;
      marcaElement.textContent = marca;
      modeloElement.textContent = modelo; 
      serialElement.textContent = serial; 
      garantiaElement.textContent = garantia;
      firmacolaboradorElement.textContent = name;
    }

    console.log("Contrato HTML después de sustituciones:", contratoHTML);

    var contratoHTML = document.getElementById('contrato').innerHTML;
    // Obtener el contenido del contrato
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

    // Cambiar el tipo de letra y tamaño de fuente
    pdf.setFont("helvetica"); // Cambia "helvetica" al nombre del tipo de letra deseado
    pdf.setFontSize(12); // Tamaño de fuente

    // Dividir y procesar el contenido limpio en líneas
    var lines = pdf.splitTextToSize(contenidoLimpio, 16);

    // Agregar cada línea al PDF
    var y = 2.5; // Posición vertical inicial
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

    // Abre la vista previa de impresión del navegador
    pdf.output('dataurlnewwindow');
    // Generar el PDF
    console.log("PDF Generado");

    var colaboradorElement = document.querySelector('.namecolaborador');

    // Obtener el contenido del párrafo
    var colaborador = colaboradorElement.textContent;

    // Verifica si el valor se ha obtenido correctamente
    console.log('Valor de colaborador:', colaborador);
  }



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
<!-- <script>
  document.addEventListener("DOMContentLoaded", function() {
        // Función para generar el PDF desde el contenido del contrato
        document.getElementById("imprimirContrato").addEventListener("click", function() {
            const contratoHTML = document.getElementById("contrato").innerHTML;
            const pdf = new jsPDF();
            
            // Agregar el contenido HTML del contrato al PDF
            pdf.fromHTML(contratoHTML, 15, 15);

            // Guardar el PDF con un nombre específico
            pdf.save("contrato.pdf");
        });
      });
    </script> -->

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
    
    include "../../includes/conecta.php";
    $idPCA = $row['PCA_idTbl_PC_Assignment'];
    $newstmt =  $conn->prepare("CALL sp_dataContract('$idPCA')");
    $newstmt->execute();

    // Obtiene los resultados
    $result = $newstmt->get_result();

    while ($fila = $result->fetch_assoc()) {
      //optenemos las variables del select y la asignamos a la session activa
      $NameCollaborator =  $fila["NameCollaborator"];
      $EmployeeCode =  $fila["EmployeeCode"];
      $EmployeePosition =  $fila["EmployeePosition"];
      $Marca =  $fila["Marca"];
      $Modelo =  $fila["Modelo"];
      $Serial = $fila["Serial"];
      $Garantia = $fila["Garantia"];
    }


    echo "<td align='center'> 
            <a href='../views/update_collaborator.php?p=" . $row['PCA_idTbl_PC_Assignment'] . "' class='btn btn-outline-primary btn-sm' title='Editar Registro'>
              <i class='fas fa-pencil-alt'></i>
            </a>
            <a href='../views/view_mappingSoftware.php?p=" . $row['PCA_idTbl_PC_Assignment'] . "' class='btn btn-outline-info btn-sm' title='Más Información'>
            <i class='fas fa-info'></i>
            </a>
   
    <button class='btn btn-outline-dark btn-sm imprimirContrato' title='Imprimir Contrato' name='imprimirContrato' id='imprimirContrato' onclick=\"return generarPDF('".$NameCollaborator."', '" .  $_SESSION["NameUserlog"] . "', '".$EmployeeCode."','".$EmployeePosition."','".$Marca."','".$Modelo."','".$Serial."','".$Garantia."');\">
            <i class='fa fa-file-contract'></i>
            </button>
  <div id='contrato' style='display: none;'>
              
               <h1>CONTRATO DE ASIGNACIÓN DE EQUIPO DE CÓMPUTO</h1>
                                  
<p>.- Partes Contratantes:</p>
<p>Azucarera la Grecia S.A de C.V, en adelante denominada 'La Empresa,' representada en este contrato por el sistema de INFRAG con el usuario representante:  <p class='nameuser'>" .$_SESSION["NameUserlog"]. "</p>, con domicilio en Kilometro 21, Carretera hacía Cedeño,Marcovia, Choluteca . </p>

<p class='namecolaborador'>" . $NameCollaborator . "</p>,<p> en adelante denominado 'El Empleado,' con número de identificación dentro de la empresa <p class='numeroIdentificación'>  " . $EmployeeCode . "</p> , y cargo <p class='EmployeePosition'>" . $EmployeePosition . "</p> en La Empresa. </p>

<p>.- Antecedentes:</p>
<p>La Empresa proporciona equipos de cómputo, en este caso, una computadora personal (PC), para su uso por parte del Empleado en el desempeño de sus funciones laborales.</p>

<p>.- Cláusulas: </p>
<p><b>1. Asignación del Equipo de Cómputo</b>  </p>
<p>La Empresa asigna al Empleado una computadora personal (PC) con las siguientes características:</p>
                                 <p> Marca y modelo: <p class='marca'>" . $Marca . "</p>, <p class='modelo'>" . $Modelo . "</p> .</p>
                                 <p> Número de serie: <p class='serie'>" . $Serial . "</p>.</p>
                                 <p>Tipo de garantía: <p class='garantia'>" . $Garantia . "</p>.</p>

<p><b>2. Uso del Equipo de Cómputo</b> </p>
        <p> <b>2.1</b> El Empleado utilizará el equipo de cómputo exclusivamente para fines laborales relacionados con las responsabilidades asignadas por La Empresa.</p>
        <p> <b>2.2</b> El Empleado se compromete a utilizar el equipo de manera responsable y a mantenerlo en buen estado. Cualquier daño o pérdida deberá ser reportado de inmediato a la persona o departamento designado por La Empresa.</p>
        <p> <b>2.3 </b> El Empleado se compromete a no instalar software no autorizado ni a realizar modificaciones en la configuración del equipo sin la autorización expresa de La Empresa.</p>

<p> <b>3. Responsabilidad por el Equipo de Cómputo </b></p>
        <p><b>3.1</b> La Empresa se reserva el derecho de monitorear y auditar el uso del equipo de cómputo en cualquier momento.</p>
        <p><b>3.2 </b>El Empleado es responsable de garantizar la seguridad del equipo y no deberá dejarlo desatendido en ningún momento.</p>             

<p><b>4. Mantenimiento y Reparaciones</b> </p>
<p>La Empresa se encargará del mantenimiento y las reparaciones necesarias del equipo de cómputo. El Empleado deberá reportar cualquier problema o mal funcionamiento de manera oportuna. </p>

<p><b>5. Devolución del Equipo de Cómputo </b></p>
<p>Al término de la relación laboral con La Empresa, el Empleado deberá devolver el equipo de cómputo en las mismas condiciones en las que lo recibió, salvo el desgaste normal por el uso. </p>

<p><b>6. Confidencialidad</b> </p>
<p>El Empleado se compromete a mantener la confidencialidad de la información almacenada en el equipo de cómputo y a no divulgar información confidencial de La Empresa. </p>

 <p><b>7. Duración del Contrato</b></p>
<p>Este contrato de asignación de equipo de cómputo entrará en vigor a partir de la fecha de firma y tendrá una duración indefinida, sujeto a las condiciones de empleo del Empleado en La Empresa.</p>
                 


                                               <p><b>Firma de las Partes:</b></p>



       <p>_______________________                        ________________________</p>
       <p>Firma y Sello del Representante                             Firma de Empleado</p>
                 <p class='nameuser'>" .$_SESSION["NameUserlog"]. "</p>                                  <p class='firmacolaborador'>" . $NameCollaborator . "</p>
         



              <p>Contrato firmado el <p id='fecha'></p> en Marcovia, Choluteca.</p>
              </div>

            <button class='btn btn-outline-danger btn-sm btnDeleteCMP' title='Eliminar Registro' name='btnDeleteCBT' id='btnDeleteCBT' data-id='" . $row['PCA_idTbl_PC_Assignment'] . "'>
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
</script>