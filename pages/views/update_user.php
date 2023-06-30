<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";
$permisoUSER = isset($privilegios["USER"]) && $privilegios["USER"];


//obtendremos lA VARIABLE QUE PASAMOS POR METODO get 
$idUser = $_GET['p'];

// Preparar la llamada al procedimiento almacenado 
//Extraer los datos con el id que se nos paso por medio de la url 

$stmt = $conn->query("CALL sp_selectUser($idUser)");
while ($row = $stmt->fetch_assoc()) {
    //   echo '<pre>';
    //   print_r($row);
    //   echo '</pre>';
    $User_idTbl_User = $row['User_idTbl_User'];
    $User_DataRegister = $row['User_DataRegister'];
    $User_Username = $row['User_Username'];
    $User_Email = $row['User_Email'];
    $User_Password = $row['User_Password'];
    $CBT_idTbl_Collaborator = $row['CBT_idTbl_Collaborator'];
    $STS_idTbl_Status = $row['STS_idTbl_Status'];
    $User_img = $row['User_img'];
    $RLS_idTbl_Roles = $row['RLS_idTbl_Roles'];
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
                            if ($permisoUSER) {
                                // Agregar la ruta al array $arrayAdd
                                $ruta = "../views/view_user.php";
                                $arrayAdd[] = $ruta;

                                // Crear el botón con la ruta almacenada en la variable
                                echo "<a href=\"$ruta\"><button button type='button' class='btn btn-block btn-primary'></i><span class='fas fa-arrow-circle-left'></span>   Volver</button></a>";
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
                    <div class="card card-primary card-outline card-tabs">
                        <div class="card-header">
                            <h3 class="card-title">Formulario para Actualizar <?php echo $pageName; ?> </h3>
                        </div>

                        <!-- form start -->
                        <form role="form" action="" method="POST" name="formUpdateUSER" id="formUpdateUSER" class="form-horizontal" enctype="multipart/form-data">
                            <div class="card-body">
                                <label class="form-check-label" style="padding-bottom: 5px;"> A continuación se le mostrara el formulario con información tenga <b> cuidado</b> al momento de presionar el boton:</label>
                                <!-- Input ocultos  -->
                                <input type="hidden" class="form-control" id="userId" name="userId" value="<?php echo $User_idTbl_User ?>">
                                <input type="hidden" class="form-control" id="txtAction" name="txtAction" >

                                <!--  Primer Row DE LA IZQUIERDA-->
                                <div class="row" style="padding-top:10px; padding-bottom:10px;">
                                    <div class="col-sm-6">
                                        <!-- Image -->
                                        <div class="form-group" style="padding-left:15px;">
                                            <label>Imagen de perfil</label>
                                            <div class="input-group" style="flex-direction: column; padding-left:15px; display: flex; justify-content: center; align-items: center;">
                                                <img class="img-fluid img-circle" src="../..<?php echo $User_img ?>" width="150" height="150" style="margin: 10px;" id="imgPerfil">
                                                <input type="file" name="imgUser" id="imgUser" accept="image/png,image/jpeg" style="padding-left:15px; padding-top:2.5px;">
                                            </div>
                                        </div>
                                        <!-- USERNAME -->
                                        <div class="form-group" style="padding-left:15px;">
                                            <label ACRONYM title="Nombre de Usuario">Nomb. Usuario: </label>
                                            <input type="text" class="form-control" id="txtNombreUsuario" name="txtNombreUsuario" maxlength="45" value="<?php echo $User_Username; ?>" placeholder="Nickname">
                                        </div>

                                        <!-- Fecha de registro -->
                                        <div class="form-group" style="padding-left:15px;">
                                            <label ACRONYM title="Fecha que fue ingresado">Fec. Ingreso:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control datepicker-input " id="txtFechaIngresado" name="txtFechaIngresado" value="<?php echo $User_DataRegister; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!--  Segunda Row -->
                                    <div class="col-sm-6">

                                        <!-- COLABORADOR -->
                                        <div class="form-group" style="padding-left:15px; padding-top:2.5px;">
                                            <label ACRONYM title="Nombre de Colaborador">Nomb. Colaborador: </label>
                                            <input type="text" class="form-control" id="txt_busqueda" name="txt_busqueda" placeholder="Buscar Colaborador">
                                            <?php $resultado = mysqli_query($conn, "CALL sp_selectCollaborators()"); ?>
                                            <select class="form-control" id="selectColaborador" name="selectColaborador">
                                                <?php while ($row = mysqli_fetch_array($resultado)) {
                                                    $select = ($CBT_idTbl_Collaborator == $row['CBT_idTbl_Collaborator']) ? "selected=selected" : "";

                                                ?>
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
                                        <!-- Correo -->
                                        <div class="form-group" style="padding-left:15px; padding-top:2.5px;">
                                            <label ACRONYM title="Correo Electronico">Email </label>
                                            <input type="emai" class="form-control" id="txtEmail" name="txtEmail" maxlength="45" value="<?php echo $User_Email; ?>" placeholder="Nickname">
                                        </div>
                                        <!-- Estado -->
                                        <div class="form-group" style="padding-left:15px; padding-top:2.5px;">
                                            <label>Estado del Usuario: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_status_select()"); ?>
                                            <select class="form-control" id="selectStatus" name="selectStatus">
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
                                        <!-- ROL DE USUARIO -->
                                        <div class="form-group" style="padding-left:15px; padding-top:2.5px;">
                                            <label>Rol de Usuario: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_rolesSelect()"); ?>
                                            <select class="form-control" id="selectRoles" name="selectRoles">
                                                <?php while ($row = mysqli_fetch_array($resultado)) {
                                                    $select = ($RLS_idTbl_Roles == $row['RLS_idTbl_Roles']) ? "selected=selected" : ""; ?>
                                                    <option value="<?php echo $row['RLS_idTbl_Roles']; ?>" <?php echo $select; ?>><?php echo $row['RLS_Description']; ?></option>
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
                                    <div class="col-sm-4">

                                        <!-- Password
                                        <div class="form-group">
                                            <label>Password:</label>
                                            <input type="password" class="form-control" name="txt_password" id="txt_password" maxlength="32" required >
                                        </div>


                                         Password 
                                        <div class="form-group">
                                            <label>Confirmar Password:</label>
                                            <input type="password" class="form-control" name="txt_confirmPassword" id="txt_confirmPassword" maxlength="32" required>
                                        </div> -->
                                    </div>

                                </div>
                                <!-- Comienzo fila 5 -->
                                <div class="row justify-content-center" style="padding-bottom:10px;">
                                    <div class="col-mb-12">
                                        <button type="submit" id="buttonUpdateUser" name="buttonUpdateUser" class="btn btn-block bg-olive" onclick='return validateData();'>Actualizar</button>
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
if (isset($_POST["buttonUpdateUser"])) {
    
    # Quieren guardar
    #valido si tiene el permiso de usuario 
    $permisoUSR = isset($privilegios["USER"]) && $privilegios["USER"];
    date_default_timezone_set('America/Mexico_City');
    $idUserHidde = $_POST["userId"];
    $action= $_POST["txtAction"];
    $dataRegisterInput = $_POST["txtFechaIngresado"];
    $usernameInput = $_POST["txtNombreUsuario"];
    $emailInput = $_POST["txtEmail"];
    $colaboratorSelect = $_POST["selectColaborador"];
    $statuSelect = $_POST["selectStatus"];
    #var_dump($_FILES['imgUser']);
    // valido si el campo esta vacio y  mango el antiguo valor
    if (empty($_FILES['imgUser']['name'])) {
        $imagenUserField = $User_img;
    } else {
        $imagenUserField = '/resources/User/' . $_FILES['imgUser']['name'];
    }
    $roleSelect = $_POST["selectRoles"];

    $uploads_dir = '../../resources/User/';  // Ruta de la carpeta de destino para los archivos
    
    if ($permisoUSR && $action=="true") {
       
        //preparamos el insert 
        $stmt = $conn->prepare("CALL sp_updateUser(?,?,?,?,?,?,?,?)");

        // Mandamos los parametros y los input que seran enviados al PA O SP
        $stmt->bind_param("ssssssss", $idUserHidde, $dataRegisterInput, $usernameInput, $emailInput, $colaboratorSelect, $statuSelect, $imagenUserField, $roleSelect);
        // $query = "CALL sp_updateUser('$idUserHidde','$dataRegisterInput', '$usernameInput', '$emailInput', '$colaboratorSelect', '$statuSelect', '$imagenUserField', '$roleSelect');";
        // echo $query;

        // Ejecutar el procedimiento almacenado
        $stmt->execute();
        if ($stmt->error) {
            error_log("Error en la ejecución del procedimiento almacenado: " . $stmt->error);
        }
        // Obtener el valor de la variable de salida
        $stmt->bind_result($answerExistsComp, $msgErrorInsert);
        $stmt->fetch();
        $stmt->close();
        $conn->next_result();

        
        // se extraen los valores qu     nos devuelve el procedimiento almacenado y enviamos el error
        if ($answerExistsComp > 0 && $msgErrorInsert == 0) {
            echo '<script > toastr.success("Los datos de <b>' . $usernameInput . '</b> se Actualizaron de manera exitosa.", "¡¡Enhorabuena!!"); ';
            echo 'setTimeout(function() {';
            echo '  window.location.href = "view_user.php";';
            echo ' }, 2000); // 2000 milisegundos = 2 segundos de retraso ';
            echo 'document.getElementById("formInsertCMP").reset(); ';
            echo '</script>';
            // Comprobar si el archivo ya existe
            if (file_exists($uploads_dir . $_FILES['imgUser']['name']) != '/resources/User/default.png') {
                echo '<script > toastr.info("La imagen ya existe")</script>;';
                $uploadOk = 0; //si existe lanza un valor en 0
            } else {
                move_uploaded_file($_FILES['imgUser']['tmp_name'], $uploads_dir . $_FILES['imgUser']['name']);
            }
        } else if ($answerExistsComp == "" && $msgErrorInsert == 1) {
            echo '<script > toastr.error("No se pudo guardar <br>Ya existe un registro con este el Username: <b>' . $usernameInput . '</b>","¡¡UPS!!  Advertencia: 1");';
            echo 'var usernametxt = document.getElementById("txt_username");';
            echo 'usernametxt.focus();';
            echo '</script>';
        } else if ($answerExistsComp == "" && $msgErrorInsert == 2) {
            echo '<script > toastr.error(" No se pudo guardar<br> Ya existe un registro con este Colaborador (ID):  <b> ' . $colaboratorSelect . ' </b>","¡¡UPS!!  Advertencia: 2");';
            echo ' colaboradorSelect.focus();';
            echo '</script>';
        } else if ($answerExistsComp == "" && $msgErrorInsert == 3) {
            echo '<script > toastr.error(" No se pudo guardar<br> Ya existe un Registro guardado con este Email<b> ' . $emailInput . ' </b>","¡¡UPS!!  Advertencia: 3");';
            echo 'emailtxt.focus();';
            echo '</script>';
        } else if ($answerExistsComp == "" && $msgErrorInsert == 5) {
            echo '<script>';
            echo 'toastr.error(" No se pudo guardar<br> No existe un registro para el <b>Username: ' . $usernameInput . ' </b><br> pero si existen un Registro con Colaborador: <b> ' . $colaboratorSelect . '</b> y  Email <b> ' . $emailInput . '</b>.","¡¡UPS!!  Advertencia: 5");';
            echo '</script>';
        } else if ($answerExistsComp == "" && $msgErrorInsert == 6) {
            echo '<script>';
            echo 'toastr.error(" No se pudo guardar<br> No existe un registro para el <b>Colaborador(ID): ' . $colaboratorSelect . '</b><br> pero si existen un Registro con Username: <b> ' . $usernameInput . ' </b> y  Email <b> ' . $emailInput . '</b> . ","¡¡UPS!!  Advertencia: 6");';
            echo '</script>';
        } else if ($answerExistsComp == "" && $msgErrorInsert == 7) {
            echo '<script>';
            echo 'toastr.error(" No se pudo guardar <br> No existe un registro para Email: <b>' . $emailInput . '</b><br> pero si existen un Registro con Username: <b> ' . $usernameInput . ' </b> y  Colaborador (ID): <b> ' . $colaboratorSelect . '</b>" ,"¡¡UPS!!  Advertencia: 7");';
            echo '</script>';
        }
        exit;
    }
    
}
?>



<script type="text/javascript">
    // funcion para validar los datos ingresados en el formulario

    function validateData() {
        let dataRegisterInput = document.getElementById('txtFechaIngresado');
        let usernameInput = document.getElementById('txtNombreUsuario');
        let emalInput = document.getElementById('txtEmail');
        let colaboradorSelect = document.getElementById('selectColaborador');
        let statusSelect = document.getElementById('selectStatus');
        let rolSelect = document.getElementById('selectRoles');
        let Action = document.getElementById('txtAction');

        if (dataRegisterInput.value.trim() === "") {
            toastr.warning('La <b>Fecha de Registro</b> esta vacio(a).<br>Por favor, rellene este campo');
            dataRegisterInput.focus();
            return false;
        } else if (usernameInput.value.trim() === "") {
            toastr.warning('La <b>Nombre de Usuario</b> esta vacio(a).<br>Por favor, rellene este campo');
            usernameInput.focus();
            return false;
        } else if (emalInput.value.trim() === "") {
            toastr.warning('La <b>Email</b> esta vacio(a).<br>Por favor, rellene este campo');
            emalInput.focus();
            return false;
        } else if (colaboradorSelect.selectedIndex === 0) {
            toastr.warning('El <b>Colaborador</b> seleccionado no es valido(a).<br>Por favor,seleccione un campo valido');
            colaboradorSelect.focus();
            return false;
        } else if (statusSelect.selectedIndex === 0) {
            toastr.warning('El <b>Estado</b> seleccionado no es valido(a).<br>Por favor,seleccione un campo valido');
            statusSelect.focus();
            return false;
        } else if (rolSelect.selectedIndex === 0) {
            toastr.warning('El <b>Rol</b> seleccionado no es valido(a).<br>Por favor,seleccione un campo valido');
            rolSelect.focus();
            return false;
        } else {
            Action.value="true";
            // Si no hay errores, procesa los datos enviados
            document.getElementById("formUpdateUSER").submit();
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
        showDuration: "200",
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
        $(".datepicker-input").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });
</script>