<?php
include "menu.php";
?>


  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-4">
          <div class="col-sm-9">
            <h1 class="m-0">Inicio</h1>
          </div>
    
    
          <!--botones  de agregar  -->
          <div class="row mb-2">

             <div class="breadcrumb float-sm-right">
                  
                <div class="btn-group">
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" title="Crear Bienes">
                    <span class="fas fa-plus"></span>
                     
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" class="btn btn-default" data-toggle="modal" data-target="#modal-default">Crear Cl's </a>
                        <a class="dropdown-item" href="#">Import Cl's</a>
                    </div>
                  </div>

                  
                </div>
            <!-- fin botones  de agregar  -->
          </div>


         <!--cinta de home y el nombre de la pagina --> 
          <div class="col-sm-2">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
              <li class="breadcrumb-item active"> <?php echo nameProject; ?> </li>
            </ol>
          </div>
          <!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    


    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Crear Cl's</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">

            <a class="btn btn-app" style="Margin:0px,0px,50px,50px;">
                  <i class="fas fa-desktop"></i> Dispositivos
                </a>
            
                <a class="btn btn-app" style="Margin:0px,0px,50px,50px;">
                  <i class="fab fa-uncharted"></i> Software
                </a>

                <a class="btn btn-app" style="Margin:0px,0px,50px,50px;">
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

<?php
include "footer.php";
?>