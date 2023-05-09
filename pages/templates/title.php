<?php
include "menu.php";
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 ><?php echo $pageName; ?></h1>
        </div>
        <div class="col-sm-3">
            <!--cinta de home y el nombre de la pagina --> 
            <ol class="breadcrumb float-sm-right">
            <div class="btn-group" class="col-sm-3">
                 <!--botones  de agregar  -->
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" title="Crear Bienes">
                    <span class="fa fa-plus"></span>                       
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" class="btn btn-default" data-toggle="modal" data-target="#modal-default">Crear Nuevos </a>
                        <a class="dropdown-item" href="#">Import Cl's</a>
                    </div>
                </div>        
            </ol>
        </div>
        <div class="col-sm-3">
            <!--cinta de home y el nombre de la pagina --> 
            <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo $pageLink; ?>">
                    <?php echo $pageName; ?>
                    </a></li>
                    <li class="breadcrumb-item active"> 
                      <?php echo nameProject; ?> 
                    </li>
            </ol>
        </div>
          <!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" style="text-align:center">Crear Nuevos</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>

            <div class="modal-body">

                <a class="btn btn-app" href="../views/computer.php">
                  <i class="fas fa-desktop"></i> Computadoras
                </a>
            
                <a class="btn btn-app" style="Margin:0px,0px,50px,50px;">
                  <i class="fab fa-uncharted"></i> Software
                </a>

                <a class="btn btn-app"  href="../views/user.php">
                  <i class="fas fa-user-plus"></i> Usuario
                </a>

                <a class="btn btn-app" style="Margin:0px,0px,50px,50px;">
                  <i class="fas fa-laptop"></i> Asignar Pc
                </a>

                <a class="btn btn-app" style="Margin:0px,0px,50px,50px;">
                  <i class="fas fa-certificate"></i> Garantia
                </a>
            </div>
           
        </div>
          <!-- /.modal-content -->
    </div>
        <!-- /.modal-dialog -->
</div>
      <!-- /.modal -->
      <section class="content">
    <div class="container-fluid">