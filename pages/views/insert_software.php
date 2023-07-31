<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";
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

    function validate_data() {
        let nameInput = document.getElementById('txt_nameSft').value;
        let
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
                            if ($PermisoUSER) {
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

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline card-tabs">
                        <div class="card-header">
                            <h3 class="card-title">Formulario para Añadir <?php echo $pageName; ?> </h3>
                        </div>
                        <form action="" method="post" name="formInsertSFT" id="formInsertSFT" class="form-horizontal" enctype="multipart/form-data">
                            <div class="card-body">
                                <label class="form-check-label" style="padding-bottom: 5px;"> A continuación se le pedirá que <b> Ingrese</b> los siguientes datos:</label>

                                <!-- Input ocultos  -->
                                <input type="hidden" class="form-control" id="todayDate" name="todayDate" placeholder="<?php echo $todayDate; ?>">
                                <input type="hidden" class="form-control" id="accion" name="accion" placeholder="">

                                <div class="row justify-content-center" style="padding-top:10px; padding-bottom:10px;">
                                    <!-- IMAGEN -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <!-- style="text-align: center;  display: block;  margin: 0 auto;" -->
                                            <label>Imagen: </label>

                                            <div class="input-group" style=" display: flex;   justify-content: center;   align-items: center;   height: 200px;">
                                                <img class="img-fluid" src="../../resources/Software/default.jpg" width="150" height="150" id="imgPerfil">
                                                <input type="file" name="imgSFT" id="imgSFT" accept="image/png,image/jpeg" style=" margin-left: 20px;text-align: center;">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- nombre -->
                                    <div class="col-sm-3">
                                        <div class="form-group" style="padding-top: 70px;">
                                            <label>Nombre Software:</label>
                                            <input type="text" class="form-control" name="txt_nameSft" id="txt_nameSft" maxlength="45" required>
                                        </div>
                                    </div>

                                    <!-- version -->
                                    <div class="col-sm-2">
                                        <div class="form-group" style="padding-top: 70px;">
                                            <label>Versión Software:</label>
                                            <input type="text" class="form-control" name="txt_VersionSft" id="txt_VersionSft" maxlength="25" required>
                                        </div>
                                    </div>

                                    <!-- Tipo de software  -->
                                    <div class="col-sm-2" style="padding-top: 70px;">
                                        <div class="form-group">
                                            <label>Tipo De software: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_Select_SoftwareType()"); ?>
                                            <select class="form-control" id="slct_SftType" name="slct_SftType">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['STP_idTbl_Software_Type']; ?>"><?php echo $row['STP_Description']; ?></option>
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
                                    <!-- Fabricante  -->
                                    <div class="col-md-2 " style="padding-top: 70px;">
                                        <div class="form-group">
                                            <label>Fabricante: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_manufacturerSoft_Select()"); ?>
                                            <select class="form-control select2bs4" style="width: 100%;" id="slct_manufacturerSftType" name="slct_manufacturerSftType">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['MFS_idtbl_manufacturer_software']; ?>"><?php echo $row['MFS_Description']; ?></option>
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
                                    <!-- <div class="col-sm-2" style="padding-top: 50px;">
                                        <div class="form-group">
                                            <label>Fabricante: </label>
                                            <input type="text" id="searchManufacturer" placeholder="Buscador para fabricantes: " class="form-control">
                                            <?php $resultado = mysqli_query($conn, "CALL sp_manufacturerSoft_Select()"); ?>
                                            <select class="form-control" id="slct_manufacturerSftType" name="slct_manufacturerSftType">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['MFS_idtbl_manufacturer_software']; ?>"><?php echo $row['MFS_Description']; ?></option>
                                                <?php }
                                                #NOTA
                                                #CADA QUE QUIERA HACER UNA NUEVA CONSULTA CON PROCEDIMIENTOS ALMACENADOS ESTOS EL RESULTADO SE CIERRA Y LA VARIABLE DE LA CONECCION SE PREPARA PARA EL NUEVO RESULTADO
                                                # QUE TENDRA ABAJO
                                                $resultado->close();
                                                $conn->next_result();
                                                ?>
                                            </select>
                                        </div>
                                    </div> -->

                                </div> <!-- Fin fila 1 -->

                                <div class="row">
                                    <!-- Licencia/Serial -->
                                    <div class="col-sm-3">
                                        <div class="form-group" style="padding-top: 20px;">
                                            <label>Licencia / Serial:</label>
                                            <input type="text" class="form-control" name="txt_licenciaSft" id="txt_licenciaSft" maxlength="45" required>
                                        </div>
                                    </div>

                                    <!-- clasificacion de licencia  -->
                                    <div class="col-sm-3" style="padding-top: 20px;">
                                        <div class="form-group">
                                            <label>Clasificación de Licencia: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_select_licence_clasificatioion()"); ?>
                                            <select class="form-control" id="slct_licenceClasification" name="slct_licenceClasification">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['LC_idTbl_License_Clasification']; ?>"><?php echo $row['LC_Description']; ?></option>
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

                                    <!-- categoria  -->
                                    <div class="col-sm-3" style="padding-top: 20px;">
                                        <div class="form-group">
                                            <label>Categoria: </label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_selectCategory()"); ?>
                                            <select class="form-control select2bs4 " id="slct_category" name="slct_category">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['CTG_idTbl_Category']; ?>"><?php echo $row['CTG_Description']; ?></option>
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
                                        <div class="form-group" style="padding-top: 20px;">
                                            <label>Observaciones: </label>
                                            <textarea type="text" class="form-control" name="txt_observation" id="txt_observation" maxlength="60"> </textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-center" style="padding-bottom:20px;">
                                    <div class="col-mb-3">
                                        <button type="submit" class="btn btn-block btn-info" id="buttonInsertSFT" name="buttonInsertSFT">Guardar</button>
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
</section>
</div>

<?php
require_once "../templates/footer.php";
?>


<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });
</script>