<?php
require_once "../templates/nav.php";
require_once "../templates/menu.php";

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
  $CMP_Serial = $row['CMP_Serial'];
  $CMP_Acquisition_Date = $row['CMP_Acquisition_Date'];
  $CMP_Warranty_Expiration = $row['CMP_Warranty_Expiration'];
  $CMP_Warranty_Year = $row['CMP_Warranty_Year'];
  $STS_idTbl_Status = $row['STS_idTbl_Status'];
  $LCT_idTbl_Location = $row['LCT_idTbl_Location'];
  $CMP_Observations = $row['CMP_Observations'];
  $CMP_Report = $row['CMP_Report'];
  //valido si viene nulos o vacios los datos de BD ponga una imagen por default
  if (empty($CMP_Report) || $CMP_Report === null || $CMP_Report == "/resources/Computer/") {
    $CMP_Report = "/resources/Computer/default.jpg";
  }
  $User_Username = $row['User_Username'];
  $TG_idtbl_Type_Guarantee = $row['TG_idtbl_Type_Guarantee'];
  $OS_idtbl_operatingSystems = $row['OS_idtbl_operatingSystems'];
}
$stmt->close();
$conn->next_result();

// Preparar la llamada al procedimiento almacenado
$stmt = $conn->query("CALL sp_selectComputerDetail($idComp)");
$existingOptions  = array(); // Aquí almacenaremos los datos de la segunda consulta

while ($fila = $stmt->fetch_assoc()) {
  // echo '<pre>';
  // print_r($fila);
  // echo '</pre>';
  $peripheralslista = array(
    "idPeripherals"  => $fila["PRL_idTbl_Peripherals"]
  );
  $existingOptions[] = $peripheralslista;
}
$stmt->close();
$conn->next_result();

// $stmt = $conn->query("CALL sp_imgCMP($idComp)");
// // Obtener las imágenes y almacenarlas en un array
// $imagenes = array();
// while ($fila = $stmt->fetch_assoc()) {
//   $imagenes[] = $fila['CMP_Image'];
//   $imagenes[] = $fila['CMP_Report'];
// }
// $primerImagenMostrada = false;

// $stmt->close();
// $conn->next_result();

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
              if ($PermisoCMP) {
                // Agregar la ruta al array $arrayAdd
                $ruta = "../views/view_computer.php";
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
            <form role="form" action="" method="POST" name="formUpdateCMP" id="formUpdateCMP" class="form-horizontal" enctype="multipart/form-data">
              <div class="card-body">
                <label class="form-check-label" style="padding-bottom: 5px;"> A continuación se le mostrara el formulario con información tenga <b> cuidado</b> al momento de presionar el boton:</label>
                <!-- Input ocultos  -->
                <input type="hidden" class="form-control" id="TxtId" name="TxtId">
                <input type="hidden" class="form-control" id="txtIdComputer" name="txtIdComputer" value="<?php echo $CMP_idTbl_Computer ?>">
                <input type="hidden" class="form-control" id="txtAccion" name="txtAccion" value="2">

                <!--  Primer Row -->
                <div class="row" style="padding-top:10px; padding-bottom:10px;">

                  <div class="col-sm-6 d-flex justify-content-center align-items-center">
                    <!-- Image -->
                    <div class="form-group" style="padding-left:15px;">
                      <label>Imagen de Referencia del pc</label>
                      <div class="input-group" style="flex-direction: column; padding-left:15px; display: flex; justify-content: center; align-items: center;">
                        <img class="img-fluid img" src="../..<?php echo $CMP_Image ?>" width="180" height="180" style="margin: 10px;" id="imgCMP" name="imgCMP">
                        <input accept="image/png,image/jpeg" type="file" name="fileImg" id="fileImg" style="padding-left:15px; padding-top:2.5px;">
                      </div>
                    </div>

                  </div>
                  <!-- 1ERA COLUMAN DE LA ROW 1 -->
                  <div class="col-sm-3">
                    <!-- FECHA DE INVENTARIO -->
                    <div class="form-group">
                      <label>Fecha de Inventariado:</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="todayDate" name="todayDate" value="<?php echo $inventoryDate ?>" readonly>
                      </div>
                    </div>
                    <!-- MARCA  -->
                    <div>
                      <div class="form-group">
                        <label><code>*</code>Marca: </label>
                        <?php
                        #Se procede a llamar al procedimiento almacenado que se llama sp_manufacturer_select,con la variable que almancena "cnn" la base de datos 
                        $resultado = mysqli_query($conn, "CALL sp_manufacturer_select()"); ?>
                        <select class="form-control select2bs4" id="selectManufacturerSelect" name="selectManufacturerSelect" onchange="filtrarModelos()">
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

                  <!-- 2DA COLUMAN DE LA ROW 1 -->
                  <div class="col-sm-3">
                    <div class="form-group">
                      <!-- Fecha de Compra -->
                      <label><code>*</code>Fecha de Compra:</label>
                      <div class="input-group">
                        <input type="text" class="form-control datepicker-input" name="txtAcquisitionDate" id="txtAcquisitionDate" value="<?php echo $CMP_Acquisition_Date; ?>">
                      </div>
                    </div>
                    <!-- MODELOS  -->
                    <div>
                      <div class="form-group">
                        <label><code>*</code>Modelo : </label>
                        <!-- <input type="text" id="lookModels" placeholder="Buscar modelo en especifico" class="form-control">
                        <?php $resultado = mysqli_query($conn, "CALL sp_model_select()"); ?> -->
                        <select class="form-control select2bs4" id="selectModel" name="selectModel">
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
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label><code>*</code>Tipo de Computadora : </label>
                      <?php $resultado = mysqli_query($conn, "CALL sp_computerType_select()"); ?>
                      <select class="form-control select2bs4" id="selectComputerTypes" name="selectComputerTypes">
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
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label><code>*</code>Nombre Técnico: </label>
                      <input type="text" class="form-control" name="txtTechnicalName" id="txtTechnicalName" maxlength="45" value="<?php echo $CMP_Technical_Name; ?>" placeholder="ASSET2023-0#">
                    </div>
                  </div>
                  <!-- Servitag-->
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label><code>*</code>Servitag: </label>
                      <input type="text" class="form-control" name="txtServitag" id="txtServitag" maxlength="45" value="<?php echo $CMP_Servitag; ?>" placeholder="FKCX???">
                    </div>
                  </div>

                  <!-- Tipo de Garantia -->
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label><code>*</code>Tipo de Garantia: </label>
                      <?php
                      #Se procede a llamar al procedimiento almacenado que se llama sp_manufacturer_select,con la variable que almancena "cnn" la base de datos 
                      $resultado = mysqli_query($conn, "CALL sp_typeGuarantee_select()"); ?>
                      <select class="form-control select2bs4" id="selectTypeGuarantee" name="selectTypeGuarantee">
                        <?php while ($row = mysqli_fetch_array($resultado)) {

                          $select = ($TG_idtbl_Type_Guarantee == $row['TG_idtbl_Type_Guarantee']) ? "selected=selected" : "";
                        ?>
                          <option value="<?php echo $row['TG_idtbl_Type_Guarantee']; ?>" <?php echo $select; ?> data-warranty="<?php echo $row['MFC_idTbl_Manufacturer']; ?>"><?php echo $row['TG_Description']; ?></option>
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
                  <!-- Fecha limite garantia -->
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label ACRONYM title="Fecha Límite de la Garantía"><code>*</code>Fec. Lím. Garantía:</label>
                      <div class="input-group">
                        <input type="text" class="form-control datepicker-input " name="txtWarrantyExpiration" id="txtWarrantyExpiration" value="<?php echo $CMP_Warranty_Expiration; ?>" onchange="actualizarAnio()">
                      </div>
                    </div>
                  </div>
                  <!-- Anho limite garantia -->
                  <div class="col-1">
                    <div class="form-group">
                      <label ACRONYM title="Año Límite de la Garantía">Año: </label>
                      <div class="input-group">
                        <input type="text" class="form-control" min="2000" max="2050" name="txtyearExpiration" id="txtyearExpiration" value="<?php echo $CMP_Warranty_Year; ?>" readonly>
                      </div>
                    </div>
                  </div>

                </div>
                <!-- Comienzo fila 3 -->
                <div class="row" style="padding-bottom:10px;">

                  <!-- Lincencia -->
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label><code>*</code>Licencia: </label>
                      <input type="text" class="form-control" name="txtLicense" id="txtLicense" maxlength="60" value="<?php echo $CMP_License; ?>" placeholder="CMCDN-?????-?????-?????-?????">
                    </div>
                  </div>
                  <!-- Serial-->
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label>Serial: </label>
                      <input type="text" class="form-control" name="txtSerial" id="txtSerial" maxlength="60" value="<?php echo $CMP_Serial; ?>" placeholder="0W3XW5-A00">
                    </div>
                  </div>
                  <!-- Sistema Operativo  -->
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label><code>*</code>Sistema Operativo: </label>
                      <?php $resultado = mysqli_query($conn, "CALL sp_selectOperatingSystem()"); ?>
                      <select class="form-control select2bs4" id="slctOS" name="slctOS">
                        <option value="0">Empty/Vacio</option>
                        <?php while ($row = mysqli_fetch_array($resultado)) {
                          $select = ($OS_idtbl_operatingSystems == $row['OS_idtbl_operatingSystems']) ? "selected=selected" : "";
                        ?>
                          <option value="<?php echo $row['OS_idtbl_operatingSystems']; ?>" <?php echo $select; ?>><?php echo $row['INFO']; ?></option>
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
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label><code>*</code>Estado Computadora: </label>
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
                  <!-- Localizacion -->
                  <div class="col-sm-2">
                    <label><code>*</code>Localización Computadora: </label>
                    <div class="form-group">
                      <?php $resultado = mysqli_query($conn, "CALL sp_location_select"); ?>
                      <select class="form-control select2bs4" id="selectLocations" name="selectLocations">
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
                  </div>
                </div>

                <!-- Comienzo fila 4 -->
                <div class="row" style="padding-bottom:10px;">

                  <!-- Especificaciones del Equipo-->
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label><code>*</code>Especificaciones del Equipo:</label>
                      <?php $resultado = mysqli_query($conn, "CALL sp_selectPeripheralsActive()"); ?>
                      <select class="duallistbox" multiple="multiple" id="slctPeripherals" name="slctPeripherals">
                        <?php while ($row = mysqli_fetch_array($resultado)) {
                          $selected = in_array($row['PRL_idTbl_Peripherals'], array_column($existingOptions, 'idPeripherals')) ? 'selected' : ''; ?>
                          <option value="<?php echo $row['PRL_idTbl_Peripherals']; ?>" <?php echo $selected; ?>><?php echo $row['info']; ?></option>
                        <?php }
                        $resultado->close();
                        $conn->next_result();
                        ?>
                      </select>
                    </div>
                  </div>


                  <!-- Observaciones -->
                  <div class="col-sm-4">
                    <div class="form-group  mb-3">
                      <label>Observaciones: </label>
                      <textarea type="text" class="form-control" name="txtObservation" id="txtObservation" maxlength="100"> <?php echo $CMP_Observations; ?></textarea>
                    </div>
                    <div class="form-group">
                      <div class="form-check">
                        <input ACRONYM title="Presiona para confirmar que el equipo tiene una denuncia" class="form-check-input" type="checkbox" id="checkReport">
                        <label class="form-check-label">Este equipo tiene Reporté/Denuncia de Extravio</label>
                      </div>
                    </div>
                  </div>
                  <!-- Imagen de referencia del Reporte Extravio/Robo -->
                  <div class="col-sm-3">
                    <div class="form-group" id="aparthImgReport" style="display:none;">
                      <label>Imagen de referencia del Reporte Extravio/Robo: </label>
                      <img class="img-fluid img" src="../..<?php echo $CMP_Report ?>" width="180" height="180" style="margin: 10px;" id="imgReport" name="imgReport">
                      <input accept="image/png,image/jpeg" type="file" name="fileReport" id="fileReport">
                    </div>
                  </div>

                  <!-- Boton guardar -->

                  <!--/. fila 4 -->
                </div>
                <!-- Comienzo fila 5 -->
                <div class="row justify-content-center" style="padding-bottom:10px;">
                  <div class="col-mb-3">
                    <button type="submit" class="btn btn-block bg-olive" id="buttonUpdateComputer" name="buttonUpdateComputer" onclick='return validate_data();'>Actualizar</button>
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
  // Cuando el documento HTML está completamente cargado...
  $(document).ready(function() {
    // Inicializa el componente Dual Listbox para el select #slctPeripherals
    var demo1 = $('select[name="slctPeripherals"]').bootstrapDualListbox();

    // Variable para almacenar los IDs seleccionados
    var array = [];

    // Función para actualizar el campo de texto
    function actualizarCampoTexto() {
      // Obtiene los elementos seleccionados en el Dual Listbox del select #slctPeripherals
      var selectedOptions = demo1.val();

      // Verifica si hay opciones seleccionadas
      if (selectedOptions.length > 0) {
        // Reinicia el array en cada cambio para evitar duplicados
        array = [];

        // Recorre los valores seleccionados y agrega los IDs al array
        selectedOptions.forEach(function(optionValue) {
          array.push(optionValue);
        });

        // Convierte el array a una cadena JSON
        var arrayTexto = JSON.stringify(array);

        // Actualiza el valor del campo de texto con la cadena JSON
        $('#TxtId').val(arrayTexto);
      } else {
        // Si no hay opciones seleccionadas, borra el valor del campo de texto
        $('#TxtId').val('');
      }
    }
    // Agrega un manejador de evento para el cambio en el select #slctSoftware
    $('#slctPeripherals').on('change', function() {
      // Llama a la función para actualizar el campo de texto
      actualizarCampoTexto();
    });

    // Llama a la función al cargar la página para mostrar las opciones seleccionadas inicialmente
    actualizarCampoTexto();
  });
</script>

<!--Validaciones de PHP-->
<?php
//validacion si preciona el boton  

# En caso de que haya sido el de guardar, no agregamos más campos
$uploads_dir = '../../resources/Computer/';  // Ruta de la carpeta de destino para los archivos
if (isset($_POST["buttonUpdateComputer"])) {
  $accion = $_POST["txtAccion"]; // Acción recibida del formulario (puede ser "insert" o "update")
  $cmpId = $_POST["txtIdComputer"]; // ID de la computadora (puede estar vacío en caso de inserción)
  $cmpAcquisitionDate = $_POST["txtAcquisitionDate"]; // Fecha de adquisición de la computadora
  $cmpIdManufacturer = $_POST['selectManufacturerSelect']; // ID del fabricante seleccionado
  $cmpIdModel = $_POST['selectModel']; // ID del modelo seleccionado
  $cmpCompType = $_POST['selectComputerTypes']; // Tipo de computadora seleccionado
  $cmptName = $_POST['txtTechnicalName']; // Nombre técnico de la computadora
  $cmpServitag = $_POST['txtServitag']; // Servitag de la computadora
  $cmpWarrantyExpiration = $_POST['txtWarrantyExpiration']; // Fecha de vencimiento de la garantía
  $cmpYearExpiration = $_POST['txtyearExpiration']; // Año de vencimiento de la garantía
  $cmpLicence = $_POST['txtLicense']; // Licencia de la computadora
  if (empty($cmpLicence)) {
    $cmpLicence = NULL;
} 
  $cmpMotherboard = $_POST['txtSerial']; // Número de serie de la tarjeta madre
  $cmpso = $_POST['slctOS']; // ID del sistema operativo
  $cmpIdStatu = $_POST['selectStatus']; // ID del estado de la computadora
  $cmpIdLocation = $_POST['selectLocations']; // ID de la ubicación de la computadora
  $cmpObservation = $_POST['txtObservation']; // Observación sobre la computadora
  $cmpeIdGuarate = $_POST['selectTypeGuarantee']; // ID del tipo de garantía seleccionado
  date_default_timezone_set('America/Mexico_City'); // Zona horaria configurada a Ciudad de México
  $todayDate = $_POST['todayDate']; // Fecha actual del sistema

  // Obtener la ruta completa de la imagen de la PC
  if (empty($_FILES['fileImg']['name'])) {
    $cmpImgComp = $CMP_Image; // El campo de imagen está vacío
  } else {
    // El campo no está vacío
    $cmpImgComp = '/resources/Computer/' . $_FILES['fileImg']['name'];
  }

  // Obtener la ruta completa de la imagen del reporte
  if (empty($_FILES['fileReport']['name'])) {

    $cmpImgCompReport = $CMP_Report;  // El campo de imagen está vacío
  } else {
    // El campo no está vacío
    $cmpImgCompReport = '/resources/Computer/' . $_FILES['fileReport']['name'];
  }

  // ID del usuario actual (obtenido de la sesión)
  $idUser = $_SESSION["User_idTbl_User"];
  $todayDateInsert = date("Y-m-d"); // Fecha actual formateada para inserciones
  $idsArrayTexto = $_POST['TxtId']; // Variable para obtener los valores codificados en JSON del campo oculto enviado con datos
  $listIdDecodePRL = json_decode($idsArrayTexto); // Decodificar la cadena JSON en un array de PHP

  // Validamos si tiene el permiso de CMP
  if ($PermisoCMP) {
    try {
      // Llamamos al procedimiento almacenado para actualizar la computadora
      $stmt = $conn->prepare("CALL sp_updateComputer(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
      // Mandamos los parámetros y los input que serán enviados al PA o SP
      $stmt->bind_param("ssssssssssssssssssss", $cmpId, $todayDate, $cmpIdManufacturer, $cmpImgComp, $cmptName, $cmpIdModel, $cmpCompType, $cmpServitag, $cmpLicence, $cmpMotherboard, $cmpAcquisitionDate, $cmpWarrantyExpiration, $cmpYearExpiration, $cmpIdLocation, $cmpIdStatu, $cmpObservation, $cmpImgCompReport, $idUser, $cmpeIdGuarate, $cmpso);
      $stmt->execute(); // Ejecuta el procedimiento almacenado

      // Manejar errores en la ejecución del procedimiento almacenado
      if ($stmt->error) {
        error_log("Error en la ejecución del procedimiento almacenado: " . $stmt->error);
      }

      // Obtener el número de filas afectadas por el insert
      $stmt->bind_result($answerExistsComp);
      $stmt->fetch();
      $stmt->close();
      $conn->next_result();

      // Verificar si la actualización fue exitosa
      if ($answerExistsComp > 0) {
        // Llama al procedimiento almacenado para obtener registros existentes
        $result = $conn->query("CALL sp_selectComputerDetail($cmpId)");
        $existingOptions = array();

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $existingOptions[] = array(
              "PRL_idTbl_Peripherals" => $row['PRL_idTbl_Peripherals'],
              "STS_idTbl_Status" => $row['STS_idTbl_Status']
            );
          }
        } else {
          // Si no hay filas, asignar un array vacío a $existingOptions
          $existingOptions = array();
        }

        // Iterar sobre las opciones existentes
        foreach ($existingOptions as $option) {
          $idPeripheral = $option["PRL_idTbl_Peripherals"];
          $idStatus = $option["STS_idTbl_Status"];
        }

        $result->close();
        $conn->next_result();

        // Obtener los IDs de periféricos ya guardados en un array
        $existingPeripheralsIds = array();
        foreach ($existingOptions as $option) {
          $existingPeripheralsIds[] = $option["PRL_idTbl_Peripherals"];
        }

        // Iterar sobre las opciones recibidas para actualizar Computer Detail
        foreach ($listIdDecodePRL as $optionValue) {
          if (empty($existingPeripheralsIds) || !in_array($optionValue, $existingPeripheralsIds)) {
            try {
              // Insertar un nuevo registro con estado "Activo"
              $statusprl = '2';
              $stmtInsert = $conn->prepare("CALL sp_insertComputerDetailUpdate(?, ?, ?, ?, ?)");
              $stmtInsert->bind_param("sssss", $cmpId, $optionValue, $idUser, $statusprl, $todayDateInsert);
              $stmtInsert->execute();
              $stmtInsert->bind_result($answerExistsPCD);
              $stmtInsert->fetch();
              $stmtInsert->close();
              $conn->next_result();
            } catch (mysqli_sql_exception $e) {
              // Manejar el error en la inserción
            }
          }
        }

        // Identificar las opciones que se deseleccionaron (marcar como "inactivas")
        $optionsToMarkAsUninstalled = array_diff($existingPeripheralsIds, $listIdDecodePRL);

        if (!empty($optionsToMarkAsUninstalled)) {
          foreach ($optionsToMarkAsUninstalled as $optionValue) {
            try {
              // Llama al procedimiento almacenado para marcar como "Desinstalado"
              $stmt = $conn->prepare("CALL sp_UninstalledPCDetails (?,?)");
              // Vincular los parámetros al procedimiento almacenado
              $stmt->bind_param("ss", $cmpId, $optionValue);
              $stmt->execute(); // Ejecutar el procedimiento almacenado

              if ($stmt->error) {
                error_log("Error en la ejecución del tercer procedimiento almacenado: " . $stmt->error);
              }

              $stmt->bind_result($answerExistsPCD);
              $stmt->fetch();
              $stmt->close();
              $conn->next_result();

              // Verificar si la actualización fue exitosa
              if ($answerExistsPCD > 0) {
                // Mostrar mensaje de éxito y redirigir después de 2 segundos
                echo '<script > toastr.success("Los datos de <b>' . $cmptName . '</b> se actualizaron de manera exitosa.", "¡Enhorabuena!"); ';
                echo 'setTimeout(function() {';
                echo '  window.location.href = "view_computer.php";';
                echo ' }, 2000);';
                echo 'document.getElementById("formInsertCMP").reset(); ';
                echo '</script>';

                // Subir archivos si no existen
                if ($_FILES['fileImg']['name'] != 'default.jpg') {
                  move_uploaded_file($_FILES['fileImg']['tmp_name'], $uploads_dir . $_FILES['fileImg']['name']);
                } else {
                  echo '<script > toastr.info("La imagen ya existe")</script>;';
                  $uploadOk = 0;
                }

                if ($_FILES['fileReport']['name'] != 'denuncia.jpeg') {
                  move_uploaded_file($_FILES['fileReport']['tmp_name'], $uploads_dir . $_FILES['fileReport']['name']);
                } else {
                  echo '<script > toastr.info("La imagen del reporte ya existe")</script>;';
                  $uploadOk = 0;
                }
                exit;
              }
            } catch (mysqli_sql_exception $e) {
              // Manejar el error en la inserción
            }
          }
        }
        
        // Verificar si la inserción fue exitosa
        if ($answerExistsPCD > 0) {
          // Mostrar mensaje de éxito y redirigir después de 2 segundos
          echo '<script > toastr.success("Los datos de <b>' . $cmptName . '</b> se actualizaron de manera exitosa.", "¡Enhorabuena!"); ';
          echo 'setTimeout(function() {';
          echo '  window.location.href = "view_computer.php";';
          echo ' }, 2000);';
          echo 'document.getElementById("formInsertCMP").reset(); ';
          echo '</script>';

          // Subir archivos si no existen
          if ($_FILES['fileImg']['name'] != 'default.jpg') {
            move_uploaded_file($_FILES['fileImg']['tmp_name'], $uploads_dir . $_FILES['fileImg']['name']);
          } else {
            echo '<script > toastr.info("La imagen ya existe")</script>;';
            $uploadOk = 0;
          }

          if ($_FILES['fileReport']['name'] != 'denuncia.jpeg') {
            move_uploaded_file($_FILES['fileReport']['tmp_name'], $uploads_dir . $_FILES['fileReport']['name']);
          } else {
            echo '<script > toastr.info("La imagen del reporte ya existe")</script>;';
            $uploadOk = 0;
          }
          exit;
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
      }
    } catch (mysqli_sql_exception $e) {
      if ($e->getCode() == 1062) {
        // Manejar errores de duplicado específicos
        if (strpos($e->getMessage(), 'CMP_Technical_Name_UNIQUE') !== false) {
          echo '<script > toastr.error("No se pudo guardar <br> El Nombre técnico proporcionado ya está en uso. Por favor, elige un Nombre técnico diferente.","¡UPS! Advertencia: 1");';
          echo 'var nombretxt = document.getElementById("txtTechnicalName");';
          echo 'nombretxt.focus();';
          echo '</script>';
        } elseif (strpos($e->getMessage(), 'CMP_Servitag_UNIQUE') !== false) {
          echo '<script > toastr.error("No se pudo guardar <br> El Servitag proporcionado ya está en uso. Por favor, elige un Servitag diferente.","¡UPS! Advertencia: 2");';
          echo 'var servitagtxt = document.getElementById("txtServitag");';
          echo 'servitagtxt.focus();';
          echo '</script>';
        } elseif (strpos($e->getMessage(), 'CMP_License_UNIQUE') !== false) {
          echo '<script > toastr.error("No se pudo guardar <br>La Licencia del colaborador proporcionado ya está en uso. Por favor, elige una Licencia diferente.","¡UPS! Advertencia: 3");';
          echo 'var  licencetxt = document.getElementById("txtLicense");';
          echo 'licencetxt.focus();';
          echo '</script>';
        } else {
          // Si ninguno de los campos específicos coincide, mostrar un mensaje de error genérico
          echo "Error: Entrada duplicada para uno o más campos únicos. Proporcione valores diferentes.";
        }
      } else {
        // Manejar otros tipos de errores relacionados con la base de datos
        echo "Error código: " . $e->getCode() . " - " . $e->getMessage();
      }
    }
  }
}

?>

<script type="text/javascript">
  // Función para validar los datos ingresados en el formulario
  function validate_data() {

    let accionInput = document.getElementById('txtAccion');
    let acquisitionFecha = document.getElementById('txtAcquisitionDate');
    let manufacturerSelect = document.getElementById('selectManufacturerSelect');
    let modelSelect = document.getElementById('selectModel');
    let computerTypesSelect = document.getElementById('selectComputerTypes');
    let nombreInput = document.getElementById('txtTechnicalName');
    let servitagInput = document.getElementById('txtServitag');
    let warrantyExpirationInput = document.getElementById('txtWarrantyExpiration');
    let yearExpirationInput = document.getElementById('txtyearExpiration');
    let licenceInput = document.getElementById('txtLicense');
    let statusSelect = document.getElementById('selectStatus');
    let locationsSelect = document.getElementById('selectLocations');
    let todayDateInput = document.getElementById('todayDate');
    let peripheralsSlct = document.getElementById('slctPeripherals');
        let selectedOptions = Array.from(slctPeripherals.selectedOptions);
        if (selectedOptions.length == 0) {
            // alert('Ninguna opción ha sido seleccionada.');
            toastr.warning('No ha seleccionado ninguna <b>Especificacion del Equipo</b> esta vacio(a).<br>Por favor Ingrese una Software valida');
            peripheralsSlct.focus();
            return false;
        }
    let typeGuanteeSelect = document.getElementById('selectTypeGuarantee');

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
      toastr.warning('El <b>Nombre técnico</b> esta vacio(a).<br>Por favor Ingrese un Nombre valido');
      nombreInput.focus();
    } else if (servitagInput.value.trim() === "") {
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
    } else if (typeGuanteeSelect.selectedIndex == 0) {
      toastr.warning('El <b>Tipo de Garantia</b> esta vacio(a).<br>Por favor Ingrese un Tipo de Garantia valida');
      typeGuanteeSelect.focus();
    } else {
      // Si no hay errores, procesa los datos enviados
      //$opcion = $_POST['opciones'];
      if (accionInput.value.trim() === "") {
        accionInput.value = "2";

      }
      document.getElementById("formUpdateCMP").submit();

    }
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
  $(function() {

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  });
  // Función para obtener el anho automaticamente
  function actualizarAnio() {
    var warrantyExpirationInput = document.getElementById('txtWarrantyExpiration');
    var yearExpirationInput = document.getElementById('txtyearExpiration');

    // Obtener el año a partir de la fecha
    var fecha = new Date(warrantyExpirationInput.value);
    var anio = fecha.getFullYear();

    // Actualizar el valor del campo de entrada del año
    yearExpirationInput.value = anio;
  }

  function readURL(input, imageID) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        // Asignamos el atributo src a la tag de imagen
        $('#' + imageID).attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  // El listener va asignado al input
  $("#fileImg").change(function() {
    readURL(this, 'imgCMP');
  });

  // El listener va asignado al input
  $("#fileReport").change(function() {
    readURL(this, 'imgReport');
  });
</script>



<!-- Ekko Lightbox -->
<?php
require_once "../templates/footer.php";
?>
<script>
  var checkbox = document.getElementById('checkReport');
  var opcionFotos = document.getElementById('aparthImgReport');

  checkbox.addEventListener('change', function() {
    if (checkbox.checked) {
      opcionFotos.style.display = 'block';
    } else {
      opcionFotos.style.display = 'none';
    }
  });

  function filtrarModelos() {
    // Obtener el valor seleccionado en el primer select
    var manufacturerSeleccionado = document.getElementById("selectManufacturerSelect").value;

    // Obtener todos los options del segundo select
    var opcionesModelos = document.getElementById("selectModel").options;

    // Obtener todos los options del segundo select
    var opcionesGarantia = document.getElementById("selectTypeGuarantee").options;

    // Obtenr el texto del segundo seletc
    var contenidoModelo = document.getElementsByTagName("option");
    var contenidoGarantia = document.getElementsByTagName("option");

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
    if (document.querySelectorAll("#selectModel option[style='display: none;']").length === opcionesModelos.length - 1) {
      document.getElementById("selectModel").innerHTML = "<option value=''>No hay modelos disponibles para este fabricante</option>";
    }

    // Recorrer todas las opciones y ocultar las que no pertenecen al fabricante seleccionado
    for (var i = 1; i < opcionesGarantia.length; i++) {
      var garantia = opcionesGarantia[i];
      if (garantia.getAttribute("data-warranty") == manufacturerSeleccionado || manufacturerSeleccionado == "") {
        garantia.style.display = "";
      } else {
        garantia.style.display = "none";
      }
    }

    // Si no hay modelos disponibles para el fabricante seleccionado, mostrar un mensaje en el segundo select
    if (document.querySelectorAll("#selectTypeGuarantee option[style='display: none;']").length === contenidoGarantia.length - 1) {
      document.getElementById("selectTypeGuarantee").innerHTML = "<option value=''>No hay modelos disponibles para este fabricante</option>";
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
      $('#selectModel option').filter(function() {
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
  //Bootstrap Duallistbox
  $('.duallistbox').bootstrapDualListbox()
</script>