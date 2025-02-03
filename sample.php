<?php 


                $query_transaction = "SELECT COUNT(*) AS transaction_notif FROM `inventory_transaction_table` WHERE HOUR(transaction_date) = HOUR(NOW())";
                $exec1 = mysqli_query($conn, $query_transaction);

                if (mysqli_num_rows($exec1) > 0) {
                

                    while ($row = mysqli_fetch_assoc($exec)) {
                        // Convert the stored date and time to a readable format

                        $notif_date = new DateTime($row['transaction_date']);
                        $notif_dateFormatted = $notif_date->format('g:i A, l, F j, Y'); // Format: MM dd, yyyy HH:mm pm
                        $now = new DateTime();

                        // Calculate the time difference
                        $interval = $now->diff($notif_date);
                        if ($interval->h >= 1) {
                            // If the datetime is from 1 hour to less than a day ago
                            $notif_dateFormatted = $interval->h . " hour" . ($interval->h > 1 ? "s" : "") . " ago";
                        } elseif ($interval->i >= 1) {
                            // If the datetime is from 1 minute to less than an hour ago
                            $notif_dateFormatted = $interval->i . " minute" . ($interval->i > 1 ? "s" : "") . " ago";
                        } else {
                            // If the datetime was placed just now
                            $notif_dateFormatted = "Just now";
                        }
                    }
                }
                $query_order = "SELECT COUNT(*) AS order_notif FROM `order_table` WHERE HOUR(order_date) = HOUR(NOW())";
                $exec2 = mysqli_query($conn, $query_order);

                if (mysqli_num_rows($exec2) > 0) {
                

                    while ($row = mysqli_fetch_assoc($exec)) {
                        // Convert the stored date and time to a readable format

                        $notif_date = new DateTime($row['order_date']);
                        $notif_dateFormatted = $notif_date->format('g:i A, l, F j, Y'); // Format: MM dd, yyyy HH:mm pm
                        $now = new DateTime();

                        // Calculate the time difference
                        $interval = $now->diff($notif_date);
                        if ($interval->h >= 1) {
                            // If the datetime is from 1 hour to less than a day ago
                            $notif_dateFormatted = $interval->h . " hour" . ($interval->h > 1 ? "s" : "") . " ago";
                        } elseif ($interval->i >= 1) {
                            // If the datetime is from 1 minute to less than an hour ago
                            $notif_dateFormatted = $interval->i . " minute" . ($interval->i > 1 ? "s" : "") . " ago";
                        } else {
                            // If the datetime was placed just now
                            $notif_dateFormatted = "Just now";
                        }
                    }
                }

?>

                <a href="transactions.php" class="dropdown-item">
                    <i class="fas fa-exchange-alt mr-2"></i> New Transactions
                    <span class="float-right text-muted text-sm">3 mins ago</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="suppliers.php" class="dropdown-item">
                    <i class="fas fa-truck mr-2"></i> Supplier Updates
                    <span class="float-right text-muted text-sm">2 days ago</span>
                </a>