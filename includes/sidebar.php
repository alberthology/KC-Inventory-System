<?php
// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-teal elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="assets/images/closet.png" alt="KC Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><b>KC's closet</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item menu-open">
                    <a href="index.php" class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="stocks.php" class="nav-link <?php echo ($current_page == 'stocks.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Available Stocks
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="transaction.php" class="nav-link <?php echo ($current_page == 'transaction.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Transactions
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="inventory.php" class="nav-link <?php echo ($current_page == 'inventory.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Inventory
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="records.php" class="nav-link <?php echo ($current_page == 'records.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Records
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="stocks-options.php" class="nav-link <?php echo ($current_page == 'stocks-options.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fa fa-cogs"></i>
                        <p>
                            Stocks Settings
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>