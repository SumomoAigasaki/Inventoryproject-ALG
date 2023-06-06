<?php
include "../includes/conecta.php";
include "../includes/constantes.php";
session_start();
//Verificamos si existe la session en caso de exister redirigimos a la pagina home
if (isset($_SESSION["username"])) {
  header("location: templates/index.php");
}

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

<!--CODIGO PARA VALIDAR LOS CAMPOS VACIOS
JAVASCRIP -->
<script>
  function validate() {
    var usuario = document.getElementById("username");
    var contrasenhia = document.getElemntById("pass");

    alert(contrasenhia.value + " - " + usuario.value);

    if (usuario.value != "" && contrasenhia != "") {
      document.getElementById("formLogin").submit();
    }
    return false;
  }
</script>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Recuperar los valores del formulario
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Llamar al procedimiento almacenado para validar el usuario y la contraseña
  $resultado = null;
  $conn->query("CALL sp_validate_user('$username','$password', @resultado)");
  $resultado = $conn->query("SELECT @resultado")->fetch_assoc()["@resultado"];

  // Verificar el resultado del procedimiento almacenado 
  if ($resultado == 1) {
    // Usuario y contraseña son correctos, redirigir a la página de bienvenida
    session_start();
    $_SESSION['username'] = $username;

    header("Location:../pages/templates/index.php");
    exit();
  } else {
    // Usuario y/o contraseña son incorrectos, mostrar un mensaje de error
    session_start();
    $_SESSION["error_message"] = "Contraseña y/o usuario inválido. Ingrese credenciales correctas.";
    header("Location: login.php");
    exit();
  }
}
?>

<!-- /.login-logo -->
<div class="card card-outline card-primary">
  <div class="card-header text-center">
    <a href="what_is.php" class="h1"><b>INFRAG</b></a>
  </div>
  <script src='../public/js/sweetalert2/sweetalert2.min.js'></script>

  <body class="hold-transition login-page">
    <script>
      <?php
      if (isset($_SESSION["error_message"])) {
        $errorMessage = $_SESSION["error_message"];
        unset($_SESSION["error_message"]);
      ?>
        Swal.fire({
          icon: 'error',
          title: 'Credenciales erróneas',
          text: '<?php echo $errorMessage; ?>',
          confirmButtonText: 'Aceptar'
        });
      <?php
      }
      ?>
    </script>


    <div class="card-body">
      <p class="login-box-msg">Ingresa tu usuario para Iniciar sesion</p>

      <form action="" method="POST" name="formLogin" id="formLogin">

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
<!-- /.login-box -->
<!-- jQuery -->
<script src="../public/js/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../public/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../public/js/adminlte.min.js"></script>
</body>

</html>