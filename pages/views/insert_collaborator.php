<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
<script src="../../public/jquery/jquery.min.js"></script>
<script src="../../public/js/toastr.min.js"></script>

<script type="text/javascript">
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
                                $ruta = "../views/view_collaborator.php";
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
                        <form role="form" action="" method="POST" name="formInsertCBT" id="formInsertCBT" class="form-horizontal" enctype="multipart/form-data">
                            <div class="card-body">
                                <label class="form-check-label" style="padding-bottom: 5px;"> A continuación se le pedirá que <b> Ingrese</b> los siguientes datos:</label>

                                <!-- Input ocultos  -->
                                <input type="hidden" class="form-control" id="todayDate" name="todayDate" placeholder="<?php echo $todayDate ?>">
                                <input type="hidden" class="form-control" id="accion" name="accion" placeholder="">

                                <!-- Fila 1 -->
                                <div class="row justify-content-center">
                                    <!-- IMAGEN -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Imagen de Referencia Colaborador: </label>
                                            <div class="input-group" style=" display: flex;   justify-content: center;   align-items: center;   height: 200px;">
                                                <img class="img-fluid" src="../../resources/Collaborator/default.jpg" width="150" height="150" id="imgPerfil">
                                                <input type="file" name="fileImg" id="fileImg" accept="image/png,image/jpeg" style="margin-left: 20px;text-align: center;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Fila 2 -->
                                <div class="row justify-content-center" style="padding-top:10px; padding-bottom:10px;">
                                    <!-- Codigo de Empleado -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Código Empleado:</label>
                                            <input type="number" class="form-control" name="txtEmployeeCode" id="txtEmployeeCode" maxlength="45" placeholder="002872">
                                        </div>
                                    </div>

                                    <!-- Nacionalidad -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Nacionalidad: </label>
                                            <?php
                                            #Se procede a llamar al procedimiento almacenado que se llama sp_manufacturer_select,con la variable que almancena "cnn" la base de datos 
                                            $resultado = mysqli_query($conn, "CALL sp_selectNationality()"); ?>
                                            <select class="form-control select2bs4" id="slctNacionality" name="slctNacionality">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['NTL_idTbl_Nationality']; ?>"><?php echo $row['NTL_Description']; ?></option>
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

                                    <!-- Primer Nombre -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Primer Nombre :</label>
                                            <input type="text" class="form-control" name="txtfirstName" id="txtfirstName" maxlength="25" placeholder="José">
                                        </div>
                                    </div>

                                    <!-- Segundo Nombre -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Segundo Nombre :</label>
                                            <input type="text" class="form-control" name="txtsecondName" id="txtsecondName" maxlength="25" placeholder="Santos">
                                        </div>
                                    </div>
                                </div>

                                <!-- Fila 3 -->
                                <div class="row justify-content-center" style="padding-top:10px; padding-bottom:10px;">
                                    <!-- Primer Apellido -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Primer Apellido :</label>
                                            <input type="text" class="form-control" name="txtfirstSurname" id="txtfirstSurname" maxlength="25" placeholder="Martinez">
                                        </div>
                                    </div>

                                    <!-- Segundo Apellido -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Segundo Apellido :</label>
                                            <input type="text" class="form-control" name="txtsecondSurname" id="txtsecondSurname" maxlength="25" placeholder="Hernandez">
                                        </div>
                                    </div>

                                    <!-- Genero -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Genero: </label>
                                            <?php
                                            #Se procede a llamar al procedimiento almacenado que se llama sp_manufacturer_select,con la variable que almancena "cnn" la base de datos 
                                            $resultado = mysqli_query($conn, "CALL sp_selectGender()"); ?>
                                            <select class="form-control select2bs4" id="slctGender" name="slctGender">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['GD_idTbl_Gender']; ?>"><?php echo $row['GD_Description']; ?></option>
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

                                    <!-- Número de teléfono -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Número de teléfono :</label>
                                            <input type="text" class="form-control" name="txtphoneNumber" id="txtphoneNumber" maxlength="16" placeholder="+504 0000-0000" pattern="\([0-9]{4}\) [0-9]{4}[ -][0-9]{4}" required>
                                        </div>
                                    </div>
                                </div>


                                <!-- Fila 4 -->
                                <div class="row justify-content-center" style="padding-top:10px; padding-bottom:10px;">
                                    <!-- Fecha de cumpleaños -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label> Fecha de Nacimiento:</label>
                                            <input type="text" class="form-control datepicker-input" name="txtbirthDate" id="txtbirthDate">
                                        </div>
                                    </div>

                                    <!-- Dirección -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Dirección :</label>
                                            <input type="text" class="form-control" name="txtaddress" id="txtaddress" maxlength="60" placeholder="B° el centro">
                                        </div>
                                    </div>

                                    <!-- Gerencia -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Gestion: </label>
                                            <?php
                                            #Se procede a llamar al procedimiento almacenado que se llama sp_manufacturer_select,con la variable que almancena "cnn" la base de datos 
                                            $resultado = mysqli_query($conn, "CALL sp_selectManagement()"); ?>
                                            <select class="form-control select2bs4" id="slctManagement" name="slctManagement">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['MNG_idTbl_Management']; ?>"><?php echo $row['MNG_Description']; ?></option>
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

                                    <!-- Proceso -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Proceso: </label>
                                            <?php
                                            #Se procede a llamar al procedimiento almacenado que se llama sp_manufacturer_select,con la variable que almancena "cnn" la base de datos 
                                            $resultado = mysqli_query($conn, "CALL sp_selectProcess()"); ?>
                                            <select class="form-control select2bs4" id="slctProcess" name="slctProcess">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['PCS_idTbl_Process']; ?>"><?php echo $row['PCS_Description']; ?></option>
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
                                <div class="row justify-content-center" style="padding-bottom:20px;">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Cargo a Desempeñar:</label>
                                            <input type="text" class="form-control" name="txtposition" id="txtposition" maxlength="45" placeholder="Auxiliar ">
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center" style="padding-bottom:20px;">
                                    <!-- Boton guardar -->
                                    <div class="col-sm-2" style="padding-top:40px;">
                                        <button type="submit" class="btn btn-block btn-info" id="buttonInsertCBT" name="buttonInsertCBT" onclick='return validate_data();'>Guardar</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                </div>
                            </div>


                    </div>

                </div>
            </div>
        </div>
</div>
</section>
</div>
<?php
require_once "../templates/footer.php";
?>
<script>
    // Función para validar los datos ingresados en el formulario
    function validate_data() {
        let employeeCodeTxt = document.getElementById('txtEmployeeCode');
        let nacionalitySlct = document.getElementById('slctNacionality');
        let firstNameTxt = document.getElementById('txtfirstName');
        let firstSurnameTxt = document.getElementById('txtfirstSurname');
        let genderSlct = document.getElementById('slctGender');
        let phoneNumberTxt = document.getElementById('txtphoneNumber');
        let addressTxt = document.getElementById('txtaddress');
        let processSlct = document.getElementById('slctProcess');
        let managementSlct = document.getElementById('slctManagement');
        let positionTxt = document.getElementById('txtposition');

        if (employeeCodeTxt.value.trim() === "") {
            toastr.warning("El <b>Codigo de Empleado</b> esta vacio(a).<br>Por favor Ingrese un Codigo de Empleado valida");
            employeeCodeTxt.focus();
            return false;
        } else if (nacionalitySlct.selectedIndex == 0) {
            toastr.warning('La <b>Nacionalidad</b> esta vacio(a).<br>Por favor Ingrese una Nacionalidad valida');
            nacionalitySlct.focus();
            return false;
        } else if (firstNameTxt.value.trim() === "") {
            toastr.warning("El <b>Primer Nombre</b> esta vacio(a).<br>Por favor Ingrese un Primer Nombre valida");
            firstNameTxt.focus();
            return false;
        } else if (firstSurnameTxt.value.trim() === "") {
            toastr.warning("El <b>Primer Apellido</b> esta vacio(a).<br>Por favor Ingrese un Primer Apellido valida");
            firstSurnameTxt.focus();
            return false;
        } else if (genderSlct.selectedIndex == 0) {
            toastr.warning('El <b>Genero</b> esta vacio(a).<br>Por favor Ingrese una Genero valida');
            genderSlct.focus();
            return false;
        } else if (phoneNumberTxt.value.trim() === "") {
            toastr.warning("El <b>Número de teléfono</b> esta vacio(a).<br>Por favor Ingrese un Número de teléfono valida");
            phoneNumberTxt.focus();
            return false;
        } else if (addressTxt.value.trim() === "") {
            toastr.warning("La <b>Dirección</b> esta vacio(a).<br>Por favor Ingrese una Dirección valida");
            addressTxt.focus();
            return false;
        } else if (processSlct.selectedIndex == 0) {
            toastr.warning('El <b>Proceso</b> esta vacio(a).<br>Por favor Ingrese una Proceso valida');
            processSlct.focus();
            return false;
        } else if (managementSlct.selectedIndex == 0) {
            toastr.warning('La <b>Gestión</b> esta vacio(a).<br>Por favor Ingrese una Gestión valida');
            managementSlct.focus();
            return false;
        } else if (positionTxt.value.trim() === "") {
            toastr.warning("El <b>Cargo de Desempeño</b> esta vacio(a).<br>Por favor Ingrese un Cargo de Desempeño");
            positionTxt.focus();
            return false;
        } else {
            // Si no hay errores, procesa los datos enviados
            if (accionInput.value.trim() === "") {
                accionInput.value = "1";

            }
            document.getElementById("formInsertCBT").submit();

        }

    }

    $(function() {
        $(".datepicker-input").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });

    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
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
    $("#fileImg").change(function() {
        readURL(this);
    });
</script>

<?php
if (isset($_POST["buttonInsertCBT"])) {
    $imgCBT =  $_FILES['fileImg']['name'];
    $employeCodeCBT = $_POST["txtEmployeeCode"];
    $nacionalityCBT = $_POST["slctNacionality"];
    $firstNameCBT = $_POST["txtfirstName"];
    $secondNameCBT = $_POST["txtsecondName"];
    $firstSurnameCBT = $_POST["txtfirstSurname"];
    $secondSurnameCBT = $_POST["txtsecondSurname"];
    $genderCBT = $_POST["slctGender"];
    $phoneNumberCBT = $_POST["txtphoneNumber"];
    $birthDateCBT = $_POST["txtbirthDate"];
    $addressCBT = $_POST["txtaddress"];
    $processCBT = $_POST["slctProcess"];
    $managementCBT = $_POST["slctManagement"];
    $employeePositionCBT = $_POST["txtposition"];
    date_default_timezone_set('America/Mexico_City');
    $todayDate = date("Y-m-d");
    $idUser = $_SESSION["User_idTbl_User"];
    $status = '2';


    if (empty($imgCBT)) {
        $imgCBT = '/resources/Collaborator/default.jpg';
    } else {
        $imgCBT = '/resources/Collaborator/' . $_FILES['fileImg']['name'];
    }
    # Ruta de la carpeta de destino para los archivos
    $urlCBT = '../../resources/Collaborator/';
    if ($PermisoCBT) {
        try {
            //Caso contrario Guardara
            $stmt = $conn->prepare("CALL sp_insertCollaborator(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

            // $query = "CALL sp_insertCollaborator('$imgCBT', '$employeCodeCBT', '$nacionalityCBT', '$firstNameCBT', '$secondNameCBT', '$firstSurnameCBT', '$secondSurnameCBT', '$genderCBT', '$phoneNumberCBT', '$birthDateCBT', '$addressCBT', '$processCBT', '$managementCBT', '$todayDate', '$idUser','$status');";
            // echo $query;
            // Mandamos los parametros y los input que seran enviados al PA O SP
            $stmt->bind_param("sssssssssssssssss", $imgCBT, $employeCodeCBT, $nacionalityCBT, $firstNameCBT, $secondNameCBT, $firstSurnameCBT, $secondSurnameCBT, $genderCBT, $phoneNumberCBT, $birthDateCBT, $addressCBT, $processCBT, $managementCBT, $todayDate, $idUser, $status, $employeePositionCBT);


            // Ejecutar el procedimiento almacenado
            $stmt->execute();
            if ($stmt->error) {
                error_log("Error en la ejecución del procedimiento almacenado: " . $stmt->error);
            }
            // Obtener el valor de la variable de salida
            $stmt->bind_result($answerExistsComp);
            $stmt->fetch();
            $stmt->close();
            $conn->next_result();

            // se extraen los valores qu     nos devuelve el procedimiento almacenado y enviamos el error
            if ($answerExistsComp > 0) {
                echo '<script > toastr.success("Los datos de <b>' . $employeCodeCBT . '</b> se Guardaron de manera exitosa.", "¡¡Enhorabuena!!"); ';
                echo 'setTimeout(function() {';
                echo '  window.location.href = "view_collaborator.php";';
                echo ' }, 2000); // 2000 milisegundos = 2 segundos de retraso ';
                echo 'document.getElementById("formInsertCBT").reset(); ';
                echo '</script>';

                if ($_FILES['fileImg']['name'] != 'default.jpg') {
                    move_uploaded_file($_FILES['fileImg']['tmp_name'], $urlCBT . $_FILES['fileImg']['name']);
                } else if (file_exists($urlCBT . $_FILES['fileImg']['name'])) {
                    echo '<script > toastr.info("La imagen ya existe ' . $imgCBT . '")</script>;';
                    $uploadOk = 0; //si existe lanza un valor en 0                 

                }
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                // Check which specific unique field is causing the constraint violation
                if (strpos($e->getMessage(), 'CBT_Employee_Code_UNIQUE') !== false) {
                    // echo "Error: ";
                    echo '<script > toastr.error("No se pudo guardar <br> El Código de Empleado proporcionado ya está en uso. Por favor, elige un Código de Empleado diferente.","¡¡UPS!!  Advertencia: 1");';
                    echo 'var nombretxt = document.getElementById("txtTechnicalName");';
                    echo 'nombretxt.focus();';
                    echo '</script>';
                } elseif (strpos($e->getMessage(), 'CBT_Phone_Number_UNIQUE') !== false) {
                    echo '<script > toastr.error("No se pudo guardar <br> El Número de teléfono proporcionado ya está en uso. Por favor, elige un Número de teléfono diferente.","¡¡UPS!!  Advertencia: 2");';
                    echo 'var servitagtxt = document.getElementById("txtServitag");';
                    echo 'servitagtxt.focus();';
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