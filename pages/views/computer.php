<?php
require_once "../templates/title.php";
?>
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

    // document.addEventListener('DOMContentLoaded', function() {
    //     const formInsert = document.getElementById('formInsertCMP');
    //     const btnInsert = document.getElementById('buttonInsert');
    //     btnInsert.addEventListener('click', function() {
    //         formInsert.reset();
    //     });
    // });


    // Función para validar los datos ingresados en el formulario
    function validate_data() {
        var accionInput = document.getElementById('accion');
        var acquisitionFecha = document.getElementById('acquisitionDate');
        var manufacturerSelect = document.getElementById('manufacturerSelect');
        var modelSelect = document.getElementById('modelSelect');
        var computerTypesSelect = document.getElementById('computerTypes');
        var nombreInput = document.getElementById('nombre');
        var servitagInput = document.getElementById('servitag');
        var warrantyExpirationInput = document.getElementById('warrantyExpiration');
        var licenceInput = document.getElementById('licence');
        var statusSelect = document.getElementById('status');
        var locationsSelect = document.getElementById('locations');
        var guaranteeSelect = document.getElementById('typeGuarantee');
        var todayDateInput = document.getElementById('todayDate');


        if (acquisitionFecha.value.trim() === "") {
            toastr.warning("La <b>Fecha de Compra</b> esta vacio(a).<br>Por favor Ingrese una fecha valida");
            acquisitionFecha.focus();
        } else if (manufacturerSelect.selectedIndex == 0) {
            toastr.warning('La <b>Marca</b> esta vacio(a).<br>Por favor Ingrese una Marca valida');
            manufacturerSelect.focus();
        } else if (modelSelect.value == 1) {
            toastr.warning('El <b>Modelo</b> esta vacio(a).<br>Por favor Ingrese un Modelo valida');
            modelSelect.focus();
        } else if (computerTypesSelect.selectedIndex == 0) {
            toastr.warning('El <b>Tipo de computadora</b> esta vacio(a).<br>Por favor Ingrese un tipo de computadora valido');
            computerTypesSelect.focus();
        } else if (nombreInput.value.trim() === "") {
            toastr.warning('El <b>Nombre técnico</b> esta vacio(a).<br>Por favor Ingrese un Nombre valido');
            nombreInput.focus();
        } else if (servitagInput.value.trim() === "") {
            toastr.warning('El <b>Servitag</b> esta vacio(a).<br>Por favor Ingrese una servitag valido');
            servitagInput.focus();
        } else if (warrantyExpirationInput.value.trim() === "") {
            toastr.warning('La <b>Fecha Límite Garantía</b> esta vacio(a).<br>Por favor Ingrese una Fecha Límite Garantía valida');
            warrantyExpirationInput.focus();
        } else if (licenceInput.value.trim() === "") {
            toastr.warning('La <b>Lincencia</b> esta vacio(a).<br>Por favor Ingrese una Lincensia valida');
            licenceInput.focus();
        } else if (statusSelect.selectedIndex == 0) {
            toastr.warning('El <b>Estado del Computador</b> esta vacio(a).<br>Por favor Ingrese una Estado del Computador valida');
            statusSelect.focus();
        } else if (locationsSelect.selectedIndex == 0) {
            toastr.warning('La <b>Localizacion del Computador</b> esta vacio(a).<br>Por favor Ingrese una Localizacion del Computador valida');
            locationsSelect.focus();
        } else if (guaranteeSelect.selectedIndex == 0) {
            toastr.warning('El <b>Tipo de Garantia </b> esta vacio(a).<br>Por favorTipo de Garantia del Computador valida');
            guaranteeSelect.focus();
        } else {
            // Si no hay errores, procesa los datos enviados
            //$opcion = $_POST['opciones'];
            if (accionInput.value.trim() === "") {
                accionInput.value = "1";

            }
            document.getElementById("formInsertCMP").submit();

        }
        return false;
    }
    // Función para actualizar el valor del campo de entrada del año
    function actualizarAnio() {
        var warrantyExpirationInput = document.getElementById('warrantyExpiration');
        var yearExpirationInput = document.getElementById('yearExpiration');

        // Obtener el año a partir de la fecha
        var fecha = new Date(warrantyExpirationInput.value);
        var anio = fecha.getFullYear();

        // Actualizar el valor del campo de entrada del año
        yearExpirationInput.value = anio;
    }
</script>

<?php

if (isset($_POST["accion"])) {
    $accion = $_POST["accion"];
    $cmpAcquisitionDate = $_POST["acquisitionDate"];
    $cmpIdManufacturer = $_POST['select_manufacturer'];
    $cmpIdModel = $_POST['select_model'];
    $cmpCompType = $_POST['select_computerType'];
    $cmptName = $_POST['txt_nombre'];
    $cmpServitag = $_POST['txt_servitag'];
    $cmpWarrantyExpiration = $_POST['warrantyExpiration'];
    //$cmpYearExpiration = date("Y", strtotime($cmpWarrantyExpiration));
    $cmpYearExpiration = $_POST['yearExpiration'];
    $cmpLicence = $_POST['txt_licence'];
    $cmpMotherboard = $_POST['txt_motherboard'];
    $cmpIdStatu = $_POST['select_statu'];
    $cmpIdLocation = $_POST['select_location'];

    // var_dump($_FILES['archivo']);
    $cmpImgComp = '/resources/Computer/' . $_FILES['archivo']['name'];
    // Obtener la ruta completa de la imagen
    $uploads_dir = '../../resources/Computer/';  // Ruta de la carpeta de destino para los archivos

    $cmpObservation = $_POST['txt_observation'];
    $cmpIdGuarantee = $_POST['select_typeGuarantee'];
    //$cmpImgCompReport = "";
    date_default_timezone_set('America/Mexico_City');
    $todayDate = date("Y-m-d");

    //la opcion 1 es para guardar y el C-CMP valida que tenga el permiso C-reateE en (CMP)computer
    if ($accion == "1" && $_SESSION["C-CMP"]) {

        //Caso contrario Guardara
        $stmt = $conn->prepare("CALL sp_insertComputer(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

        // Mandamos los parametros y los input que seran enviados al PA O SP
        $stmt->bind_param("sssssssssssssssss", $todayDate, $cmpIdManufacturer, $cmpImgComp, $cmptName, $cmpIdModel, $cmpCompType, $cmpServitag, $cmpLicence, $cmpMotherboard, $cmpAcquisitionDate, $cmpWarrantyExpiration, $cmpYearExpiration, $cmpIdLocation, $cmpIdStatu, $cmpObservation, $idUser,$cmpIdGuarantee);
       // $query = "CALL sp_insertComputer('$todayDate', '$cmpIdManufacturer', '$cmpImgComp', '$cmptName', '$cmpIdModel', '$cmpCompType', '$cmpServitag', '$cmpLicence', '$cmpMotherboard', '$cmpAcquisitionDate', '$cmpWarrantyExpiration', '$cmpYearExpiration', '$cmpIdLocation', '$cmpIdStatu', '$cmpObservation', '$idUser','$cmpIdGuarantee');";
        echo $query;

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
            echo '<script > toastr.success("Los datos de <b>' . $cmptName . '</b> se Guardaron de manera exitosa.", "¡¡Enhorabuena!!");
            // setTimeout(function() {
            //     window.location.href = "explorer.php";
            // }, 2000); // 2000 milisegundos = 2 segundos de retraso             
            </script>';
            move_uploaded_file($_FILES['archivo']['tmp_name'], $uploads_dir . $_FILES['archivo']['name']);
        } else {
            echo '<script > toastr.error(" No se pudo guardar recuerda que tiene que tener un Servitag unico. ' . $cmpServitag . '","¡¡UPS!!");
                setTimeout(function() {
                    window.location.href = "computer.php"; 
                }, 3000);     
            </script>';
            //  echo '<script>setTimeout(function() { location.reload(); }, 2000);</script>' 
        }
    }
}

?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline card-tabs">
                <div class="card-header">
                    <h3 class="card-title">Formulario para Añadir <?php echo $pageName; ?> </h3>
                </div>
                <!-- form start -->
                <form role="form" action="computer.php" method="POST" name="formInsertCMP" id="formInsertCMP" class="form-horizontal" enctype="multipart/form-data">
                    <div class="card-body">
                        <label class="form-check-label" style="padding-bottom: 5px;"> A continuación se le pedirá que <b> Ingrese</b> los siguientes datos:</label>

                        <!-- Input ocultos  -->
                        <input type="hidden" class="form-control" id="todayDate" name="todayDate" placeholder="<?php echo $todayDate ?>">
                        <input type="hidden" class="form-control" id="accion" name="accion" placeholder="">
                        <div class="row" style="padding-top:10px; padding-bottom:10px;">
                            <!-- Fecha de Compra -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Fecha de Compra:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker-input" name="acquisitionDate" id="acquisitionDate">
                                    </div>
                                </div>
                            </div>
                            <!-- MARCA -->
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Marca: </label>
                                    <?php
                                    #Se procede a llamar al procedimiento almacenado que se llama sp_manufacturer_select,con la variable que almancena "cnn" la base de datos 
                                    $resultado = mysqli_query($conn, "CALL sp_manufacturer_select()"); ?>
                                    <select class="form-control" id="manufacturerSelect" name="select_manufacturer" onchange="filtrarModelos()">
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
                                    <label>Modelo : </label>
                                    <input type="text" id="lookModels" placeholder="Buscar modelo en especifico" class="form-control">
                                    <?php $resultado = mysqli_query($conn, "CALL sp_model_select()"); ?>
                                    <select class="form-control" id="modelSelect" name="select_model">
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
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Tipo de Computadora : </label>
                                    <?php $resultado = mysqli_query($conn, "CALL sp_computerType_select()"); ?>
                                    <select class="form-control" id="computerTypes" name="select_computerType">
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
                        </div>
                        <!-- Comienzo fila 2 -->
                        <div class="row" style="padding-bottom:10px;">
                            <!-- Nombre Tecnico-->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Nombre Técnico:</label>
                                    <input type="text" class="form-control" name="txt_nombre" id="nombre" maxlength="45" value="<?php echo (isset($nombres) ? $nombres : ""); ?>" placeholder="ASSET2023-0#">
                                </div>
                            </div>
                            <!-- Servitag-->
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Servitag: </label>
                                    <input type="text" class="form-control" name="txt_servitag" id="servitag" maxlength="45" value="<?php echo (isset($servitags) ? $servitags : ""); ?>" placeholder="FKCX???">
                                </div>
                            </div>
                            <!-- Fecha limite garantia -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Fecha Límite Garantía:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker-input" name="warrantyExpiration" id="warrantyExpiration" onchange="actualizarAnio()">
                                    </div>
                                </div>
                            </div>
                            <!-- Anho limite garantia -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Año Limite Garantía: </label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" min="2000" max="2050" name="yearExpiration" id="yearExpiration" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Comienzo fila 3 -->
                        <div class="row" style="padding-bottom:10px;">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Tipo de Garantia: </label>
                                    <?php
                                    #Se procede a llamar al procedimiento almacenado que se llama sp_manufacturer_select,con la variable que almancena "cnn" la base de datos 
                                    $resultado = mysqli_query($conn, "CALL sp_typeGuarantee_select()"); ?>
                                    <select class="form-control" id="typeGuarantee" name="select_typeGuarantee">
                                        <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                            <option value="<?php echo $row['TG_idtbl_Type_Guarantee']; ?>"><?php echo $row['TG_Description']; ?></option>
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
                            <!-- Lincencia -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Licencia: </label>
                                    <input type="text" class="form-control" name="txt_licence" id="licence" maxlength="60" value="<?php echo (isset($licenses) ? $licenses : ""); ?>" placeholder="CMCDN-?????-?????-?????-?????">
                                </div>
                            </div>
                            <!-- Tarjeta Madre -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Tarjeta Madre: </label>
                                    <input type="text" class="form-control" name="txt_motherboard" id="motherboard" maxlength="60" value="<?php echo (isset($motherboards) ? $motherboards : ""); ?>" placeholder="0W3XW5-A00">
                                </div>
                            </div>
                            <!-- Estado de la computadora  -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Estado del Computador: </label>
                                    <?php $resultado = mysqli_query($conn, "CALL sp_status_select()"); ?>
                                    <select class="form-control" id="status" name="select_statu">
                                        <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                            <option value="<?php echo $row['STS_idTbl_Status']; ?>"><?php echo $row['STS_Description']; ?></option>
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
                        <!-- Comienzo fila 4 -->
                        <div class="row">
                            <!-- Localizacion -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Localizacion del Computador : </label>
                                    <?php $resultado = mysqli_query($conn, "CALL sp_location_select"); ?>
                                    <select class="form-control" id="locations" name="select_location">
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
                            <!-- IMAGEN -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Imagen: </label>
                                    <div class="input-group">
                                        <input type="file" name="archivo">
                                    </div>
                                </div>
                            </div>
                            <!-- Observaciones -->
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Observaciones: </label>
                                    <textarea type="text" class="form-control" name="txt_observation" id="observation" maxlength="100" value="<?php echo (isset($observations) ? $observations : ""); ?>"> </textarea>
                                </div>
                            </div>
                            <!-- Boton guardar -->
                            <div class="col-sm-2" style="padding-top:40px;">
                                <button type="button" class="btn btn-block btn-info" id="buttonInsert" name="buttonInsert" onclick='return validate_data();'>Guardar</button>
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
</section>
<script>
    function filtrarModelos() {
        // Obtener el valor seleccionado en el primer select
        var manufacturerSeleccionado = document.getElementById("manufacturerSelect").value;

        // Obtener todos los options del segundo select
        var opcionesModelos = document.getElementById("modelSelect").options;

        // Obtenr el texto del segundo seletc
        var contenidoModelo = document.getElementsByTagName("option");

        // Recorrer todas las opciones y ocultar las que no pertenecen al fabricante seleccionado
        for (var i = 1; i < opcionesModelos.length; i++) {
            var modelo = opcionesModelos[i];
            if (modelo.getAttribute("data-manufacturer") == manufacturerSeleccionado || manufacturerSeleccionado == "") {
                modelo.style.display = "";
            } else {
                modelo.style.display = "none";
            }
        }

        // Si no hay modelos disponibles para el fabricante seleccionado, mostrar un mensaje en el segundo select
        if (document.querySelectorAll("#modelSelect option[style='display: none;']").length === opcionesModelos.length - 1) {
            document.getElementById("modelSelect").innerHTML = "<option value=''>No hay modelos disponibles para este fabricante</option>";
        }
    }

    $(function() {
        $(".datepicker-input").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });

    // Vincula el input de búsqueda con el select ded models 
    $(document).ready(function() {
        $('#lookModels').on('keyup', function() {
            var texto = $(this).val().toLowerCase();
            $('#modelSelect option').filter(function() {
                return $(this).text().toLowerCase().indexOf(texto) > -1;
            }).prop('selected', true);
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const formInsert = document.getElementById('formInsertCMP');
        const btnInsert = document.getElementById('buttonInsert');
        btnInsert.addEventListener('click', function() {
            formInsert.reset();
        });
    });
</script>

<?php
require_once "../templates/footer.php";
?>