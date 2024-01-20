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
            window.location.href = '<?php echo BASE_URL ?>pages/views/view_peripherals.php';
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
                            if ($PermisoPRL) {
                                // Agregar la ruta al array $arrayAdd
                                $ruta = "../views/view_peripherals.php";
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
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline card-tabs">
                        <div class="card-header">
                            <h3 class="card-title">Formulario para Añadir <?php echo $pageName; ?> </h3>
                        </div>
                        <form action="" method="post" name="formInsertPRL" id="formInsertPRL" class="form-horizontal" enctype="multipart/form-data">
                            <div class="card-body">
                                <label class="form-check-label" style="padding-bottom: 5px;"> A continuación se le pedirá que <b> Ingrese</b> los siguientes datos:</label>

                                <!-- Input ocultos  -->
                                <input type="hidden" class="form-control" id="todayDate" name="todayDate" placeholder="<?php echo $todayDate; ?>">
                                <input type="hidden" class="form-control" id="accion" name="accion" placeholder="">

                                <div class="row justify-content-center" style="padding-top:10px; padding-bottom:10px;">

                                    <!-- nombre -->
                                    <div class="col-sm-4">
                                        <div class="form-group" style="padding-top: 20px;">
                                            <label><code>*</code>Nombre Periferico:</label>
                                            <input type="text" class="form-control" name="txt_namePRL" id="txt_namePRL" maxlength="45" required>
                                        </div>
                                    </div>

                                    <!-- Tipo de componente  -->
                                    <div class="col-sm-4" style="padding-top: 20px;">
                                        <div class="form-group">
                                            <label><code>*</code>Tipo De Periferico: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_selectComponenteType()"); ?>
                                            <select class="form-control select2bs4" id="slct_componentType" name="slct_componentType" onchange="filtrarMarcas()">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['CPT_idtbl_component_type']; ?>"><?php echo $row['CPT_Description']; ?></option>
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
                                    <!-- Descripcion Principal  -->
                                    <div class="col-sm-4">
                                        <div class="form-group" style="padding-top: 20px;">
                                            <label>Descripcion Principal Periferico:</label>
                                            <input type="text" class="form-control" name="txt_description" id="txt_description" maxlength="45" >
                                        </div>
                                    </div>


                                </div> <!-- Fin fila 1 -->

                                <div class="row">
                                    <!-- Especificacion del componente -->
                                    <div class="col-sm-4" style="padding-top: 20px;">
                                        <div class="form-group">
                                            <label><code>*</code>Especificacion del componente: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_selectComponentDescription()"); ?>
                                            <select class="form-control select2bs4" id="slct_componentDescription" name="slct_componentDescription">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['CPD_idtbl_component_description']; ?>" data-ComponentDescription="<?php echo $row['CPT_idtbl_component_type']; ?>"><?php echo $row['CPD_Description']; ?></option>
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

                                    <!-- Estado de la computadora  -->
                                    <div class="col-sm-4" style="padding-top: 20px;">
                                        <div class="form-group">
                                            <label>Marca: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_selectBrand()"); ?>
                                            <select class="form-control select2bs4" id="slct_brand" name="slct_brand">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['BRD_idtbl_brand']; ?>"><?php echo $row['BRD_Description']; ?></option>
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

                                    <!-- Localizacion -->
                                    <div class="col-sm-4" style="padding-top: 20px;">
                                        <div class="form-group">
                                            <label><code>*</code>Localizacion del Componente : </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_location_select"); ?>
                                            <select class="form-control select2bs4" id="slctLocation" name="slctLocation">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['LCT_idTbl_Location']; ?>"><?php echo $row['LCT_Description']; ?></option>
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
                                </div>

                                <!-- Observaciones -->
                                <div class="row justify-content-center" style="padding-bottom:20px;">
                                    <div class="col-sm-6">
                                        <div class="form-group" style="padding-top: 20px;">
                                            <label>Observaciones: </label>
                                            <textarea type="text" class="form-control" name="txt_observation" id="txt_observation" maxlength="100"> </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center" style="padding-bottom:20px;">
                                <div class="col-mb-3">
                                    <button type="submit" class="btn btn-block btn-info" id="buttonInsertPRL" name="buttonInsertPRL" onclick='return validate_data();'>Guardar</button>
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
</section>
</div>



<script>
    function validate_data() {
        let nameInput = document.getElementById('txt_namePRL');
        let componentTypeSelect = document.getElementById('slct_componentType');
        let componentDescriptionInput = document.getElementById('slct_componentDescription');
        let locationSelect = document.getElementById('slctLocation');


        if (nameInput.value.trim() === "") {
            toastr.warning("El <b>Nombre de Periferico</b> esta vacio(a).<br>Por favor Ingrese un Nombre de Periferico valido");
            nameInput.focus();
            return false;
        } else if (componentTypeSelect.selectedIndex == 0) {
            toastr.warning("El <b>Tipo de Componente</b> esta vacio(a).<br>Por favor Ingrese un Tipo de Componente valida");
            componentTypeSelect.focus();
            return false;
        } else if (componentDescriptionInput.selectedIndex == 0) {
            toastr.warning("La <b>Especificacion del Periferico</b> esta vacio(a).<br>Por favor Ingrese una Especificacion del Periferico valida");
            componentDescriptionInput.focus();
            return false;
        } else if (locationSelect.selectedIndex == 0) {
            toastr.warning("La <b>Localizacion del Periferico</b> esta vacio(a).<br>Por favor Ingrese un Localizacion del Periferico valido");
            locationSelect.focus();
            return false;
        } else {
            // Si no hay errores, procesa los datos enviados
            if (accionInput.value.trim() === "") {
                accionInput.value = "1";

            }
            document.getElementById("formInsertPRL").submit();

        }
    }
</script>

<?php
if (isset($_POST["buttonInsertPRL"])) {

    $namePRL = $_POST['txt_namePRL'];
    $componentTypePRL = $_POST['slct_componentType'];
    $descriptionPRL = $_POST['txt_description'];
    $componentDescriptionPRL = $_POST['slct_componentDescription'];
    $brandPRL = $_POST['slct_brand'];
    $locationPRL = $_POST['slctLocation'];
    $observationsPRL = $_POST['txt_observation'];
    date_default_timezone_set('America/Mexico_City');
    $todayDate = date("Y-m-d");
    $user = $_SESSION["User_idTbl_User"];
    $status = '2';


    if ($PermisoPRL) {
        try {
            //Caso contrario Guardara
            $stmt = $conn->prepare("CALL  sp_insertPeripherals(?,?,?,?,?,?,?,?,?,?)");

            //  $query = "CALL sp_insertPeripherals( '$todayDate', '$namePRL', '$componentTypePRL', '$descriptionPRL', '$componentDescriptionPRL', '$brandPRL', '$observationsPRL', '$status', '$locationPRL', '$user');";
            // echo $query;
            // Mandamos los parametros y los input que seran enviados al PA O SP
            $stmt->bind_param("ssssssssss", $todayDate, $namePRL, $componentTypePRL, $descriptionPRL, $componentDescriptionPRL, $brandPRL, $observationsPRL, $status, $locationPRL, $user);


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
                echo '<script > toastr.success("Los datos de <b>' . $namePRL . '</b> se Guardaron de manera exitosa.", "¡¡Enhorabuena!!"); ';
                echo 'setTimeout(function() {';
                echo '  window.location.href = "view_peripherals.php";';
                echo ' }, 2000); // 2000 milisegundos = 2 segundos de retraso ';
                echo 'document.getElementById("formInsertPRL").reset(); ';
                echo '</script>';


                exit;
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                // Check which specific unique field is causing the constraint violation
                if ($e->getCode() == 1062) {
                    // Check which specific unique field is causing the constraint violation
                    if (strpos($e->getMessage(), 'PRL_Name_UNIQUE') !== false) {
                        // echo "Error: ";
                        echo '<script > toastr.error("No se pudo guardar <br> El Nombre del Periferico proporcionado ya está en uso. Por favor, elige un Nombre de Periferico diferente.","¡¡UPS!!  Advertencia: 1");';
                        echo 'var nameInput = document.getElementById("txt_namePRL");';
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
<?php
require_once "../templates/footer.php";
?>


<script>
    function filtrarMarcas() {
        // Obtener el valor seleccionado en el primer select
        var tipoComponenteSeleccionado = document.getElementById("slct_componentType").value;

        // Obtener todos los options del segundo select
        var opcionesDescriptions = document.getElementById("slct_componentDescription").options;


        // Obtenr el texto del segundo seletc
        var contenidoDescription = document.getElementsByTagName("option");

        // Recorrer todas las opciones y ocultar las que no pertenecen al fabricante seleccionado
        for (var i = 1; i < opcionesDescriptions.length; i++) {
            var descriptionsOptions = opcionesDescriptions[i];
            if (descriptionsOptions.getAttribute("data-ComponentDescription") == tipoComponenteSeleccionado || tipoComponenteSeleccionado == "") {
                descriptionsOptions.disabled = false; // No se deshabilita si pertenece al fabricante seleccionado o si no se seleccionó ningún fabricante
            } else {
                descriptionsOptions.disabled = true; // Se deshabilita si no pertenece al fabricante seleccionado
            }
        }

        // Si no hay modelos disponibles para el fabricante seleccionado, mostrar un mensaje en el segundo select
        if (document.querySelectorAll("#slct_componentDescription option[style='display: none;']").length === opcionesDescriptions.length - 1) {
            document.getElementById("slct_componentDescription").innerHTML = "<option value=''>No hay modelos disponibles para este fabricante</option>";
        }


    }
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });
</script>