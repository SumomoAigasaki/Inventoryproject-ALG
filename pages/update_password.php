<?php
require_once "../includes/conecta.php";
require_once "../includes/constantes.php";
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
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../public/css/base/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/base/adminlte.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../public/css/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="what_is.php" class="h1"><b>INFRAG</b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Estás a un paso de tu nueva contraseña, recupera tu contraseña ahora.</p>
        <form action="" method="POST">
          <!-- Antigua Contraseña -->
          <div class="input-group mb-3">
            <input type="password" class="form-control" id="txtOldPassword" name="txtOldPassword" placeholder="Antigua Contraseña" autocomplete="current-password" />
            <div class="input-group-append">
              <button class="btn btn-primary" type="button" onclick="mostrarPassword('txtOldPassword', this)">
                <i class="fa fa-eye-slash icon"></i>
              </button>
            </div>
          </div>
          <!-- Nueva Contraseña -->
          <div class="input-group mb-3">
            <input type="password" class="form-control" id="txtNewPassword" name="txtNewPassword" placeholder="Nueva Contraseña" autocomplete="current-password">
            <div class="input-group-append">
              <button class="btn btn-primary" type="button" onclick="mostrarPassword('txtNewPassword', this)">
                <i class="fa fa-eye-slash icon"></i>
              </button>
            </div>
          </div>
          <!-- Confirmar Nueva Contraseña -->
          <div class="input-group mb-3">
            <input type="password" class="form-control" id="txtConfirmNewPass" name="txtConfirmNewPass" placeholder="Confirmar Nueva Contraseña" autocomplete="current-password">
            <div class="input-group-append">
              <button class="btn btn-primary" type="button" onclick="mostrarPassword('txtConfirmNewPass', this)">
                <i class="fa fa-eye-slash icon"></i>
              </button>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Cambiar Contraseña</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mt-3 mb-1">
          <a href="../pages/templates/SignOff.php">Login</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="../public/js/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../public/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../public/js/adminlte.min.js"></script>


  <script type="text/javascript">
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
  </script>
</body>

</html>