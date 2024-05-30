<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo get_user('nombre_completo'); ?></span>
                <?php
                // Get the profile picture path from the 'perfil' field in the 'usuarios' table
                $profilePicture = get_user('perfil');

                // Set the default profile picture path if the user does not have a profile picture
                $defaultProfilePicture = IMAGES.'undraw_profile.svg';

                // Use the profile picture if available, otherwise use the default profile picture
                $profilePictureSrc = $profilePicture ? UPLOADED.$profilePicture : $defaultProfilePicture;
                ?>
                <img class="img-profile rounded-circle" src="<?php echo $profilePictureSrc; ?>">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <!--<a class="dropdown-item" href="perfil" data-toggle="modal" data-target="#profileModal">-->
                <a class="dropdown-item" href="usuarios/ver">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    perfil
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Cerrar sesión
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- End of Topbar -->