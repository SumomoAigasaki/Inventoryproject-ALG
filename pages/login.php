<?php
include "../includes/conecta.php";
include "../includes/constantes.php";
session_start();
//Verificamos si existe la session en caso de exister redirigimos a la pagina home
if (isset($_SESSION["username"])) {
	header("location: template/index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inicio Sesion  <?php echo nameWeb; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../public/css/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/adminlte.min.css"> 

  </head>

<!--CODIGO PARA VALIDAR LOS CAMPOS VACIOS
JAVASCRIP -->
<script>

  function validate() {
    var usuario = document.getElementById("username");
    var contrasenhia = document.getElemntById("pass");
    
    alert($contrasenhia,$usuario);

     if (usuario.value != "" && contrasenhia != ""){
      document.getElementById("formulario").submit();
    }
    return false;
  }

</script>


<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="../../index2.html" class="h1"><b>INFRA </b>ALG</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Ingresa tu usuario para Iniciar sesion</p>

      <form action="views/login_validation.php" method="POST" name="log_val" id="login">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="username" id="username" placeholder="Usuario" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" id="pass" placeholder="Contraseña" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="row" style="display: flex; justify-content: center;">

          <!-- /.col -->
          <div class="col-6">
            <button type="submit" class="btn btn-primary btn-block" onclick='validate()'>Iniciar Sesion</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- /.social-auth-links -->
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../public/js/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../public/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../public/js/adminlte.min.js"></script>

</body>
</html>
