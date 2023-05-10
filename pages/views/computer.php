<?php
include "../templates/title.php"; 
?>
<script src="../../public/js/toastr.min.js"></script>
<script type="text/javascript">
   toastr.options = {
      closeButton: true,
      progressBar: true,
      positionClass: "toast-top-right",
      timeOut: 5000,
      extendedTimeOut: 200
      };

      function clearForm() {
        var form = document.getElementById('formulario');
        var inputs = form.getElementsByTagName('input');
        var selects = form.getElementsByTagName('select');

        for (var i = 0; i < inputs.length; i++) {
          inputs[i].value = '';
        }

        for (var i = 0; i < selects.length; i++) {
          selects[i].selectedIndex = 1;
        }
      }
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
              
                
        if (acquisitionFecha.value.trim() === "" ) {  
          console.log("dentro de fecha");          
            toastr.warning("La <b>Fecha de Compra</b> esta vacio(a).<br>Por favor Ingrese una fecha valida");
            acquisitionFecha.focus();            
        }      
        else if (manufacturerSelect.selectedIndex == 0) {
          console.log("dentro de Marca");
             toastr.warning('La <b>Marca</b> esta vacio(a).<br>Por favor Ingrese una Marca valida');
             manufacturerSelect.focus();  
        }
      
        else if (modelSelect.value == 1) {
          console.log("dentro de model");
             toastr.warning('El <b>Modelo</b> esta vacio(a).<br>Por favor Ingrese un Modelo valida');
             modelSelect.focus();
        }

        else if (computerTypesSelect.selectedIndex == 0) {
          console.log("dentro de tipo de computadora");
             toastr.warning('El <b>Tipo de computadora</b> esta vacio(a).<br>Por favor Ingrese un tipo de computadora valido');
             computerTypesSelect.focus();
        }

        else if (nombreInput.value.trim() === "") {
          console.log("dentro de nombre tecnico");
             toastr.warning('El <b>Nombre técnico</b> esta vacio(a).<br>Por favor Ingrese un Nombre valido');
             nombreInput.focus();
        }

        else if (servitagInput.value.trim() === "") {
          console.log("dentro de servitag");
             toastr.warning('El <b>Servitag</b> esta vacio(a).<br>Por favor Ingrese una servitag valido');
             servitagInput.focus();
        }

        else  if (warrantyExpirationInput.value.trim() === "") {
          console.log("dentro de fehca limite");
             toastr.warning('La <b>Fecha Límite Garantía</b> esta vacio(a).<br>Por favor Ingrese una Fecha Límite Garantía valida');
             warrantyExpirationInput.focus();
        }


        else if (yearExpirationInput.value.trim() === "") {
             toastr.warning('El <b>Año Limite Garantía</b> esta vacio(a).<br>Por favor Ingrese una Año Limite Garantía valida');
             yearExpirationInput.focus();
        }
        else if (licenceInput.value.trim() === "") {
             toastr.warning('La <b>Lincencia</b> esta vacio(a).<br>Por favor Ingrese una Lincensia valida');
             licenceInput.focus();
        }

        else if (statusSelect.selectedIndex == 0) {
             toastr.warning('El <b>Estado del Computador</b> esta vacio(a).<br>Por favor Ingrese una Estado del Computador valida');
             statusSelect.focus();
        }

        else if (locationsSelect.selectedIndex == 0) {
             toastr.warning('La <b>Localizacion del Computador</b> esta vacio(a).<br>Por favor Ingrese una Localizacion del Computador valida');
             locationsSelect.focus();
        }
          else {
            // Si no hay errores, procesa los datos enviados
            //$opcion = $_POST['opciones'];
              if(accionInput.value.trim() === ""){
                accionInput.value = "1";
                
              }
            document.getElementById("formulario").submit();
            
            
            // Realiza las operaciones necesarias con los datos
            // ...
        } 
        return false;
     }
</script>

<?php 


if (isset($_POST["accion"])) {
  $accion = $_POST["accion"];
  $cmpID = $_POST["cmpId"];
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
  $cmpImgComp = $_POST['img_Comp'];
  $cmpObservation = $_POST['txt_observation'];
  $cmpImgCompReport = "NULL";
  date_default_timezone_set('America/Mexico_City');
  //variables globales 
  $todayDate = date("Y-m-d");
  //$cmptodayDate = $_POST['todayDate'];

  if($accion == "1" && $_SESSION["C-CMP"]){
     //la opcion 1 es para guardar y el C-CMP valida que tenga el permiso C-reateE en (CMP)computer
  
      // Codigo para llamar procedimiento almacenado 
      $stmt = $conn->prepare("CALL 	cp_insertComputer(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,@spID)");
      $stmt->bind_param("sssssssssssssssss", $todayDate,$cmpIdManufacturer,$cmpImgComp,$cmptName,$cmpIdModel,$cmpCompType,$cmpServitag,$cmpLicence,$cmpMotherboard,$cmpAcquisitionDate,$cmpWarrantyExpiration,$cmpYearExpiration,$cmpIdLocation,$cmpIdLocation,$cmpObservation,$cmpImgCompReport,$idUser);
      $stmt->execute();

      // Obtener el valor de la variable de salida
      $result = $conn->query("SELECT @spID AS id")->fetch_assoc();
      $id = $result['id'];

      if($id > 0) {
        echo '<script > toastr.success("¡¡Enhorabuena!!\\nLos datos de <b>' . $cmptName . '</b> se Guardaron de manera exitosa.");</script>';
        exit();
      }else {
        echo '<script > toastr.error("¡¡UPS!!\\n Recuerda que no pueden existir dos:  <b>' . $cmpServitag . '</b> por los tando no se pueden guardar.");</script>';
        exit();
      }

      
  }
}
 
?>  
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
              <h3 class="card-title">Formulario para  <?php echo $pageName; ?> </h3>
          </div>
  
          <!-- form start -->
          <form role="form" action="computer.php" method="POST" name="formulario" id="formulario"  class="form-horizontal" >
            <div class="card-body">
              <label class="form-check-label" for="exampleCheck2" style="padding-bottom: 5px;" >  A continuación se le pedirá que <b> Ingrese</b> los siguientes datos:</label>
                <!-- Input ocultos  -->
                <input type="hidden" class="form-control" id="todayDate" name="todayDate" placeholder="<?php echo $todayDate ?>" >
                <input type="hidden" class="form-control" id="cmpId" name="cmpId" placeholder="" >
                <input type="hidden" class="form-control" id="accion" name="accion" placeholder="" >
                <div class="row" style="padding-top:10px; padding-bottom:10px;">
                  <!-- Fecha de Compra -->
                  <div class="col-sm-4" >
                    <div class="form-group">
                      <label>Fecha de Compra:</label>
                      <div class="input-group">
                        <input type="text" class="form-control"  name="acquisitionDate" id="acquisitionDate"  >
                      </div>
                    </div>
                  </div>
                  <!-- MARCA -->
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label>Marca: </label> 
                         <?php 
                         #Se procede a llamar al procedimiento almacenado que se llama sp_manufacturer_select,con la variable que almancena "cnn" la base de datos 
                         $resultado = mysqli_query($conn, "CALL sp_manufacturer_select()"); ?>
                      <select class="form-control" id="manufacturerSelect"  name="select_manufacturer" onchange="filtrarModelos()">
                         <?php while($row = mysqli_fetch_array($resultado)) {?>
                      <option value="<?php echo $row['MFC_idTbl_Manufacturer']; ?>"><?php echo $row['MFC_Description']; ?></option>
                         <?php } 
                         #NOTA
                         #CADA QUE QUIERA HACER UNA NUEVA CONSULTA CON PROCEDIMIENTOS ALMACENADOS ESTOS EL RESULTADO SE CIERRA Y LA VARIABLE DE LA CONECCION SE PREPARA PARA EL NUEVO RESULTADO
                         # QUE TENDRA ABAJO
                         $resultado->close();
                         $conn->next_result();
                         ?></select>
                   </div>
                  </div>
                  <!-- MODELOS  -->
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Modelo : </label> 
                        <input type="text" id="lookModels" placeholder="Buscar modelo en especifico" class="form-control" >
                          <?php $resultado = mysqli_query($conn, "CALL sp_model_select()");?>
                        <select class="form-control" id="modelSelect" name="select_model">
                            <?php while($row = mysqli_fetch_array($resultado)) {?>
                          <option value="<?php echo $row['MDL_idTbl_Model']; ?>" data-manufacturer="<?php echo $row['MFC_idTbl_Manufacturer']; ?>"><?php echo $row['MDL_Description']; ?></option>
                             <?php }
                             #NOTA
                             #CADA QUE QUIERA HACER UNA NUEVA CONSULTA CON PROCEDIMIENTOS ALMACENADOS ESTOS EL RESULTADO SE CIERRA Y LA VARIABLE DE LA CONECCION SE PREPARA PARA EL NUEVO RESULTADO
                             # QUE TENDRA ABAJO
                             $resultado->close();
                             $conn->next_result();
                             ?> </select>
                     </div>
                  </div>
                  <!-- TIPO DE COMPUTADORA -->
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Tipo de Computadora : </label> 
                         <?php $resultado = mysqli_query($conn, "CALL sp_computerType_select()");?>
                        <select class="form-control" id="computerTypes" name="select_computerType">
                          <?php while($row = mysqli_fetch_array($resultado)) {?>
                        <option value="<?php echo $row['CT_idTbl_Computer_Type']; ?>"><?php echo $row['CT_Description']; ?></option>
                           <?php } 
                           #NOTA
                           #CADA QUE QUIERA HACER UNA NUEVA CONSULTA CON PROCEDIMIENTOS ALMACENADOS ESTOS EL RESULTADO SE CIERRA Y LA VARIABLE DE LA CONECCION SE PREPARA PARA EL NUEVO RESULTADO
                           # QUE TENDRA ABAJO
                           $resultado->close();
                           $conn->next_result();
                           ?> </select>
                    </div>
                  </div>
                </div> 
            
                <!-- Comienzo fila 2 -->
                <div class="row" style="padding-bottom:10px;" >
                  <!-- Nombre Tecnico-->
                  <div class="col-sm-3" >
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nombre Técnico: </label>
                      <input type="text" class="form-control" name="txt_nombre" id="nombre" maxlength="45" value="<?php echo(isset($nombres) ? $nombres : ""); ?>" placeholder="ASSET2023-0#">
                    </div>
                  </div>
                  <!-- Servitag-->
                  <div class="col-sm-2" >
                    <div class="form-group">
                      <label for="exampleInputEmail1">Servitag: </label>
                      <input type="text" class="form-control" name="txt_servitag" id="servitag" maxlength="45" value="<?php echo(isset($servitags) ? $servitags : ""); ?>" placeholder="FKCX???">
                    </div>
                  </div>
                  <!-- Fecha limite garantia -->            
                  <div class="col-sm-4" >
                    <div class="form-group">
                      <label>Fecha Límite Garantía:</label>
                        <div class="input-group">
                          <input type="text" class="form-control"  name="warrantyExpiration" id="warrantyExpiration"  >
                        </div>
                    </div>
                  </div>
                  <!-- Anho limite garantia -->   
                  <div class="col-sm-3" >
                    <div class="form-group">
                      <label>Año Limite Garantía: </label>
                        <div class="input-group">
                          <input type="number" class="form-control" min="2000" max="2050" name="yearExpiration" id="yearExpiration">
                        </div>
                    </div>
                  </div>
                </div>

                <!-- Comienzo fila 3 -->
                <div class="row" style="padding-bottom:10px;" >
                  <!-- Lincencia -->
                  <div class="col-sm-3" >
                    <div class="form-group">
                      <label for="exampleInputEmail1">Licencia: </label>
                      <input type="text" class="form-control" name="txt_licence" id="licence" maxlength="60" value="<?php echo(isset($licenses) ? $licenses : ""); ?>" placeholder="CMCDN-?????-?????-?????-?????">
                    </div>
                  </div>
                  <!-- Tarjeta Madre --> 
                  <div class="col-sm-3" >
                    <div class="form-group">
                      <label for="exampleInputEmail1">Tarjeta Madre: </label>
                      <input type="text" class="form-control" name="txt_motherboard" id="motherboard" maxlength="60" value="<?php echo(isset($motherboards) ? $motherboards : ""); ?>" placeholder="0W3XW5-A00">
                    </div>
                  </div>
                  <!-- Estado de la computadora  -->
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Estado del Computador: </label> 
                            <?php $resultado = mysqli_query($conn, "CALL sp_status_select()");?>
                        <select class="form-control" id="status" name="select_statu">
                            <?php while($row = mysqli_fetch_array($resultado)) {?>
                              <option value="<?php echo $row['STS_idTbl_Status']; ?>"><?php echo $row['STS_Description']; ?></option>
                                <?php }  
                                #NOTA
                                #CADA QUE QUIERA HACER UNA NUEVA CONSULTA CON PROCEDIMIENTOS ALMACENADOS ESTOS EL RESULTADO SE CIERRA Y LA VARIABLE DE LA CONECCION SE PREPARA PARA EL NUEVO RESULTADO
                                # QUE TENDRA ABAJO
                                $resultado->close();
                                $conn->next_result();
                                ?> </select>
                    </div>
                  </div>
                  <!-- Localizacion -->  
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Localizacion del Computador : </label> 
                            <?php $resultado = mysqli_query($conn, "CALL sp_location_select");?>
                      <select class="form-control" id="locations" name="select_location">
                            <?php while($row = mysqli_fetch_array($resultado)) {?>
                      <option value="<?php echo $row['LCT_idTbl_Location']; ?>"><?php echo $row['LCT_Description']; ?></option>
                          <?php }   
                          #NOTA
                          #CADA QUE QUIERA HACER UNA NUEVA CONSULTA CON PROCEDIMIENTOS ALMACENADOS ESTOS EL RESULTADO SE CIERRA Y LA VARIABLE DE LA CONECCION SE PREPARA PARA EL NUEVO RESULTADO
                          # QUE TENDRA ABAJO
                          $resultado->close();
                          $conn->next_result();
                          ?> </select>
                      </div>
                  </div>
                </div>
            
                <!-- Comienzo fila 4 -->
                <div class="row" >
                  <!-- IMAGEN -->
                  <div class="col-sm-5">
                    <div class="form-group">
                      <label>Imagen: </label>
                      <input type="file" name="img_Comp"  id="imageComp" > 
                      <input type="submit" value="Upload">
                    </div>
                  </div>
                  <!-- Observaciones -->
                  <div class="col-sm-5" >
                    <div class="form-group">
                      <label for="exampleInputEmail1">Observaciones: </label>
                      <textarea type="text" class="form-control" name="txt_observation" id="observation" maxlength="100" value="<?php echo(isset($observations) ? $observations : ""); ?>" > </textarea>
                    </div>
                  </div>
                  <!-- Boton guardar -->
                  <div class="col-sm-2" style="padding-top:40px;">
                    <button type="button" class="btn btn-block btn-info" onclick='return validate_data();' >Guardar</button>
                  </div>
                  
                   
                    <!-- IMAGEN
                    <div class="col-sm-3">
                      
                      <div class="form-group">
                        <label>Reporte de Extravio/Robo: </label>
                        <input type="file" name="imageComp"  id="imageComp" > 
                        <input type="submit" value="Upload">
                      </div>
                    </div>
                    -->

                 <!--/. fila 4 --> 
                </div>
              <label class="form-check-label"> </label> 
             <!-- /.card body -->
            </div>
           <!-- /.form-->
          </form>
         <!-- /.card card-primary card-outline -->
        </div>
       <!-- /.col-md-12-->
      </div>
     <!-- /.row -->
    </div>
   <!-- /.rocontainer-fluidw -->  
  </div>
 <!-- /.section--> 
</section>

    
<script src="../../public/jquery/jquery.min.js" ></script>
<!-- Toastr 
<script src="../../public/js/toastr.min.js"></script>
<script>
   $(function() {
    // Agrega un controlador de eventos click a cualquier elemento con la clase "toastrDefaultWarning"
    $('.toastrDefaultWarning').click(function() {
      // Utiliza la función warning de Toastr para mostrar una notificación de advertencia
        toastr.warning('Mensaje de abvertencia', 'Advertencia', {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 3000,
        extendedTimeOut: 1000
        });
      });
  });
</script>-->

<script>


function filtrarModelos() {
  // Obtener el valor seleccionado en el primer select
   var manufacturerSeleccionado = document.getElementById("manufacturerSelect").value;

   // Obtener todos los options del segundo select
   var opcionesModelos = document.getElementById("modelSelect").options;
   
   // Obtenr el texto del segundo seletc
   var contenidoModelo = document.getElementsByTagName("option");
   
   // Recorrer todas las opciones y ocultar las que no pertenecen al fabricante seleccionado
   for (var i = 1; i <opcionesModelos.length; i++) {
    var modelo = opcionesModelos[i];
    if(modelo.getAttribute("data-manufacturer") == manufacturerSeleccionado || manufacturerSeleccionado == "") {
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
      $("#acquisitionDate").datepicker({ dateFormat: "yy-mm-dd" });
    });

  $(function() {
      $("#warrantyExpiration").datepicker({ dateFormat: "yy-mm-dd" });
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
 </script> 
 
<?php
include "../templates/footer.php";
?>