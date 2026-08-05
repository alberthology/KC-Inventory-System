<?php

include '..\functions/db_con.php';
include '..\includes/header.php';
include '..\includes/nav.php';
include '..\includes/sidebar.php';
?>

<div class="content-wrapper">

    <div class="content">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Inventory History Log</h4>
                            <p class="card-text">This log tracks changes in inventory levels and transaction details. Provides logs of all inventory transactions, including product updates, additions, and sales.</p>
                        </div>
                        <div class="card-body" style="            
                                    width: 95%;
                                    height: 500px;
                                    margin: 20px auto;
                                    padding: 20px;
                                    border: 1px solid #ccc;
                                    border-radius: 10px;
                                    background-color: #f5f5f5;
                                    overflow-y: scroll;">


                            <?php
                            // Query to get all transactions ordered by date
                            $query = "
                                        SELECT 
                                            i.transaction_id,  
                                            i.transaction_type,  
                                            i.quantity,  
                                            i.transaction_date,  
                                            i.transaction_amount,
                                            p.product_name,
                                            b.brand_name,
                                            u.user_id,
                                            u.full_name
                                        FROM inventory_transaction_table i
                                        LEFT JOIN user_table u ON i.user_id = u.user_id
                                        LEFT JOIN product_table p ON i.product_id = p.product_id
                                        LEFT JOIN brand_table b ON p.brand_id = b.brand_id
                                        ORDER BY i.transaction_date DESC
                                    ";
                            $result = mysqli_query($conn, $query);

                            if (!$result) {
                                die("Query failed: " . mysqli_error($conn));
                            }

                            $current_date = null;
                            ?>

                            <div class='tab-pane' id='timeline'>
                                <div class='timeline timeline-inverse'>

                                    <?php
                                    if (mysqli_num_rows($result) === 0) {
                                        echo "<div class='card'><div class='card-header'>No transactions found.</div></div>";
                                    }

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $transaction_date = (new DateTime($row['transaction_date']))->format('F j, Y');

                                        // New date group
                                        if ($current_date !== $transaction_date) {
                                            if ($current_date !== null) {
                                                echo '</div>'; // Close previous date group's wrapper div
                                            }
                                            $current_date = $transaction_date;
                                            echo "
                                                <div class='time-label'>
                                                    <span class='bg-success'>{$transaction_date}</span>
                                                </div>
                                                <div class='date-group'>"; // Open new date group wrapper
                                        }

                                        // Format time
                                        $orderDate = new DateTime($row['transaction_date']);
                                        $now = new DateTime();
                                        $interval = $now->diff($orderDate);

                                        if ($interval->y > 0 || $interval->m > 0 || $interval->d > 7) {
                                            $orderDateFormatted = $orderDate->format('g:i A, l, F j, Y');
                                        } elseif ($interval->d >= 1) {
                                            $orderDateFormatted = $interval->d . " day" . ($interval->d > 1 ? "s" : "") . " ago";
                                        } elseif ($interval->h >= 1) {
                                            $orderDateFormatted = $interval->h . " hour" . ($interval->h > 1 ? "s" : "") . " ago";
                                        } elseif ($interval->i >= 1) {
                                            $orderDateFormatted = $interval->i . " minute" . ($interval->i > 1 ? "s" : "") . " ago";
                                        } else {
                                            $orderDateFormatted = "Just now";
                                        }

                                        // $transaction_detail = ($row['transaction_type'] === 'Purchase') ? 'Purchased' : 'Sold';

                                        // $quantity = isset($row['quantity']) && $row['quantity'] !== null
                                        //     ? numberToWords($row['quantity'])
                                        //     : 'No item';

                                        // $transaction = ($row['transaction_type'] === 'Purchase') ? 'Product In' : 'Product Out';

                                        // $icon = ($row['transaction_type'] === 'Purchase')
                                        //     ? '<i class="fas fa-shopping-cart bg-primary p-2 rounded-circle float-left mr-2"></i>'
                                        //     : '<i class="fas fa-dollar-sign bg-success p-2 rounded-circle float-left mr-2"></i>';


                                        $transaction_detail = match ($row['transaction_type']) {
                                            'Purchase' => 'Purchased',
                                            'Update'   => 'Updated',
                                            default    => 'Sold',
                                        };

                                        $quantity = isset($row['quantity']) && $row['quantity'] !== null
                                            ? numberToWords($row['quantity'])
                                            : 'No item';

                                        $transaction = match ($row['transaction_type']) {
                                            'Purchase' => 'Product In',
                                            'Update'   => 'Stock Adjustment',
                                            default    => 'Product Out',
                                        };

                                        $icon = match ($row['transaction_type']) {
                                            'Purchase' => '<i class="fas fa-shopping-cart bg-primary p-2 rounded-circle float-left mr-2"></i>',
                                            'Update'   => '<i class="fas fa-pen bg-warning p-2 rounded-circle float-left mr-2"></i>',
                                            default    => '<i class="fas fa-dollar-sign bg-success p-2 rounded-circle float-left mr-2"></i>',
                                        };
                                    ?>

                                        <div class="">

                                            <div class="timeline-item card">

                                                <div class="card-header">

                                                    <span class="time float-right"><i class="far fa-clock"></i> <?php echo $orderDateFormatted; ?></span>
                                                    <?php echo $icon; ?>
                                                    <h3 class="timeline-header">
                                                        <a href="stocks-options"><?php echo $row['transaction_type']; ?></a>
                                                        Transaction (<?php echo $transaction; ?>)
                                                    </h3>
                                                    <div class="card-body">
                                                        <h5><?php echo $row['full_name'] . ' ' . $transaction_detail . ' ' . $quantity . ' ' . $row['brand_name'] . ' ' . $row['product_name']; ?>
                                                        </h5>
                                                    </div>

                                                    <a href="stocks-options.php#product" class="btn btn-primary float-right">View</a>

                                                </div>
                                            </div>
                                        </div>

                                    <?php } // end while

                                    if ($current_date !== null) {
                                        echo '</div>'; // Close the last date group wrapper
                                    }
                                    ?>

                                </div> <!-- end timeline-inverse -->
                            </div> <!-- end tab-pane -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<?php
include '..\includes/footer.php';
include 'message.php';
?>

<script>





</script>