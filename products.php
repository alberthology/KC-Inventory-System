<?php

    include 'functions/db_con.php';
    include 'includes/header.php';
    include 'includes/nav.php';
    include 'includes/sidebar.php';
    ?>

<div class="content-wrapper">

    <div class="content">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Inventory Log Details</h4>
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

        // Loop through transactions
        while ($row = mysqli_fetch_assoc($result)) {
            $transaction_date = (new DateTime($row['transaction_date']))->format('F j, Y');

            // Display a new date label if it's a new day
            if ($current_date !== $transaction_date) {
                if ($current_date !== null) {
                    echo '</div>'; // Close previous day's timeline group
                }
                $current_date = $transaction_date;
                echo "
                <div class='tab-pane' id='timeline'>
                    <div class='timeline timeline-inverse'>
                        <div class='time-label'>
                            <span class='bg-success'>{$transaction_date}</span>
                        </div>
                ";
            }

            // Format transaction details
            $orderDate = new DateTime($row['transaction_date']);
            $now = new DateTime();
            $interval = $now->diff($orderDate);

            if ($interval->y > 0) {
                $orderDateFormatted = $orderDate->format('g:i A, l, F j, Y');
            } elseif ($interval->m > 0 || $interval->d > 7) {
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

            $transactionAmount = isset($row['transaction_amount']) && $row['transaction_amount'] !== null 
                ? '₱ '.number_format($row['transaction_amount'], 2).' each' 
                : '0 Amount';

            $transaction_detail = ($row['transaction_type'] === 'Purchase') 
                        ? 'Purchased' 
                        : 'Sold';

            $quantity = isset($row['quantity']) && $row['quantity'] !== null 
                ? numberToWords($row['quantity']) 
                : 'No item';

            $transaction = ($row['transaction_type'] === 'Purchase') ? 'Product In' : 'Product Out';
            ?>

            <div>
                <?php
                    $icon = ($row['transaction_type'] === 'Purchase') 
                        ? '<i class="fas fa-shopping-cart bg-primary"></i>' 
                        : '<i class="fas fa-dollar-sign bg-success"></i>';
                    echo $icon;
                    ?>


                <div class="timeline-item">
                    <span class="time"><i class="far fa-clock"></i> <?php echo $orderDateFormatted; ?></span>
                    <h3 class="timeline-header"><a href="stocks-options"> <?php echo $row['transaction_type']; ?></a> Transaction <?php echo '('.$transaction.')'; ?></h3>

                    <div class="timeline-body">
                        <?php echo $row['full_name'].' '.$transaction_detail.' '.$quantity.' '.$row['brand_name'].' '.$row['product_name']; ?>
                    </div>
                    <div class="timeline-footer">
                        <a href="stocks-options.php#product" class="btn btn-primary btn-sm">View</a>
                    </div>
                </div>
            </div>
            <?php
        }

        if ($current_date !== null) {
            echo '</div> '; // Close the last timeline group
        }

        // Display message if no transactions exist
        if (mysqli_num_rows($result) === 0) {
            echo "<div class='card'>
                <div class='card-header'>
                    No transactions found.
                </div>
            </div>";
        }
        ?>


    </div>
</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>


<?php
include 'includes/footer.php';
include 'message.php';
?>

<script>





</script>