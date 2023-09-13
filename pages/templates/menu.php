<?php
//validaciones para los modulos
#dashboard
if (in_array('Dashboard', array_column($privilegios, 'modulo'))) {
    $PermisoDashboard = true;
} else {
    $PermisoDashboard = false;
}
#masterdata
if (in_array('MasterData', array_column($privilegios, 'modulo'))) {
    $PermisoMasterData = true;
} else {
    $PermisoMasterData = false;
}
#transaction
if (in_array('Transaction', array_column($privilegios, 'modulo'))) {
    $PermisoTransaction = true;
} else {
    $PermisoTransaction = false;
}
#Seguridad
if (in_array('Security', array_column($privilegios, 'modulo'))) {
    $PermisoSecurity = true;
} else {
    $PermisoSecurity = false;
}



?>

<!-- Main Sidebar Container (MENU) -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
        <img src="../../public/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"> <?php echo nameProject; ?> </span>
    </a>
    <!-- Sidebar detecta -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <?php
                $ImgProfile = $_SESSION["User_img"];
                if (empty($ImgProfile) || $ImgProfile == "/resources/User/") {
                    // La variable está vacía
                    $ImgProfile = "/resources/User/default.png";
                }
                ?>
                <img src="../../<?php echo $ImgProfile ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    <?php echo  $_SESSION["User_Username"];
                    ?>
                </a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Opciones del sistema</li>
                <!-- dashboard -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>Dashboard </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Computadoras por area</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Computadoras Ingresadas recientemente</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Garantia vigentes</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Masterdata -->
                <li class="nav-item">
                    <a href="../views/explorer.php" class="nav-link">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>Master Data </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php
                            // Verificar si el usuario tiene el permiso de "Software"
                            if ($PermisoSTF) {
                                echo ' <li class="nav-item">';
                                echo '<a href="../views/view_software.php" class="nav-link">';
                                echo '<i class="far fa-circle nav-icon"></i>';
                                echo ' <p>Software</p>';
                                echo '</a>';
                                echo '</li>';
                            }

                            // Verificar si el usuario tiene el permiso de "Perifericos"
                            if ($PermisoPRL) {
                                echo'<li class="nav-item">';
                                echo'<a href="../views/view_peripherals.php" class="nav-link">';
                                echo'<i class="far fa-circle nav-icon"></i>';
                                echo'<p>Perifericos</p>';
                                echo'</a>';
                                echo'</li>';
                                
                            }
                                            
                            // Verificar si el usuario tiene el permiso de "Colaboradores"
                            if ($PermisoCBT) {
                                echo '<li class="nav-item">';
                                echo '<a href="../views/view_collaborator.php" class="nav-link">';
                                echo '<i class="far fa-circle nav-icon"></i>';
                                echo '<p>Colaboradores</p>';
                                echo '</a>';
                                echo '</li>';                            
                            }
                            ?>  
                    </ul>
                </li>

                <!-- Transaction -->
                <li class="nav-item">
                    <a href="../views/explorer.php" class="nav-link">
                        <i class="nav-icon fa fa-database"></i>
                        <p> Transaction </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php
                        // Verificar si el usuario tiene el permiso de "USER"
                        if ($PermisoCMP) {
                            // Mostrar la opción del menú para el usuario
                            echo '<li class="nav-item">';
                            echo '<a href="../views/view_computer.php" class="nav-link">';
                            echo '<i class="far fa-circle nav-icon"></i>';
                            echo ' <p>Computadoras</p>';
                            echo '</a>';
                            echo '</li>';
                        }
                        if ($PermisoPCA) {
                            echo ' <li class="nav-item">';
                            echo '<a href="../views/view_assignment_pc.php" class="nav-link">';
                            echo ' <i class="far fa-circle nav-icon"></i>';
                            echo '  <p>Asignar PC</p>';
                            echo ' </a>';
                            echo ' </li>';
                        } 
                        ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Garantia</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <!-- Security -->
                <?php



                if ($PermisoSecurity) {
                    echo '<li class="nav-item">';
                    echo ' <a href="#" class="nav-link">';
                    echo ' <i class="nav-icon  fa fa-shield-alt"></i>';
                    echo '<p>Security </p>';
                    echo '</a>';
                    echo ' <ul class="nav nav-treeview">';
                    // Verificar si el usuario tiene el permiso de "ROLES"
                    if ($PermisoRLS) {

                        echo '   <li class="nav-item">';
                        echo '  <a href="#" class="nav-link">';
                        echo '  <i class="far fa-circle nav-icon"></i>';
                        echo '  <p>Roles</p>';
                        echo ' </a>';
                        echo '</li>';
                    }

                    // Verificar si el usuario tiene el permiso de "USER"
                    if ($PermisoUSER) {
                        // Mostrar la opción del menú para el usuario
                        echo '<li class="nav-item">';
                        echo ' <a href="../views/view_user.php" class="nav-link">';
                        echo '<i class="far fa-circle nav-icon"></i>';
                        echo '<p>Usuario</p>';
                        echo '</a>';
                        echo '</li>';
                    }
                    echo ' </ul>';
                    echo '</li>';
                }
                ?>

                <li class="nav-header">Opciones Generales</li>
                <li class="nav-item">
                    <a href="../update_password.php?p=<?php echo $_SESSION["User_idTbl_User"]; ?>&usuario=<?php echo  $_SESSION["User_Username"] ?>" class="nav-link">
                        <i class="nav-icon fas fa-sync-alt"></i>
                        <p>Cambiar Contraseña</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../templates/SignOff.php" class="nav-link">
                        <i class="nav-icon   fas fa-arrow-right"></i>
                        <!--<i class="fa-solid fa-arrow-right-from-bracket"></i> -->
                        <p>Cerrar Sesion </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="../views/explorer.php" class="nav-link">
                        <i class="nav-icon fas fa-globe"></i>
                        <p>Explorar </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>