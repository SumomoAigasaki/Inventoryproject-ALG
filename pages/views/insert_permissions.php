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
            window.location.href = '<?php echo BASE_URL ?>pages/views/view_software.php';
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
                            if ($PermisoSTF) {
                                // Agregar la ruta al array $arrayAdd
                                $ruta = "../views/view_permissions.php";
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
                        <form action="" method="post" name="formInsertUSP" id="formInsertUSP" class="form-horizontal" enctype="multipart/form-data">
                            <div class="card-body">
                                <label class="form-check-label" style="padding-bottom: 5px;"> A continuación se le pedirá que <b> Ingrese</b> los siguientes datos:</label>

                                <!-- Input ocultos  -->
                                <input type="hidden" class="form-control" id="todayDate" name="todayDate">
                                <input type="hidden" class="form-control" id="accion" name="accion" placeholder="">

                                <!-- Input para guardar la lista del modulo a guardar -->
                                <input type="hidden" class="form-control" id="txtIdModule" name="txtIdModule" placeholder="">
                                <input type="hidden" class="form-control" id="txtIdPrivilege" name="txtIdPrivilege" placeholder="">


                                <!-- Fila 1 -->
                                <div class="row justify-content-center" style="padding-top:10px; padding-bottom:10px;">

                                    <!-- ROL-->
                                    <div class="col-sm-2">
                                        <div class="form-group" style="padding-top: 10px;">
                                            <label><code> * </code>Rol:</label>
                                            <!-- <input type="text" class="form-control" id="txt_busqueda" name="txt_busqueda" placeholder="Buscar Colaborador">
                                            <?php $resultado = mysqli_query($conn, "CALL sp_rolesSelect()"); ?> -->
                                            <select class="form-control select2bs4" id="slctRoles" name="slctRoles">
                                                <option value="0">0.- Empty/Vacio</option>
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

                                    <!-- Modulo-->
                                    <div class="col-sm-4">
                                        <div class="form-group" style="padding-top: 10px;">
                                            <label><code> * </code>Modulo:</label>
                                            <div class="select2-primary">
                                                <select id="slctModule" name="slctModule" class="select2" multiple="multiple" data-placeholder="Selecciona los Modulos" style="width: 100%;">
                                                    <?php $resultado = mysqli_query($conn, "CALL sp_moduleSelect()"); ?>

                                                    <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                        <option value="<?php echo $row['MDU_idtbl_Module']; ?>"><?php echo $row['MDU_Descriptions']; ?></option>
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
                                    <!-- Privilegios-->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><code> * </code> Privilegios:</label>
                                            <?php $resultado = mysqli_query($conn, "CALL sp_privilegesAllSelect()"); ?>

                                            <select class="duallistbox" multiple="multiple" id="slctprivileges" name="slctprivileges">
                                                <?php while ($row = mysqli_fetch_array($resultado)) { ?>
                                                    <option value="<?php echo $row['PRV_idTbl_Privileges']; ?>" data-module="<?php echo $row['MDU_idtbl_Module']; ?>"><?php echo $row['PRV_Name']; ?></option>
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

                                <!-- Fila 2 -->
                                <div class="row justify-content-center" style="padding-top:10px; padding-bottom:10px;">


                                    <div class="row justify-content-center" style="padding-bottom:20px;">
                                        <div class="col-mb-3">
                                            <button type="submit" class="btn btn-block btn-info" id="buttonInsertUSP" name="buttonInsertUSP" onclick='return validate_data();'>Guardar</button>
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
<script>

</script>
<?php
require_once "../templates/footer.php";
?>
<!-- Validaciones generales sobre llenado de txt -->
<script>
    var customArray = [];

    // Para agregar valores en IDMODULO
    $('#slctModule').on('select2:select', function(e) {
        var data = e.params.data;

        // Verificar si el elemento ya está en el array
        var index = customArray.findIndex(function(element) {
            return element.id === data.id;
        });

        // Si no está en el array, agregarlo
        if (index === -1) {
            customArray.push({
                id: data.id
            });
        }

        console.log(customArray);
        $('#txtIdModule').val(JSON.stringify(customArray));
        // Llamar a recorrerArray después de actualizar txtIdModule
        recorrerArray();
    });

    // para quitar valores deseleccionados en modulos
    $('#slctModule').on('select2:unselect', function(e) {
        var data = e.params.data;

        // Encontrar el índice del elemento deseleccionado y eliminarlo del array
        var index = customArray.findIndex(function(element) {
            return element.id === data.id;
        });

        if (index !== -1) {
            customArray.splice(index, 1);
        }

        console.log(customArray);
        $('#txtIdModule').val(JSON.stringify(customArray));

        // Llamar a recorrerArray después de actualizar txtIdModule
        recorrerArray();
    });


    function recorrerArray() {
        const txtIdModuleValue = document.getElementById("txtIdModule").value;
        const customArray = JSON.parse(txtIdModuleValue);
        const privilegiosSelect = document.getElementById("slctprivileges");
        const modulosSeleccionados = new Set();

        // Recopilar todos los módulos seleccionados en un conjunto
        customArray.forEach(function(element) {
            modulosSeleccionados.add(element.id);
        });

        // Iterar sobre las opciones y mostrar aquellas que estén en el conjunto de módulos seleccionados
        for (let i = 0; i < privilegiosSelect.options.length; i++) {
            const option = privilegiosSelect.options[i];
            if (modulosSeleccionados.has(option.getAttribute("data-module")) || option.value === "") {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        }
    }

    $(document).ready(function() {
        // Inicializa el componente Dual Listbox para el select #slctprivileges
        var demo1 = $('select[name="slctprivileges"]').bootstrapDualListbox();

        // Variable para almacenar los IDs seleccionados
        var array = [];

        // Función para actualizar el campo de texto
        function actualizarCampoTexto() {
            // Obtiene los elementos seleccionados en el Dual Listbox del select #slctprivileges
            var selectedOptions = demo1.val();

            if (selectedOptions.length > 0) {
                // Reinicia el array en cada cambio para evitar duplicados
                array = [];

                // Recorre los valores seleccionados y agrega los IDs al array
                selectedOptions.forEach(function(optionValue) {
                    var moduleValue = $('select[name="slctprivileges"] option[value="' + optionValue + '"]').data('module');
                    var obj = {
                        "id": optionValue,
                        "module": moduleValue
                    };
                    array.push(obj);
                });

                // Convierte el array a una cadena JSON
                var arrayTexto = JSON.stringify(array);

                // Actualiza el valor del campo de texto con la cadena JSON
                $('#txtIdPrivilege').val(arrayTexto);
            } else {
                // Si no hay opciones seleccionadas, borra el valor del campo de texto
                $('#txtIdPrivilege').val('');
            }
        }

        // Agrega un manejador de evento para el cambio en el select #slctprivileges
        $('#slctprivileges').on('change', function() {
            // Llama a la función para actualizar el campo de texto
            actualizarCampoTexto();
        });

        // Llama a la función al cargar la página para mostrar las opciones seleccionadas inicialmente
        actualizarCampoTexto();
    });
</script>

<!-- Validaciones de cajas vacias  -->
<script>
    // Función para validar los datos ingresados en el formulario
    function validate_data() {
        let rolesSlct = document.getElementById("slctRoles");
        let moduleSlct = document.getElementById("slctModule");
        let modulotxt = document.getElementById("txtIdModule");
        let privilegesSlct = document.getElementById("slctprivileges");
        let optiones = document.getElementsByName("slctprivileges_helper2");


        if (rolesSlct.selectedIndex == 0) {
            toastr.warning('No ha Seleccionado ningun <b>Rol</b> esta vacio(a).<br>Por favor Ingrese una Rol valida');
            rolesSlct.focus();
            return false;
        } else if (modulotxt.value.trim() === "") {
            toastr.warning('No ha Seleccionado ningun <b>Modulo</b> esta vacio(a).<br>Por favor Ingrese una Modulo valida');
            moduleSlct.focus();
            return false;
        }

        let selectedOptions = Array.from(privilegesSlct.selectedOptions);
        if (selectedOptions.length == 0) {
            // alert('Ninguna opción ha sido seleccionada.');
            toastr.warning('No ha seleccionado ningun <b>Privilegios</b> esta vacio(a).<br>Por favor Ingrese una Privilegios valida');
            privilegesSlct.focus();
            return false;
        } else {
            // Si no hay errores, procesa los datos enviados
            if (accionInput.value.trim() === "") {
                accionInput.value = "1";
            }

            document.getElementById("formInsertUSP").submit();
            setTimeout(function() {
                console.log("Después de 2 segundos");
            }, 10000);

        }
    }
</script>
<!-- Variables para que funcionen -->
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox();
</script>

<?php
if (isset($_POST["buttonInsertUSP"])) {
    $rolId = $_POST["slctRoles"];
    $ListIdModulo = $_POST["txtIdModule"];
    // Decodifica la cadena JSON en un array de PHP
    //idsModulos es la variable para la lista de codigos seleccionados
    $idsModulos = json_decode($ListIdModulo);

    $ListIdPrivileges = $_POST["txtIdPrivilege"];
    // Decodifica la cadena JSON en un array de PHP
    //idsprivilegios es la variable para la lista de codigos seleccionados
    $idsPrivileges = json_decode($ListIdPrivileges, true);

    date_default_timezone_set('America/Mexico_City');
    $todayDate = date("Y-m-d");
    $user = $_SESSION["User_idTbl_User"];
    $status = '2';
    // PermisoPCA
    if ($PermisoRLS) {
        //Caso contrario Guardara
        foreach ($idsPrivileges as $item) {
            $privilegioID = $item['id'];
            $moduloID = $item['module'];

            $stmt = $conn->prepare("CALL sp_insertUserPriveleges(?,?,?,?,?,?)");
            // $query = "insert into( '$rolId', '$moduloID', '$privilegioID','$todayDate','$status','$user' );";
            // echo $query;
            // echo"";
            $stmt->bind_param("ssssss", $rolId, $moduloID, $privilegioID, $todayDate, $status, $user);


            // Ejecutar el procedimiento almacenado
            $stmt->execute();
            if ($stmt->error) {
                error_log("Error en la ejecución del procedimiento almacenado: " . $stmt->error);
            }
            // Obtener el valor de la variable de salida
            $stmt->bind_result($answerExistsUSP);
            $stmt->fetch();
            $stmt->close();
            $conn->next_result();
        }
        if ($answerExistsUSP > 0) {
            echo '<script > toastr.success("Los datos de <b>' . $rolId . '</b> se Guardaron de manera exitosa.", "¡¡Enhorabuena!!"); ';
            echo 'setTimeout(function() {';
            echo '  window.location.href = "view_permissions.php";';
            echo ' }, 2000); // 2000 milisegundos = 2 segundos de retraso ';
            echo 'document.getElementById("formInsertUSP").reset(); ';
            echo '</script>';
            exit;
        }
    }
    try {
    } catch (mysqli_sql_exception $e) {
    }
}
?>