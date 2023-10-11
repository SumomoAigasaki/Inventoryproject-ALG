<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";

?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
<script src="../../public/jquery/jquery.min.js"></script>
<script src="../../public/js/toastr.min.js">
    toastr.options = {
        closeButton: true,
        debug: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        preventDuplicates: true,
        onclick: function() {
            window.location.href = '<?php echo BASE_URL ?>pages/views/explorer.php';
        },
        showDuration: '300',
        hideDuration: '1000',
        timeOut: '5000',
        extendedTimeOut: '1000',
        showEasing: 'swing',
        hideEasing: 'linear',
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut'
    }
</script>



<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-1">
                <div class="col-sm-4">
                    <h1><?php echo $pageName; ?></h1>
                </div>
                <div class="col-sm-4">
                    <!--cinta de home y el nombre de la pagina -->
                    <ol class="breadcrumb float-sm-right">
                        <div class="btn-group" class="col-sm-4">
                            <!--botones  de agregar  -->
                            <?php
                            if ($PermisoCMP) {
                                // Agregar la ruta al array $arrayAdd
                                $ruta = "../views/view_warranty.php";
                                $arrayAdd[] = $ruta;

                                // Crear el botón con la ruta almacenada en la variable
                                echo "<a href=\"$ruta\"><button button type='button' class='btn btn-block btn-info'></i><span class='fa fa-arrow-circle-left'></span>   Volver</button></a>";
                            }
                            ?>
                            </button>
                        </div>
                        <!--  -->

                    </ol><!-- /.modal-dialog -->
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
    </div><!-- Termina la cinta del nav -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline card-tabs">
                        <div class="card-header">
                            <h3 class="card-title">Formulario para <?php echo $pageName; ?> </h3>
                        </div>
                        <!-- form start -->
                        <form role="form" action="" method="POST" name="formInsertWR" id="formInsertWR" class="form-horizontal" enctype="multipart/form-data">
                            <div class="card-body">
                                <label class="form-check-label" style="padding-bottom: 5px;"> A continuación se le pedirá que <b> Ingrese</b> los siguientes datos:</label>

                                <!-- Input para guardar la lista de los software a guardar -->
                                <input type="hidden" class="form-control" id="TxtId" name="TxtId" placeholder="">

                                <!-- Fila 1 -->
                                <div class="row justify-content-center" style="padding-top:10px; padding-bottom:10px;">

                                    <div class="col-sm-4" style="padding-top: 10px;">
                                        <div class="form-group">
                                            <!-- Fecha de Instalacion Software -->
                                            <label ACRONYM title="Fecha en que se hizo el reporte"> <code> * </code> Fecha de Reporte:</label>
                                            <input type="text" class="form-control datepicker-input" name="txtDateAdmision" id="txtDateAdmision">
                                        </div>
                                    </div>



                                    <!-- Computadora-->
                                    <div class="col-sm-4">
                                        <div class="form-group" style="padding-top: 10px;">
                                            <label><code> * </code>Computadora:</label>
                                            <!-- <input type="text" class="form-control" id="txt_busqueda" name="txt_busqueda" placeholder="Buscar Colaborador">
                                            <?php $resultado = mysqli_query($conn, "CALL sp_selectComputerWarranty()"); ?> -->
                                            <select class="form-control select2bs4" id="slctComputer" name="slctComputer">
                                                <option value="0">0.- Empty/Vacio</option>
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['CMP_idTbl_Computer']; ?>"><?php echo $row['Info']; ?></option>
                                                <?php }
                                                #NOTA
                                                #CADA QUE QUIERA HACER UNA NUEVA CONSULTA CON PROCEDIMIENTOS ALMACENADOS ESTOS EL RESULTADO SE CIERRA Y LA VARIABLE DE LA CONECCION SE PREPARA PARA EL NUEVO RESULTADO
                                                # QUE TENDRA ABAJO
                                                $resultado->close();
                                                $conn->next_result();
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Numero de Reporte-->
                                    <div class="col-sm-4">
                                        <div class="form-group" style="padding-top: 10px;">
                                            <label><code> * </code>Numero de Reporte:</label>
                                            <input type="text" class="form-control" name="txtNumberApplications" id="txtNumberApplications" maxlength="45" placeholder="">
                                        </div>
                                    </div>


                                </div>

                                <!-- Fila 2 -->
                                <div class="row justify-content-center" style="padding-top:10px; padding-bottom:10px;">

                                    <!--Problema Principal-->
                                    <div class="col-sm-4" style="padding-top: 10px;">
                                        <div class="form-group">
                                            <label><code> * </code>Problema Principal: </label>
                                            <textarea type="text" class="form-control" name="txtMainProblem" id="txtMainProblem" maxlength="255" > </textarea>
                                        </div>
                                    </div>

                                   <!-- Observaciones -->
                                   <div class="col-sm-4" style="padding-top: 10px;">
                                        <div class="form-group">
                                            <label> <code> * </code>Acciones Realizadas: </label>
                                            <textarea type="text" class="form-control" name="txtActionDone" id="txtActionDone" maxlength="60"> </textarea>
                                        </div>
                                    </div>

                                    <!-- Observaciones -->
                                    <div class="col-sm-4" style="padding-top: 10px;">
                                        <div class="form-group">
                                            <label> Observaciones: </label>
                                            <textarea type="text" class="form-control" name="txtObservation" id="txtObservation" maxlength="60"> </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                 <!-- IMAGEN -->
                                 <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Imagen de Referencia del Problema: </label>
                                            <div class="input-group" style=" display: flex;   justify-content: center;   align-items: center;   height: 200px;">
                                                <img class="img-fluid" src="../../resources/Warranty/DefaultProblem.jpg" width="200" height="250" id="imgPerfil">
                                                <input type="file" name="fileReferent" id="fileReferent" accept="image/png,image/jpeg" style="margin-left: 20px;text-align: center;">
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="row justify-content-center" style="padding-bottom:20px;">
                                <div class="col-mb-3">
                                    <button type="submit" class="btn btn-block btn-info" id="buttonInsertWR" name="buttonInsertWR" onclick='return validate_data();'>Guardar</button>
                                </div>
                            </div>
                            <div class="form-group">
                            </div>
                    </div>
                </div>
                </form>

            </div>

        </div>
</div>
</div>
</div>
</section>
</div>

<script>
  var textarea = document.getElementById("txtMainProblem");
  
  // Agregar el mensaje de ejemplo al cargar la página
  textarea.value = "Descripción detallada de la problemática o defecto reportado por el usuario, incluyendo síntomas, mensajes de error, o cualquier información relevante";
  textarea.classList.add("placeholder");

  // Cuando el usuario hace clic en el textarea, eliminar el mensaje de ejemplo y el estilo CSS
  textarea.addEventListener("focus", function() {
    if (textarea.classList.contains("placeholder")) {
      textarea.value = "";
      textarea.classList.remove("placeholder");
    }
  });

  // Cuando el usuario sale del textarea sin ingresar ningún texto, restaurar el mensaje de ejemplo
  textarea.addEventListener("blur", function() {
    if (textarea.value === "") {
      textarea.value = "Descripción detallada de la problemática o defecto reportado por el usuario, incluyendo síntomas, mensajes de error, o cualquier información relevante";
      textarea.classList.add("placeholder");
    }
  });
</script>

<?php
require_once "../templates/footer.php";
?>
<script>
    // Función para validar los datos ingresados en el formulario
    function validate_data() {
        let dateAdmisiontxt = document.getElementById('txtDateAdmision');
        let computerSlct = document.getElementById('slctComputer');
        let numberApplicationstxt = document.getElementById('txtNumberApplications');
        let mainProblemtxt = document.getElementById('txtMainProblem');


        if (dateAdmisiontxt.value.trim() === "") {
            toastr.warning("La <b>Fecha de reporte</b> esta vacia(a).<br>Por favor Ingrese una Fecha de Reporte valida");
            dateAdmisiontxt.focus();
            return false;
        } else if (computerSlct.selectedIndex == 0) {
            toastr.warning('El campo de <b>Computadora</b> esta vacio(a).<br>Por favor Ingrese una Computadora valida');
            computerSlct.focus();
            return false;
        } else if (numberApplicationstxt.value.trim() === "") {
            toastr.warning('El <b>Numero de Reporte</b> esta vacio(a).<br>Por favor Ingrese un Numero de Reporte valido');
            numberApplicationstxt.focus();
            return false;
        } else if (mainProblemtxt.value.trim() === "") {
            toastr.warning('El <b>Problema Principal:</b> esta vacio(a).<br>Por favor Ingrese un Problema Principal: valida');
            mainProblemtxt.focus();
            return false;
        } else {
            // Si no hay errores, procesa los datos enviados
            if (accionInput.value.trim() === "") {
                accionInput.value = "1";
            }

            document.getElementById("formInsertWR").submit();
            setTimeout(function() {
                console.log("Después de 2 segundos");
            }, 10000);

        }
    }

    $(function() {
        $(".datepicker-input").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });

      // Funcion para cargar la previsualizacion de imagen 
      function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // Asignamos el atributo src a la tag de imagen
                $('#imgPerfil').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    // El listener va asignado al input
    $("#fileReferent").change(function() {
        readURL(this);
    });
</script>
<?php

if (isset($_POST["buttonInsertWR"])) {
    $computerId = $_POST["slctComputer"];
    $mainProblemtxt = $_POST["txtMainProblem"];
    $dateAdmisiontxt = $_POST["txtDateAdmision"];
    $numberApplicationstxt = $_POST["txtNumberApplications"];
    $imgProblem =  $_FILES['fileReferent']['name'];
        if (empty($imgProblem)) {
            $imgProblem = '/resources/Warranty/DefaultProblem.jpg';
        } else {
            $imgProblem = '/resources/Warranty/' . $_FILES['fileReferent']['name'];
        }
    $observationstxt= $_POST["txtObservation"];
    $user = $_SESSION["User_idTbl_User"];
    // el estado en 4 porque es en espera 
    $status = 4;
    date_default_timezone_set('America/Mexico_City');
    $todayDate = date("Y-m-d");

    // Verificar el permiso para realizar la operación
    if ($PermisoWR) {
        try {
            //Caso contrario Guardara
            $stmt = $conn->prepare("CALL  sp_insertWarranty(?,?,?,?,?,?,?,?,?)");

                                //  $query = "CALL sp_insertWarranty( '$computerId', '$dateAdmisiontxt', '$numberApplicationstxt', '$mainProblemtxt', '$imgProblem', '$observationstxt', '$todayDate', '$status', '$user');";
                                // echo $query;
            // Mandamos los parametros y los input que seran enviados al PA O SP
            $stmt->bind_param("sssssssss", $computerId, $dateAdmisiontxt, $numberApplicationstxt, $mainProblemtxt, $imgProblem, $observationstxt, $todayDate, $status, $user);


            // Ejecutar el procedimiento almacenado
            $stmt->execute();
            if ($stmt->error) {
                error_log("Error en la ejecución del procedimiento almacenado: " . $stmt->error);
            }
            // Obtener el valor de la variable de salida
            $stmt->bind_result($answerExistsPRL);
            $stmt->fetch();
            $stmt->close();
            $conn->next_result();
            // se extraen los valores qu     nos devuelve el procedimiento almacenado y enviamos el error
            if ($answerExistsPRL > 0) {
                echo '<script > toastr.success("Los datos de <b>' . $numberApplicationstxt . '</b> se Guardaron de manera exitosa.", "¡¡Enhorabuena!!"); ';
                echo 'setTimeout(function() {';
                echo '  window.location.href = "view_warranty.php";';
                echo ' }, 2000); // 2000 milisegundos = 2 segundos de retraso ';
                echo 'document.getElementById("formInsertWR").reset(); ';
                echo '</script>';


                exit;
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                // Check which specific unique field is causing the constraint violation
                if ($e->getCode() == 1062) {
                    // Check which specific unique field is causing the constraint violation
                    if (strpos($e->getMessage(), 'WR_Application_Number_UNIQUE') !== false) {
                        // echo "Error: ";
                        echo '<script > toastr.error("No se pudo guardar <br> El Numero de Reporte proporcionado ya está en uso. Por favor, elige un Numero de Reporte diferente.","¡¡UPS!!  Advertencia: 1");';
                        echo 'var nameInput = document.getElementById("txtNumberApplications");';
                        echo 'nameInput.focus();';
                        echo '</script>';
                    }
                } else {
                    // If none of the specific fields match, display a generic error message
                    echo "Error: Duplicate entry for one or more unique fields. Please provide different values.";
                }
            } else {
                // Handle other types of database-related errors
                echo "Error código: " . $e->getCode() . " - " . $e->getMessage();
            }
        }
    }
}
?>