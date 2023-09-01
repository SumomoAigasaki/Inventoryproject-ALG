<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";
?>
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
                            if ($PermisoUSER) {
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
                                            <label>Nombre Periferico:</label>
                                            <input type="text" class="form-control" name="txt_nameSft" id="txt_nameSft" maxlength="45" required>
                                        </div>
                                    </div>

                                    <!-- Tipo de componente  -->
                                    <div class="col-sm-4" style="padding-top: 20px;">
                                        <div class="form-group">
                                            <label>Tipo De Periferico: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_selectComponenteType()"); ?>
                                            <select class="form-control" id="slct_componentType" name="slct_componentType"  onchange="filtrarMarcas()">
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
                                            <input type="text" class="form-control" name="txt_description" id="txt_description" maxlength="45" required>
                                        </div>
                                    </div>


                                </div> <!-- Fin fila 1 -->

                                <div class="row">
                                    <!-- Especificacion del componente -->
                                    <div class="col-sm-4" style="padding-top: 20px;">
                                        <div class="form-group">
                                            <label>Especificacion del componente: </label>
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
                                            <label>Localizacion del Componente : </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_location_select"); ?>
                                            <select class="form-control" id="selectLocation" name="selectLocation">
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
                                            <textarea type="text" class="form-control" name="txt_observation" id="txt_observation" maxlength="60"> </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center" style="padding-bottom:20px;">
                                <div class="col-mb-3">
                                    <button type="submit" class="btn btn-block btn-info" id="buttonInsertSFT" name="buttonInsertSFT" onclick='return validate_data();'>Guardar</button>
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
        let nameInput = document.getElementById('txt_nameSft');
        let manufacturerSelect = document.getElementById('slct_manufacturerSftType');
        let versionInput = document.getElementById('txt_versionSft');
        let typeSftSelect = document.getElementById('slct_SftType');
        let licenceClasifSelect = document.getElementById('slct_licenceClasification');
        let categoriSftSelect = document.getElementById('slct_category');


        if (nameInput.value.trim() === "") {
            toastr.warning("El <b>Nombre de Software</b> esta vacio(a).<br>Por favor Ingrese un Nombre de Software valida");
            nameInput.focus();
            return false;
        } else if (versionInput.value.trim() === "") {
            toastr.warning("La <b>Version</b> esta vacio(a).<br>Por favor Ingrese una Version valida");
            versionInput.focus();
            return false;
        } else if (typeSftSelect.selectedIndex === 0) {
            toastr.warning("El <b>Tipo de Software</b> esta vacio(a).<br>Por favor Ingrese un Tipo de Software valido");
            typeSftSelect.focus();
            return false;
        } else if (manufacturerSelect.selectedIndex === 0) {
            toastr.warning('El <b>Fabricante</b> esta vacio(a).<br>Por favor Ingrese una Fabricante valida');
            manufacturerSelect.focus();
            return false;
        } else if (licenceClasifSelect.selectedIndex === 0) {
            toastr.warning("El <b>Tipo de Licencia</b> esta vacio(a).<br>Por favor Ingrese un Tipo de Licencia valido");
            licenceClasifSelect.focus();
            return false;
        } else if (categoriSftSelect.selectedIndex === 0) {
            toastr.warning("La <b>Categoria </b> esta vacio(a).<br>Por favor Ingrese una Categoria valida");
            categoriSftSelect.focus();
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
    
    $nameSft = $_POST['txt_nameSft'];
    $manufacturerSft = $_POST['slct_manufacturerSftType'];
    $versionSft = $_POST['txt_versionSft'];
    $serialSft = $_POST['txt_licenciaSft'];

    if (empty($serialSft)) {
        $serialSft = NULL;
    }
    $typeSft = $_POST['slct_SftType'];
    $clasificationLicenceSft = $_POST['slct_licenceClasification'];
    $todayDate = date("Y-m-d");
    $observationsSft = $_POST['txt_observation'];
    $category = $_POST['slct_category'];
    $user = $_SESSION["User_idTbl_User"];
    $status = '2';

    # Ruta de la carpeta de destino para los archivos
    $urlSFT = '../../resources/Software/';

    if ($PermisoSTF) {
        try {
            //Caso contrario Guardara
            $stmt = $conn->prepare("CALL  sp_insertSoftware(?,?,?,?,?,?,?,?,?,?,?,?)");

            // $query = "CALL sp_insertSoftware('$imageSft', '$nameSft', '$manufacturerSft', '$versionSft', '$serialSft', '$typeSft', '$clasificationLicenceSft', '$todayDate', '$observationsSft', '$category', '$user', '$status');";
            // echo $query;
            // Mandamos los parametros y los input que seran enviados al PA O SP
            $stmt->bind_param("ssssssssssss", $imageSft, $nameSft, $manufacturerSft, $versionSft, $serialSft, $typeSft, $clasificationLicenceSft, $todayDate, $observationsSft, $category, $user, $status);


            // Ejecutar el procedimiento almacenado
            $stmt->execute();
            if ($stmt->error) {
                error_log("Error en la ejecución del procedimiento almacenado: " . $stmt->error);
            }
            // Obtener el valor de la variable de salida
            $stmt->bind_result($answerExistsSoft);
            $stmt->fetch();
            $stmt->close();
            $conn->next_result();
            // se extraen los valores qu     nos devuelve el procedimiento almacenado y enviamos el error
            if ($answerExistsSoft > 0) {
                echo '<script > toastr.success("Los datos de <b>' . $nameSft . '</b> se Guardaron de manera exitosa.", "¡¡Enhorabuena!!"); ';
                echo 'setTimeout(function() {';
                echo '  window.location.href = "view_software.php";';
                echo ' }, 2000); // 2000 milisegundos = 2 segundos de retraso ';
                echo 'document.getElementById("formInsertPRL").reset(); ';
                echo '</script>';

                if ($_FILES['imgSFT']['name'] != 'default.jpg') {
                    move_uploaded_file($_FILES['imgSFT']['tmp_name'], $urlSFT . $_FILES['imgSFT']['name']);
                } else if (file_exists($urlSFT . $_FILES['imgSFT']['name'])) {
                    echo '<script > toastr.info("La imagen ya existe ' . $imageSft . '")</script>;';
                    $uploadOk = 0; //si existe lanza un valor en 0                 

                }
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                // Check which specific unique field is causing the constraint violation
                if ($e->getCode() == 1062) {
                    // Check which specific unique field is causing the constraint violation
                    if (strpos($e->getMessage(), 'SFT_Software_Name_UNIQUE') !== false) {
                        // echo "Error: ";
                        echo '<script > toastr.error("No se pudo guardar <br> El Nombre del Software proporcionado ya está en uso. Por favor, elige un Nombre de Software diferente.","¡¡UPS!!  Advertencia: 1");';
                        echo 'var nameInput = document.getElementById("txt_nameSft");';
                        echo 'nameInput.focus();';
                        echo '</script>';
                    } elseif (strpos($e->getMessage(), 'SFT_Serial_UNIQUE') !== false) {
                        echo '<script > toastr.error("No se pudo guardar <br> La Licencia y/o Serial proporcionado ya está en uso. Por favor, elige una Licencia y/o Serial diferente.","¡¡UPS!!  Advertencia: 2");';
                        echo 'var serialInput = document.getElementById("txt_licenciaSft");';
                        echo 'serialInput.focus();';
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