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
                                <input type="hidden" class="form-control" id="cmpId" name="cmpId" value="<?php echo $CMP_idTbl_Computer ?>">

                                <!--  Primer Row DE LA IZQUIERDA-->
                                <div class="row" style="padding-top:10px; padding-bottom:10px;">
                                    <div class="col-sm-6">
                                        <!-- Image -->
                                        <div class="form-group" style="padding-left:15px;" >
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

                                        <!-- USERNAME -->
                                        <div class="form-group"  style="padding-left:15px; padding-top:2.5px;">
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
                                            <select class="form-control" id="sltStatus" name="sltStatus">
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
                                            <button type="button" class="btn btn-block bg-olive" onclick='return validate_data();'>Actualizar</button>
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


<script>
    $(function() {
        $(".datepicker-input").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });
</script>