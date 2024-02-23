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


    // Función para validar los datos ingresados en el formulario
    function validate_data() {
        var accionInput = document.getElementById('accion');
        var acquisitionFecha = document.getElementById('txtacquisitionDate');
        var selectmanufacturer = document.getElementById('selectmanufacturer');
        var selectModel = document.getElementById('selectModel');
        var selectComputertypes = document.getElementById('selectComputertypes');
        var nombreInput = document.getElementById('txtTechnicalName');
        var servitagInput = document.getElementById('txtServitag');
        var warrantyExpirationInput = document.getElementById('txtWarrantyExpiration');
        // var licenceInput = document.getElementById('txtLicense');
        var statusSelect = document.getElementById('selectStatus');
        var locationsSelect = document.getElementById('selectLocation');
        var guaranteeSelect = document.getElementById('selectTypeGuarantee');
        var todayDateInput = document.getElementById('todayDate');
        var serialTxt = document.getElementById('txtSerial');
        var sistemaOperativosslct = document.getElementById('slctOS');
        let peripheralsSlct = document.getElementById('slctPeripherals');
        let selectedOptions = Array.from(slctPeripherals.selectedOptions);
        if (selectedOptions.length == 0) {
            // alert('Ninguna opción ha sido seleccionada.');
            toastr.warning('No ha seleccionado ninguna <b>Especificacion del Equipo</b> esta vacio(a).<br>Por favor Ingrese una Software valida');
            peripheralsSlct.focus();
            return false;
        }

        if (acquisitionFecha.value.trim() === "") {
            toastr.warning("La <b>Fecha de Compra</b> esta vacio(a).<br>Por favor Ingrese una fecha valida.");
            acquisitionFecha.focus();
            return false;
        } else if (selectmanufacturer.selectedIndex == 0) {
            toastr.warning('La <b>Marca</b> esta vacio(a).<br>Por favor Ingrese una Marca valida.');
            selectmanufacturer.focus();
            return false;
        } else if (selectModel.value == 1) {
            toastr.warning('El <b>Modelo</b> esta vacio(a).<br>Por favor Ingrese un Modelo valida.');
            selectModel.focus();
            return false;
        } else if (selectComputertypes.selectedIndex == 0) {
            toastr.warning('El <b>Tipo de computadora</b> esta vacio(a).<br>Por favor Ingrese un tipo de computadora valido.');
            selectComputertypes.focus();
        } else if (nombreInput.value.trim() === "") {
            toastr.warning('El <b>Nombre técnico</b> esta vacio(a).<br>Por favor Ingrese un Nombre valido.');
            nombreInput.focus();
            return false;
        } else if (servitagInput.value.trim() === "") {
            toastr.warning('El <b>Servitag</b> esta vacio(a).<br>Por favor Ingrese una txtServitag valido.');
            servitagInput.focus();
            return false;
        } else if (warrantyExpirationInput.value.trim() === "") {
            toastr.warning('La <b>Fecha Límite Garantía</b> esta vacio(a).<br>Por favor Ingrese una Fecha Límite Garantía valida.');
            warrantyExpirationInput.focus();
            return false;
        }
        // else if (licenceInput.value.trim() === "") {
        //     toastr.warning('La <b>Lincencia</b> esta vacio(a).<br>Por favor Ingrese una Lincensia valida.');
        //     licenceInput.focus();
        //     return false;
        // } 
        else if (statusSelect.selectedIndex == 0) {
            toastr.warning('El <b>Estado del Computador</b> esta vacio(a).<br>Por favor Ingrese una Estado del Computador valida.');
            statusSelect.focus();
            return false;
        } else if (locationsSelect.selectedIndex == 0) {
            toastr.warning('La <b>Localizacion del Computador</b> esta vacio(a).<br>Por favor Ingrese una Localizacion del Computador valida.');
            locationsSelect.focus();
            return false;
        } else if (guaranteeSelect.selectedIndex == 0) {
            toastr.warning('El <b>Tipo de Garantia </b> esta vacio(a).<br>Por favorIngrese Tipo de Garantia del Computador valida.');
            guaranteeSelect.focus();
            return false;
        } else if (sistemaOperativosslct.selectedIndex == 0) {
            toastr.warning('El <b>Sistema Operativo </b> esta vacio(a).<br>Por favor Ingrese Tipo de Garantia del Computador valida.');
            sistemaOperativosslct.focus();
            return false;
        } else if (serialTxt.value.trim() === "") {
            toastr.warning('El <b>Serial</b> esta vacio(a).<br>Por favor Ingrese un Serial para el Computador valido.');
            serialTxt.focus();
            return false;
        } else {
            // Si no hay errores, procesa los datos enviados
            //$opcion = $_POST['opciones'];
            if (accionInput.value.trim() === "") {
                accionInput.value = "1";

            }
            document.getElementById("formInsertCMP").submit();

        }
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
                                $ruta = "../views/view_computer.php";
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
                        <form role="form" action="" method="POST" name="formInsertCMP" id="formInsertCMP" class="form-horizontal" enctype="multipart/form-data">
                            <div class="card-body">
                                <label class="form-check-label" style="padding-bottom: 5px;"> A continuación se le pedirá que <b> Ingrese</b> los siguientes datos:</label>

                                <!-- Input ocultos  -->
                                <!-- Input para guardar la lista de los software a guardar -->
                                <input type="hidden" class="form-control" id="TxtId" name="TxtId" placeholder="">
                                <input type="hidden" class="form-control" id="accion" name="accion" placeholder="">
                                <!-- Fila 1   -->
                                <div class="row" style="padding-top:10px; padding-bottom:10px;">
                                    <!-- Fecha de Compra -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><code>*</code>Fecha de Compra:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control datepicker-input" name="txtacquisitionDate" id="txtacquisitionDate">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- MARCA -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><code>*</code>Marca: </label>
                                            <?php
                                            #Se procede a llamar al procedimiento almacenado que se llama sp_manufacturer_select,con la variable que almancena "cnn" la base de datos 
                                            $resultado = mysqli_query($conn, "CALL sp_manufacturer_select()"); ?>
                                            <select class="form-control select2bs4" id="selectmanufacturer" name="selectmanufacturer" onchange="filtrarModelos()">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['MFC_idTbl_Manufacturer']; ?>"><?php echo $row['MFC_Description']; ?></option>
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
                                    <!-- MODELOS  -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><code>*</code>Modelo : </label>
                                            <!-- <input type="text" id="lookModels" placeholder="Buscar modelo en especifico" class="form-control"> -->
                                            <?php $resultado = mysqli_query($conn, "CALL sp_model_select()"); ?>
                                            <select class="form-control select2bs4" id="selectModel" name="selectModel">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['MDL_idTbl_Model']; ?>" data-manufacturer="<?php echo $row['MFC_idTbl_Manufacturer']; ?>"><?php echo $row['MDL_Description']; ?></option>
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
                                    <!-- TIPO DE COMPUTADORA -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><code>*</code>Tipo de Computadora : </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_computerType_select()"); ?>
                                            <select class="form-control select2bs4" id="selectComputertypes" name="selectComputertypes">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['CT_idTbl_Computer_Type']; ?>"><?php echo $row['CT_Description']; ?></option>
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
                                    <!-- Nombre Tecnico-->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><code>*</code>Nombre Técnico:</label>
                                            <input type="text" class="form-control" name="txtTechnicalName" id="txtTechnicalName" maxlength="45" placeholder="ASSET2023-0#">
                                        </div>
                                    </div>
                                </div>

                                <!-- Fila 2 -->
                                <div class="row" style="padding-bottom:10px;">

                                    <!-- Servitag-->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><code>*</code>Servitag: </label>
                                            <input type="text" class="form-control" name="txtServitag" id="txtServitag" maxlength="45" placeholder="FKCX???">
                                        </div>
                                    </div>
                                    <!-- Fecha limite garantia -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><code>*</code>Fecha Límite Garantía:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control datepicker-input" name="txtWarrantyExpiration" id="txtWarrantyExpiration" onchange="actualizarAnio()">
                                            </div>
                                        </div>
                                    </div>
                                    <!--Año Limite Garantía -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Año Limite Garantía: </label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" min="2000" max="2050" name="txtYearExpiration" id="txtYearExpiration" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Tipo de Garantia -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><code>*</code>Tipo de Garantia: </label>
                                            <?php
                                            #Se procede a llamar al procedimiento almacenado que se llama sp_manufacturer_select,con la variable que almancena "cnn" la base de datos 
                                            $resultado = mysqli_query($conn, "CALL sp_typeGuarantee_select()"); ?>
                                            <select class="form-control select2bs4" id="selectTypeGuarantee" name="selectTypeGuarantee">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['TG_idtbl_Type_Guarantee']; ?>" data-warranty="<?php echo $row['MFC_idTbl_Manufacturer']; ?>"><?php echo $row['TG_Description']; ?></option>
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
                                    <!-- Licencia -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Licencia: </label>
                                            <input type="text" class="form-control" name="txtLicense" id="txtLicense" maxlength="60" placeholder="CMCDN-?????-?????-?????-?????">
                                        </div>
                                    </div>
                                </div>
                                <!-- Fila 3 -->
                                <div class="row justify-content-center" style="padding-bottom:10px;">

                                    <!-- Tarjeta Madre -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><code>*</code>Serial: </label>
                                            <input type="text" class="form-control" name="txtSerial" id="txtSerial" maxlength="60" placeholder="FKC---3">
                                        </div>
                                    </div>
                                    <!-- Sistema Operativo  -->
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><code>*</code>Sistema Operativo: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_selectOperatingSystem()"); ?>
                                            <select class="form-control select2bs4" id="slctOS" name="slctOS">
                                                <option value="0">Empty/Vacio</option>
                                                <?php while ($row = mysqli_fetch_array($resultado)) {
                                                    $select = ($OS_idtbl_operatingSystems == $row['OS_idtbl_operatingSystems']) ? "selected=selected" : "";
                                                ?>
                                                    <option value="<?php echo $row['OS_idtbl_operatingSystems']; ?>" <?php echo $select; ?>><?php echo $row['INFO']; ?></option>
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
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><code>*</code>Localizacion del Computador : </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_location_select"); ?>
                                            <select class="form-control select2bs4" id="selectLocation" name="selectLocation">
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
                                    <!-- Especificaciones del Equipo-->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><code>*</code>Especificaciones del Equipo:</label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_selectPeripheralsActive()"); ?>

                                            <select class="duallistbox" multiple="multiple" id="slctPeripherals" name="slctPeripherals">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['PRL_idTbl_Peripherals']; ?>"><?php echo $row['info']; ?></option>
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
                                        <div class="form-group">
                                            <label>Observaciones: </label>
                                            <textarea type="text" class="form-control" name="txtObservation" id="txtObservation" maxlength="100" value="<?php echo (isset($observations) ? $observations : ""); ?>"> </textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Fila 4 -->
                                <div class="row justify-content-center">
                                    <!-- IMAGEN -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Imagen de Referencia Dispostivo: </label>
                                        
                                            <div class="input-group" style=" display: flex;   justify-content: center;   align-items: center;   height: 200px;">
                                                <img class="img-fluid" src="../../resources/Computer/default.jpg" width="200" height="250" id="imgPerfil">
                                                <input type="file" name="fileImg" id="fileImg" accept="image/png,image/jpeg" style="margin-left: 20px;text-align: center;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fila 5 -->
                                <div class="row justify-content-center" style="padding-bottom:20px;">
                                    <!-- Boton guardar -->
                                    <div class="col-sm-2">
                                        <button type="submit" class="btn btn-block btn-info" id="buttonInsertCMP" name="buttonInsertCMP" onclick='return validate_data();'>Guardar</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                </div>
                                <!-- /.card body -->
                            </div>
                            <!-- /.form-->
                        </form>
                        <!-- /.card card-primary card-outline -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
if (isset($_POST["buttonInsertCMP"])) {
    $accion = $_POST["accion"];
    $cmpAcquisitionDate = $_POST["txtacquisitionDate"];
    $cmpIdManufacturer = $_POST['selectmanufacturer'];
    $cmpIdModel = $_POST['selectModel'];
    $cmpCompType = $_POST['selectComputertypes'];
    $cmptName = $_POST['txtTechnicalName'];
    $cmpServitag = $_POST['txtServitag'];
    $cmpWarrantyExpiration = $_POST['txtWarrantyExpiration'];
    //$cmpYearExpiration = date("Y", strtotime($cmpWarrantyExpiration));
    $cmpYearExpiration = $_POST['txtYearExpiration'];
    $cmpLicence = $_POST['txtLicense'];
    if (empty($cmpLicence)) {
        $cmpLicence = NULL;
    }
    $cmpMotherboard = $_POST['txtSerial'];
    $cmpIdStatu = 2;
    $cmpIdLocation = $_POST['selectLocation'];

    $idsArrayTexto  = $_POST["TxtId"];
    // Decodifica la cadena JSON en un array de PHP
    //idsArray es la variable para la lista de codigos seleccionados
    $idsArray = json_decode($idsArrayTexto);


    //var_dump(isset(  $_FILES['fileImg']['name'])); 
    $cmpImgComp =  $_FILES['fileImg']['name'];

    if (empty($cmpImgComp)) {
        $cmpImgComp = '/resources/Computer/default.jpg';
    } else {
        $cmpImgComp = '/resources/Computer/' . $_FILES['fileImg']['name'];
    }
    $cmpObservation = $_POST['txtObservation'];
    $cmpIdGuarantee = $_POST['selectTypeGuarantee'];
    //$cmpImgCompReport = "";
    date_default_timezone_set('America/Mexico_City');
    $todayDate = date("Y-m-d");

    # Ruta de la carpeta de destino para los archivos
    $cmp_dir = '../../resources/Computer/';
    $idUser = $_SESSION["User_idTbl_User"];
    $cmpIdSistemaOperativo = $_POST['slctOS'];
    //validamos si tiene permiso de hacer un insert 

    if ($PermisoCMP) {

        try {
            //Caso contrario Guardara
            $stmt = $conn->prepare("CALL sp_insertComputer(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

            // Mandamos los parametros y los input que seran enviados al PA O SP
            $stmt->bind_param("ssssssssssssssssss", $todayDate, $cmpIdManufacturer, $cmpImgComp, $cmptName, $cmpIdModel, $cmpCompType, $cmpServitag, $cmpLicence, $cmpMotherboard, $cmpAcquisitionDate, $cmpWarrantyExpiration, $cmpYearExpiration, $cmpIdLocation, $cmpIdStatu, $cmpObservation, $idUser, $cmpIdGuarantee, $cmpIdSistemaOperativo);


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

            if ($answerExistsComp > 0) {
                foreach ($idsArray as $id) {
                    //Insert para mapping software 
                    // detalle para software
                    $stsId = '2';
                    $stmt = $conn->prepare("CALL sp_insertComputerDetail(?,?,?,?,?)");

                    $query = "CALL sp_insertComputerDetail( '$answerExistsComp', '$id', '$idUser', '$stsId', '$todayDate');";
                    echo $query;
                    // Mandamos los parametros y los input que seran enviados al PA O SP
                    $stmt->bind_param("sssss", $answerExistsComp, $id, $idUser, $stsId, $todayDate);


                    // Ejecutar el procedimiento almacenado
                    $stmt->execute();
                    if ($stmt->error) {
                        error_log("Error en la ejecución del procedimiento almacenado: " . $stmt->error);
                    }
                    // Obtener el valor de la variable de salida
                    $stmt->bind_result($answerExistsDetail);
                    $stmt->fetch();
                    $stmt->close();
                    $conn->next_result();

                    // echo "Inserción exitosa para ID: " . $id . "<br>";
                    //   echo "Inserción exitosa para ID: " . $id . "<br>";

                }
            }


            // se extraen los valores qu     nos devuelve el procedimiento almacenado y enviamos el error
            if ($answerExistsDetail > 0) {
                echo '<script > toastr.success("Los datos de <b>' . $cmptName . '</b> se Guardaron de manera exitosa.", "¡¡Enhorabuena!!"); ';
                echo 'setTimeout(function() {';
                echo '  window.location.href = "view_computer.php";';
                echo ' }, 2000); // 2000 milisegundos = 2 segundos de retraso ';
                echo 'document.getElementById("formInsertCMP").reset(); ';
                echo '</script>';

                if ($_FILES['fileImg']['name'] != 'default.jpg') {
                    move_uploaded_file($_FILES['fileImg']['tmp_name'], $cmp_dir . $_FILES['fileImg']['name']);
                } else if (file_exists($cmp_dir . $_FILES['fileImg']['name'])) {
                    echo '<script > toastr.info("La imagen ya existe ' . $cmpImgComp . '")</script>;';
                    $uploadOk = 0; //si existe lanza un valor en 0                 

                }
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                // Check which specific unique field is causing the constraint violation
                if (strpos($e->getMessage(), 'CMP_Technical_Name_UNIQUE') !== false) {
                    // echo "Error: ";
                    echo '<script > toastr.error("No se pudo guardar <br> El Nombre técnico  proporcionado ya está en uso. Por favor, elige un Nombre técnico  diferente.","¡¡UPS!!  Advertencia: 1");';
                    echo 'var nombretxt = document.getElementById("txtTechnicalName");';
                    echo 'nombretxt.focus();';
                    echo '</script>';
                } elseif (strpos($e->getMessage(), 'CMP_Servitag_UNIQUE') !== false) {
                    echo '<script > toastr.error("No se pudo guardar <br> El Servitag proporcionado ya está en uso. Por favor, elige un Servitag diferente.","¡¡UPS!!  Advertencia: 2");';
                    echo 'var servitagtxt = document.getElementById("txtServitag");';
                    echo 'servitagtxt.focus();';
                    echo '</script>';
                } elseif (strpos($e->getMessage(), 'CMP_License_UNIQUE') !== false) {
                    // Replace 'another_unique_field' with the actual name of the third unique field
                    echo '<script > toastr.error("No se pudo guardar <br>La Licencia del colaborador proporcionado ya está en uso. Por favor, elige una Licencia  diferente.","¡¡UPS!!  Advertencia: 3");';
                    echo 'var  licencetxt = document.getElementById("txtLicense");';
                    echo 'licencetxt.focus();';
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
<?php
require_once "../templates/footer.php";
?>
<script>
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


    // Función para actualizar el valor del campo de entrada del año
    function actualizarAnio() {
        var warrantyExpirationInput = document.getElementById('txtWarrantyExpiration');
        var yearExpirationInput = document.getElementById('txtYearExpiration');

        // Obtener el año a partir de la fecha
        var fecha = new Date(warrantyExpirationInput.value);
        var anio = fecha.getFullYear();

        // Actualizar el valor del campo de entrada del año
        yearExpirationInput.value = anio;
    }
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
    $(document).ready(function() {
        // Inicializa el componente Dual Listbox para el select #slctPeripherals
        var demo1 = $('select[name="slctPeripherals"]').bootstrapDualListbox();

        // Variable para almacenar los IDs seleccionados
        var array = [];

        // Función para actualizar el campo de texto
        function actualizarCampoTexto() {
            // Obtiene los elementos seleccionados en el Dual Listbox del select #slctPeripherals
            var selectedOptions = demo1.val();

            if (selectedOptions.length > 0) {
                // Reinicia el array en cada cambio para evitar duplicados
                array = [];

                // Recorre los valores seleccionados y agrega los IDs al array
                selectedOptions.forEach(function(optionValue) {
                    array.push(optionValue);
                });

                // Convierte el array a una cadena JSON
                var arrayTexto = JSON.stringify(array);

                // Actualiza el valor del campo de texto con la cadena JSON
                $('#TxtId').val(arrayTexto);
            } else {
                // Si no hay opciones seleccionadas, borra el valor del campo de texto
                $('#TxtId').val('');
            }
        }

        // Agrega un manejador de evento para el cambio en el select #slctPeripherals
        $('#slctPeripherals').on('change', function() {
            // Llama a la función para actualizar el campo de texto
            actualizarCampoTexto();
        });

        // Llama a la función al cargar la página para mostrar las opciones seleccionadas inicialmente
        actualizarCampoTexto();
    });

    function filtrarModelos() {
        // Obtener el valor seleccionado en el primer select
        var manufacturerSeleccionado = document.getElementById("selectmanufacturer").value;

        // Obtener todos los options del segundo select
        var opcionesModelos = document.getElementById("selectModel").options;

        // Obtener todos los options del tercer select
        var opcionesGarantias = document.getElementById("selectTypeGuarantee").options;

        // Obtenr el texto del segundo seletc
        var contenidoModelo = document.getElementsByTagName("option");
        // Obtenr el texto del tercer seletc
        var contenidoGarantia = document.getElementsByTagName("option");

        // Recorrer todas las opciones y ocultar las que no pertenecen al fabricante seleccionado
        for (var i = 1; i < opcionesModelos.length; i++) {
            var modelo = opcionesModelos[i];
            if (modelo.getAttribute("data-manufacturer") == manufacturerSeleccionado || manufacturerSeleccionado == "") {
                modelo.disabled = false; // No se deshabilita si pertenece al fabricante seleccionado o si no se seleccionó ningún fabricante
            } else {
                modelo.disabled = true; // Se deshabilita si no pertenece al fabricante seleccionado
            }
        }

        // Si no hay modelos disponibles para el fabricante seleccionado, mostrar un mensaje en el segundo select
        if (document.querySelectorAll("#selectModel option[style='display: none;']").length === opcionesModelos.length - 1) {
            document.getElementById("selectModel").innerHTML = "<option value=''>No hay modelos disponibles para este fabricante</option>";
        }
        // Recorrer todas las opciones y ocultar las que no pertenecen al fabricante seleccionado
        for (var i = 1; i < opcionesGarantias.length; i++) {
            var garantia = opcionesGarantias[i];
            if (garantia.getAttribute("data-warranty") == manufacturerSeleccionado || manufacturerSeleccionado == "") {
                garantia.style.display = "";
            } else {
                garantia.style.display = "none";
            }
        }

        // Si no hay Garantias disponibles para el fabricante seleccionado, mostrar un mensaje en el segundo select
        if (document.querySelectorAll("#selectTypeGuarantee option[style='display: none;']").length === opcionesGarantias.length - 1) {
            document.getElementById("selectTypeGuarantee").innerHTML = "<option value=''>No hay modelos disponibles para este fabricante</option>";
        }

    }

    $(function() {
        $(".datepicker-input").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });


    // Vincula el input de búsqueda con el select ded models 
    // $(document).ready(function() {
    //     $('#lookModels').on('keyup', function() {
    //         var texto = $(this).val().toLowerCase();
    //         $('#selectModel option').filter(function() {
    //             return $(this).text().toLowerCase().indexOf(texto) > -1;
    //         }).prop('selected', true);
    //     });
    // });
</script>