<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";
$permisoUSR = isset($privilegios["USER"]) && $privilegios["USER"];

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
                            if ($permisoUSR) {
                                // Agregar la ruta al array $arrayAdd
                                $ruta = "../views/view_user.php";
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
                            <h3 class="card-title">Formulario para Añadir <?php echo $pageName; ?> </h3>
                        </div>
                        <!-- form start -->
                        <form role="form" action="" method="post" name="formInsertUSR" id="formInsertUSR" class="form-horizontal" enctype="multipart/form-data">
                            <div class="card-body">
                                <label class="form-check-label" style="padding-bottom: 5px;"> A continuación se le pedirá que <b> Ingrese</b> los siguientes datos:</label>

                                <!-- Input ocultos  -->
                                <input type="hidden" class="form-control" id="todayDate" name="todayDate" placeholder="<?php echo $todayDate ?>">
                                <input type="hidden" class="form-control" id="accion" name="accion" placeholder="">

                                <div class="row justify-content-center" style="padding-top:10px; padding-bottom:10px;">
                                    <!-- Colaborador-->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Colaborador:</label>
                                            <input type="text" class="form-control" id="txt_busqueda" name="txt_busqueda" placeholder="Buscar Colaborador">
                                            <?php $resultado = mysqli_query($conn, "CALL sp_selectCollaborators()"); ?>
                                            <select class="form-control" id="selectColaborador" name="selectColaborador">
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
                                    <!-- IMAGEN -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Imagen: </label>

                                            <div class="input-group">
                                                <img class="img-fluid" src="../../resources/User/default.png" width="150" height="150" style="margin: 10px;" id="imgPerfil">
                                                <input type="file" name="imgUser" id="imgUser" accept="image/png,image/jpeg" style="padding-left:15px; padding-top:75px;">
                                            </div>
                                        </div>
                                    </div>



                                </div><!-- Comienzo fila 2 -->

                                <div class="row">
                                    <!-- UserName -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Username:</label>
                                            <input type="text" class="form-control" name="txt_username" id="txt_username" maxlength="16" placeholder="fcalderon" required>
                                        </div>
                                    </div>
                                    <!-- email -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input type="email" class="form-control" name="txt_email" id="txt_email" placeholder="juanjose@alg.com" maxlength="100" required>
                                        </div>
                                    </div>
                                    <!-- Password -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Password:</label>
                                            <input type="password" class="form-control" name="txt_password" id="txt_password" maxlength="32" required>
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Confirmar Password:</label>
                                            <input type="password" class="form-control" name="txt_confirmPassword" id="txt_confirmPassword" maxlength="32" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="row justify-content-center">
                                    <!-- Estado de la computadora  -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Estado del Usuario: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_status_select()"); ?>
                                            <select class="form-control" id="selectStatus" name="selectStatus">
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

                                    <!-- Estado de la computadora  -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Rol Usuario: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_rolesSelect()"); ?>
                                            <select class="form-control" id="selectRoles" name="selectRoles">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['RLS_idTbl_Roles']; ?>"><?php echo $row['RLS_Description']; ?></option>
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

                                <div class="row justify-content-center" style="padding-bottom:10px;">
                                    <div class="col-mb-3">
                                        <button type="submit" class="btn btn-block btn-info" id="buttonInsertUser" name="buttonInsertUser" onclick='return validate_data();'>Guardar</button>
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
<script type="text/javascript">
    // Función para validar los datos ingresados en el formulario
    function validate_data() {
        let accionInput = document.getElementById('accion');
        let colaboradorSelect = document.getElementById('selectColaborador');
        let usernametxt = document.getElementById('txt_username');
        let emailtxt = document.getElementById('txt_email');
        let passwordtxt = document.getElementById('txt_password');
        let confirmPasswordtxt = document.getElementById('txt_confirmPassword');
        let statusSelect = document.getElementById('selectStatus');
        let rolesSelect = document.getElementById('selectRoles');

        if (colaboradorSelect.selectedIndex === 0) {
            toastr.warning('El <b>Colaborador</b> esta vacio(a).<br>Por favor Ingrese una Colaborador valida');
            colaboradorSelect.focus();
            return false;
        } else if (usernametxt.value.trim() === "") {
            toastr.warning("El <b>Usuario</b> esta vacio(a).<br>Por favor Ingrese un Usuario valida");
            usernametxt.focus();
            return false;
        } else if (emailtxt.value.trim() === "") {
            toastr.warning('El <b>Email</b> esta vacio(a).<br>Por favor Ingrese un Email valido');
            emailtxt.focus();
            return false;
        } else if (passwordtxt.value.trim() === "") {
            toastr.warning('La <b>Contraseña</b> esta vacio(a).<br>Por favor Ingrese una Contraseña valido');
            passwordtxt.focus();
        } else if (confirmPasswordtxt.value.trim() === "") {
            toastr.warning('La <b>Confirmacion de Contraseña</b> esta vacio(a).<br>Por favor Ingrese una Confirmacion de Contraseñavalida');
            confirmPasswordtxt.focus();
            return false;
        } else if (statusSelect.selectedIndex === 0) {
            toastr.warning('El <b>Estado del Computador</b> esta vacio(a).<br>Por favor Ingrese una Estado del Computador valida');
            statusSelect.focus();
            return false;
        } else if (rolesSelect.selectedIndex === 0) {
            toastr.warning('El <b>Rol del Usuario</b> esta vacio(a).<br>Por favor Ingrese una Rol del Usuario valida');
            rolesSelect.focus();
            return false;
        } else if (passwordtxt.value != confirmPasswordtxt.value) {
            toastr.info('Las contraseña no coinciden, coloque una que si coincida ');
            confirmPasswordtxt.focus();
            return false;
        } else {
            // Si no hay errores, procesa los datos enviados
            if (accionInput.value.trim() === "") {
                accionInput.value = "1";

            }
            document.getElementById("formInsertUSR").submit();

        }

    }

    // window.onload= function(){
    //     document.getElementById("buttonInsertUser").onclick= validate_data;
    // }
</script>

<?php
//validar que exista el boton enviar
if (isset($_POST["buttonInsertUser"])) {

    date_default_timezone_set('America/Mexico_City');
    $todayDateInput = date("Y-m-d");
    $colaboratorSelect = $_POST["selectColaborador"];
    var_dump($_FILES['imgUser']);
    $imagenUserField = $_POST["imgUser"];
    if ($imagenUserField === "") {
        $imagenUserField = '/resources/User/default.png';
    } else {
        $imagenUserField = '/resources/User/' . $_FILES['imgUser']['name'];
    }
    $usernameInput = $_POST["txt_username"];
    $emailInput = $_POST["txt_email"];
    $passwordInput = $_POST["txt_password"];
    $statuSelect = $_POST["selectStatus"];
    $roleSelect = $_POST["selectRoles"];

    $uploads_dir = '../../resources/User/';  // Ruta de la carpeta de destino para los archivos
    $permisoUSR = isset($privilegios["USER"]) && $privilegios["USER"];
    if ($permisoUSR) {
        //Caso contrario Guardara
        $stmt = $conn->prepare("CALL sp_insertUser(?,?,?,?,?,?,?,?)");

        // Mandamos los parametros y los input que seran enviados al PA O SP
        $stmt->bind_param("ssssssss", $todayDateInput, $usernameInput, $emailInput, $passwordInput, $colaboratorSelect, $statuSelect, $imagenUserField, $roleSelect);
        // $query = "CALL sp_insertUser('$todayDateInput', '$usernameInput', '$emailInput', '$passwordInput', '$colaboratorSelect', '$statuSelect', '$imagenUserField', '$roleSelect');";
        // echo $query;

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
            echo '<script > toastr.success("Los datos de <b>' . $usernameInput . '</b> se Guardaron de manera exitosa.", "¡¡Enhorabuena!!"); ';
            echo 'setTimeout(function() {';
            echo '  window.location.href = "view_user.php";';
            echo ' }, 2000); // 2000 milisegundos = 2 segundos de retraso ';
            echo 'document.getElementById("formInsertCMP").reset(); ';
            echo '</script>';
              // Comprobar si el archivo ya existe
              if (file_exists($uploads_dir . $_FILES['imgUser']['name'])) {
                echo '<script > toastr.info("La imagen ya existe")</script>;';
                $uploadOk = 0; //si existe lanza un valor en 0
            } else {
                move_uploaded_file($_FILES['imgUser']['tmp_name'], $uploads_dir. $_FILES['imgUser']['name']);
                
            }
           
        } else {
            echo '<script > toastr.error(" No se pudo guardar recuerda que tiene que tener un Username unico. ' . $usernameInput . '","¡¡UPS!!");
        </script>';
            //  echo '<script>setTimeout(function() { location.reload(); }, 2000);</script>' 
        }
    }
}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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
    $("#imgUser").change(function() {
        readURL(this);
    });

    // Vincula el input de búsqueda con el select ded models 
    $(document).ready(function() {
        $('#txt_busqueda').on('keyup', function() {
            var texto = $(this).val().toLowerCase();

            $('#selectColaboratos option').each(function() {
                var opcion = $(this).text().toLowerCase();
                var mostrar = opcion.indexOf(texto) > -1;
                $(this).toggle(mostrar);
            });

            // Si no hay opciones visibles, selecciona la opción 1
            var opcionesVisibles = $('#selectColaboratos option:visible');
            if (opcionesVisibles.length === 0) {
                $('#selectColaboratos').val('1');
            }
        });
    });
</script>

<?php
require_once "../templates/footer.php";
?>