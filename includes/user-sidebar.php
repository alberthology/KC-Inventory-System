<?php
// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-teal elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
        <img src="..\assets/images/closet.png" alt="KC Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><b>KC's Closet</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="stocks-options.php" class="nav-link <?php echo ($current_page == 'stocks-options.php') ? 'active' : ''; ?>">
                        <i class="fas fa-tags nav-icon"></i>
                        <p>Stocks Management</p>
                    </a>
                </li>


                <!-- Transactions -->
                <li class="nav-item">
                    <a href="transactions.php" class="nav-link <?php echo ($current_page == 'transactions.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-exchange-alt"></i>
                        <p>Transactions</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>