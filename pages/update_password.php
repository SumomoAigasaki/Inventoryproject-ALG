<?php
require_once "../includes/conecta.php";
require_once "../includes/constantes.php";
//obtendremos lA VARIABLE QUE PASAMOS POR METODO get 
$idusuario = $_GET['p'];
$username = $_GET['usuario'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo  $pageName;
          echo nameWeb; ?></title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/css/base/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../public/css/base/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../public/css/base/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../public/css/base/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/base/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../public/css/base/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../public/css/base/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../public/css/base/summernote-bs4.min.css">
  <!-- ./Archivos Base para el Dashboard -->
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="../public/css/ekko-lightbox/ekko-lightbox.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../public/css/toastr.min.css">
  <!-- Agrega jQuery y jQuery UI a tu página -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
  <!-- daterange picker -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
  <!-- DataTables -->
  <link rel="stylesheet" href="../public/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../public/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../public/css/buttons.bootstrap4.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../public/css/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

</head>
<!-- TOASTR -->
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="../public/js/toastr.min.js"></script>
<!-- <script>
  toastr.options = {
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    debug: true
  }
</script> -->

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="what_is.php" class="h1"><b>INFRAG</b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Estás a un paso de tu nueva contraseña, recupera tu contraseña ahora.</p>
        <form action="" method="POST" name="formUpdatePass" id="formUpdatePass" class="form-horizontal">

          <!-- username -->
          <div class="form-group">
            <div class="input-group mb-3">
              <input type="hidden" class="form-control" id="userId" name="userId" value="<?php echo $idusuario; ?>">
              <input class="form-control" type="text" id="txtUsername" name="txtUsername" value="<?php echo $username; ?>" autocomplete="username" readonly>
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-user icon"></i>
                </button>
              </div>
            </div>
          </div>


          <!-- Antigua Contraseña -->
          <div class="form-group">
            <div class="input-group mb-3">
              <input type="password" class="form-control" id="txtOldPassword" name="txtOldPassword" placeholder="Antigua Contraseña" autocomplete="current-password" required>
              <div class="input-group-append">
                <button class="btn btn-primary" type="button" onclick="mostrarPassword('txtOldPassword', this)">
                  <i class="fa fa-eye-slash icon"></i>
                </button>
              </div>
            </div>
          </div>
          <!-- Nueva Contraseña -->
          <div class="input-group mb-3">
            <input type="password" class="form-control" id="txtNewPassword" name="txtNewPassword" placeholder="Nueva Contraseña" autocomplete="current-password" required>
            <div class="input-group-append">
              <button class="btn btn-primary" type="button" onclick="mostrarPassword('txtNewPassword', this)">
                <i class="fa fa-eye-slash icon"></i>
              </button>
            </div>
          </div>
          <!-- Confirmar Nueva Contraseña -->
          <div class="input-group mb-3">
            <input type="password" class="form-control" id="txtConfirmNewPass" name="txtConfirmNewPass" placeholder="Confirmar Nueva Contraseña" autocomplete="current-password" required>
            <div class="input-group-append">
              <button class="btn btn-primary" type="button" onclick="mostrarPassword('txtConfirmNewPass', this)">
                <i class="fa fa-eye-slash icon"></i>
              </button>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block" id="buttonUpdatePass" name="buttonUpdatePass" onclick="return validacion();">Cambiar Contraseña</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mt-3 mb-1">
          <a href="../pages/templates/SignOff.php">Login</a>
          <a href="../pages/templates/index.php" style="margin-left:30px ;">Atras</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>





  <script type="text/javascript">
    //funcion pra los botones de
    function mostrarPassword(passwordId, button) {
      var cambio = document.getElementById(passwordId);
      if (cambio.type == "password") {
        cambio.type = "text";
        button.innerHTML = '<i class="fa fa-eye icon"></i>';
      } else {
        cambio.type = "password";
        button.innerHTML = '<i class="fa fa-eye-slash icon"></i>';
      }
    }


    function validacion() {
      var inputConfirmNewPass = document.getElementById("txtConfirmNewPass").value;
      var inputNewPassword = document.getElementById("txtNewPassword").value;
      var inputOldPassword = document.getElementById("txtOldPassword").value;

      // Validar si los campos están vacíos
      if (inputOldPassword === "" || inputNewPassword === "" || inputConfirmNewPass === "") {
        // Al menos uno de los campos está vacío, hacer algo aquí
        console.log("Por favor, complete todos los campos de contraseña");
        $(document).Toasts('create', {
          class: 'bg-maroon',
          title: 'Campos Vacios ',
          subtitle: 'Error leve',
          body: 'Por favor, complete todos los campos de contraseña.'
        })
        return false;
      } else {
        // Ambos campos tienen valores, hacer algo aquí
        console.log("Se han completado ambos campos de contraseña");
        if (inputOldPassword === inputNewPassword) {
          $(document).Toasts('create', {
            class: 'bg-warning',
            title: 'Contraseña Coinciden ',
            subtitle: 'Error Moderado',
            body: 'Las contraseña Nueva que se ingreso es Igual a la que ingreso en Antigua Contraseña .'
          })
          return false;
        }

        if (inputConfirmNewPass !== inputNewPassword) {
          //Swal.fire({ icon: "warning", title: "Las contraseña no coinciden, coloque una que si coincida"});
          //toasts.warning('Las contraseña no coinciden, coloque una que si coincida ');
          $(document).Toasts('create', {
            class: 'bg-info',
            title: 'La contraseña nueva no coincide',
            subtitle: 'Error Leve',
            body: 'Las contraseña no coinciden, coloque una que si coincidan'
          })
          return false;
        } else {
          document.getElementById("formUpdatePass").submit();
        }
      }


    }
  </script>


  <?php
  //validar que exista el boton submit
  if (isset($_POST["buttonUpdatePass"])) {

    $txtNewPass = $_POST["txtNewPassword"];
    $txtOldPass = $_POST["txtOldPassword"];
    $txtUserName =  $_POST["txtUsername"];
    $txtUserid = $_POST["userId"];

    #aca no validare permiso porque todo aquel usuario que pueda acceder a la plataforma es porque tiene permiso 
    //preparamos el insert 
    $stmt = $conn->prepare("CALL spUpdatePassUser(?,?,?,?)");

    // Mandamos los parametros y los input que seran enviados al PA O SP
    $stmt->bind_param("ssss", $txtUserid, $txtUserName, $txtOldPass, $txtNewPass);
    $query = "CALL spUpdatePassUser('$txtUserid','$txtUserName','$txtOldPass','$txtNewPass');";
    echo $query;

    // Ejecutar el procedimiento almacenado
    $stmt->execute();
    if ($stmt->error) {
      error_log("Error en la ejecución del procedimiento almacenado: " . $stmt->error);
    }
    // Obtener el valor de la variable de salida
    $stmt->bind_result($answerExistsUser, $msgErrorInsert);
    $stmt->fetch();
    $stmt->close();
    $conn->next_result();

    // se extraen los valores qu     nos devuelve el procedimiento almacenado y enviamos el error
    if ($answerExistsUser > 0 && $msgErrorInsert == 0) {

      // echo "<script > \n";
      // echo " $(document).Toasts('create', { \n";
      // echo " class: 'bg-success', \n";
      // echo " title: 'Contraseña Actulizada Correctamente ', \n";
      // echo " subtitle: 'Proceso Execute', \n";
      // echo " body: 'Se ha actulizaron los datos de la contraseña para el usuario: <b> " . $txtUserName . ".'";
      // echo "}) \n";
      // echo "</script> \n";
      echo "<script >";
      echo "toastr.success('Se ha actulizaron los datos de la contraseña para el usuario: <b> " . $txtUserName . ".' , 'Contraseña Actulizada Correctamente ');";
      echo "</script> \n";
      exit;
    } else if ($answerExistsUser == "" && $msgErrorInsert == 1) {
      echo "<script >";
      echo "toastr.warning('La contraseña es incorrecta vuelve a ingresarla.' , 'La contraseña incorrecta');";
      echo "</script> \n";
    } else if ($answerExistsUser == "" && $msgErrorInsert == 2) {
      // echo "<script> \n";
      // echo " $(document).Toasts('create', { \n";
      // echo " class: 'bg-maroon', \n";
      // echo " title: 'Usuario Deshabilitado', \n";
      // echo " subtitle: 'Error 2', \n";
      // echo " body: 'El usuario esta deshabilitado por lo tanto no puedes cambiar la contraseña.' \n";
      // echo "}) \n";
      // echo "</script> \n";

      echo "<script >";
      echo "toastr.info('El usuario esta deshabilitado por lo tanto no puedes cambiar la contraseña' , 'Usuario Deshabilitado');";
      echo "</script> \n";
    }
  }


  ?>


  <!-- /.login-box -->
  <!-- jQuery x-->
  <script src="../public/js/jquery.min.js"></script>
  <!-- Bootstrap 4 x-->
  <script src="../public/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App x-->
  <script src="../public/js/adminlte.min.js"></script>
  <!-- SWEETALERT x-->
  <script src="../public/js/sweetalert2/sweetalert2.min.js"></script>
  <!-- jQuery UI 1.11.4 x-->
  <script src="../public/js/jquery-ui.min.js"></script>




  <!-- JQVMap -->
  <script src="../public/js/jquery.vmap.min.js"></script>
  <script src="../public/js/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="../public/js/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="../public/js/moment.min.js"></script>
  <script src="../public/js/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="../public/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="../public/js/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="../public/js/jquery.overlayScrollbars.min.js"></script>

  <!-- Ekko Lightbox -->
  <script src="../public/css/ekko-lightbox/ekko-lightbox.min.js"></script>


</body>

</html>