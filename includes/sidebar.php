<?php
// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-teal elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
        <img src="assets/images/closet.png" alt="KC Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><b>KC's Closet</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="index.php" class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Product Management -->
                <li class="nav-item has-treeview <?php echo in_array($current_page, ['products.php', 'categories.php', 'brands.php']) ? 'menu-open' : ''; ?>">
                    <a href="products.php" class="nav-link <?php echo in_array($current_page, ['products.php', 'categories.php', 'brands.php']) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-warehouse"></i>
                        <p>Inventory<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="products.php" class="nav-link <?php echo ($current_page == 'products.php') ? 'active' : ''; ?>">
                                <i class="fas fa-cube nav-icon"></i>
                                <p>Product List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="categories.php" class="nav-link <?php echo ($current_page == 'categories.php') ? 'active' : ''; ?>">
                                <i class="fas fa-tags nav-icon"></i>
                                <p>Product Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="brands.php" class="nav-link <?php echo ($current_page == 'brands.php') ? 'active' : ''; ?>">
                                <i class="fas fa-industry nav-icon"></i>
                                <p>Brands</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Inventory -->
                <!--<li class="nav-item">
                    <a href="inventory.php" class="nav-link <?php //echo ($current_page == 'inventory.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-warehouse"></i>
                        <p>Inventory</p>
                    </a>
                </li> -->

                <!-- Transactions -->
                <li class="nav-item">
                    <a href="transactions.php" class="nav-link <?php echo ($current_page == 'transactions.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-exchange-alt"></i>
                        <p>Transactions</p>
                    </a>
                </li>

                <!-- Suppliers -->
                <li class="nav-item">
                    <a href="suppliers.php" class="nav-link <?php echo ($current_page == 'suppliers.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>Suppliers</p>
                    </a>
                </li>

                <!-- Users -->
                <li class="nav-item">
                    <a href="users.php" class="nav-link <?php echo ($current_page == 'users.php') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
