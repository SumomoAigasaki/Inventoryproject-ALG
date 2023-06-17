<?php
require_once "../templates/menu.php";
$permisoCMP = isset($privilegios["CMP"]) && $privilegios["CMP"];

//obtendremos lA VARIABLE QUE PASAMOS POR METODO get 
$idComp = $_GET['p'];

// Preparar la llamada al procedimiento almacenado
$stmt = $conn->query("CALL sp_selectComputer($idComp)");
while ($row = $stmt->fetch_assoc()) {
  // echo '<pre>';
  // print_r($row);
  // echo '</pre>';
  // Obtener el valor de [CMP_Inventory_Date]
  $CMP_idTbl_Computer = $row['CMP_idTbl_Computer'];
  $inventoryDate = $row['CMP_Inventory_Date'];
  $MFC_idTbl_Manufacturer = $row['MFC_idTbl_Manufacturer'];
  $CMP_Image = $row['CMP_Image'];
  //valido si viene nulos o vacios los datos de BD ponga una imagen por default
  if (empty($CMP_Image) || $CMP_Image === null || $CMP_Image == "/resources/Computer/") {
    $CMP_Image = "/resources/Computer/default.jpg";
  }
  $CMP_Technical_Name = $row['CMP_Technical_Name'];
  $MDL_idTbl_Model = $row['MDL_idTbl_Model'];
  $CT_idTbl_Computer_Type = $row['CT_idTbl_Computer_Type'];
  $CMP_Servitag = $row['CMP_Servitag'];
  $CMP_License = $row['CMP_License'];
  $CMP_Motherboard = $row['CMP_Motherboard'];
  $CMP_Acquisition_Date = $row['CMP_Acquisition_Date'];
  $CMP_Warranty_Expiration = $row['CMP_Warranty_Expiration'];
  $CMP_Warranty_Year = $row['CMP_Warranty_Year'];
  $STS_idTbl_Status = $row['STS_idTbl_Status'];
  $LCT_idTbl_Location = $row['LCT_idTbl_Location'];
  $CMP_Observations = $row['CMP_Observations'];
  $CMP_Report = $row['CMP_Report'];
  $User_Username = $row['User_Username'];
  $TG_idtbl_Type_Guarantee = $row['TG_idtbl_Type_Guarantee'];
}
$stmt->close();
$conn->next_result();

$stmt = $conn->query("CALL sp_imgCMP($idComp)");
// Obtener las imágenes y almacenarlas en un array
$imagenes = array();
while ($fila = $stmt->fetch_assoc()) {
  $imagenes[] = $fila['CMP_Image'];
  $imagenes[] = $fila['CMP_Report'];
}
$primerImagenMostrada = false;

$stmt->close();
$conn->next_result();

?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
<script src="../../public/jquery/jquery.min.js"></script>
<script src="../../public/js/toastr.min.js"></script>

<script type="text/javascript">
  // Función para validar los datos ingresados en el formulario
  function validate_data() {

    var accionInput = document.getElementById('accion');
    var acquisitionFecha = document.getElementById('acquisitionDate');
    var manufacturerSelect = document.getElementById('manufacturerSelect');
    var modelSelect = document.getElementById('modelSelect');
    var computerTypesSelect = document.getElementById('computerTypes');
    var nombreInput = document.getElementById('nombre');
    var servitagInput = document.getElementById('servitag');
    var warrantyExpirationInput = document.getElementById('warrantyExpiration');
    var yearExpirationInput = document.getElementById('yearExpiration');
    var licenceInput = document.getElementById('licence');
    var statusSelect = document.getElementById('status');
    var locationsSelect = document.getElementById('locations');
    var todayDateInput = document.getElementById('todayDate');


    if (acquisitionFecha.value.trim() === "") {
      console.log("dentro de fecha");
      toastr.warning("La <b>Fecha de Compra</b> esta vacio(a).<br>Por favor Ingrese una fecha valida");
      acquisitionFecha.focus();
    } else if (manufacturerSelect.selectedIndex == 0) {
      console.log("dentro de Marca");
      toastr.warning('La <b>Marca</b> esta vacio(a).<br>Por favor Ingrese una Marca valida');
      manufacturerSelect.focus();
    } else if (modelSelect.value == 1) {
      console.log("dentro de model");
      toastr.warning('El <b>Modelo</b> esta vacio(a).<br>Por favor Ingrese un Modelo valida');
      modelSelect.focus();
    } else if (computerTypesSelect.selectedIndex == 0) {
      console.log("dentro de tipo de computadora");
      toastr.warning('El <b>Tipo de computadora</b> esta vacio(a).<br>Por favor Ingrese un tipo de computadora valido');
      computerTypesSelect.focus();
    } else if (nombreInput.value.trim() === "") {
      console.log("dentro de nombre tecnico");
      toastr.warning('El <b>Nombre técnico</b> esta vacio(a).<br>Por favor Ingrese un Nombre valido');
      nombreInput.focus();
    } else if (servitagInput.value.trim() === "") {
      console.log("dentro de servitag");
      toastr.warning('El <b>Servitag</b> esta vacio(a).<br>Por favor Ingrese una servitag valido');
      servitagInput.focus();
    } else if (warrantyExpirationInput.value.trim() === "") {
      console.log("dentro de fehca limite");
      toastr.warning('La <b>Fecha Límite Garantía</b> esta vacio(a).<br>Por favor Ingrese una Fecha Límite Garantía valida');
      warrantyExpirationInput.focus();
    } else if (yearExpirationInput.value.trim() === "") {
      toastr.warning('El <b>Año Limite Garantía</b> esta vacio(a).<br>Por favor Ingrese una Año Limite Garantía valida');
      yearExpirationInput.focus();
    } else if (licenceInput.value.trim() === "") {
      toastr.warning('La <b>Lincencia</b> esta vacio(a).<br>Por favor Ingrese una Lincensia valida');
      licenceInput.focus();
    } else if (statusSelect.selectedIndex == 0) {
      toastr.warning('El <b>Estado del Computador</b> esta vacio(a).<br>Por favor Ingrese una Estado del Computador valida');
      statusSelect.focus();
    } else if (locationsSelect.selectedIndex == 0) {
      toastr.warning('La <b>Localizacion del Computador</b> esta vacio(a).<br>Por favor Ingrese una Localizacion del Computador valida');
      locationsSelect.focus();
    } else {
      // Si no hay errores, procesa los datos enviados
      //$opcion = $_POST['opciones'];
      if (accionInput.value.trim() === "") {
        accionInput.value = "2";

      }
      document.getElementById("formUpdateCMP").submit();

    }
    return false;
  }

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

  // Función para obtener el anho automaticamente
  function actualizarAnio() {
    var warrantyExpirationInput = document.getElementById('warrantyExpiration');
    var yearExpirationInput = document.getElementById('yearExpiration');

    // Obtener el año a partir de la fecha
    var fecha = new Date(warrantyExpirationInput.value);
    var anio = fecha.getFullYear();

    // Actualizar el valor del campo de entrada del año
    yearExpirationInput.value = anio;
  }
</script>


<!--Validaciones de PHP-->
<?php
// Obtener la ruta completa de la imagen
$uploads_dir = '../../resources/Computer/';  // Ruta de la carpeta de destino para los archivos
if (isset($_POST["accion"])) {
  $accion = $_POST["accion"];
  $cmpId = $_POST["cmpId"];
  $cmpAcquisitionDate = $_POST["acquisitionDate"];
  $cmpIdManufacturer = $_POST['select_manufacturer'];
  $cmpIdModel = $_POST['select_model'];
  $cmpCompType = $_POST['select_computerType'];
  $cmptName = $_POST['txt_nombre'];
  $cmpServitag = $_POST['txt_servitag'];
  $cmpWarrantyExpiration = $_POST['warrantyExpiration'];
  $cmpYearExpiration = $_POST['yearExpiration'];
  $cmpLicence = $_POST['txt_licence'];
  $cmpMotherboard = $_POST['txt_motherboard'];
  $cmpIdStatu = $_POST['select_statu'];
  $cmpIdLocation = $_POST['select_location'];

  if (empty($_FILES['archivo']['name'])) {
    // El campo de imagen está vacío
    $cmpImgComp = $CMP_Image;
  } else {
    // El campo no está vacío
    $cmpImgComp = '/resources/Computer/' . $_FILES['archivo']['name'];
  }


  if (empty($_FILES['imagReport']['name'])) {
    // El campo de imagen está vacío
    $cmpImgCompReport = $CMP_Report;
  } else {
    // El campo no está vacío
    $cmpImgCompReport = '/resources/Computer/' . $_FILES['imagReport']['name'];
  }
  // Obtener la ruta completa de la imagen
  $cmpObservation = $_POST['txt_observation'];
  $cmpeIdGuarate = $_POST['select_typeGuarantee'];
  date_default_timezone_set('America/Mexico_City');
  $todayDate = date("Y-m-d");

  $idUser=$_SESSION["User_idTbl_User"];
  //la opcion 2 es para actualizar y el C-CMP valida que tenga el permiso U-pdate en (CMP)computer
  if ($accion == "2" && $privilegios["U-CMP"]) {
    //llamamos el procedimiento almacemado de actualizar computadora 
    $stmt = $conn->prepare("CALL sp_updateComputer(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    // Mandamos los parametros y los input que seran enviados al PA O SP
    $stmt->bind_param("sssssssssssssssssss", $cmpId, $todayDate, $cmpIdManufacturer, $cmpImgComp, $cmptName, $cmpIdModel, $cmpCompType, $cmpServitag, $cmpLicence, $cmpMotherboard, $cmpAcquisitionDate, $cmpWarrantyExpiration, $cmpYearExpiration, $cmpIdLocation, $cmpIdStatu, $cmpObservation, $cmpImgCompReport, $idUser, $cmpeIdGuarate);
    // Ejecutar el procedimiento almacenado

    $stmt->execute();
    // $query = "CALL sp_updateComputer('$cmpId', '$todayDate', '$cmpIdManufacturer', '$cmpImgComp', '$cmptName', '$cmpIdModel', '$cmpCompType', '$cmpServitag', '$cmpLicence', '$cmpMotherboard', '$cmpAcquisitionDate', '$cmpWarrantyExpiration', '$cmpYearExpiration', '$cmpIdLocation', '$cmpIdStatu', '$cmpObservation', '$cmpImgCompReport', '$idUser', '$cmpeIdGuarate');";
    // echo $query;
    // echo '<pre>';
    if ($stmt->error) {
      error_log("Error en la ejecución del procedimiento almacenado: " . $stmt->error);
    }
    // Obtener el número de filas afectadas por el insert
    $stmt->bind_result($idC);
    $stmt->fetch();
    // echo $idC;

    // Cerrar el statement
    $stmt->close();
    // Avanzar al siguiente conjunto de resultados si hay varios
    $conn->next_result();


    if ($idC > 0) {
      echo '<script>
      toastr.success("Los datos de <b>' . $cmptName . '</b> se actualizaron de manera exitosa con el <b>ID</b> de: ' . $cmpId . '", "¡Enhorabuena!");

      setTimeout(function() {
        window.location.href = "' . BASE_URL . 'pages/views/view_computer.php";
      }, 2000); // 2000 milisegundos = 2 segundos de retraso
    </script>';
      move_uploaded_file($_FILES['archivo']['tmp_name'], $uploads_dir . $_FILES['archivo']['name']);
      move_uploaded_file($_FILES['imagReport']['tmp_name'], $uploads_dir . $_FILES['imagReport']['name']);
    } else {
      echo '<script > toastr.error(" No se pudo realizar la operacion de  Actualizar.","¡¡UPS!!");</script>';
      //  echo '<script>setTimeout(function() { location.reload(); }, 2000);</script>' 
    }
    exit;
  }
}

?>
<div class="content-wrapper">

<!-- Content Header (Page header) -->
<section class="content-header">
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
                        if ($permisoCMP) {
                            // Agregar la ruta al array $arrayAdd
                            $ruta = "../views/view_computer.php";
                            $arrayAdd[] = $ruta;

                            // Crear el botón con la ruta almacenada en la variable
                            echo "<a href=\"$ruta\"><button button type='button' class='btn btn-block btn-primary'></i><span class='fas fa-arrow-circle-left'></span>   Volver</button></a>";
                        }
                        ?>
                        </button>
                    </div>
                    <!--  -->

                    <!-- /.modal-dialog -->
            </div>
            </ol>

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
</section>
<!-- Termina la cinta del nav -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary card-outline card-tabs">
        <div class="card-header">
          <h3 class="card-title">Formulario para Actualizar <?php echo $pageName; ?> </h3>
        </div>

        <!-- form start -->
        <form role="form" action="" method="POST" name="formUpdateCMP" id="formUpdateCMP" class="form-horizontal" enctype="multipart/form-data">
          <div class="card-body">
            <label class="form-check-label" style="padding-bottom: 5px;"> A continuación se le mostrara el formulario con información tenga <b> cuidado</b> al momento de presionar el boton:</label>
            <!-- Input ocultos  -->
            <input type="hidden" class="form-control" id="cmpId" name="cmpId" value="<?php echo $CMP_idTbl_Computer ?>">
            <input type="hidden" class="form-control" id="accion" name="accion" value="2">

            <!--  Primer Row -->
            <div class="row" style="padding-top:10px; padding-bottom:10px;">
              <!--  Carusel de imagenes -->
              <div class="col-sm-6 d-flex justify-content-center align-items-center">
                <?php if (empty($imagenes)) : ?>
                  <!-- Imagen por defecto si $imagenes está vacío -->
                  <img class="img-fluid" src="../../resources/Computer/default.jpg" alt="Imagen por defecto" width='300' height='400'>
                <?php else : ?>
                  <!-- Imagen si $imagenes tiene valores -->
                  <?php foreach ($imagenes as $imagen) : ?>

                    <?php if (!$primerImagenMostrada && !empty($imagen)) : ?>
                      <?php if (!empty($imagenes[0])) : ?>
                        <a href="../..<?php echo $imagenes[0] ?>" data-toggle="lightbox"  data-title="Imagen de Computadora: <?php echo $CMP_Technical_Name; ?>" data-gallery="gallery">
                          <img src="../..<?php echo $imagenes[0] ?>" class="img-fluid" alt="Imagen de Computadora: <?php echo $CMP_Technical_Name; ?>" width="300" height="400" />
                        </a>
                      <?php endif; ?>

                      <!-- Mostrar las demás imágenes en el modal -->
                      <?php foreach ($imagenes as $index => $imagen) : ?>
                        <?php if ($index > 0 && !empty($imagen)) : ?>
                          <a href="../..<?php echo $imagen ?>" data-toggle="lightbox" data-title="Imagen de denuncia: <?php echo $CMP_Technical_Name; ?>" data-gallery="gallery"></a>
                        <?php endif; ?>
                      <?php endforeach; ?>
                      <?php $primerImagenMostrada = true; ?>
                    <?php endif; ?>
                  <?php endforeach; ?>

                  <?php if (!$primerImagenMostrada) : ?>
                    <!-- Imagen por defecto si no se mostró ninguna imagen -->
                    <img class="img-fluid" src="../../resources/Computer/default.jpg" alt="Imagen Computadora" width="300" height="400">
                  <?php endif; ?>
                <?php endif; ?>
              </div>

              <div class="col-sm-3">
                <!-- FECHA DE INVENTARIO -->
                <div class="form-group">
                  <label>Fecha de Inventariado:</label>
                  <div class="input-group">
                    <input type="text" class="form-control datepicker-input" id="todayDate" name="todayDate" value="<?php echo $inventoryDate ?>" require>
                  </div>
                </div>
                <!-- MARCA  -->
                <div>
                  <div class="form-group">
                    <label>Marca: </label>
                    <?php
                    #Se procede a llamar al procedimiento almacenado que se llama sp_manufacturer_select,con la variable que almancena "cnn" la base de datos 
                    $resultado = mysqli_query($conn, "CALL sp_manufacturer_select()"); ?>
                    <select class="form-control" id="manufacturerSelect" name="select_manufacturer" onchange="filtrarModelos()">
                      <?php while ($row = mysqli_fetch_array($resultado)) {
                        $select = ($MFC_idTbl_Manufacturer == $row['MFC_idTbl_Manufacturer']) ? "selected=selected" : "";

                      ?>
                        <option value="<?php echo $row['MFC_idTbl_Manufacturer']; ?>" <?php echo $select; ?>><?php echo $row['MFC_Description']; ?></option>
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


              <div class="col-sm-3">
                <div class="form-group">
                  <!-- Fecha de Compra -->
                  <label>Fecha de Compra:</label>
                  <div class="input-group">
                    <input type="text" class="form-control datepicker-input" name="acquisitionDate" id="acquisitionDate" value="<?php echo $CMP_Acquisition_Date; ?>">
                  </div>
                </div>
                <!-- MODELOS  -->
                <div>
                  <div class="form-group">
                    <label>Modelo : </label>
                    <input type="text" id="lookModels" placeholder="Buscar modelo en especifico" class="form-control">
                    <?php $resultado = mysqli_query($conn, "CALL sp_model_select()"); ?>
                    <select class="form-control" id="modelSelect" name="select_model">
                      <?php while ($row = mysqli_fetch_array($resultado)) {
                        $select = ($MDL_idTbl_Model == $row['MDL_idTbl_Model']) ? "selected=selected" : "";
                      ?>
                        <option value="<?php echo $row['MDL_idTbl_Model']; ?>" <?php echo $select; ?> data-manufacturer="<?php echo $row['MFC_idTbl_Manufacturer']; ?>"><?php echo $row['MDL_Description']; ?></option>
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

            <!-- Comienzo fila 2 -->
            <div class="row">
              <!-- TIPO DE COMPUTADORA -->
              <div class="col-sm-3">
                <div class="form-group">
                  <label>Tipo de Computadora : </label>
                  <?php $resultado = mysqli_query($conn, "CALL sp_computerType_select()"); ?>
                  <select class="form-control" id="computerTypes" name="select_computerType">
                    <?php while ($row = mysqli_fetch_array($resultado)) {
                      $select = ($CT_idTbl_Computer_Type == $row['CT_idTbl_Computer_Type']) ? "selected=selected" : "";
                    ?>
                      <option value="<?php echo $row['CT_idTbl_Computer_Type']; ?>" <?php echo $select; ?>><?php echo $row['CT_Description']; ?></option>
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
              <!-- Nombre Tecnico-->
              <div class="col-sm-3">
                <div class="form-group">
                  <label>Nombre Técnico: </label>
                  <input type="text" class="form-control" name="txt_nombre" id="nombre" maxlength="45" value="<?php echo $CMP_Technical_Name; ?>" placeholder="ASSET2023-0#">
                </div>
              </div>
              <!-- Servitag-->
              <div class="col-sm-2">
                <div class="form-group">
                  <label>Servitag: </label>
                  <input type="text" class="form-control" name="txt_servitag" id="servitag" maxlength="45" value="<?php echo $CMP_Servitag; ?>" placeholder="FKCX???">
                </div>
              </div>

              <!-- Fecha limite garantia -->
              <div class="col-sm-2">
                <div class="form-group">
                  <label ACRONYM title="Fecha Límite de la Garantía">Fec. Lím. Garantía:</label>
                  <div class="input-group">
                    <input type="text" class="form-control datepicker-input " name="warrantyExpiration" id="warrantyExpiration" value="<?php echo $CMP_Warranty_Expiration; ?>" onchange="actualizarAnio()">
                  </div>
                </div>
              </div>
              <!-- Anho limite garantia -->
              <div class="col-2">
                <div class="form-group">
                  <label ACRONYM title="Año Límite de la Garantía">Año: </label>
                  <div class="input-group">
                    <input type="text" class="form-control" min="2000" max="2050" name="yearExpiration" id="yearExpiration" value="<?php echo $CMP_Warranty_Year; ?>" readonly>
                  </div>
                </div>
              </div>
            </div>
            <!-- Comienzo fila 3 -->
            <div class="row" style="padding-bottom:10px;">
              <div class="col-sm-3">
                <div class="form-group">
                  <label>Tipo de Garantia: </label>
                  <?php
                  #Se procede a llamar al procedimiento almacenado que se llama sp_manufacturer_select,con la variable que almancena "cnn" la base de datos 
                  $resultado = mysqli_query($conn, "CALL sp_typeGuarantee_select()"); ?>
                  <select class="form-control" id="typeGuarantee" name="select_typeGuarantee">
                    <?php while ($row = mysqli_fetch_array($resultado)) {

                      $select = ($TG_idtbl_Type_Guarantee == $row['TG_idtbl_Type_Guarantee']) ? "selected=selected" : "";
                    ?>
                      <option value="<?php echo $row['TG_idtbl_Type_Guarantee']; ?>" <?php echo $select; ?>><?php echo $row['TG_Description']; ?></option>
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
              <!-- Lincencia -->
              <div class="col-sm-3">
                <div class="form-group">
                  <label>Licencia: </label>
                  <input type="text" class="form-control" name="txt_licence" id="licence" maxlength="60" value="<?php echo $CMP_License; ?>" placeholder="CMCDN-?????-?????-?????-?????">
                </div>
              </div>
              <!-- Tarjeta Madre -->
              <div class="col-sm-3">
                <div class="form-group">
                  <label>Tarjeta Madre: </label>
                  <input type="text" class="form-control" name="txt_motherboard" id="motherboard" maxlength="60" value="<?php echo $CMP_Motherboard; ?>" placeholder="0W3XW5-A00">
                </div>
              </div>
              <!-- Estado de la computadora  -->
              <div class="col-sm-3">
                <div class="form-group">
                  <label>Estado Computadora: </label>
                  <?php $resultado = mysqli_query($conn, "CALL sp_status_select()"); ?>
                  <select class="form-control" id="status" name="select_statu">
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
            <!-- Comienzo fila 4 -->
            <div class="row" style="padding-bottom:10px;">
              <div class="col-sm-3">
                <!-- Localizacion -->

                <label>Localización Computadora: </label>
                <div class="form-group">
                  <?php $resultado = mysqli_query($conn, "CALL sp_location_select"); ?>
                  <select class="form-control" id="locations" name="select_location">
                    <?php while ($row = mysqli_fetch_array($resultado)) {
                      $select = ($LCT_idTbl_Location == $row['LCT_idTbl_Location']) ? "selected=selected" : "";
                    ?>
                      <option value="<?php echo $row['LCT_idTbl_Location']; ?>" <?php echo $select; ?>><?php echo $row['LCT_Description']; ?></option>
                    <?php }
                    #NOTA
                    #CADA QUE QUIERA HACER UNA NUEVA CONSULTA CON PROCEDIMIENTOS ALMACENADOS ESTOS EL RESULTADO SE CIERRA Y LA VARIABLE DE LA CONECCION SE PREPARA PARA EL NUEVO RESULTADO
                    # QUE TENDRA ABAJO
                    $resultado->close();
                    $conn->next_result();
                    ?>
                  </select>
                </div>
                <div class="form-group" id="imgReport" style="display:none;">
                  <label>Reporte de Extravio/Robo: </label>
                  <input accept="image/png,image/jpeg" type="file" name="imagReport" value="<?php echo $CMP_Report; ?>">
                </div>
              </div>
              <div class="col-sm-4">
                <!-- IMAGEN -->
                <label>Imagen del PC: </label>
                <div class="form-group mb-3">
                  <input accept="image/png,image/jpeg" type="file" name="archivo">
                </div>


              </div>
              <!-- Observaciones -->
              <div class="col-sm-5">
                <div class="form-group  mb-3">
                  <label>Observaciones: </label>
                  <textarea type="text" class="form-control" name="txt_observation" id="observation" maxlength="100" value="<?php echo $CMP_Observations; ?>"> </textarea>
                </div>
                <div class="form-group">
                  <div class="form-check">
                    <input ACRONYM title="Presiona para confirmar que el equipo tiene una denuncia" class="form-check-input" type="checkbox" id="checkReport">
                    <label class="form-check-label">Este equipo tiene Reporté/Denuncia de Extravio</label>
                  </div>
                </div>
              </div>

              <!-- Boton guardar -->

              <!--/. fila 4 -->
            </div>
            <!-- Comienzo fila 5 -->
            <div class="row justify-content-center" style="padding-bottom:10px;">
              <div class="col-mb-3">
                <button type="button" class="btn btn-block bg-olive" onclick='return validate_data();'>Actualizar</button>
              </div>
              <!-- <div class="col-mb-3" style="margin-left: 5px;">
                <button type="button" class="btn btn-block btn-primary" onclick="window.location.href = 'view_computer.php';">Atras</button>
              </div> -->
            </div>
          </div>


      </div>
      </form>
    </div>
  </div>
  </div>
</section>
</div>
</section>
<!-- Ekko Lightbox -->

<script>
  var checkbox = document.getElementById('checkReport');
  var opcionFotos = document.getElementById('imgReport');

  checkbox.addEventListener('change', function() {
    if (checkbox.checked) {
      opcionFotos.style.display = 'block';
    } else {
      opcionFotos.style.display = 'none';
    }
  });

  function filtrarModelos() {
    // Obtener el valor seleccionado en el primer select
    var manufacturerSeleccionado = document.getElementById("manufacturerSelect").value;

    // Obtener todos los options del segundo select
    var opcionesModelos = document.getElementById("modelSelect").options;

    // Obtenr el texto del segundo seletc
    var contenidoModelo = document.getElementsByTagName("option");

    // Recorrer todas las opciones y ocultar las que no pertenecen al fabricante seleccionado
    for (var i = 1; i < opcionesModelos.length; i++) {
      var modelo = opcionesModelos[i];
      if (modelo.getAttribute("data-manufacturer") == manufacturerSeleccionado || manufacturerSeleccionado == "") {
        modelo.style.display = "";
      } else {
        modelo.style.display = "none";
      }
    }

    // Si no hay modelos disponibles para el fabricante seleccionado, mostrar un mensaje en el segundo select
    if (document.querySelectorAll("#modelSelect option[style='display: none;']").length === opcionesModelos.length - 1) {
      document.getElementById("modelSelect").innerHTML = "<option value=''>No hay modelos disponibles para este fabricante</option>";
    }

  }

  $(function() {
    $(".datepicker-input").datepicker({
      dateFormat: "yy-mm-dd"
    });
  });

  // Vincula el input de búsqueda con el select ded models 
  $(document).ready(function() {
    $('#lookModels').on('keyup', function() {
      var texto = $(this).val().toLowerCase();
      $('#modelSelect option').filter(function() {
        return $(this).text().toLowerCase().indexOf(texto) > -1;
      }).prop('selected', true);
    });
  });

  $(function() {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });
  });
</script>

<?php
require_once "../templates/footer.php";
?>