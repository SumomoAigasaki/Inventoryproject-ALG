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
<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo  $pageName; echo nameWeb; ?></title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../public/css/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/adminlte.min.css"> 

    </head>

<body>

    <section class="content" style="margin-top:20px;">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                     <h3 class="card-title">¿Que es <b>INFRAG</b>? </h3>
                </div> 
             <!-- /.card-body -->
            <div class="card-body">
                <strong>Information & Resource AG</strong>
                <p>El nombre como tal se enfoca en el aspecto de gestión de información y recursos que involucra el control de inventario de dispositivos, y la sigla AG para la empresa Azucarera La Grecia.</p>

                <strong>El sistema INFRAG</strong>
                <p>El sosftware no es mas que una heramienta el cual viene a mejorar el proceso de gestion y control de inventario de dispositivos en el departamento de Informática, ya que hay un proceso lento el cual fue previamente analizado en el tiempo de practica por el pasante de Ing. en Computacion Sarahi Osorto de Universidad Tecnologica de Honduras. </p>
                
                <strong>Opciones</strong>
                 <div>
                    <a href="login.php">volver</a><br>
                   
                </div>
            </div>
            <!-- /.card-body -->
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

</body>

</html>