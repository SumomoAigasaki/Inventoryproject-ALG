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

                                    <div class="col-sm-4" style="padding-top: 10px;">
                                        <div class="form-group">
                                            <!-- Fecha de Instalacion Software -->
                                            <label ACRONYM title="Fecha en que se hizo el reporte"> Fecha de Reporte:</label>
                                            <input type="text" class="form-control datepicker-input" name="txtDateAdmision" id="txtDateAdmision">
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

                                      <!-- Numero de Reporte-->
                                      <div class="col-sm-4">
                                        <div class="form-group" style="padding-top: 10px;">
                                            <label>Numero de Reporte:</label>
                                            <input type="text" class="form-control" name="txtNumberApplications" id="txtNumberApplications" maxlength="45" placeholder="ASSET2023-0#">
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
    $(function() {
        $(".datepicker-input").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });
</script>