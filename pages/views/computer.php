<?php
include "../templates/title.php"; 
?>
<!---
<script src="../models/modelComputer.php">
        // Crea un objeto de la clase Computer
        var computer = new Computer();

        // Obtén los elementos del formulario HTML
        var form = document.getElementById('formulario');
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
                
        
        // Agrega un evento "submit" al formulario
        form.addEventListener('submit', function(event) {
            // Previene que el formulario se envíe automáticamente
            event.preventDefault();
            
            // Obtén los valores ingresados en el formulario
            var acquisitionDate = acquisitionFecha.value;
            var select_manufacturer = manufacturerSelect.value;
            var select_model = modelSelect.value;
            var select_computerType = computerTypesSelect.value;
            var txt_nombre = nombreInput.value;
            var txt_servitag = servitagInput.value;
            var warrantyExpiration = warrantyExpirationInput.value;
            var yearExpiration = yearExpirationInput.value;
            var txt_licencia = licenceInput.value;
            var select_statu = statusSelect.value;
            var select_location = locationsSelect.value;

            
            // Valida los datos ingresados
            var isValid = computer.validate_data(acquisitionDate, select_manufacturer, select_model, select_computerType, nombreInput, 
                                                  txt_servitag, warrantyExpiration, warrantyExpiration, yearExpiration,txt_licencia,
                                                  select_statu, select_location);
            
            // Si los datos son válidos, agrega la computadora a la base de datos
            //if (isValid) {
              //  computer.create_computer(name, type, brand);
            //}
        });
    </script>
    
-->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
              <h3 class="card-title">Formulario para  <?php echo $pageName; ?> </h3>
          </div>
  
          <!-- form start -->
          <form role="form" class="form-horizontal" >
            <div class="card-body">
              <label class="form-check-label" for="exampleCheck2" style="padding-bottom: 5px;" >  A continuación se le pedirá que ingrese los siguientes datos:</label>
                <!-- Input ocultos  -->
                <input type="hidden" class="form-control" id="todayDate" name="todayDate" placeholder="<?php echo $todayDate ?>" >
                <input type="hidden" class="form-control" id="cmpId" name="cmpId" placeholder="" >
                
                <input type="hidden" class="form-control"  placeholder=<?php echo  $_SESSION["User_Username"] ; ?>>

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
                          <option value="<?php echo $row['MDL_Description']; ?>" data-manufacturer="<?php echo $row['MFC_idTbl_Manufacturer']; ?>"><?php echo $row['MDL_Description']; ?></option>
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
                    <button type="button" class="btn btn-block btn-info toastrDefaultWarning">Guardar</button>
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
<!-- Toastr -->
<script src="../../public/js/toastr.min.js"></script>
<script>
   $(function() {
    // Agrega un controlador de eventos click a cualquier elemento con la clase "toastrDefaultWarning"
    $('.toastrDefaultWarning').click(function() {
      // Utiliza la función warning de Toastr para mostrar una notificación de advertencia
        toastr.warning(':D Ya me dio esta mierda', 'Advertencia', {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 3000,
        extendedTimeOut: 1000
        });
      });
  });
</script>

<script>
function filtrarModelos() {
  // Obtener el valor seleccionado en el primer select
   var manufacturerSeleccionado = document.getElementById("manufacturerSelect").value;

   // Obtener todos los options del segundo select
   var opcionesModelos = document.getElementById("modelSelect").options;
   
   // Obtenr el texto del segundo seletc
   var contenidoModelo = document.getElementsByTagName("option");
   
   // Recorrer todas las opciones y ocultar las que no pertenecen al fabricante seleccionado
   for (var i = 0; i <=opcionesModelos.length; i++) {
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