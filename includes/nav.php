<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="transactions.php" class="dropdown-item">
                    <i class="fas fa-exchange-alt mr-2"></i> New Transactions
                    <span class="float-right text-muted text-sm">3 mins ago</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="inventory.php" class="dropdown-item">
                    <i class="fas fa-warehouse mr-2"></i> Low Stock Alert
                    <span class="float-right text-muted text-sm">1 hour ago</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="suppliers.php" class="dropdown-item">
                    <i class="fas fa-truck mr-2"></i> Supplier Updates
                    <span class="float-right text-muted text-sm">2 days ago</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="notifications.php" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        
        <!-- User Account Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-user"></i> <span></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="profile.php" class="dropdown-item">
                    <i class="fas fa-user-circle mr-2"></i> Profile
                </a>
                <a href="archive.php" class="dropdown-item">
                    <i class="fas fa-folder mr-2"></i> Archive Logs
                </a>
                <div class="dropdown-divider"></div>
                <a href="logout.php" class="dropdown-item">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->