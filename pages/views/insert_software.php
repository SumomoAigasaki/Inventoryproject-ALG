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
            window.location.href = '<?php echo BASE_URL ?>pages/views/view_software.php';
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
                            if ($PermisoSTF) {
                                // Agregar la ruta al array $arrayAdd
                                $ruta = "../views/view_software.php";
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
                        <form action="" method="post" name="formInsertSFT" id="formInsertSFT" class="form-horizontal" enctype="multipart/form-data">
                            <div class="card-body">
                                <label class="form-check-label" style="padding-bottom: 5px;"> A continuación se le pedirá que <b> Ingrese</b> los siguientes datos:</label>

                                <!-- Input ocultos  -->
                                <input type="hidden" class="form-control" id="todayDate" name="todayDate" placeholder="<?php echo $todayDate; ?>">
                                <input type="hidden" class="form-control" id="accion" name="accion" placeholder="">

                                <div class="row justify-content-center" style="padding-top:10px; padding-bottom:10px;">
                                    <!-- IMAGEN -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <!-- style="text-align: center;  display: block;  margin: 0 auto;" -->
                                            <label>Imagen: </label>

                                            <div class="input-group" style=" display: flex;   justify-content: center;   align-items: center;   height: 200px;">
                                                <img class="img-fluid" src="../../resources/Software/default.jpg" width="150" height="150" id="imgPerfil">
                                                <input type="file" name="imgSFT" id="imgSFT" accept="image/png,image/jpeg" style=" margin-left: 20px;text-align: center;">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- nombre -->
                                    <div class="col-sm-3">
                                        <div class="form-group" style="padding-top: 70px;">
                                            <label><code>*</code>Nombre Software:</label>
                                            <input type="text" class="form-control" name="txt_nameSft" id="txt_nameSft" maxlength="45" required>
                                        </div>
                                    </div>

                                    <!-- version -->
                                    <div class="col-sm-2">
                                        <div class="form-group" style="padding-top: 70px;">
                                            <label><code>*</code>Versión Software:</label>
                                            <input type="text" class="form-control" name="txt_versionSft" id="txt_versionSft" maxlength="25" required>
                                        </div>
                                    </div>

                                    <!-- Tipo de software  -->
                                    <div class="col-sm-2" style="padding-top: 70px;">
                                        <div class="form-group">
                                            <label><code>*</code>Tipo De software: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_Select_SoftwareType()"); ?>
                                            <select class="form-control select2bs4" id="slct_SftType" name="slct_SftType">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['STP_idTbl_Software_Type']; ?>"><?php echo $row['STP_Description']; ?></option>
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
                                    <!-- Fabricante  -->
                                    <div class="col-md-2 " style="padding-top: 70px;">
                                        <div class="form-group">
                                            <label><code>*</code>Fabricante: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_manufacturerSoft_Select()"); ?>
                                            <select class="form-control select2bs4" style="width: 100%;" id="slct_manufacturerSftType" name="slct_manufacturerSftType">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['MFS_idtbl_manufacturer_software']; ?>"><?php echo $row['MFS_Description']; ?></option>
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
                                    <!-- <div class="col-sm-2" style="padding-top: 50px;">
                                        <div class="form-group">
                                            <label>Fabricante: </label>
                                            <input type="text" id="searchManufacturer" placeholder="Buscador para fabricantes: " class="form-control">
                                            <?php $resultado = mysqli_query($conn, "CALL sp_manufacturerSoft_Select()"); ?>
                                            <select class="form-control" id="slct_manufacturerSftType" name="slct_manufacturerSftType">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['MFS_idtbl_manufacturer_software']; ?>"><?php echo $row['MFS_Description']; ?></option>
                                                <?php }
                                                #NOTA
                                                #CADA QUE QUIERA HACER UNA NUEVA CONSULTA CON PROCEDIMIENTOS ALMACENADOS ESTOS EL RESULTADO SE CIERRA Y LA VARIABLE DE LA CONECCION SE PREPARA PARA EL NUEVO RESULTADO
                                                # QUE TENDRA ABAJO
                                                $resultado->close();
                                                $conn->next_result();
                                                ?>
                                            </select>
                                        </div>
                                    </div> -->

                                </div> <!-- Fin fila 1 -->

                                <div class="row">
                                    <!-- Licencia/Serial -->
                                    <div class="col-sm-3">
                                        <div class="form-group" style="padding-top: 20px;">
                                            <label><code>*</code>Licencia / Serial:</label>
                                            <input type="text" class="form-control" name="txt_licenciaSft" id="txt_licenciaSft" maxlength="45">
                                        </div>
                                    </div>

                                    <!-- clasificacion de licencia  -->
                                    <div class="col-sm-3" style="padding-top: 20px;">
                                        <div class="form-group">
                                            <label><code>*</code>Clasificación de Licencia: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_select_licence_clasificatioion()"); ?>
                                            <select class="form-control select2bs4" id="slct_licenceClasification" name="slct_licenceClasification">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['LC_idTbl_License_Clasification']; ?>"><?php echo $row['LC_Description']; ?></option>
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

                                    <!-- categoria  -->
                                    <div class="col-sm-3" style="padding-top: 20px;">
                                        <div class="form-group">
                                            <label><code>*</code>Categoria: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_selectCategory()"); ?>
                                            <select class="form-control select2bs4 " id="slct_category" name="slct_category">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['CTG_idTbl_Category']; ?>"><?php echo $row['CTG_Description']; ?></option>
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

                                    <!-- Observaciones -->
                                    <div class="col-sm-3">
                                        <div class="form-group" style="padding-top: 20px;">
                                            <label>Observaciones: </label>
                                            <textarea type="text" class="form-control" name="txt_observation" id="txt_observation" maxlength="60"> </textarea>
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
            document.getElementById("formInsertSFT").submit();

        }
    }

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
    $("#imgSFT").change(function() {
        readURL(this);
    });
</script>

<?php
if (isset($_POST["buttonInsertSFT"])) {
    $imageSft = $_FILES['imgSFT']['name'];
    if (empty($imageSft)) {
        $imageSft = '/resources/Software/default.jpg';
    } else {
        $imageSft = '/resources/Software/' . $_FILES['imgSFT']['name'];
    }
    $nameSft = $_POST['txt_nameSft'];
    $manufacturerSft = $_POST['slct_manufacturerSftType'];
    $versionSft = $_POST['txt_versionSft'];
    $serialSft = $_POST['txt_licenciaSft'];

    if (empty($serialSft)) {
        $serialSft = NULL;
    }
    $typeSft = $_POST['slct_SftType'];
    $clasificationLicenceSft = $_POST['slct_licenceClasification'];
    date_default_timezone_set('America/Mexico_City');
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
                echo 'document.getElementById("formInsertSFT").reset(); ';
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
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });
</script>