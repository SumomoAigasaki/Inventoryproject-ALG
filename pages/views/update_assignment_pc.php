<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";
$id = $_GET['p'];

// Preparar la llamada al procedimiento almacenado
$stmt = $conn->query("CALL sp_selectAssignmetnPcs($id)");
while ($row = $stmt->fetch_assoc()) {
    // echo '<pre>';
    // print_r($row);
    // echo '</pre>';
    $PCA_idTbl_PC_Assignment = $row['PCA_idTbl_PC_Assignment'];
    $PCA_Date_Assignment = $row['PCA_Date_Assignment'];
    $CBT_idTbl_Collaborator = $row['CBT_idTbl_Collaborator'];
    $CMP_idTbl_Computer = $row['CMP_idTbl_Computer'];
    $PCA_Return_Date = $row['PCA_Return_Date'];
    $STS_idTbl_Status = $row['STS_idTbl_Status'];
    $PCA_Observations = $row['PCA_Observations'];
    $PCA_imgContrato = $row['PCA_imgContrato'];
    if (empty($PCA_imgContrato) || $PCA_imgContrato === null || $PCA_imgContrato == "/resources/AsignacionPC/") {
        $PCA_imgContrato = "../../resources/AsignacionPC/defaultPDF.jpg";
    }
    $PCA_Inventory_Date = $row['PCA_Inventory_Date'];
    $MS_Instalation_date = $row['MS_Instalation_date'];
    $PCA_months_hiring = $row['PCA_months_hiring'];
}
$stmt->close();
$conn->next_result();

// Preparar la llamada al procedimiento almacenado
$stmt = $conn->query("CALL sp_selectMappingSoftwares($id)");
$existingOptions  = array(); // Aquí almacenaremos los datos de la segunda consulta

while ($fila = $stmt->fetch_assoc()) {
    // echo '<pre>';
    // print_r($row);
    // echo '</pre>';
    $softwarelista = array(
        "idSoftware"  => $fila["SFT_idTbl_Software"]
    );
    $existingOptions[] = $softwarelista;

    // var_dump($softwarelista);

}
$stmt->close();
$conn->next_result();

// foreach ($existingOptions  as $lista) {
//     echo $lista["idSoftware"] . "<br>";
// }

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
                                echo "<a href=\"$ruta\"><button button type='button' class='btn btn-block bg-olive'></i><span class='fa fa-arrow-circle-left'></span>   Volver</button></a>";
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
                    <div class="card card-success card-outline card-tabs">
                        <div class="card-header">
                            <h3 class="card-title">Formulario para <?php echo $pageName; ?> </h3>
                        </div>
                        <!-- form start -->
                        <form role="form" action="" method="POST" name="formUpdatePCA" id="formUpdatePCA" class="form-horizontal" enctype="multipart/form-data">
                            <div class="card-body">
                                <label class="form-check-label" style="padding-bottom: 5px;"> A continuación se le mostrara el formulario con información tenga <b> cuidado</b> al momento de presionar el boton:</label>

                                <input type="hidden" class="form-control" id="TxtId" name="TxtId" placeholder="">
                                <input type="hidden" class="form-control" id="TxtIdPCAsignment" name="TxtIdPCAsignment" value="<?php echo $PCA_idTbl_PC_Assignment ?>">
                                <input type="hidden" class="form-control" id="TxtIdMappingsoftware" name="TxtIdMappingsoftware">
                                <div class="row justify-content-center" style="padding-bottom:20px;">
                                    <div class="col-mb-4">
                                        <label>Contrato de Asignacion de PC</label>
                                        <div class="input-group" style="flex-direction: column; padding-left:15px; display: flex; justify-content: center; align-items: center;">
                                            <div id="vistaPrevia"></div>
                                            <img class="img-fluid" src="../../resources/AsignacionPC/defaultPDF.jpg" width="250" height="200" name="imgPerfil" id="imgPerfil">
                                            <input type="file" name="filePDF" id="filePDF" accept="application/pdf" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Fila 1 -->
                                <div class="row justify-content-center" style="padding-top:10px; padding-bottom:10px;">

                                    <!-- Colaborador-->
                                    <div class="col-sm-3">
                                        <div class="form-group" style="padding-top: 10px;">
                                            <label>Colaborador:</label>
                                            <!-- <input type="text" class="form-control" id="txt_busqueda" name="txt_busqueda" placeholder="Buscar Colaborador"> -->
                                            <?php $resultado = mysqli_query($conn, "CALL sp_selectCollaborators()"); ?>
                                            <select class="form-control select2bs4" id="slctColaborador" name="slctColaborador">
                                                <?php while ($row = mysqli_fetch_array($resultado)) {
                                                    $select = ($CBT_idTbl_Collaborator == $row['CBT_idTbl_Collaborator']) ? "selected=selected" : ""; ?>
                                                    <option value="<?php echo $row['CBT_idTbl_Collaborator']; ?>" <?php echo $select; ?>><?php echo $row['InformacionGeneral']; ?></option>
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
                                    <div class="col-sm-3">
                                        <div class="form-group" style="padding-top: 10px;">
                                            <label>Computadora:</label>
                                            <!-- <input type="text" class="form-control" id="txt_busqueda" name="txt_busqueda" placeholder="Buscar Colaborador">
                                            <?php $resultado = mysqli_query($conn, "CALL sp_selectComputerAll()"); ?> -->
                                            <select class="form-control select2bs4" id="slctComputer" name="slctComputer">
                                                <?php while ($row = mysqli_fetch_array($resultado)) {
                                                    $select = ($CMP_idTbl_Computer == $row['CMP_idTbl_Computer']) ? "selected=selected" : ""; ?>
                                                    <option value="<?php echo $row['CMP_idTbl_Computer']; ?>" <?php echo $select; ?>><?php echo $row['Info']; ?></option>
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

                                    <!-- ESTADO -->
                                    <div class="col-sm-3" style="padding-top: 10px;">
                                        <div class="form-group">
                                            <label>Estado de asignacion PC: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_status_select()"); ?>
                                            <select class="form-control select2bs4" id="slctStatus" name="slctStatus">
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
                                    </div>
                                    <!-- Fecha de Entrega -->
                                    <div class="col-sm-3">
                                        <div class="form-group" style="padding-top: 10px;">
                                            <label ACRONYM title="Fecha de Ingreso al Sistema"> Fecha de Ingreso:</label>
                                            <input type="text" class="form-control datepicker-input" name="txtDateInventory" id="txtDateInventory" value="<?php echo $PCA_Inventory_Date ?>">
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
                                                <?php while ($row = mysqli_fetch_array($resultado)) {
                                                    $selected = in_array($row['SFT_idTbl_Software'], array_column($existingOptions, 'idSoftware')) ? 'selected' : ''; ?>
                                                    <option value="<?php echo $row['SFT_idTbl_Software']; ?>" <?php echo $selected; ?>><?php echo $row['Info']; ?></option>
                                                <?php }
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
                                            <input type="text" class="form-control datepicker-input" name="txtInstalleSoftware" id="txtInstalleSoftware" value="<?php echo $MS_Instalation_date ?>">
                                        </div>

                                        <div class="form-group">
                                            <!-- Observaciones -->
                                            <label>Observaciones: </label>
                                            <textarea type="text" class="form-control" name="txtObservation" id="txtObservation" maxlength="100" value="<?php echo $PCA_Observations ?>"> </textarea>
                                        </div>
                                    </div>


                                    <div class="col-sm-4">
                                        <!-- Fecha de Retorno -->
                                        <div class="form-group">
                                            <label ACRONYM title="Fecha en que el area de TI le hace entrega del dispositivo"> Fecha de Entrega:</label>
                                            <input type="text" class="form-control datepicker-input" name="txtDeadline" id="txtDeadline" value="<?php echo $PCA_Date_Assignment ?>">
                                        </div>
                                        <div class="form-group">
                                            <label> Meses de Contratación:</label>
                                            <input type="number" class="form-control " name="txtmonth" id="txtmonth" onchange="calcularFechaRetorno()" value="<?php echo $PCA_months_hiring ?>">
                                        </div>
                                        <!-- Fecha de Retorno -->
                                        <div class="form-group">
                                            <label> Fecha de Retorno:</label>
                                            <input type="text" class="form-control datepicker-input" name="txtReturnDate" id="txtReturnDate" readonly value="<?php echo $PCA_Return_Date ?>">
                                        </div>

                                    </div>


                                </div>

                            </div>
                    </div>
                    <div class="row justify-content-center" style="padding-bottom:20px;">
                        <div class="col-mb-3">
                            <button type="submit" class="btn btn-block bg-olive" id="buttonUpdatePCA" name="buttonUpdatePCA" onclick='return validate_data();'>Actualizar</button>
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
<!-- script para colocar el pdf en el div y hacer una vista previa -->
<script>
    const filePDF = document.getElementById('filePDF');
    const labelArchivoPDF = document.getElementById('labelArchivoPDF');
    const imgPerfil = document.getElementById('imgPerfil');
    const vistaPrevia = document.getElementById('vistaPrevia');

    // Obtener la URL de la imagen del contrato desde PHP
    const imgContratoURL = "<?php echo $PCA_imgContrato; ?>";

    // Comprobar si hay una URL de imagen del contrato disponible y si no es la URL por defecto
    if (imgContratoURL && imgContratoURL !== "/resources/AsignacionPC/defaultPDF.jpg") {
        // Mostrar la imagen del contrato en un elemento embed
        const embedTag = `<embed src="${imgContratoURL}"  type="application/pdf"  width="350" height="300">`;
        vistaPrevia.innerHTML = embedTag;
        vistaPrevia.style.display = 'block'; // Mostrar la previsualización del contrato
        imgPerfil.style.display = 'none'; // Ocultar la imagen por defecto
    }

    filePDF.addEventListener('change', function() {
        const archivo = filePDF.files[0];

        if (archivo) {
            const lector = new FileReader();
            lector.onload = function(e) {
                // Actualizar la previsualización del PDF
                const embedTag = `<embed src="${e.target.result}" type="application/pdf" width="350" height="300">`;
                vistaPrevia.innerHTML = embedTag;
                vistaPrevia.style.display = 'block';

                // Ocultar la imagen por defecto
                imgPerfil.style.display = 'none';
            };

            lector.readAsDataURL(archivo);
        } else {
            // Mostrar la imagen del contrato si está disponible
            if (imgContratoURL && imgContratoURL !== "/resources/AsignacionPC/defaultPDF.jpg") {
                // Mostrar la imagen del contrato en un elemento embed
                const embedTag = `<embed src="${imgContratoURL}"  type="application/pdf"  width="350" height="300">`;
                vistaPrevia.innerHTML = embedTag;
                vistaPrevia.style.display = 'block'; // Mostrar la previsualización del contrato
                imgPerfil.style.display = 'none'; // Ocultar la imagen por defecto
            } else {
                // Restaurar la previsualización del PDF si no hay imagen del contrato
                vistaPrevia.innerHTML = '';
                vistaPrevia.style.display = 'none';

                // Restaurar la imagen por defecto
                imgPerfil.style.display = 'block';
            }
        }
    });
</script>


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

            document.getElementById("formUpdatePCA").submit();
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


    // Cuando el documento HTML está completamente cargado...
    $(document).ready(function() {
        // Inicializa el componente Dual Listbox para el select #slctSoftware
        var demo1 = $('select[name="slctSoftware"]').bootstrapDualListbox();

        // Variable para almacenar los IDs seleccionados
        var array = [];

        // Función para actualizar el campo de texto
        function actualizarCampoTexto() {
            // Obtiene los elementos seleccionados en el Dual Listbox del select #slctSoftware
            var selectedOptions = demo1.val();

            // Verifica si hay opciones seleccionadas
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

    // Cuando el documento HTML está completamente cargado...
    $(document).ready(function() {

    });
</script>

<?php
// Ruta de la carpeta de destino para los archivos
$uploads_dir = '../../resources/AsignacionPC/';

// Verificar si se ha enviado un formulario con el botón "buttonUpdatePCA"
if (isset($_POST["buttonUpdatePCA"])) {
    // Recoger los datos enviados a través del formulario
    $colaboradorId = $_POST["slctColaborador"];
    $computerId = $_POST["slctComputer"];
    $deadlineTxt = $_POST["txtDeadline"];
    $installeSoftwareTxt = $_POST["txtInstalleSoftware"];
    $returnDateTxt = $_POST["txtReturnDate"];
    $observationTxt = $_POST["txtObservation"];
    $idsArrayTexto  = $_POST["TxtId"];
    date_default_timezone_set('America/Mexico_City');
    $todayDate = $_POST['txtDateInventory'];
    $user = $_SESSION["User_idTbl_User"];
    $status = $_POST["slctStatus"];

    // Decodificar la cadena JSON en un array de PHP
    $idsArray = json_decode($idsArrayTexto);
    $idPCA = $_POST['TxtIdPCAsignment'];
    $monthTxt = $_POST['txtmonth'];

    // Validar si el campo de archivo 'filePDF' está vacío y mantener el valor anterior si es así
    if (empty($_FILES['filePDF']['name'])) {
        $imgContrato = $PCA_imgContrato;
    } else {
        $imgContrato = '../../resources/AsignacionPC/' . $_FILES['filePDF']['name'];
    }

    $todayDateInsert = date("Y-m-d");

    // Verificar el permiso para realizar la operación
    if ($PermisoPCA) {
        try {
            // Preparar una llamada a un procedimiento almacenado
            $stmt = $conn->prepare("CALL sp_UpdateAssignmentePC(?,?,?,?,?,?,?,?,?,?)");

            // Vincular los parámetros al procedimiento almacenado
            $stmt->bind_param("ssssssssss", $idPCA, $deadlineTxt, $colaboradorId, $computerId, $returnDateTxt, $status, $observationTxt, $imgContrato, $todayDate, $monthTxt);

            // Ejecutar el procedimiento almacenado
            $stmt->execute();

            // Verificar errores en la ejecución
            if ($stmt->error) {
                error_log("Error en la ejecución del procedimiento almacenado: " . $stmt->error);
            }

            // Obtener el resultado del procedimiento almacenado
            $stmt->bind_result($idu);
            $stmt->fetch();

            $stmt->close();
            $conn->next_result();

            // Comprobar si la operación tuvo éxito
            if ($idu > 0) {
                // Llama al procedimiento almacenado para obtener registros existentes
                $result = $conn->query("CALL sp_selectMappingSoftwares($idPCA)");
                $existingOptions = array();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $existingOptions[] = array(
                            "SFT_idTbl_Software" => $row['SFT_idTbl_Software'],
                            "STS_idTbl_Status" => $row['STS_idTbl_Status']
                        );
                    }

                    // Iterar sobre las opciones existentes
                    foreach ($existingOptions as $option) {
                        $idSoftware = $option["SFT_idTbl_Software"];
                        $idStatus = $option["STS_idTbl_Status"];
                    }

                    $result->close();
                    $conn->next_result();

                    // Obtener los IDs de software existentes en un array
                    $existingSoftwareIds = array();
                    foreach ($existingOptions as $option) {
                        $existingSoftwareIds[] = $option["SFT_idTbl_Software"];
                    }

                    // Actualizar registros según selecciones
                    foreach ($idsArray as $optionValue) {
                        if (!in_array($optionValue, $existingSoftwareIds)) {
                            // Insertar un nuevo registro con estado "Instalado"

                            // Llama al procedimiento almacenado para realizar la inserción
                            $statussft = '10';
                            $stmt = $conn->prepare("CALL sp_insertMappingSoftwareUpdate(?,?,?,?,?,?)");

                            // Vincular los parámetros al procedimiento almacenado
                            $stmt->bind_param("ssssss", $idPCA, $optionValue, $user, $statussft, $installeSoftwareTxt, $todayDateInsert);

                            // Ejecutar el procedimiento almacenado
                            $stmt->execute();

                            if ($stmt->error) {
                                error_log("Error en la ejecución del procedimiento almacenado: " . $stmt->error);
                            }

                            // Obtener el valor de la variable de salida
                            $stmt->bind_result($idu);
                            $stmt->fetch();
                            $stmt->close();
                            $conn->next_result();
                        }
                    }

                    // Identificar las opciones que se deseleccionaron (marcar como "Desinstaladas")
                    $optionsToMarkAsUninstalled = array_diff($existingSoftwareIds, $idsArray);

                    if (!empty($optionsToMarkAsUninstalled)) {
                        foreach ($optionsToMarkAsUninstalled as $optionValue) {
                            // Llama al procedimiento almacenado para marcar como "Desinstalado"
                            $stmt = $conn->prepare("CALL sp_UninstalledMappingSoftware(?,?)");

                            // Vincular los parámetros al procedimiento almacenado
                            $stmt->bind_param("ss", $optionValue, $idPCA);

                            // Ejecutar el procedimiento almacenado
                            $stmt->execute();

                            if ($stmt->error) {
                                error_log("Error en la ejecución del procedimiento almacenado: " . $stmt->error);
                            }

                            $stmt->bind_result($idu);
                            $stmt->fetch();
                            $stmt->close();
                            $conn->next_result();
                        }
                    }

                    // Cerrar la conexión a la base de datos
                    $conn->close();
                }
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                if (strpos($e->getMessage(), 'CMP_idTbl_Computer_UNIQUE') !== false) {
                    // Error de clave duplicada, específicamente para CMP_idTbl_Computer
                    echo '<script > toastr.error("No se pudo guardar <br> La Computadora proporcionado ya está en uso. Por favor, elige una Computadora diferente.","¡¡UPS!!  Advertencia: 1");';
                    echo 'var computerId = document.getElementById("slctComputer");';
                    echo 'computerId.focus();';
                    echo '</script>';
                } else {
                    // Error de clave duplicada para otros campos únicos
                    echo "Error: Entrada duplicada para uno o más campos únicos. Proporcione valores diferentes.";
                }
            } else {
                // Manejar otros tipos de errores relacionados con la base de datos
                echo "Error código: " . $e->getCode() . " - " . $e->getMessage();
            }
        }
       
         // Mover el archivo cargado a la carpeta de destino
         if ($_FILES['filePDF']['name'] != 'defaultPDF.jpg') {
            $destino = $uploads_dir . $_FILES['filePDF']['name'];
            if (move_uploaded_file($_FILES['filePDF']['tmp_name'], $destino)) {
                // La operación de movimiento fue exitosa
                // Puedes mostrar un mensaje de éxito o realizar otras acciones aquí
                move_uploaded_file($_FILES['filePDF']['tmp_name'], $destino);
            } else {
                // Ocurrió un error al mover el archivo
                echo '<script > toastr.error("Error al subir el archivo ' . $_FILES['filePDF']['name'] . '")</script>;';
                $uploadOk = 0; // Establecer en 0 para indicar que hubo un error
                exit;
            }
        } else if (file_exists($uploads_dir . $_FILES['filePDF']['name'])) {
            echo '<script > toastr.info("La imagen ya existe ' . $_FILES['filePDF']['name'] . '")</script>;';
            $uploadOk = 0; // Si existe, establecer en 0 para indicar que ya existe
        }
        // Comprobar si la inserción tuvo éxito
        if ($idu > 0) {
            // Mostrar un mensaje de éxito y redirigir después de 2 segundos
            echo '<script > toastr.success("Los datos de <b>' . $colaboradorId . '</b> se Guardaron de manera exitosa.", "¡¡Enhorabuena!!"); ';
            echo 'setTimeout(function() {';
            echo '  window.location.href = "view_assignment_pc.php";';
            echo ' }, 2000); // 2000 milisegundos = 2 segundos de retraso ';
            echo 'document.getElementById("formInsertPRL").reset(); ';
            echo '</script>';
            exit;
        }
       
    }
}
?>