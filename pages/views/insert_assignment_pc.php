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
            window.location.href = '<?php echo BASE_URL ?>pages/views/view_assignment_pc.php';
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
                                $ruta = "../views/view_assignment_pc.php";
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
                        <form role="form" action="" method="POST" name="formInsertPCA" id="formInsertPCA" class="form-horizontal" enctype="multipart/form-data">
                            <div class="card-body">
                                <label class="form-check-label" style="padding-bottom: 5px;"> A continuación se le pedirá que <b> Ingrese</b> los siguientes datos:</label>

                                <!-- Input para guardar la lista de los software a guardar -->
                                <input type="hidden" class="form-control" id="TxtId" name="TxtId" placeholder="">
                                <!-- Fila 1 -->
                                <div class="row justify-content-center" style="padding-top:10px; padding-bottom:10px;">

                                    <!-- Colaborador-->
                                    <div class="col-sm-4">
                                        <div class="form-group" style="padding-top: 10px;">
                                            <label>Colaborador:</label>
                                            <!-- <input type="text" class="form-control" id="txt_busqueda" name="txt_busqueda" placeholder="Buscar Colaborador">
                                            <?php $resultado = mysqli_query($conn, "CALL sp_selectCollaborators()"); ?> -->
                                            <select class="form-control select2bs4" id="slctColaborador" name="slctColaborador">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['CBT_idTbl_Collaborator']; ?>"><?php echo $row['InformacionGeneral']; ?></option>
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

                                    <!-- Computadora-->
                                    <div class="col-sm-4">
                                        <div class="form-group" style="padding-top: 10px;">
                                            <label>Computadora:</label>
                                            <!-- <input type="text" class="form-control" id="txt_busqueda" name="txt_busqueda" placeholder="Buscar Colaborador">
                                            <?php $resultado = mysqli_query($conn, "CALL sp_selectComputerActive()"); ?> -->
                                            <select class="form-control select2bs4" id="slctComputer" name="slctComputer">
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
                                    <!-- Fecha de Entrega -->
                                    <div class="col-sm-4">
                                        <div class="form-group" style="padding-top: 10px;">
                                            <label ACRONYM title="Fecha en que el area de TI le hace entrega del dispositivo"> Fecha de Entrega:</label>
                                            <input type="text" class="form-control datepicker-input" name="txtDeadline" id="txtDeadline">
                                        </div>
                                    </div>

                                </div>

                                <!-- Fila 2 -->
                                <div class="row justify-content-center" style="padding-top:10px; padding-bottom:10px;">
                                    <!-- Software-->
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label>Software:</label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_selectSoftwareActive()"); ?>

                                            <select class="duallistbox" multiple="multiple" id="slctSoftware" name="slctSoftware">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['SFT_idTbl_Software']; ?>"><?php echo $row['Info']; ?></option>
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

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <!-- Fecha de Instalacion Software -->
                                            <label> Fecha de Instalacion Software:</label>
                                            <input type="text" class="form-control datepicker-input" name="txtInstalleSoftware" id="txtInstalleSoftware">
                                        </div>

                                        <div class="form-group">
                                            <!-- Observaciones -->
                                            <label>Observaciones: </label>
                                            <textarea type="text" class="form-control" name="txtObservation" id="txtObservation" maxlength="100" value="<?php echo (isset($observations) ? $observations : ""); ?>"> </textarea>
                                        </div>
                                    </div>


                                    <div class="col-sm-4">
                                        <!-- Fecha de Retorno -->
                                        <div class="form-group">
                                            <label> Meses de Contratación:</label>
                                            <input type="number" class="form-control " name="txtmonth" id="txtmonth" onchange="calcularFechaRetorno()">
                                        </div>
                                        <!-- Fecha de Retorno -->
                                        <div class="form-group">
                                            <label> Fecha de Retorno:</label>
                                            <input type="text" class="form-control datepicker-input" name="txtReturnDate" id="txtReturnDate" readonly>
                                        </div>


                                    </div>

                                </div>
                            </div>
                            <div class="row justify-content-center" style="padding-bottom:20px;">
                                <div class="col-mb-3">
                                    <button type="submit" class="btn btn-block btn-info" id="buttonInsertPCA" name="buttonInsertPCA" onclick='return validate_data();'>Guardar</button>
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
<?php
require_once "../templates/footer.php";
?>

<script>
      // Obtener los elementos del formulario
      var deadlineTxtInput = document.getElementById("txtDeadline");
        var txtmonthInput = document.getElementById("txtmonth");
        var txtReturnDateInput = document.getElementById("txtReturnDate");

        // Agregar eventos a los campos de fecha de entrega y meses de contratación
        deadlineTxtInput.addEventListener("input", calcularFechaRetorno);
        txtmonthInput.addEventListener("input", calcularFechaRetorno);

        // Agregar evento blur al campo de meses de contratación
        txtmonthInput.addEventListener("blur", function() {
            calcularFechaRetorno();
        });
        // Función para calcular la fecha de retorno
        function calcularFechaRetorno() {
            var fechaEntrega = new Date(deadlineTxtInput.value);
            var mesesContratacion = parseInt(txtmonthInput.value);

            if (!isNaN(mesesContratacion)) {
                var fechaRetorno = new Date(fechaEntrega);
                fechaRetorno.setMonth(fechaRetorno.getMonth() + mesesContratacion);

                // Formatear la fecha de retorno como "YYYY-MM-DD"
                var yyyy = fechaRetorno.getFullYear();
                var mm = String(fechaRetorno.getMonth() + 1).padStart(2, '0');
                var dd = String(fechaRetorno.getDate() + 1).padStart(2, '0');
                txtReturnDateInput.value = yyyy + '-' + mm + '-' + dd;
            } else {
                txtReturnDateInput.value = ""; // Borrar la fecha de retorno si no se ingresan meses válidos
            }
        }




    // Función para validar los datos ingresados en el formulario
    function validate_data() {
        let colaboradorSlct = document.getElementById('slctColaborador');
        let computerSlct = document.getElementById('slctComputer');
        let deadlineTxt = document.getElementById('txtDeadline');
        let softwareSlct = document.getElementById('slctSoftware');
        let optiones = document.getElementsByName('slctSoftware_helper2');
        let selectedOptions = Array.from(softwareSlct.selectedOptions);
        if (selectedOptions.length == 0) {
            // alert('Ninguna opción ha sido seleccionada.');
            toastr.warning('No ha seleccionado ningun <b>Software</b> esta vacio(a).<br>Por favor Ingrese una Software valida');
            softwareSlct.focus();
            return false;
        }

        let installeSoftwareTxt = document.getElementById('txtInstalleSoftware');
        let returnDateTxt = document.getElementById('txtReturnDate');
        let monthTxt = document.getElementById('txtmonth');

        if (colaboradorSlct.selectedIndex == 0) {
            toastr.warning("El <b>Colaborador</b> esta vacio(a).<br>Por favor Ingrese un Colaborador valida");
            colaboradorSlct.focus();
            return false;
        } else if (computerSlct.selectedIndex == 0) {
            toastr.warning('El campo de <b>Computadora</b> esta vacio(a).<br>Por favor Ingrese una Computadora valida');
            computerSlct.focus();
            return false;
        } else if (deadlineTxt.value.trim() === "") {
            toastr.warning('La <b>Fecha de Entrega</b> esta vacio(a).<br>Por favor Ingrese una Fecha de Entrega valida');
            deadlineTxt.focus();
            return false;
        } else if (installeSoftwareTxt.value.trim() === "") {
            toastr.warning('La <b>Fecha de instalacion de Software</b> esta vacio(a).<br>Por favor Ingrese una Fecha de instalacion de Software valida');
            installeSoftwareTxt.focus();
            return false;
        } else if (returnDateTxt.value.trim() === "") {
            toastr.warning('La <b>Fecha de Retorno</b> esta vacio(a).<br>Por favor Ingrese una Fecha de Retorno valida');
            returnDateTxt.focus();
            return false;
        } else if (monthTxt.value.trim() === "") {
            toastr.warning('El <b>Meses de Contratación</b> esta vacio(a).<br>Por favor Ingrese un(os) Meses de Contratación valida');
            monthTxt.focus();
            return false;
        } else {
            // Si no hay errores, procesa los datos enviados
            if (accionInput.value.trim() === "") {
                accionInput.value = "1";
            }

            document.getElementById("formInsertPCA").submit();
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
        // Inicializa el componente Dual Listbox para el select #slctSoftware
        var demo1 = $('select[name="slctSoftware"]').bootstrapDualListbox();

        // Variable para almacenar los IDs seleccionados
        var array = [];

        // Función para actualizar el campo de texto
        function actualizarCampoTexto() {
            // Obtiene los elementos seleccionados en el Dual Listbox del select #slctSoftware
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

        // Agrega un manejador de evento para el cambio en el select #slctSoftware
        $('#slctSoftware').on('change', function() {
            // Llama a la función para actualizar el campo de texto
            actualizarCampoTexto();
        });

        // Llama a la función al cargar la página para mostrar las opciones seleccionadas inicialmente
        actualizarCampoTexto();
    });
</script>

<?php
if (isset($_POST["buttonInsertPCA"])) {
    $colaboradorId = $_POST["slctColaborador"];
    $computerId = $_POST["slctComputer"];
    $deadlineTxt = $_POST["txtDeadline"];
    $installeSoftwareTxt = $_POST["txtInstalleSoftware"];
    $returnDateTxt = $_POST["txtReturnDate"];
    $observationTxt = $_POST["txtObservation"];
    $idsArrayTexto  = $_POST["TxtId"];
    $monthtxt =$_POST["txtmonth"];
    date_default_timezone_set('America/Mexico_City');
    $todayDate = date("Y-m-d");
    $user = $_SESSION["User_idTbl_User"];
    $status = '2';
    // Decodifica la cadena JSON en un array de PHP
    //idsArray es la variable para la lista de codigos seleccionados
    $idsArray = json_decode($idsArrayTexto);


    // PermisoPCA
    if ($PermisoPCA) {
        try {
            //Caso contrario Guardara
            $stmt = $conn->prepare("CALL sp_insertAssignmentPC(?,?,?,?,?,?,?,?,?)");

            // $query = "CALL sp_insertAssignmentPC( '$deadlineTxt', '$user', '$colaboradorId', '$computerId', '$returnDateTxt', '$status', '$observationTxt', '$todayDate');";
            // echo $query;
            // Mandamos los parametros y los input que seran enviados al PA O SP
            $stmt->bind_param("sssssssss", $deadlineTxt, $user, $colaboradorId, $computerId, $returnDateTxt, $status, $observationTxt, $todayDate,$monthtxt);


            // Ejecutar el procedimiento almacenado
            $stmt->execute();
            if ($stmt->error) {
                error_log("Error en la ejecución del procedimiento almacenado: " . $stmt->error);
            }
            // Obtener el valor de la variable de salida
            $stmt->bind_result($idPCA);
            $stmt->fetch();
            $stmt->close();
            $conn->next_result();

            if ($idPCA > 0) {
                foreach ($idsArray as $id) {
                    //Insert para mapping software 
                    // detalle para software
                    $statussft = '10';
                    $stmt = $conn->prepare("CALL sp_insertMappingSoftware(?,?,?,?,?,?)");

                    // $query = "CALL sp_insertMappingSoftware( '$idPCA', '$id', '$user', '$ststatussftatus', '$installeSoftwareTxt', '$status', '$todayDate');";
                    // echo $query;
                    // Mandamos los parametros y los input que seran enviados al PA O SP
                    $stmt->bind_param("ssssss", $idPCA, $id, $user, $statussft, $installeSoftwareTxt, $todayDate);


                    // Ejecutar el procedimiento almacenado
                    $stmt->execute();
                    if ($stmt->error) {
                        error_log("Error en la ejecución del procedimiento almacenado: " . $stmt->error);
                    }
                    // Obtener el valor de la variable de salida
                    $stmt->bind_result($answerExistsMS);
                    $stmt->fetch();
                    $stmt->close();
                    $conn->next_result();

                    // echo "Inserción exitosa para ID: " . $id . "<br>";
                }
            }

            // se extraen los valores qu     nos devuelve el procedimiento almacenado y enviamos el error
            if ($answerExistsMS > 0) {
                //si se pudo guardar
                //Asignacion de PC
                //Mapeo de sofware

                //Deshabilitamos la computadora 

                $stmt = $conn->prepare("CALL sp_disablecomputer	(?)");

                //  $query = "CALL sp_insertMappingSoftware( '$computerId');";
                // echo $query;
                // Mandamos los parametros y los input que seran enviados al PA O SP
                $stmt->bind_param("s", $computerId);


                // Ejecutar el procedimiento almacenado
                $stmt->execute();
                if ($stmt->error) {
                    error_log("Error en la ejecución del procedimiento almacenado: " . $stmt->error);
                }
                // Obtener el valor de la variable de salida
                $stmt->bind_result($answerExistsCMP);
                $stmt->fetch();
                $stmt->close();
                $conn->next_result();

                if ($answerExistsCMP > 0) {
                    echo '<script > toastr.success("Los datos de <b>' . $colaboradorId . '</b> se Guardaron de manera exitosa.", "¡¡Enhorabuena!!"); ';
                    echo 'setTimeout(function() {';
                    echo '  window.location.href = "view_assignment_pc.php";';
                    echo ' }, 2000); // 2000 milisegundos = 2 segundos de retraso ';
                    echo 'document.getElementById("formInsertPRL").reset(); ';
                    echo '</script>';
                    exit;
                }
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                // Check which specific unique field is causing the constraint violation
                if (strpos($e->getMessage(), 'CMP_idTbl_Computer_UNIQUE') !== false) {
                    // echo "Error: ";
                    echo '<script > toastr.error("No se pudo guardar <br> La Computadora proporcionado ya está en uso. Por favor, elige una Computadora diferente.","¡¡UPS!!  Advertencia: 1");';
                    echo 'var computerId = document.getElementById("slctComputer");';
                    echo 'computerId.focus();';
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
<!-- slctSoftware_helper2 -->