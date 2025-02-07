<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #dab659;">
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
<?php
// Set the timezone
date_default_timezone_set("Asia/Manila");

// Define the low stock threshold
$low_stock_threshold = 4;

// Initialize the low stock count and query
$low_stock_count = 0; // Default value in case of query failure
$query_low_stock = "SELECT COUNT(*) AS product_notif FROM `product_table` WHERE quantity_in_stock <= $low_stock_threshold";

// Execute the query to check low stock products
$exec1 = mysqli_query($conn, $query_low_stock);
if ($exec1 && mysqli_num_rows($exec1) > 0) {
    $row = mysqli_fetch_assoc($exec1);
    $low_stock_count = $row['product_notif']; // Fetch the low stock count

    // Check if low stock notification conditions are met
    if ($low_stock_count > 0) {
        // Initialize session for notification time if not set
        if (!isset($_SESSION['last_notification_time'])) {
            $_SESSION['last_notification_time'] = time(); // Set the current time as the last notification time
        }

        $current_time = time(); // Get the current time

        // Check if at least 24 hours have passed since the last notification
        if (($current_time - $_SESSION['last_notification_time']) > 86400) {
            $_SESSION['last_notification_time'] = $current_time; // Update the session time
        }
    }
}

// Query for transaction updates notification (based on time of transaction)
$query_transaction = "SELECT COUNT(*) AS transaction_notif FROM `inventory_transaction_table` WHERE transaction_date >= DATE_SUB(NOW(), INTERVAL 3 HOUR)";
$exec2 = mysqli_query($conn, $query_transaction);
$transaction_notif = 0; // Default value
if ($exec2 && mysqli_num_rows($exec2) > 0) {
    $row = mysqli_fetch_assoc($exec2);
    $transaction_notif = $row['transaction_notif']; // Store the number of new transactions
}

// Query for order updates notification (based on time of order)
$query_order = "SELECT COUNT(*) AS order_notif FROM `order_table` WHERE order_date >= DATE_SUB(NOW(), INTERVAL 3 HOUR)";
$exec3 = mysqli_query($conn, $query_order);
$order_notif = 0; // Default value
if ($exec3 && mysqli_num_rows($exec3) > 0) {
    $row = mysqli_fetch_assoc($exec3);
    $order_notif = $row['order_notif']; // Store the number of new orders
}

// Function to format the time difference
function timeAgo($datetime) {
    $notif_date = new DateTime($datetime);
    $now = new DateTime();
    $interval = $now->diff($notif_date);

    if ($interval->d > 0) {
        return $interval->d . "d" . ($interval->d > 1 ? /*"s"*/"" : "") . " ago";
    } elseif ($interval->h > 0) {
        return $interval->h . "h" . ($interval->h > 1 ? "" : "") . " ago";
    } elseif ($interval->i > 0) {
        return $interval->i . "m" . ($interval->i > 1 ? "" : "") . " ago";
    } else {
        return "Just now";
    }
}

// Sample datetime values for transaction and order dates (Replace with actual database values)
/*$transaction_date = '2025-01-04 15:00:00'; 
$order_date = '2025-01-04 14:45:00'; */

// Query for the transaction dates
$query_transact_dates = "SELECT transaction_date FROM `inventory_transaction_table` WHERE transaction_date BETWEEN DATE_SUB(NOW(), INTERVAL 3 HOUR) AND NOW() ORDER BY transaction_date DESC LIMIT 1 ";

$result_transact_dates = $conn->query($query_transact_dates);
$transaction_dates = [];


$query_order_dates = "SELECT order_date FROM `order_table` WHERE order_date BETWEEN DATE_SUB(NOW(), INTERVAL 3 HOUR) AND NOW() ORDER BY order_date DESC LIMIT 1 ";
$result_order_dates = $conn->query($query_order_dates);
$order_dates = [];



?>

<!-- Notification Dropdown -->
<a class="nav-link" data-toggle="dropdown" href="#">
    <i class="fas fa-bell"></i>

    <?php
    // Show the badge if there are any low stock products or recent transactions/orders
    if ($low_stock_count > 0 || $transaction_notif > 0 || $order_notif > 0) {
        echo '<span class="badge badge-danger navbar-badge">•</span>';
        $transaction_notif_count = 1;
        $order_notif_count = 1;
    }

    // $notif_count = $low_stock_count + $transaction_notif_count + $order_notif_count ;
    ?>
</a>

<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    <span class="dropdown-header"><?php //echo $notif_count; ?> Notifications</span>
    <div class="dropdown-divider"></div>

    <?php
// Display the low stock notification if conditions are met
if ($low_stock_count > 0 && isset($_SESSION['last_notification_time'])) {
    // Calculate how long ago the notification was set
    $notification_time_ago = timeAgo(date('Y-m-d H:i:s', $_SESSION['last_notification_time']));
    
    // Show the notification
    echo '
        <a href="stocks-options.php" class="dropdown-item">
            <i class="fas fa-warehouse mr-2"></i> Low Stock Alert
            <span class="float-right text-muted text-sm">' . $notification_time_ago . '</span>
        </a>
    ';
}
    ?>

    <!-- Transaction Notification (recent) -->
    <?php if ($transaction_notif > 0): ?>
        <a href="products.php" class="dropdown-item">
            <i class="fas fa-exchange-alt mr-2"></i> New Transactions
            <span class="float-right text-muted text-sm">
                <?php 
                    while ($row_transact_dates = $result_transact_dates->fetch_assoc()) {
                        $transaction_dates[] = timeAgo($row_transact_dates['transaction_date']);
                        echo timeAgo($row_transact_dates['transaction_date']);
                    }
                ?>
            </span>
        </a>
        <div class="dropdown-divider"></div>
    <?php endif; ?>

    <!-- Order Notification (recent) -->
    <?php if ($order_notif > 0): ?>
        <a href="transactions.php" class="dropdown-item">
            <i class="fas fa-dollar-sign mr-2"></i> New Order
            <span class="float-right text-muted text-sm">
                <?php 
                    while ($row_order_dates = $result_order_dates->fetch_assoc()) {
                        $order_dates[] = timeAgo($row_order_dates['order_date']);
                        echo timeAgo($row_order_dates['order_date']);
                    }
                ?>
            </span>
        </a>
        <div class="dropdown-divider"></div>
    <?php endif; ?>

    <!-- "See All Notifications" link -->
    <!-- <a href="notifications.php" class="dropdown-item dropdown-footer">See All Notifications</a> -->
    <hr>
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
                <!-- <a href="archive.php" class="dropdown-item">
                    <i class="fas fa-folder mr-2"></i> Archive Logs
                </a> -->
                <a href="users.php" class="dropdown-item">
                    <i class="fas fa-cog mr-2"></i> Add User
                </a>
                <div class="dropdown-divider"></div>
                <a href="logout.php" class="dropdown-item">
                    <i class="fas fa-power-off mr-2"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->