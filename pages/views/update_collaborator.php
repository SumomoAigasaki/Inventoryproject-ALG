<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";

//obtendremos lA VARIABLE QUE PASAMOS POR METODO get 
$idCBT = $_GET['p'];

// Preparar la llamada al procedimiento almacenado
$stmt = $conn->query("CALL sp_selectcollaborator($idCBT)");
while ($row = $stmt->fetch_assoc()) {
    // echo '<pre>';
    // print_r($row);
    // echo '</pre>';
    // Obtener el valor de [CMP_Inventory_Date]
    $CBT_idTbl_Collaborator = $row['CBT_idTbl_Collaborator'];
    $CBT_Employee_Code = $row['CBT_Employee_Code'];
    $NTL_idTbl_Nationality = $row['NTL_idTbl_Nationality'];
    $CBT_Image = $row['CBT_Image'];
    //valido si viene nulos o vacios los datos de BD ponga una imagen por default
    if (empty($CBT_Image) || $CBT_Image === null || $CBT_Image == "/resources/Computer/") {
        $CBT_Image = "/resources/Computer/default.jpg";
    }
    $CBT_First_Name = $row['CBT_First_Name'];
    $CBT_Second_Name = $row['CBT_Second_Name'];
    $CBT_First_Surname = $row['CBT_First_Surname'];
    $CBT_Second_Surname = $row['CBT_Second_Surname'];
    $GD_idTbl_Gender = $row['GD_idTbl_Gender'];
    $CBT_Address = $row['CBT_Address'];
    $CBT_Phone_Number = $row['CBT_Phone_Number'];
    $CBT_Birth_Date = $row['CBT_Birth_Date'];
    $PCS_idTbl_Process = $row['PCS_idTbl_Process'];
    $MNG_idTbl_Management = $row['MNG_idTbl_Management'];
    $CBT_Inventory_Date = $row['CBT_Inventory_Date'];
    $User_idTbl_User = $row['User_idTbl_User'];
    $STS_idTbl_Status = $row['STS_idTbl_Status'];
    $CBT_employee_position = $row['CBT_employee_position'];

    $AD_idtbl_academicDegree = $row['AD_idtbl_academicDegree'];
    $TCNT_idtbl_typeContract = $row['TCNT_idtbl_typeContract'];
    $CBT_Date_Hire_Start = $row['CBT_Date_Hire_Start'];
    $CBT_Hiring_Months = $row['CBT_Hiring_Months'];
}
$stmt->close();
$conn->next_result();



?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
<script src="../../public/jquery/jquery.min.js"></script>
<script src="../../public/js/toastr.min.js"></script>
<script>
    //Funcion General de las configuraciones de los toastr que aparecen al costado de la derecha superior
    toastr.options = {
        closeButton: true,
        debug: true,
        newestOnTop: false,
        progressBar: true,
        positionClass: "toast-top-right",
        preventDuplicates: false,
        onclick: null,
        showDuration: "200",
        hideDuration: "1000",
        timeOut: "5000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut"
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
                        <form role="form" action="" method="POST" name="formUpdateCBT" id="formUpdateCBT" class="form-horizontal" enctype="multipart/form-data">
                            <div class="card-body">
                                <label class="form-check-label" style="padding-bottom: 5px;"> A continuación se le mostrara el formulario con información tenga <b> cuidado</b> al momento de presionar el boton:</label>
                                <!-- Input ocultos  -->
                                <input type="hidden" class="form-control" id="txtId" name="txtId" value="<?php echo $CBT_idTbl_Collaborator ?>">
                                <input type="hidden" class="form-control" id="txtAccion" name="txtAccion" value="2">

                                <!--  1 FILA -->
                                <div class="row" style="padding-top:10px; padding-bottom:10px;">
                                      <!-- Image -->
                                    <div class="col-sm-6 d-flex justify-content-center align-items-center">
                                        <div class="form-group" style="padding-left:15px;">
                                            <label>Imagen de Referencia</label>
                                            <div class="input-group" style="flex-direction: column; padding-left:15px; display: flex; justify-content: center; align-items: center;">
                                                <img class="img-fluid img-circle" src="../..<?php echo $CBT_Image ?>" width="150" height="150" style="margin: 10px;" id="imgPerfil">
                                                <input type="file" name="imgCBT" id="imgCBT" accept="image/png,image/jpeg" style="padding-left:15px; padding-top:2.5px;">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Columna 1, Fila 1-->
                                    <div class="col-sm-3">
                                        <!-- FECHA DE INVENTARIO -->
                                        <div class="form-group" style="padding-top:25px; padding-bottom:10px;">
                                            <label>Fecha de Inventariado:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control -input" id="todayDate" name="todayDate" value="<?php echo $CBT_Inventory_Date ?>" readonly>
                                            </div>
                                        </div>
                                        <!-- Nacionalidad -->
                                        <div class="form-group" style="padding-top:28px;">
                                            <label><code>*</code>Nacionalidad: </label>
                                            <?php
                                            #Se procede a llamar al procedimiento almacenado que se llama sp_manufacturer_select,con la variable que almancena "cnn" la base de datos 
                                            $resultado = mysqli_query($conn, "CALL sp_selectNationality()"); ?>
                                            <select class="form-control select2bs4" id="slctNacionality" name="slctNacionality">
                                                <?php while ($row = mysqli_fetch_array($resultado)) {
                                                    $select = ($NTL_idTbl_Nationality == $row['NTL_idTbl_Nationality']) ? "selected=selected" : "";
                                                ?>
                                                    <option value="<?php echo $row['NTL_idTbl_Nationality']; ?>" <?php echo $select; ?>><?php echo $row['NTL_Description']; ?></option>
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

                                     <!-- Columna 2, Fila 1-->
                                    <div class="col-sm-3" style="padding-top:25px; padding-bottom:10px;">
                                        <!-- Codigo de Empleado -->
                                        <div class="form-group">
                                            <label><code>*</code>Código Empleado:</label>
                                            <input type="text" class="form-control" name="txtEmployeeCode" id="txtEmployeeCode" maxlength="17" placeholder="ALGCBT202#_00000" value="<?php echo $CBT_Employee_Code ?>">
                                        </div>
                                        <!-- Número de teléfono -->
                                        <div class="form-group" style="padding-top:37px;">
                                            <label><code>*</code>Número de teléfono :</label>
                                            <input type="text" class="form-control" name="txtphoneNumber" id="txtphoneNumber" maxlength="16" placeholder="+504 0000-0000" pattern="\([0-9]{4}\) [0-9]{4}[ -][0-9]{4}" value="<?php echo $CBT_Phone_Number ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Fila 2-->
                                <div class="row">
                                    <!-- Primer Nombre -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><code>*</code>Primer Nombre :</label>
                                            <input type="text" class="form-control" name="txtfirstName" id="txtfirstName" maxlength="25" placeholder="José" value="<?php echo $CBT_First_Name ?>">
                                        </div>
                                    </div>
                                    <!-- Segundo Nombre -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Segundo Nombre :</label>
                                            <input type="text" class="form-control" name="txtsecondName" id="txtsecondName" maxlength="25" placeholder="Santos" value="<?php echo $CBT_Second_Name ?>">
                                        </div>
                                    </div>
                                    <!-- Primer Apellido -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><code>*</code>Primer Apellido :</label>
                                            <input type="text" class="form-control" name="txtfirstSurname" id="txtfirstSurname" maxlength="25" placeholder="Martinez" value="<?php echo $CBT_First_Surname ?>">
                                        </div>
                                    </div>
                                    <!-- Segundo Apellido -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Segundo Apellido :</label>
                                            <input type="text" class="form-control" name="txtsecondSurname" id="txtsecondSurname" maxlength="25" placeholder="Hernandez" value="<?php echo $CBT_Second_Surname ?>">
                                        </div>
                                    </div>
                                </div>

                                <!-- Fila 3 -->
                                <div class="row" style="padding-bottom:10px;">
                                    <!-- Grado de Estudios -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><code>*</code>Grado de Estudios :</label>
                                            <?php
                                            #Se procede a llamar al procedimiento almacenado que se llama sp_manufacturer_select,con la variable que almancena "cnn" la base de datos 
                                            $resultado = mysqli_query($conn, "CALL sp_selectGrade()"); ?>
                                            <select class="form-control select2bs4" id="slctGrade" name="slctGrade">
                                                <option value="0">Empty/Vacío</option>
                                                <?php while ($row = mysqli_fetch_array($resultado)) {
                                                    $select = ($AD_idtbl_academicDegree == $row['AD_idtbl_academicDegree']) ? "selected=selected" : ""; ?>
                                                    <option value="<?php echo $row['AD_idtbl_academicDegree']; ?>" <?php echo $select; ?>><?php echo $row['AD_Description']; ?></option>
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
                                    <!-- Dirección -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><code>*</code>Dirección :</label>
                                            <input type="text" class="form-control" name="txtaddress" id="txtaddress" maxlength="60" placeholder="B° el centro" value="<?php echo $CBT_Address; ?>">
                                        </div>
                                    </div>

                                    <!-- Genero -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><code>*</code>Genero: </label>
                                            <?php
                                            #Se procede a llamar al procedimiento almacenado que se llama sp_manufacturer_select,con la variable que almancena "cnn" la base de datos 
                                            $resultado = mysqli_query($conn, "CALL sp_selectGender()"); ?>
                                            <select class="form-control select2bs4" id="slctGender" name="slctGender">
                                                <?php while ($row = mysqli_fetch_array($resultado)) {
                                                    $select = ($GD_idTbl_Gender == $row['GD_idTbl_Gender']) ? "selected=selected" : "";
                                                ?>
                                                    <option value="<?php echo $row['GD_idTbl_Gender']; ?>" <?php echo $select; ?>><?php echo $row['GD_Description']; ?></option>
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
                                    <!-- Fecha de Nacimiento -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label> Fecha de Nacimiento:</label>
                                            <input type="text" class="form-control datepicker-input" name="txtbirthDate" id="txtbirthDate" value="<?php echo $CBT_Birth_Date ?>">
                                        </div>
                                    </div>
                                </div>

                                <!-- Fila 4 -->
                                <div class="row" style="padding-top:30px;">
                                    <!-- Gerencia -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><code>*</code>Gestion: </label>
                                            <?php
                                            #Se procede a llamar al procedimiento almacenado que se llama sp_manufacturer_select,con la variable que almancena "cnn" la base de datos 
                                            $resultado = mysqli_query($conn, "CALL sp_selectManagement()"); ?>
                                            <select class="form-control select2bs4" id="slctManagement" name="slctManagement">
                                                <?php while ($row = mysqli_fetch_array($resultado)) {
                                                    $select = ($MNG_idTbl_Management == $row['MNG_idTbl_Management']) ? "selected=selected" : "";
                                                ?>
                                                    <option value="<?php echo $row['MNG_idTbl_Management']; ?>" <?php echo $select; ?>><?php echo $row['MNG_Description']; ?></option>
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
                                            <label><code>*</code>Proceso: </label>
                                            <?php
                                            #Se procede a llamar al procedimiento almacenado que se llama sp_manufacturer_select,con la variable que almancena "cnn" la base de datos 
                                            $resultado = mysqli_query($conn, "CALL sp_selectProcess()"); ?>
                                            <select class="form-control select2bs4" id="slctProcess" name="slctProcess">
                                                <?php while ($row = mysqli_fetch_array($resultado)) {
                                                    $select = ($PCS_idTbl_Process == $row['PCS_idTbl_Process']) ? "selected=selected" : "";
                                                ?>
                                                    <option value="<?php echo $row['PCS_idTbl_Process']; ?>" <?php echo $select; ?>><?php echo $row['PCS_Description']; ?></option>
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
                                    <!-- Cargo a Desempeñar -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><code>*</code>Cargo a Desempeñar:</label>
                                            <input type="text" class="form-control" name="txtposition" id="txtposition" maxlength="45" placeholder="Auxiliar " value="<?php echo $CBT_employee_position ?>">
                                        </div>
                                    </div>
                                    <!-- Tipo de contratacion -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><code>*</code>Tipo de contratacion: </label>
                                            <?php
                                            #Se procede a llamar al procedimiento almacenado que se llama sp_manufacturer_select,con la variable que almancena "cnn" la base de datos 
                                            $resultado = mysqli_query($conn, "CALL sp_selectTypeContract()"); ?>
                                            <select class="form-control select2bs4" id="slcTypeContract" name="slcTypeContract">
                                                <option value="0">Empty/Vacío</option>
                                                <?php while ($row = mysqli_fetch_array($resultado)) {
                                                    $select = ($TCNT_idtbl_typeContract == $row['TCNT_idtbl_typeContract']) ? "selected=selected" : ""; ?>
                                                    <option value="<?php echo $row['TCNT_idtbl_typeContract']; ?>" <?php echo $select; ?>><?php echo $row['TCNT_Description']; ?></option>
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

                                <!-- Fila 5-->
                                <div class="row justify-content-center" style="padding-bottom:10px;">
                                    <!-- Fecha de Contratacion -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><code>*</code>Fecha de Contratacion:</label>
                                            <input type="text" class="form-control datepicker-input" name="txtDateHirtStart" id="txtDateHirtStart" value="<?php echo $CBT_Date_Hire_Start ?>">
                                        </div>
                                    </div>
                                    <!-- Meses de Contratacion -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><code>*</code>Meses de Contratacion:</label>
                                            <input type="number" class="form-control" name="txtMountHiring" id="txtMountHiring" value="<?php echo $CBT_Hiring_Months ?>">
                                        </div>
                                    </div>
                                    <!-- Fecha aprox. Termina Contratacion -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Fecha aprox. Termina Contratacion:</label>
                                            <input type="text" class="form-control" name="txtDateHirtEnd" id="txtDateHirtEnd" readonly>
                                        </div>
                                    </div>
                                    <!-- Estado Colaborador  -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><code>*</code>Estado Colaborador: </label>
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
                                </div>
                                <!-- Fila 6 -->
                                <div class="row justify-content-center" style="padding-bottom:10px;">
                                    <!-- Boton guardar -->
                                    <div class="col-mb-3">
                                        <button type="submit" class="btn btn-block bg-olive" id="buttonUpdateCBT" name="buttonUpdateCBT" onclick='return validate_data();'>Actualizar</button>
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
<!--Validaciones de PHP-->
<?php
//validacion si preciona el boton  

# En caso de que haya sido el de guardar, no agregamos más campos
$uploads_dir = '../../resources/Collaborator/';  // Ruta de la carpeta de destino para los archivos
if (isset($_POST["buttonUpdateCBT"])) {
    $accion = $_POST["txtAccion"];
    #valido si tiene el permiso de usuario 
    $idCBT = $_POST["txtId"];
    $inventoryDateCBT = $_POST["todayDate"];
    $nacionalityCBT = $_POST['slctNacionality'];
    $employeeCodeCBT = $_POST['txtEmployeeCode'];
    $phoneNumberCBT = $_POST['txtphoneNumber'];
    $firstNameCBT = $_POST['txtfirstName'];
    $secondNameCBT = $_POST['txtsecondName'];
    $firstSurnameCBT = $_POST['txtfirstSurname'];
    $secondSurnameCBT = $_POST['txtsecondSurname'];
    $genderCBT = $_POST['slctGender'];
    $birthDateCBT = $_POST['txtbirthDate'];
    $statusCBT = $_POST['slctStatus'];
    $addressCBT = $_POST['txtaddress'];
    $managementCBT = $_POST['slctManagement'];
    $processCBT = $_POST['slctProcess'];
    $employeePositionCBT = $_POST["txtposition"];

    $gadreCBT = $_POST["slctGrade"];
    $tContractCBT = $_POST["slcTypeContract"];
    $dateHirtCBT = $_POST["txtDateHirtStart"];
    $mounthHiringCBT = $_POST["txtMountHiring"];



    if (empty($_FILES['imgCBT']['name'])) {
        // El campo de imagen está vacío
        $CBTimage = $CBT_Image;
    } else {
        // El campo no está vacío
        $CBTimage = '/resources/Collaborator/' . $_FILES['imgCBT']['name'];
    }
    //validamos si tiene el permiso de CMP
    if ($PermisoCMP) {

        try {
            //llamamos el procedimiento almacemado de actualizar computadora 
            $stmt = $conn->prepare("CALL sp_updateCollaborator(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            // Mandamos los parametros y los input que seran enviados al PA O SP
            $stmt->bind_param("sssssssssssssssssssss", $idCBT, $CBTimage, $inventoryDateCBT, $nacionalityCBT, $employeeCodeCBT, $phoneNumberCBT, $firstNameCBT, $secondNameCBT, $firstSurnameCBT, $secondSurnameCBT, $genderCBT, $birthDateCBT, $addressCBT, $managementCBT, $processCBT, $statusCBT, $employeePositionCBT, $gadreCBT, $tContractCBT, $dateHirtCBT, $mounthHiringCBT);
            // Ejecutar el procedimiento almacenado

            $stmt->execute();
            // $query = "CALL sp_updateCollaborator('$idCBT', '$CBTimage', '$inventoryDateCBT', '$nacionalityCBT', '$employeeCodeCBT', '$phoneNumberCBT', '$firstNameCBT', '$secondNameCBT', '$firstSurnameCBT', '$secondSurnameCBT', '$genderCBT', '$birthDateCBT', '$addressCBT', '$managementCBT', '$processCBT', '$statusCBT', '$employeePositionCBT', '$gadreCBT', '$tContractCBT', '$dateHirtCBT', '$mounthHiringCBT');";
            // echo $query;
            // echo '<pre>';
            if ($stmt->error) {
                error_log("Error en la ejecución del procedimiento almacenado: " . $stmt->error);
            }
            // Obtener el número de filas afectadas por el insert
            $stmt->bind_result($answerExistsComp);
            $stmt->fetch();
            // echo $idC;

            // Cerrar el statement
            $stmt->close();
            // Avanzar al siguiente conjunto de resultados si hay varios
            $conn->next_result();
            // se extraen los valores qu     nos devuelve el procedimiento almacenado y enviamos el error
            if ($answerExistsComp > 0) {
                echo '<script > toastr.success("Los datos de (<b>' . $employeeCodeCBT . ' ' . $firstNameCBT . ' ' . $firstSurnameCBT . '</b>) se Guardaron de manera exitosa.", "¡¡Enhorabuena!!"); ';
                echo 'setTimeout(function() {';
                echo '  window.location.href = "view_collaborator.php";';
                echo ' }, 2000); // 2000 milisegundos = 2 segundos de retraso ';
                echo 'document.getElementById("formInsertCBT").reset(); ';
                echo '</script>';

                if ($_FILES['imgCBT']['name'] != 'default.jpg') {
                    move_uploaded_file($_FILES['imgCBT']['tmp_name'], $uploads_dir . $_FILES['imgCBT']['name']);
                } else if (file_exists($uploads_dir . $_FILES['imgCBT']['name'])) {
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

<script type="text/javascript">
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
        let statusSlct = document.getElementById('slctStatus');
        let positionTxt = document.getElementById('txtposition');

        let gradeSlct = document.getElementById('slctGrade');
        let typeContractSlct = document.getElementById('slcTypeContract');
        let dateHirtTxt = document.getElementById('txtDateHirtStart');
        let mountHiringTxt = document.getElementById('txtMountHiring');


        if (employeeCodeTxt.value.trim() === "") {
            toastr.warning("El <b>Codigo de Empleado</b> esta vacio(a).<br>Por favor Ingrese un Codigo de Empleado valido(a).");
            employeeCodeTxt.focus();
            return false;
        } else if (nacionalitySlct.selectedIndex == 0) {
            toastr.warning('La <b>Nacionalidad</b> esta vacio(a).<br>Por favor Ingrese una Nacionalidad valido(a).');
            nacionalitySlct.focus();
            return false;
        } else if (firstNameTxt.value.trim() === "") {
            toastr.warning("El <b>Primer Nombre</b> esta vacio(a).<br>Por favor Ingrese un Primer Nombre valido(a).");
            firstNameTxt.focus();
            return false;
        } else if (firstSurnameTxt.value.trim() === "") {
            toastr.warning("El <b>Primer Apellido</b> esta vacio(a).<br>Por favor Ingrese un Primer Apellido valido(a).");
            firstSurnameTxt.focus();
            return false;
        } else if (genderSlct.selectedIndex == 0) {
            toastr.warning('El <b>Genero</b> esta vacio(a).<br>Por favor Ingrese una Genero valido(a).');
            genderSlct.focus();
            return false;
        } else if (phoneNumberTxt.value.trim() === "") {
            toastr.warning("El <b>Número de teléfono</b> esta vacio(a).<br>Por favor Ingrese un Número de teléfono valido(a).");
            phoneNumberTxt.focus();
            return false;
        } else if (addressTxt.value.trim() === "") {
            toastr.warning("La <b>Dirección</b> esta vacio(a).<br>Por favor Ingrese una Dirección valido(a).");
            addressTxt.focus();
            return false;
        } else if (processSlct.selectedIndex == 0) {
            toastr.warning('El <b>Proceso</b> esta vacio(a).<br>Por favor Ingrese una Proceso valido(a).');
            processSlct.focus();
            return false;
        } else if (managementSlct.selectedIndex == 0) {
            toastr.warning('La <b>Gestión</b> esta vacio(a).<br>Por favor Ingrese una Gestión valido(a).');
            managementSlct.focus();
            return false;
        } else if (statusSlct.selectedIndex == 0) {
            toastr.warning('El <b>Estado</b> esta vacio(a).<br>Por favor Ingrese un Estado valido(a).');
            statusSlct.focus();
            return false;
        } else if (positionTxt.value.trim() === "") {
            toastr.warning("El <b>Cargo de Desempeño</b> esta vacio(a).<br>Por favor Ingrese un Cargo de Desempeño valido(a).");
            positionTxt.focus();
            return false;
        } else if (gradeSlct.selectedIndex == 0) {
            toastr.warning('El <b>Grado de Estudios</b> esta vacio(a).<br>Por favor Ingrese un Grado de Estudios valido(a).');
            gradeSlct.focus();
            return false;
        } else if (typeContractSlct.selectedIndex == 0) {
            toastr.warning('El <b>Tipo de Contratacion</b> esta vacio(a).<br>Por favor Ingrese un Tipo de Contratacion valido(a).');
            typeContractSlct.focus();
            return false;
        } else if (dateHirtTxt.value.trim() === "") {
            toastr.warning("La <b>Fecha de Contratación</b> esta vacio(a).<br>Por favor Ingrese una Fecha de Contratación valido(a).");
            dateHirtTxt.focus();
            return false;
        } else if (mountHiringTxt.value.trim() === "") {
            toastr.warning("El(Los) <b>Mes(es) de Contratación </b> esta vacio(a).<br>Por favor Ingrese un(os) Mes(es) de Contratación valido(a).");
            mountHiringTxt.focus();
            return false;
        } else {
            // Si no hay errores, procesa los datos enviados
            if (accionInput.value.trim() === "") {
                accionInput.value = "1";

            }
            document.getElementById("buttonUpdateCBT").submit();

        }
    }


    $(function() {

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
    $("#imgCBT").change(function() {
        readURL(this);
    });

    $(document).ready(function() {
     $('#txtDateHirtStart, #txtMountHiring').on('change', function() {
         var startDate = new Date($('#txtDateHirtStart').val());
         var hiringMonths = parseInt($('#txtMountHiring').val());

            if (!isNaN(startDate.getTime()) && hiringMonths) {
                var endDate = new Date(startDate.getFullYear(), startDate.getMonth() + hiringMonths, startDate.getDate());
                endDate.setDate(endDate.getDate() + 1); // Ajustar al último día del mes

                var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth() + 1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);
                $('#txtDateHirtEnd').val(formattedEndDate);
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        var startDate = new Date(document.getElementById('txtDateHirtStart').value);
        var hiringMonths = parseInt(document.getElementById('txtMountHiring').value);

        if (!isNaN(startDate.getTime()) && hiringMonths) {
            // Obtener la fecha al inicio del siguiente mes
            var nextMonth = new Date(startDate);
            nextMonth.setMonth(nextMonth.getMonth() + 1);
            nextMonth.setDate(1);

            var endDate = new Date(nextMonth);
            endDate.setMonth(endDate.getMonth() + hiringMonths);

            // Si la fecha de inicio y fin está en el mismo día del mes, restamos un día
            if (startDate.getDate() === endDate.getDate()) {
                endDate.setDate(endDate.getDate() - 1);
            }

            var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth() + 1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);
            document.getElementById('txtDateHirtEnd').value = formattedEndDate;
        } else {
            // Manejar el caso en el que los campos estén vacíos o no sean válidos
            console.error("Por favor, completa los campos de fecha de contratación y meses de contratación válidos.");
        }
    });
</script>



<!-- Ekko Lightbox -->
<?php
require_once "../templates/footer.php";
?>