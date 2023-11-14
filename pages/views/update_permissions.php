<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";

$id = $_GET['p'];

// Preparar la llamada al procedimiento almacenado
$stmt = $conn->query("CALL sp_selectPermissions('$id')");
$existingModule = array();
$savedModuleIdList = array();
$savedPrivilegeIdList  = array(); // Aquí almacenaremos los datos de la segunda consulta
$existingUSPID = array();

while ($row = $stmt->fetch_assoc()) {

    //Lista de ID USP 
    $usplista = array(
        "idUSP" => $row['USP_IDtbl_user_privileges']
    );
    $existingUSPID[] = $usplista;
    $USP_IDtbl_user_privileges = $row['USP_IDtbl_user_privileges'];
    //ID DE ROL
    $RLS_idTbl_Roles = $row['RLS_idTbl_Roles'];

    //LISTA DE MODULOS
    $moduloLista = array(
        "idModulo" => $row['MDU_idtbl_Module']
    );
    $existingModule[] = $moduloLista;

    //OBTENER UNA LISTA DE LOS ID REPETIDOS

    // Obtener elementos que se repiten una vez en el array existingModule
    $repeatedModuleValues = array_count_values(array_column($existingModule, 'idModulo'));
    // Acceder a las claves y almacenarlas en una variable

    //LISTA de ID MODULOS SIN REPETIR
    $savedModuleIdList = array_keys($repeatedModuleValues);

    //LISTA DE PRIVILEGIOS 
    $privilegesLista = array(
        "idUSP" => $row['USP_IDtbl_user_privileges'],
        "PRV_idTbl_Privileges"  => $row["PRV_idTbl_Privileges"],
        "MDU_idtbl_Module" => $row['MDU_idtbl_Module']
    );
    $savedPrivilegeIdList[] = $privilegesLista;
}
$stmt->close();
$conn->next_result();

// echo "<pre>";
// echo "<p>* ID de USP: </p>";
// print_r($existingUSPID);
// echo "<p>* ID de ROL: " . $RLS_idTbl_Roles . "</p>";
// echo "<p>* Lista de Modulos: </p>";
// print_r($repeatedModuleValues);

// echo "<p>* ID de los modulos</p>";  // Imprimir las claves almacenadas
// print_r($savedModuleIdList);
// echo "<p>* Modulos: </p>";
// print_r($existingModule);
// echo "<p>* Privilegios: </p>";
// print_r($savedPrivilegeIdList);
// echo "</pre>";
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
                            if ($PermisoRLS) {
                                // Agregar la ruta al array $arrayAdd
                                $ruta = "../views/view_permissions.php";
                                $arrayAdd[] = $ruta;

                                // Crear el botón con la ruta almacenada en la variable
                                echo "<a href=\"$ruta\"><button button type='button' class='btn btn-block bg-olive'></i><span class='fa fa-arrow-circle-left'></span>   Volver</button></a>";
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

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success card-outline card-tabs">
                        <div class="card-header">
                            <h3 class="card-title">Formulario para <?php echo $pageName; ?> </h3>
                        </div>
                        <form action="" method="post" name="formUpdateUSP" id="formUpdateUSP" class="form-horizontal" enctype="multipart/form-data">
                            <div class="card-body">
                                <label class="form-check-label" style="padding-bottom: 5px;"> A continuación se le mostrara el formulario con información tenga <b> cuidado</b> al momento de presionar el boton:</label>

                                <!-- Input ocultos  -->
                                <input type="hidden" class="form-control" id="todayDate" name="todayDate">
                                <input type="hidden" class="form-control" id="accion" name="accion" placeholder="">
                                <input type="hidden" class="form-control" id="TxtIdUSP" name="TxtIdUSP" value="<?php echo $USP_IDtbl_user_privileges ?>">
                                <!-- <input type="hidden" class="form-control" id="TxtIdUSP" name="TxtIdUSP" value="<?php
                                                                                                                    if (is_array($existingUSPID)) {
                                                                                                                        foreach ($existingUSPID as $array) {
                                                                                                                            echo implode(',', $array) . ',';
                                                                                                                        }
                                                                                                                    } else {
                                                                                                                        echo $existingUSPID;
                                                                                                                    }
                                                                                                                    ?>"> -->
                                <!-- Input oculto MODULO -->
                                <input type="hidden" class="form-control" id="txtIdModule" name="txtIdModule" placeholder="">
                                <!-- Input oculto PRIVILEGIOS -->
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
                                                <?php while ($row = mysqli_fetch_array($resultado)) {
                                                    $select = ($RLS_idTbl_Roles == $row['RLS_idTbl_Roles']) ? "selected=selected" : "";
                                                ?>
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

                                    <!-- Modulo-->
                                    <div class="col-sm-4">
                                        <div class="form-group" style="padding-top: 10px;">
                                            <label><code> * </code>Modulo:</label>
                                            <div class="select2-primary">
                                                <select id="slctModule" name="slctModule" class="select2" multiple="multiple" data-placeholder="Selecciona los Modulos" style="width: 100%;">
                                                    <?php $resultado = mysqli_query($conn, "CALL sp_moduleSelect()"); ?>
                                                    <?php while ($row = mysqli_fetch_array($resultado)) {
                                                        $selected = in_array($row['MDU_idtbl_Module'], $savedModuleIdList) ? 'selected' : '';
                                                    ?>

                                                        <option value="<?php echo $row['MDU_idtbl_Module']; ?>" <?php echo $selected; ?>><?php echo $row['MDU_Descriptions']; ?></option>
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
                                                <?php while ($row = mysqli_fetch_array($resultado)) {
                                                    $selected = in_array($row['PRV_idTbl_Privileges'], array_column($savedPrivilegeIdList, 'PRV_idTbl_Privileges')) ? 'selected' : ''; ?>
                                                    <option value="<?php echo $row['PRV_idTbl_Privileges']; ?>" data-module="<?php echo $row['MDU_idtbl_Module']; ?>" <?php echo $selected; ?>> <?php echo $row['PRV_Name']; ?></option>
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
                                            <button type="submit" class="btn btn-block bg-olive" id="buttonUpdateUSP" name="buttonUpdateUSP" onclick='return validate_data();'>Actualizar</button>
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
</div>
<!-- Validaciones generales sobre llenado de txt -->
<script>
    // Cuando el documento HTML está completamente cargado...
    $(document).ready(function() {

        var moduleSlct = $('select[name="slctModule"]').select2();
        var moduleArray = [];

        function ActualizarCampoModulo() {
            var selectModule = moduleSlct.val();
            if (selectModule.length > 0) {
                moduleArray = [];

                // Recorre los valores seleccionados y agrega los IDs al array

                selectModule.forEach(function(optionValueModule) {
                    var values = {
                        "id": optionValueModule
                    };
                    moduleArray.push(values);
                });

                var arrayModule = JSON.stringify(moduleArray);

                $('#txtIdModule').val(arrayModule);
            } else {
                // Si no hay opciones seleccionadas, borra el valor del campo de texto
                $('#txtIdModule').val('');
            }
        }

        // Agrega un manejador de evento para el cambio en el select #slctprivileges y de #slctModule
        $('#slctModule').on('change', function() {
            // Llama a la función para actualizar el campo de texto
            ActualizarCampoModulo();
            recorrerArray();
        });

        ActualizarCampoModulo();


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





        //Datos extraidos de base de datos 
        //los denominadore datos OLD 
        // Inicializa el componente Dual Listbox para el select #slctprivileges
        var demo1 = $('select[name="slctprivileges"]').bootstrapDualListbox();
        // Inicializa el componente select2 para el select #slctprivileges
        // var moduleSlct = $('select[name="slctModule"]').select2();

        // Variable para almacenar los IDs seleccionados
        var array = [];
        // var moduleArray = [];

        // Función para actualizar el campo de texto
        function actualizarCampoTexto() {
            // Obtiene los elementos seleccionados en el Dual Listbox del select #slctprivileges
            var selectedOptions = demo1.val();
            // var selectModule = moduleSlct.val();

            //&& selectModule.length > 0
            if (selectedOptions.length > 0) {
                // Reinicia el array en cada cambio para evitar duplicados
                array = [];
                // moduleArray = [];

                // Recorre los valores seleccionados y agrega los IDs al array

                // selectModule.forEach(function(optionValueModule) {
                //     var values = {
                //         "id": optionValueModule
                //     };
                //     moduleArray.push(values);
                // });

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
                // var arrayModule = JSON.stringify(moduleArray);

                // Actualiza el valor del campo de texto con la cadena JSON
                //Estos seran los campos de texto antiguos 
                $('#txtIdPrivilege').val(arrayTexto);
                // $('#txtIdModuleOld').val(arrayModule);

            } else {
                // Si no hay opciones seleccionadas, borra el valor del campo de texto
                $('#txtIdPrivilege').val('');
                // $('#txtIdModuleOld').val('');
            }
        }

        // Agrega un manejador de evento para el cambio en el select #slctprivileges y de #slctModule
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

            document.getElementById("formUpdateUSP").submit();
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
if (isset($_POST["buttonUpdateUSP"])) {
    //Declaracion de variables 

    //Varaible para la lista de Ids de la tabla USP
    //Esta variable creo yo que no necesita decodificacion ya que son id normales 
    $idUSP = $_POST["TxtIdUSP"];
    $rolId = $_POST["slctRoles"];

    //Varaible para obtener los valores que estan en el txt oculto que envio con datos codificados json 
    $moduleIdList = $_POST["txtIdModule"];
    $privilegeIdList = $_POST["txtIdPrivilege"];

    // Decodifica la cadena JSON en un array de PHP
    //varibles asignadas para obtener las cadenas decodificadas de los json de los campos ocultos
    $listIdDecodedModule = json_decode($moduleIdList);
    $listIdDecodedPrivilege = json_decode($privilegeIdList);


    date_default_timezone_set('America/Mexico_City');
    $todayDate = date("Y-m-d");
    $user = $_SESSION["User_idTbl_User"];

    $listIdPrivileges = array(); // Inicializa un array para almacenar los IDs

    foreach ($listIdDecodedPrivilege as $cicleValues) {
        $id = $cicleValues->id; // Obtiene el valor del campo 'id' de cada objeto
        $module = $cicleValues->module; // Obtiene el valor del campo 'modulo' de cada objeto
        $listIdPrivilege[] = array('PRVid' => $id, 'MDU_idtbl_Module' => $module); // Agrega el ID con la clave 'id' al array

    }
    $listIdPrivileges[] = $listIdPrivilege;

    // Imprime los IDs obtenidos

    // echo "<pre>";
    // // // echo"<p>lista Decodificada</p>";
    // // // var_dump($listIdDecodedPrivilege);
    // // // var_dump($rolId);
    // echo "<p>IDs de la lista decodificada:</p>";
    // var_dump($listIdPrivilege);
    // echo "<p>Privilegios Previos guardados</p>";
    // print_r($savedPrivilegeIdList);
    // echo "</pre>";
    $indexToRetrieve = 0;
    $answerExistsUSP = 0; // Inicializar la variable antes de su uso

    if ($PermisoRLS) {
        try {
            foreach (array_column($listIdPrivilege, 'PRVid') as $cicleValues) {
                // print_r($cicleValues);
                // Verifica si el valor actual de array_column($listIdPrivilege, 'PRVid') no está presente en el array_column($savedPrivilegeIdList, 'PRV_idTbl_Privileges')

                if (!in_array($cicleValues, array_column($savedPrivilegeIdList, 'PRV_idTbl_Privileges'))) {
                    // Coloca aquí el código que se ejecutará si el valor no está presente en el array
                    //el valor nuevo no esta en la lista antigua  
                    //ACTUALIZAR
                    // echo "<pre>";
                    // echo "<p>Privilegios Previos guardados</p>";
                    // print_r($savedPrivilegeIdList);
                    // echo "</pre>";
                    //metodo para obtener el idUSP
                    // Verificamos si el índice que deseas obtener existe en el array
                    // if (isset($savedPrivilegeIdList[$indexToRetrieve]['idUSP'])) {
                    //     // Si existe, mostramos el valor correspondiente 
                    //     //para obtener el IDUSP
                    //     $idUSP = $savedPrivilegeIdList[$indexToRetrieve]['idUSP'];
                    //     // $idModulo= $savedPrivilegeIdList[$indexToRetrieve]['MDU_idtbl_Module'];
                    //     // echo "<p>El valor del ID correspondiente al índice $indexToRetrieve es: $idUSP</p>";
                    // }

                    //metodo para obtener el idmodulo
                    // Verificamos si el índice que deseas obtener existe en el array
                    if (isset($listIdPrivilege[$indexToRetrieve]['MDU_idtbl_Module'])) {
                        // Si existe, mostramos el valor correspondiente 
                        //para obtener el IDUSP
                        $idModulo = $listIdPrivilege[$indexToRetrieve]['MDU_idtbl_Module'];
                        // echo "<p>El valor del ID correspondiente al índice $indexToRetrieve es: $idModulo</p>";
                    }



                    $STSId = '2';
                    // Verificar el permiso para realizar la operación

                    $stmt = $conn->prepare("CALL sp_updateUserPermissions(?,?,?,?,?,?)");


                    // Vincular los parámetros al procedimiento almacenado
                    $stmt->bind_param("ssssss", $rolId, $idModulo, $cicleValues, $todayDate, $STSId, $user);
                    // $query = "CALL sp_updateUserPermissions( '$rolId','$idModulo','$cicleValues','$todayDate','$STSId','$user');";
                    // echo $query;
                    // Ejecutar el procedimiento almacenado
                    $stmt->execute();

                    if ($stmt->error) {
                        error_log("Error en la ejecución del segundo procedimiento almacenado: " . $stmt->error);
                    }

                    // Obtener el valor de la variable de salida
                    $stmt->bind_result($answerExistsUSP);
                    $stmt->fetch();
                    $stmt->close();
                    $conn->next_result();
                    // echo '<script > toastr.info("Toca Actualizar escogiste un nuevo dato.","¡Hola!  Informacion: 1");</script >';
                }
                $indexToRetrieve++;
            }

            // Identificar las opciones que se deseleccionaron de la lista originar (marcar como "Desinstaladas")
            $optionsToMarkAsUninstalled = array_diff(array_column($savedPrivilegeIdList, 'PRV_idTbl_Privileges'), array_column($listIdPrivilege, 'PRVid'));

            if (!empty($optionsToMarkAsUninstalled)) {
                foreach ($optionsToMarkAsUninstalled as $optionValue) {
                    // Suponiendo que $optionValue es un valor simple en el array
                    // echo "Option Value: " . $optionValue . "<br>";
                    // O realiza alguna operación con $optionValue aquí

                    $stmt = $conn->prepare("CALL sp_disableUserPermission(?,?)");


                    // Vincular los parámetros al procedimiento almacenado
                    $stmt->bind_param("ss", $rolId, $optionValue);
                    // $query = "CALL sp_disableUserPermission( '$rolId','$optionValue');";
                    // echo $query;
                    // Ejecutar el procedimiento almacenado
                    $stmt->execute();

                    if ($stmt->error) {
                        error_log("Error en la ejecución del segundo procedimiento almacenado: " . $stmt->error);
                    }

                    // Obtener el valor de la variable de salida
                    $stmt->bind_result($answerExistsUSP);
                    $stmt->fetch();
                    $stmt->close();
                    $conn->next_result();
                    // echo '<script > toastr.info("Toca marcar un registro como inactivo.","¡Hola!  Informacion: 2");</script >';
                }
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                // if (strpos($e->getMessage(), 'CMP_idTbl_Computer_UNIQUE') !== false) {
                //     // Error de clave duplicada, específicamente para CMP_idTbl_Computer
                //     echo '<script > toastr.error("No se pudo guardar <br> La Computadora proporcionado ya está en uso. Por favor, elige una Computadora diferente.","¡¡UPS!!  Advertencia: 1");';
                //     echo 'var computerId = document.getElementById("slctComputer");';
                //     echo 'computerId.focus();';
                //     echo '</script>';
                // } else {
                //     // Error de clave duplicada para otros campos únicos
                //     echo "Error: Entrada duplicada para uno o más campos únicos. Proporcione valores diferentes.";
                // }
            } else {
                // Manejar otros tipos de errores relacionados con la base de datos
                echo "Error código: " . $e->getCode() . " - " . $e->getMessage();
            }
        }

        // Comprobar si la inserción tuvo éxito
        if ($answerExistsUSP > 0) {
            // Mostrar un mensaje de éxito y redirigir después de 2 segundos
            echo '<script > toastr.success("Los datos del rol con Id <b>' . $rolId . '</b> se Guardaron de manera exitosa.", "¡¡Enhorabuena!!"); ';
            echo 'setTimeout(function() {';
            echo '  window.location.href = "view_permissions.php";';
            echo ' }, 2000); // 2000 milisegundos = 2 segundos de retraso ';
            echo 'document.getElementById("formUpdateUSP").reset(); ';
            echo '</script>';
        }
    }
}
?>