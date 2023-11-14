<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";
//obtendremos lA VARIABLE QUE PASAMOS POR METODO get 
$idWR = $_GET['p'];
//Extraer los datos con el id que se nos paso por medio de la url 

$stmt = $conn->query("CALL sp_selectWarranty($idWR)");
while ($row = $stmt->fetch_assoc()) {
    //   echo '<pre>';
    //   print_r($row);
    //   echo '</pre>';
    $WR_idTbl_Warranty_Registration = $row["WR_idTbl_Warranty_Registration"];
    $CMP_idTbl_Computer = $row["CMP_idTbl_Computer"];
    $WR_Date_Admission = $row["WR_Date_Admission"];
    $WR_Application_Number = $row["WR_Application_Number"];
    $WR_Main_Problem = $row["WR_Main_Problem"];
    $WR_ActionsDone = $row["WR_ActionsDone"];
    $WR_Image_Problem = $row["WR_Image_Problem"];
    $WR_Diagnosis = $row["WR_Diagnosis"];
    $WR_Solution = $row["WR_Solution"];
    $WR_Image_Solution = $row["WR_Image_Solution"];
    //valido si viene nulos o vacios los datos de BD ponga una imagen por default
    if (empty($WR_Image_Solution) || $WR_Image_Solution === null || $WR_Image_Solution == "/resources/Warranty/") {
        $WR_Image_Solution = "/resources/Warranty/compuiterRepair.jpg";
    }
    $WR_Observation = $row["WR_Observation"];
    $WR_Inventory_Date = $row["WR_Inventory_Date"];
    $WR_Date_Solution = $row["WR_Date_Solution"];
    $STS_idTbl_Status = $row["STS_idTbl_Status"];
}
$stmt->close();
$conn->next_result();
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
                    <div class="card card-success card-outline card-tabs">
                        <div class="card-header">
                            <h3 class="card-title">Formulario para <?php echo $pageName; ?> </h3>
                        </div>
                        <!-- form start -->
                        <form role="form" action="" method="POST" name="formUpdateWR" id="formUpdateWR" class="form-horizontal" enctype="multipart/form-data">
                            <div class="card-body">
                                <label class="form-check-label" style="padding-bottom: 5px;"> A continuación se le pedirá que <b> Ingrese</b> los siguientes datos:</label>

                                <!-- Input para guardar la lista de los software a guardar -->
                                <input type="hidden" class="form-control" id="TxtId" name="TxtId" value="<?php echo $WR_idTbl_Warranty_Registration ?>">

                                <!-- Fila 1 -->
                                <div class="row justify-content-center" style="padding-bottom:20px;">
                                    <!-- IMAGEN -->
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Imagen de Referencia del Problema: </label>
                                            <div class="input-group" style=" display: flex;   justify-content: center;   align-items: center;   height: 200px;">
                                                <img class="img-fluid" src="../..<?php echo $WR_Image_Problem ?>" width="200" height="250" id="imgPerfil">
                                                <input type="file" name="fileReferent" id="fileReferent" accept="image/png,image/jpeg" style="margin-left: 20px;text-align: center;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Fila 2 -->
                                <div class="row justify-content-center" style="padding-top:10px; padding-bottom:10px;">
                                    <!-- Fecha de Reporte-->
                                    <div class="col-sm-4" style="padding-top: 10px;">
                                        <div class="form-group">
                                            <label ACRONYM title="Fecha en que se hizo el reporte"> <code> * </code> Fecha de Reporte:</label>
                                            <input type="text" class="form-control datepicker-input" name="txtDateAdmision" id="txtDateAdmision" value="<?php echo $WR_Date_Admission ?>">
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
                                                <?php while ($row = mysqli_fetch_array($resultado)) {
                                                    $select = ($CMP_idTbl_Computer == $row['CMP_idTbl_Computer']) ? "selected=selected" : "";
                                                ?>
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

                                    <!-- Numero de Reporte-->
                                    <div class="col-sm-4">
                                        <div class="form-group" style="padding-top: 10px;">
                                            <label><code> * </code>Numero de Reporte/Ticket:</label>
                                            <input type="text" class="form-control" name="txtNumberApplications" id="txtNumberApplications" maxlength="45" value="<?php echo $WR_Application_Number ?>">
                                        </div>
                                    </div>


                                </div>

                                <!-- Fila 3 -->
                                <div class="row justify-content-center" style="padding-top:10px; padding-bottom:10px;">

                                    <!--Problema Principal-->
                                    <div class="col-sm-4" style="padding-top: 10px;">
                                        <div class="form-group">
                                            <label><code> * </code>Problema Principal: </label>
                                            <textarea type="text" class="form-control" name="txtMainProblem" id="txtMainProblem" maxlength="255"><?php echo $WR_Main_Problem; ?> </textarea>
                                        </div>
                                    </div>


                                    <!-- Acciones Realizadas -->
                                    <div class="col-sm-4" style="padding-top: 10px;">
                                        <div class="form-group">
                                            <label ACRONYM title="Describir las acciones tomadas por el cliente para solucionar el problema antes de realizar el reporte"> <code> * </code>Acciones Realizadas: </label>
                                            <textarea type="text" class="form-control" name="txtActionDone" id="txtActionDone" maxlength="255"><?php echo $WR_ActionsDone ?> </textarea>
                                        </div>
                                    </div>

                                    <!-- Diagnostico -->
                                    <div class="col-sm-4" style="padding-top: 10px;">
                                        <div class="form-group">
                                            <label> <code> * </code>Diagnostico: </label>
                                            <textarea type="text" class="form-control" name="txtDiagnostic" id="txtDiagnostic" maxlength="255"><?php echo $WR_Diagnosis ?> </textarea>
                                        </div>
                                    </div>


                                </div>

                                <!-- Fila 4 -->
                                <div class="row justify-content-center" style="padding-top:10px; padding-bottom:10px;">
                                    <!-- Fecha de Reporte-->
                                    <div class="col-sm-4" style="padding-top: 10px;">
                                        <div class="form-group">
                                            <label ACRONYM title="Fecha en que se hizo la visita tecnica"> <code> * </code> Fecha de Solucion:</label>
                                            <input type="text" class="form-control datepicker-input" name="txtDateSolution" id="txtDateSolution" value="<?php echo $WR_Date_Solution ?>">
                                        </div>
                                    </div>

                                    <!-- Solución -->
                                    <div class="col-sm-4" style="padding-top: 10px;">
                                        <div class="form-group">
                                            <label> <code> * </code>Solución: </label>
                                            <textarea type="text" class="form-control" name="txtSolutions" id="txtSolutions" maxlength="255"><?php echo $WR_Solution ?> </textarea>
                                        </div>
                                    </div>
                                    <!-- IMAGEN -->
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Imagen de Referencia de la Solucion: </label>
                                            <div class="input-group" style=" display: flex;   justify-content: center;   align-items: center;   height: 200px;">
                                                <img class="img-fluid" src="../..<?php echo $WR_Image_Solution ?>" width="200" height="250" id="imgSolutions">
                                                <input type="file" name="fileReferentSolutions" id="fileReferentSolutions" accept="image/png,image/jpeg" style="margin-left: 20px;text-align: center;">
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <!-- Fila 2 -->
                                <div class="row justify-content-center" style="padding-top:10px; padding-bottom:10px;">

                                    <!-- Observaciones -->
                                    <div class="col-sm-4" style="padding-top: 10px;">
                                        <div class="form-group">
                                            <label> Observaciones: </label>
                                            <textarea type="text" class="form-control" name="txtObservation" id="txtObservation" maxlength="60"> <?php echo $WR_Observation ?></textarea>
                                        </div>
                                    </div>

                                    <!-- Estado -->
                                    <div class="col-sm-4" style="padding-top: 10px;">
                                        <div class="form-group" style="padding-left:15px; padding-top:2.5px;">
                                            <label>Estado del Usuario: </label>
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
                                    </div>
                                </div>
                            </div>


                            <div class="row justify-content-center" style="padding-bottom:20px;">
                                <div class="col-mb-3">
                                    <button type="submit" class="btn btn-block bg-olive" id="buttonUpdateWR" name="buttonUpdateWR" onclick='return validate_data();'>Guardar</button>
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
    // Función para validar los datos ingresados en el formulario
    function validate_data() {
        let dateAdmisiontxt = document.getElementById('txtDateAdmision');
        let computerSlct = document.getElementById('slctComputer');
        let numberApplicationstxt = document.getElementById('txtNumberApplications');
        let mainProblemtxt = document.getElementById('txtMainProblem');
        let actionDonetxt = document.getElementById('txtActionDone');

        let diagnostictxt = document.getElementById('txtDiagnostic');
        let dateSolutiontxt = document.getElementById('txtDateSolution');
        let solutionstxt = document.getElementById('txtSolutions');


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
            toastr.warning('El <b>Problema Principal</b> esta vacio(a).<br>Por favor Ingrese un Problema Principal valida');
            mainProblemtxt.focus();
            return false;
        } else if (actionDonetxt.value.trim() === "") {
            toastr.warning('Las <b>Acciones Realizadas</b> estan vacios(as).<br>Por favor Ingrese unas Acciones Realizadas valida');
            actionDonetxt.focus();
            return false;
        } else if (diagnostictxt.value.trim() === "") {
            toastr.warning('El <b>Diagnostico</b> estan vacios(as).<br>Por favor Ingrese un Diagnostico valido');
            diagnostictxt.focus();
            return false;
        } else if (dateSolutiontxt.value.trim() === "") {
            toastr.warning('La <b>Fecha de Solucion</b> estan vacios(as).<br>Por favor Ingrese una Fecha de Solucion valida');
            dateSolutiontxt.focus();
            return false;
        } else if (solutionstxt.value.trim() === "") {
            toastr.warning('La <b>Solución</b> estan vacios(as).<br>Por favor Ingrese una Solución valida');
            solutionstxt.focus();
            return false;
        } else {
            // Si no hay errores, procesa los datos enviados
            if (accionInput.value.trim() === "") {
                accionInput.value = "1";
            }

            document.getElementById("formUpdateWR").submit();
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


    // Funcion para cargar la previsualizacion de imagen 
    function readIMGURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // Asignamos el atributo src a la tag de imagen
                $('#imgSolutions').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    // El listener va asignado al input
    $("#fileReferentSolutions").change(function() {
        readIMGURL(this);
    });

    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });
</script>
<?php
$uploads_dir = '../../resources/Warranty/';
if (isset($_POST["buttonUpdateWR"])) {
    $wrId = $_POST["TxtId"];
    $computerId = $_POST["slctComputer"];
    $dateAdmisiontxt = $_POST["txtDateAdmision"];
    $numberApplicationstxt = $_POST["txtNumberApplications"];
    $mainProblemtxt = $_POST["txtMainProblem"];
    $actionDonetxt = $_POST["txtActionDone"];
    $imgProblem =  $_FILES['fileReferent']['name'];
    if (empty($imgProblem)) {
        // El campo de imagen está vacío
        $imgProblem = $WR_Image_Problem;
    } else {
        $imgProblem = '/resources/Warranty/' . $_FILES['fileReferent']['name'];
    }
    $diagnosticTxt = $_POST["txtDiagnostic"];
    $solutionsTxt = $_POST["txtSolutions"];
    $imgSolutions =  $_FILES['fileReferentSolutions']['name'];
    if (empty($imgSolutions)) {
        $imgSolutions = $WR_Image_Solution;
    } else {
        $imgSolutions = '/resources/Warranty/' . $_FILES['fileReferentSolutions']['name'];
    }
    $dateSolutiontxt = $_POST["txtDateSolution"];
    $observationstxt = $_POST["txtObservation"];
    $statusSlct = $_POST["selectStatus"];




    // Verificar el permiso para realizar la operación
    if ($PermisoWR) {
        try {
            //Caso contrario Guardara
            $stmt = $conn->prepare("CALL  sp_updateWarranty(?,?,?,?,?,?,?,?,?,?,?,?,?)");

            $query = "CALL sp_updateWarranty( '$wrId','$computerId','$dateAdmisiontxt',' $numberApplicationstxt','$mainProblemtxt','$actionDonetxt','$imgProblem ','$diagnosticTxt','$solutionsTxt','$imgSolutions ','$dateSolutiontxt','$observationstxt','$statusSlct');";
            echo $query;
            // Mandamos los parametros y los input que seran enviados al PA O SP
            $stmt->bind_param("sssssssssssss", $wrId, $computerId, $dateAdmisiontxt, $numberApplicationstxt, $mainProblemtxt, $actionDonetxt, $imgProblem, $diagnosticTxt, $solutionsTxt, $imgSolutions, $dateSolutiontxt, $observationstxt, $statusSlct);


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
                echo 'document.getElementById("formUpdateWR").reset(); ';
                echo '</script>';

                if ($_FILES['fileReferent']['name'] != 'DefaultProblem.jpg') {
                    move_uploaded_file($_FILES['fileReferent']['tmp_name'], $uploads_dir . $_FILES['fileReferent']['name']);
                } else if (file_exists($uploads_dir . $_FILES['fileReferent']['name'])) {
                    echo '<script > toastr.info("La imagen ya existe ' . $imgProblem . '")</script>;';
                    $uploadOk = 0; //si existe lanza un valor en 0                 
                }
                if ($_FILES['fileReferentSolutions']['name'] != 'compuiterRepair.jpg') {
                    move_uploaded_file($_FILES['fileReferentSolutions']['tmp_name'], $uploads_dir . $_FILES['fileReferentSolutions']['name']);
                } else if (file_exists($uploads_dir . $_FILES['fileReferentSolutions']['name'])) {
                    echo '<script > toastr.info("La imagen ya existe ' . $imgSolutions . '")</script>;';
                    $uploadOk = 0; //si existe lanza un valor en 0                 

                }

                exit;

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