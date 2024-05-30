<li class="nav-item">
    <a class="nav-link">
        <i class="fas fa-fw fa-user-lock"></i>
        <span>Administración</span>
    </a>
</li>


<!-- Nav Item - Dashboard -->
<li class="nav-item <?php echo $slug === 'dashboard' ? 'active' : null; ?>">
    <a class="nav-link" href="dashboard">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Menú
</div>

<!-- Nav Item - Usuarios -->
<li class="nav-item <?php echo $slug === 'users' ? 'active' : null; ?>">
    <a class="nav-link" href="users">
        <i class="fa-duotone fa-user-tie"></i>
        <span>Usuarios</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
