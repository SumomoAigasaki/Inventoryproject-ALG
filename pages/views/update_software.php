<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";


//obtendremos lA VARIABLE QUE PASAMOS POR METODO get 
$idSoftware = $_GET['p'];

// Preparar la llamada al procedimiento almacenado 
//Extraer los datos con el id que se nos paso por medio de la url 

$stmt = $conn->query("CALL sp_SelectSoftware($idSoftware)");
while ($row = $stmt->fetch_assoc()) {
    //   echo '<pre>';
    //   print_r($row);
    //   echo '</pre>';
    $SFT_idTbl_Software = $row['SFT_idTbl_Software'];
    $SFT_Image = $row['SFT_Image'];
    $SFT_Software_Name = $row['SFT_Software_Name'];
    $MFS_idtbl_manufacturer_software = $row['MFS_idtbl_manufacturer_software'];
    $SFT_Version_Installe = $row['SFT_Version_Installe'];
    $SFT_Serial = $row['SFT_Serial'];
    $STP_idTbl_Software_Type = $row['STP_idTbl_Software_Type'];
    $LC_idTbl_License_Clasification = $row['LC_idTbl_License_Clasification'];
    $CTG_idTbl_Category = $row['CTG_idTbl_Category'];
    $SFT_Inventory_Date = $row['SFT_Inventory_Date'];
    $SFT_Observations = $row['SFT_Observations'];
    $STS_idTbl_Status = $row['STS_idTbl_Status'];
}
$stmt->close();
$conn->next_result();

?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
<script src="../../public/jquery/jquery.min.js"></script>
<script src="../../public/js/toastr.min.js"></script>


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
                                echo "<a href=\"$ruta\"><button button type='button' class='btn btn-block bg-olive'></i><span class='fas fa-arrow-circle-left'></span>   Volver</button></a>";
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
    <!-- Termina la cinta del nav -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success card-outline card-tabs">
                        <div class="card-header">
                            <h3 class="card-title">Formulario para <?php echo $pageName; ?> </h3>
                        </div>

                        <!-- form start -->
                        <form role="form" action="" method="POST" name="formUpdateSoftware" id="formUpdateSoftware" class="form-horizontal" enctype="multipart/form-data">
                            <div class="card-body">
                                <label class="form-check-label" style="padding-bottom: 5px;"> A continuación se le mostrara el formulario con información tenga <b> cuidado</b> al momento de presionar el boton:</label>
                                <!-- Input ocultos  -->
                                <input type="hidden" class="form-control" id="softwareId" name="softwareId" value="<?php echo $SFT_idTbl_Software ?>">
                                <input type="hidden" class="form-control" id="txtAction" name="txtAction">

                                <!--  Primer Row DE LA IZQUIERDA-->
                                <div class="row" style="padding-top:10px; padding-bottom:10px;">
                                    <div class="col-sm-6">
                                        <!-- Image -->
                                        <div class="form-group" style="padding-left:15px;">
                                            <label>Imagen de Referencia</label>
                                            <div class="input-group" style="flex-direction: column; padding-left:15px; display: flex; justify-content: center; align-items: center;">
                                                <img class="img-fluid img-circle" src="../..<?php echo $SFT_Image ?>" width="150" height="150" style="margin: 10px;" id="imgPerfil">
                                                <input type="file" name="imgSoft" id="imgSoft" accept="image/png,image/jpeg" style="padding-left:15px; padding-top:2.5px;">
                                            </div>
                                        </div>
                                        <!-- USERNAME -->
                                        <div class="form-group" style="padding-left:15px;">
                                            <label ACRONYM title="Nombre de Software"><code>*</code>Nomb. Soft.: </label>
                                            <input type="text" class="form-control" id="txtNombreSoftware" name="txtNombreSoftware" maxlength="45" value="<?php echo $SFT_Software_Name; ?>" placeholder="Nickname">
                                        </div>
                                        <!-- VERSION -->
                                        <div class="form-group" style="padding-left:15px;">
                                            <label ACRONYM title="Version de Software Instalada"><code>*</code>Version. Soft. Instalada : </label>
                                            <input type="text" class="form-control" id="txtVersionSoftware" name="txtVersionSoftware" maxlength="25" value="<?php echo $SFT_Version_Installe; ?>" placeholder="Version">
                                        </div>
                                        <!-- Serial -->
                                        <div class="form-group" style="padding-left:15px;">
                                            <label ACRONYM title="Serial del Software"><code>*</code>Serial: </label>
                                            <input type="text" class="form-control" id="txtSerialSoftware" name="txtSerialSoftware" maxlength="45" value="<?php echo $SFT_Serial; ?>" placeholder="Serial">
                                        </div>
                                        <!-- Clasificacion de Licencia  -->
                                        <div class="form-group" style="padding-left:15px; padding-top:2.5px;">
                                            <label><code>*</code>Clasificacion de Licencia: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_select_licence_clasificatioion()"); ?>
                                            <select class="form-control select2bs4" id="slct_licenceClasification" name="slct_licenceClasification">
                                                <?php while ($row = mysqli_fetch_array($resultado)) {
                                                    $select = ($LC_idTbl_License_Clasification == $row['LC_idTbl_License_Clasification']) ? "selected=selected" : "";
                                                ?>
                                                    <option value="<?php echo $row['LC_idTbl_License_Clasification']; ?>" <?php echo $select; ?>><?php echo $row['LC_Description']; ?></option>
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
                                    <!--  Segunda Row -->
                                    <div class="col-sm-6">
                                        <!-- Fecha de registro -->
                                        <div class="form-group" style="padding-left:15px;">
                                            <label ACRONYM title="Fecha que fue ingresado">Fec. Ingreso:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control datepicker-input " id="txtFechaIngresado" name="txtFechaIngresado" value="<?php echo $SFT_Inventory_Date; ?>">
                                            </div>
                                        </div>
                                        <!-- Tipo de software  -->
                                        <div class="form-group" style="padding-left:15px; padding-top:2.5px;">
                                            <label>Tipo De software: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_Select_SoftwareType()"); ?>
                                            <select class="form-control select2bs4" id="slct_SftType" name="slct_SftType">
                                                <?php while ($row = mysqli_fetch_array($resultado)) {
                                                    $select = ($STP_idTbl_Software_Type == $row['STP_idTbl_Software_Type']) ? "selected=selected" : "";
                                                ?>
                                                    <option value="<?php echo $row['STP_idTbl_Software_Type']; ?>" <?php echo $select; ?>><?php echo $row['STP_Description']; ?></option>
                                                <?php }
                                                #NOTA
                                                #CADA QUE QUIERA HACER UNA NUEVA CONSULTA CON PROCEDIMIENTOS ALMACENADOS ESTOS EL RESULTADO SE CIERRA Y LA VARIABLE DE LA CONECCION SE PREPARA PARA EL NUEVO RESULTADO
                                                # QUE TENDRA ABAJO
                                                $resultado->close();
                                                $conn->next_result();
                                                ?>
                                            </select>
                                        </div>


                                        <!-- categoria  -->
                                        <div class="form-group" style="padding-left:15px; padding-top:2.5px;">
                                            <label><code>*</code>Categoria: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_selectCategory()"); ?>
                                            <select class="form-control select2bs4 " id="slct_category" name="slct_category">
                                                <?php while ($row = mysqli_fetch_array($resultado)) {
                                                    $select = ($CTG_idTbl_Category == $row['CTG_idTbl_Category']) ? "selected=selected" : "";
                                                ?>
                                                    <option value="<?php echo $row['CTG_idTbl_Category']; ?>" <?php echo $select; ?>><?php echo $row['CTG_Description']; ?></option>
                                                <?php }
                                                #NOTA
                                                #CADA QUE QUIERA HACER UNA NUEVA CONSULTA CON PROCEDIMIENTOS ALMACENADOS ESTOS EL RESULTADO SE CIERRA Y LA VARIABLE DE LA CONECCION SE PREPARA PARA EL NUEVO RESULTADO
                                                # QUE TENDRA ABAJO
                                                $resultado->close();
                                                $conn->next_result();
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group" style="padding-left:15px; padding-top:2.5px;">
                                            <label><code>*</code>Fabricante: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_manufacturerSoft_Select()"); ?>
                                            <select class="form-control select2bs4" style="width: 100%;" id="slct_manufacturerSftType" name="slct_manufacturerSftType">
                                                <?php while ($row = mysqli_fetch_array($resultado)) {
                                                    $select = ($MFS_idtbl_manufacturer_software == $row['MFS_idtbl_manufacturer_software']) ? "selected=selected" : "";

                                                ?>
                                                    <option value="<?php echo $row['MFS_idtbl_manufacturer_software']; ?>" <?php echo $select; ?>><?php echo $row['MFS_Description']; ?></option>
                                                <?php }
                                                #NOTA
                                                #CADA QUE QUIERA HACER UNA NUEVA CONSULTA CON PROCEDIMIENTOS ALMACENADOS ESTOS EL RESULTADO SE CIERRA Y LA VARIABLE DE LA CONECCION SE PREPARA PARA EL NUEVO RESULTADO
                                                # QUE TENDRA ABAJO
                                                $resultado->close();
                                                $conn->next_result();
                                                ?>
                                            </select>
                                        </div>
                                        <!-- Estado -->
                                        <div class="form-group" style="padding-left:15px; padding-top:2.5px;">
                                            <label><code>*</code>Estado del Software: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_status_select()"); ?>
                                            <select class="form-control select2bs4" id="selectStatus" name="selectStatus">
                                                <?php while ($row = mysqli_fetch_array($resultado)) {
                                                    $select = ($STS_idTbl_Status == $row['STS_idTbl_Status']) ? "selected=selected" : "";
                                                ?>
                                                    <option value="<?php echo $row['STS_idTbl_Status']; ?>" <?php echo $select; ?>><?php echo $row['STS_Description']; ?></option>
                                                <?php }
                                                #NOTA
                                                #CADA QUE QUIERA HACER UNA NUEVA CONSULTA CON PROCEDIMIENTOS ALMACENADOS ESTOS EL RESULTADO SE CIERRA Y LA VARIABLE DE LA CONECCION SE PREPARA PARA EL NUEVO RESULTADO
                                                # QUE TENDRA ABAJO
                                                $resultado->close();
                                                $conn->next_result();
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Observaciones -->
                                        <div class="form-group" style="padding-left:15px; padding-top:2.5px;">
                                            <label>Observaciones: </label>
                                            <textarea type="text" class="form-control" name="txtObservation" id="txtObservation" maxlength="60"> <?php echo $SFT_Observations; ?></textarea>
                                        </div>

                                    </div>
                                    <div class="col-sm-4">

                                    </div>

                                </div>
                                <!-- Comienzo fila 5 -->
                                <div class="row justify-content-center" style="padding-bottom:10px;">
                                    <div class="col-mb-12">
                                        <button type="submit" id="buttonUpdateSoftware" name="buttonUpdateSoftware" class="btn btn-block bg-olive" onclick='return validateData();'>Actualizar</button>
                                    </div>

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
<?php
require_once "../templates/footer.php";
?>


<?php
//validacion si preciona el boton  

# En caso de que haya sido el de guardar, no agregamos más campos
if (isset($_POST["buttonUpdateSoftware"])) {

    # Quieren guardar
    #valido si tiene el permiso de usuario 
    date_default_timezone_set('America/Mexico_City');
    $idSoftwareHidde = $_POST["softwareId"];
    $action = $_POST["txtAction"];

    $dataRegisterInput = $_POST["txtFechaIngresado"];
    $nameSoftwareInput = $_POST["txtNombreSoftware"];
    $versionSoftwareInput = $_POST["txtVersionSoftware"];
    $serialSoftwareInput = $_POST["txtSerialSoftware"];
    $licenceClasificationSelect = $_POST["slct_licenceClasification"];
    $typeSoftwareSelect = $_POST["slct_SftType"];
    $categorySelect = $_POST["slct_category"];
    $manufacturerSelect = $_POST["slct_manufacturerSftType"];
    $statuSelect = $_POST["selectStatus"];
    $observationSoftwareInput = $_POST["txtObservation"];
    #var_dump($_FILES['imgUser']);
    // valido si el campo esta vacio y  mango el antiguo valor
    if (empty($_FILES['imgSoft']['name'])) {
        $imagenSoftwareField = $SFT_Image;
    } else {
        $imagenSoftwareField = '/resources/Software/' . $_FILES['imgSoft']['name'];
    }

    $uploads_dir = '../../resources/Software/';  // Ruta de la carpeta de destino para los archivos

    if ($PermisoSTF && $action == "true") {

        //preparamos el insert
        try {

            $stmt = $conn->prepare("CALL sp_updateSoftware(?,?,?,?,?,?,?,?,?,?,?,?)");

            // Mandamos los parametros y los input que seran enviados al PA O SP
            $stmt->bind_param("ssssssssssss", $idSoftwareHidde, $imagenSoftwareField, $nameSoftwareInput, $manufacturerSelect, $versionSoftwareInput, $serialSoftwareInput, $typeSoftwareSelect, $licenceClasificationSelect, $dataRegisterInput, $observationSoftwareInput, $categorySelect, $statuSelect);
            $query = "CALL sp_updateUser('$idSoftwareHidde','$imagenSoftwareField','$nameSoftwareInput','$manufacturerSelect', '$versionSoftwareInput', '$serialSoftwareInput', '$typeSoftwareSelect', '$licenceClasificationSelect','$dataRegisterInput', '$observationSoftwareInput','$categorySelect', '$statuSelect');";
            echo $query;

            // Ejecutar el procedimiento almacenado
            $stmt->execute();

            $stmt->bind_result($answerExistsUser);
            $stmt->fetch();
            $stmt->close();
            $conn->next_result();


            // se extraen los valores qu     nos devuelve el procedimiento almacenado y enviamos el error
            if ($answerExistsUser > 0) {
                echo '<script > toastr.success("Los datos de <b>' . $nameSoftwareInput . '</b> se Actualizaron de manera exitosa.", "¡¡Enhorabuena!!"); ';
                echo 'setTimeout(function() {';
                echo '  window.location.href = "view_software.php";';
                echo ' }, 2000); // 2000 milisegundos = 2 segundos de retraso ';
                echo 'document.getElementById("formUpdateSoftware").reset(); ';
                echo '</script>';

                // Comprobar si el archivo ya existe
                $targetFilePath = $uploads_dir . $_FILES['imgSoft']['name'];

                // Verificar si el archivo ya existe en la ruta de destino
                if (file_exists($targetFilePath)) {
                    echo '<script>toastr.info("La imagen ya existe");</script>';
                    $uploadOk = 0; // Marcar la subida como no exitosa
                } else {
                    // Si el archivo no existe, intentar moverlo a la ruta de destino
                    if (move_uploaded_file($_FILES['imgSoft']['tmp_name'], $targetFilePath)) {
                        // El archivo se movió con éxito, aquí podrías realizar más acciones si es necesario
                    } else {
                        // Si hubo un error al mover el archivo, mostrar una notificación de error
                        echo '<script>toastr.error("Error al mover la imagen.");</script>';
                    }
                }
            }
        } catch (mysqli_sql_exception $e) {
            // Si ocurre una excepción, capturamos el código de error y lo imprimimos
            // Si ocurre una excepción, capturamos el código de error y lo imprimimos
            if ($e->getCode() == 1062) {
                // Check which specific unique field is causing the constraint violation
                if (strpos($e->getMessage(), 'SFT_Software_Name_UNIQUE') !== false) {
                    // echo "Error: ";
                    echo '<script > toastr.error("No se pudo guardar <br>El nombre del software proporcionado ya está en uso. Por favor, elige un nombre de software diferente.","¡¡UPS!!  Advertencia: 1");';
                    echo 'var usernametxt = document.getElementById("txt_username");';
                    echo 'usernametxt.focus();';
                    echo '</script>';
                } elseif (strpos($e->getMessage(), 'SFT_Serial_UNIQUE') !== false) {
                    echo '<script > toastr.error("No se pudo guardar <br>El serial para este software proporcionado ya está en uso. Por favor, elige un serial diferente.","¡¡UPS!!  Advertencia: 2");';
                    echo 'var emailtxt = document.getElementById("txtEmail");';
                    echo 'emailtxt.focus();';
                    echo '</script>';
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



<script type="text/javascript">
    // funcion para validar los datos ingresados en el formulario

    function validateData() {
        let softwarenameInput = document.getElementById('txtNombreSoftware');
        let versionInput = document.getElementById('txtVersionSoftware');
        let licenseSelect = document.getElementById('slct_licenceClasification');
        let statusSelect = document.getElementById('selectStatus');
        let categorySelect = document.getElementById('slct_category');
        let manufacturerSelect = document.getElementById('slct_manufacturerSftType');
        let serialSoftwareInput =document.getElementById('txtSerialSoftware');
        let Action = document.getElementById('txtAction');

         if (softwarenameInput.value.trim() === "") {
            toastr.warning('La <b>Nombre del software</b> esta vacio(a).<br>Por favor, rellene este campo');
            softwarenameInput.focus();
            return false;
        } else if (versionInput.value.trim() === "") {
            toastr.warning('La <b>Version de Instalacion</b> esta vacio(a).<br>Por favor, rellene este campo');
            versionInput.focus();
            return false;
        } else if (serialSoftwareInput.value.trim() === "") {
            toastr.warning('El <b>Serial/b> esta vacio(a).<br>Por favor, rellene este campo');
            serialSoftwareInput.focus();
            return false;
        }else if (licenseSelect.selectedIndex === 0) {
            toastr.warning('La <b>Licencia</b> seleccionado no es valido(a).<br>Por favor,seleccione un campo valido');
            licenseSelect.focus();
            return false;
        } else if (statusSelect.selectedIndex === 0) {
            toastr.warning('El <b>Estado</b> seleccionado no es valido(a).<br>Por favor,seleccione un campo valido');
            statusSelect.focus();
            return false;
        } else if (categorySelect.selectedIndex === 0) {
            toastr.warning('La <b>Categoria</b> seleccionada no es valido(a).<br>Por favor,seleccione un campo valido');
            categorySelect.focus();
            return false;
        } else if (manufacturerSelect.selectedIndex === 0) {
            toastr.warning('El <b>Fabricante</b> seleccionada no es valido(a).<br>Por favor,seleccione un campo valido');
            manufacturerSelect.focus();
            return false;
        } else {
            Action.value = "true";
            // Si no hay errores, procesa los datos enviados
            document.getElementById("formUpdateSoftware").submit();
        }


    }
    //Funcion General de las configuraciones de los toastr que aparecen al costado de la derecha superior

    toastr.options = {
        closeButton: true,
        debug: true,
        newestOnTop: false,
        progressBar: true,
        positionClass: "toast-top-right",
        preventDuplicates: true,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "5000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut"
    };
</script>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });

    $(function() {
        $(".datepicker-input").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });

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
    $("#imgSoft").change(function() {
        readURL(this);
    });
</script>