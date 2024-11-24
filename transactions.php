 <?php
    session_start();
    include 'functions/db_con.php';
    include 'includes/header.php';
    include 'includes/nav.php';
    include 'includes/sidebar.php';
    // Function to generate the order code
function generateOrderCode($category_id, $brand_id, $product_id, $customer_id, $order_id, $order_item_id) {
    // Format category_id, brand_id, and product_id with leading zeroes for single digits
    $C = 'C' . str_pad($category_id, 2, '0', STR_PAD_LEFT);  // Ensure two digits for category ID
    $B = 'B' . str_pad($brand_id, 2, '0', STR_PAD_LEFT);      // Ensure two digits for brand ID
    $P = 'P' . $product_id;                                    // Product ID does not need leading zeroes, as it might be a single digit

    // Combine them with the customer_id, order_id, and order_item_id
    $orderCode = $C . $B . $P . '-' . $customer_id . $order_id . $order_item_id;

    return $orderCode;
}
    ?>

 <div class="content-wrapper">

     <div class="content">
         <div class="container-fluid">
             <div class="row">

                 <div class="col-md-12 mt-2">
                     <div class="card">
                         <div class="card-header p-3">
                             <ul class="nav nav-pills">
                                 <li class="nav-item"><a class="nav-link active" href="#order" data-toggle="tab"><b>Order Transactions</b></a></li>
                                 <li class="nav-item"><a class="nav-link" href="#ongoing" data-toggle="tab"><b>Partially Paid Orders</b></a></li>
                                 <li class="nav-item"><a class="nav-link" href="#completed" data-toggle="tab"><b>Completed Orders</b></a></li>
                             </ul>
                         </div>
                         <div class="card-body">
                             <div class="tab-content">
                                 <div class="active tab-pane" id="order">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-order"><i class="fas fa-plus"></i>  &nbsp Place Customer Order</button>
                                                    </div>
                                                </div>
                                                 <!-- /.card-header -->
                                                <div class="card-body">
<table id="order-table" class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <!-- <th>Date and Time</th> -->
            <th>Transaction Logs</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Query to fetch data from the order_table
        $query = "
        SELECT
            c.order_item_id,
            c.order_id,
            p.product_name,
            p.product_id,
            c.quantity,
            c.unit_price,
            c.total_price,
            p.quantity_in_stock,
            b.brand_name,
            a.category_name,
            p.price,
            o.order_date,
            o.total_amount,
            o.status,
            r.customer_name  -- Added customer_name
        FROM order_table o
        LEFT JOIN order_item_table c ON c.order_id = o.order_id
        LEFT JOIN product_table p ON c.product_id = p.product_id
        LEFT JOIN category_table a ON p.category_id = a.category_id
        LEFT JOIN customer_table r ON o.customer_id = r.customer_id
        LEFT JOIN brand_table b ON p.brand_id = b.brand_id
        WHERE o.order_date >= DATE_SUB(CURDATE(), INTERVAL 14 DAY)
        ";

        $result = mysqli_query($conn, $query);

        // Check if any orders exist
        if (mysqli_num_rows($result) > 0) {
            // Iterate through each order and display in the table
            while ($row = mysqli_fetch_assoc($result)) {
                // Convert the stored date and time to a readable format

                $orderDate = new DateTime($row['order_date']);
                $orderDateFormatted = $orderDate->format('g:i A, l, F j, Y'); // Format: MM dd, yyyy HH:mm pm
                // Assume $row['order_date'] contains the order date in 'Y-m-d H:i:s' format.
                $orderDate = new DateTime($row['order_date']);
                // $now = new DateTime();

                // Calculate the time difference
                $interval = $now->diff($orderDate);

                // Check if the difference is within a week or more
                if ($interval->y > 0) {
                    // If the difference is more than a year
                    $orderDateFormatted = $orderDate->format('g:i A, l, F j, Y');
                } elseif ($interval->m > 0) {
                    // If the difference is more than a month
                    $orderDateFormatted = $orderDate->format('g:i A, l, F j, Y');
                } elseif ($interval->d > 7) {
                    // If the difference is more than a week
                    $orderDateFormatted = $orderDate->format('g:i A, l, F j, Y');
                } elseif ($interval->d >= 1) {
                    // If the order is from 1 day to 7 days ago
                    $orderDateFormatted = $interval->d . " day" . ($interval->d > 1 ? "s" : "") . " ago";
                } elseif ($interval->h >= 1) {
                    // If the order is from 1 hour to less than a day ago
                    $orderDateFormatted = $interval->h . " hour" . ($interval->h > 1 ? "s" : "") . " ago";
                } elseif ($interval->i >= 1) {
                    // If the order is from 1 minute to less than an hour ago
                    $orderDateFormatted = $interval->i . " minute" . ($interval->i > 1 ? "s" : "") . " ago";
                } else {
                    // If the order was placed just now
                    $orderDateFormatted = "Just now";
                }
                
                // Check for null values and handle them
               $unitPrice = isset($row['unit_price']) && $row['unit_price'] !== null ? '₱ '.number_format($row['unit_price'], 2).' each' : '0 Amount';
    
                $totalPrice = isset($row['total_price']) && $row['total_price'] !== null ? '₱ '. number_format($row['total_price'], 2) : '0 Amount</b> <span style="color:red;"><b> Error: 014</b><i> Please contact the <a href="https://www.facebook.com/Alberthology/" target="_blank" style="color:red; text-decoration: underline;"> developer here</a></i></span> ';


                $quantity = isset($row['quantity']) && $row['quantity'] !== null 
                ? ( $row['quantity'] > 1 
                    ? numberToWords($row['quantity']) . ' <i>' . $row['product_name'] . "</i>s" 
                    : numberToWords($row['quantity']) . ' <i>' . $row['product_name'].'</i>' )
                : 'No item';




                echo "<tr id='category-row-{$row['order_id']}'>

                        <td>
                            <div class='comment-box'>
                                <div class='control-number'>Order Number: {$row['order_id']}{$row['order_item_id']}</div>
                                <div class='suggestion'><b>{$row['customer_name']}</b> ordered <b >{$quantity}</b>, for <u>{$unitPrice}</u>, with a total of <b>{$totalPrice}</b></div>
                                <div class='date'><p>{$orderDateFormatted}</p></div>
                            </div>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No orders found.</td></tr>";
        }
        ?>
    </tbody>
</table>


                                                 </div>
                                                 <!-- /.card-body -->
                                             </div>
                                             <!-- /.card -->
                                         </div>
                                     </div>
                                 </div>

                                <div class="tab-pane" id="ongoing">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">

                                                 <!-- /.card-header -->
                                                <div class="card-body">
                                                    <table id="ongoing-table" class="table table-bordered table-striped table-hover"> 
                                                        <thead>
                                                            <tr>
                                                                <th>Order Code</th>
                                                                <th>Customer</th>
                                                                <th>Product</th>
                                                                <!-- <th>Total Amount</th> -->
                                                                <th>Partial Payment</th>
                                                                <th>Date Ordered</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                            <?php
                                            $query = "
                                                SELECT
                                                    o.order_item_id,
                                                    o.quantity,
                                                    o.unit_price,
                                                    o.total_price,
                                                    o.payment,
                                                    i.order_id,
                                                    i.order_date,
                                                    i.total_amount,
                                                    i.status,
                                                    p.product_id,
                                                    p.product_name,
                                                    p.quantity_in_stock,
                                                    p.price,
                                                    p.product_size,
                                                    p.product_color,
                                                    c.customer_id,
                                                    c.customer_name,
                                                    c.contact_number,
                                                    v.category_id,
                                                    v.category_name,
                                                    b.brand_id,
                                                    b.brand_name
                                                FROM order_item_table o
                                                LEFT JOIN order_table i ON o.order_id = i.order_id
                                                LEFT JOIN product_table p ON o.product_id = p.product_id
                                                LEFT JOIN customer_table c ON i.customer_id = c.customer_id
                                                LEFT JOIN category_table v ON p.category_id = v.category_id
                                                LEFT JOIN brand_table b ON p.brand_id = b.brand_id
                                                WHERE o.total_price != o.payment ORDER BY i.order_date DESC"; // Assumed status is 'ongoing'

                                            $result = mysqli_query($conn, $query);
                                             
                                            // Check if any orders exist
                                            if (mysqli_num_rows($result) > 0) {
                                                // Iterate through each order and display in the table
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    // Format total_amount and payment with commas and 2 decimal places
                                                    $unit_price = number_format($row['unit_price'], 2);
                                                    $formatted_total_amount = number_format($row['total_amount'], 2);
                                                    $formatted_payment = number_format($row['payment'], 2);

                                            $orderDate = new DateTime($row['order_date']);
                                            $orderDateFormatted = $orderDate->format('g:i A, l, F j, Y'); // Format: MM dd, yyyy HH:mm pm

                                                    // Generate the order code
        $orderCode = generateOrderCode(
            $row['category_id'], 
            $row['brand_id'], 
            $row['product_id'], 
            $row['customer_id'], 
            $row['order_id'], 
            $row['order_item_id']
        );
                                            // Calculate the time difference
                                            $interval = $now->diff($orderDate);

                                            // Check if the difference is within a week or more
                                            if ($interval->y > 0) {
                                                // If the difference is more than a year
                                                $orderDateFormatted = $orderDate->format('g:i A, l, F j, Y');
                                            } elseif ($interval->m > 0) {
                                                // If the difference is more than a month
                                                $orderDateFormatted = $orderDate->format('g:i A, l, F j, Y');
                                            } elseif ($interval->d > 7) {
                                                // If the difference is more than a week
                                                $orderDateFormatted = $orderDate->format('g:i A, l, F j, Y');
                                            } elseif ($interval->d >= 1) {
                                                // If the order is from 1 day to 7 days ago
                                                $orderDateFormatted = $interval->d . " day" . ($interval->d > 1 ? "s" : "") . " ago";
                                            } elseif ($interval->h >= 1) {
                                                // If the order is from 1 hour to less than a day ago
                                                $orderDateFormatted = $interval->h . " hour" . ($interval->h > 1 ? "s" : "") . " ago";
                                            } elseif ($interval->i >= 1) {
                                                // If the order is from 1 minute to less than an hour ago
                                                $orderDateFormatted = $interval->i . " minute" . ($interval->i > 1 ? "s" : "") . " ago";
                                            } else {
                                                // If the order was placed just now
                                                $orderDateFormatted = "Just now";
                                            }


                                                    // Output the formatted data in the table
                                                    echo "<tr id='order-row-{$row['order_item_id']}'>
                                                            <td>{$orderCode}</td>
                                                            <td>{$row['customer_name']}</td>
                                                            <td>{$row['quantity']} {$row['product_name']}, for ₱ {$unit_price} each</td>
                                                            <td>₱ {$formatted_payment}</td>
                                                            <td>{$orderDateFormatted}</td>
                                                            <td style='text-align:center;'>
                                                                <button class='btn btn-primary' onclick='openEditModal({$row['order_item_id']},\"{$row['order_id']}\",\"{$row['customer_id']}\",\"{$row['category_id']}\",\"{$row['brand_id']}\",\"{$row['product_id']}\",\"{$row['customer_name']}\",\"{$row['contact_number']}\",\"{$row['category_name']}\",\"{$row['brand_name']}\",\"{$row['product_name']}\",\"{$row['product_size']}\",\"{$row['product_color']}\",\"{$row['status']}\",\"{$row['quantity']}\",\"{$row['price']}\",\"{$row['unit_price']}\",\"{$formatted_total_amount}\",\"{$formatted_payment}\")'>
                                                                    Update Payment
                                                                </button>
                                                            </td>
                                                          </tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='6'>No partially paid orders found.</td></tr>";
                                            }
                                            ?>

                                                        </tbody>
                                                    </table>

                                                 </div>
                                                 <!-- /.card-body -->
                                             </div>
                                             <!-- /.card -->
                                         </div>
                                     </div>    
                                </div>
                <!-- Edit Stock Modal -->
                        <div class="modal fade" id="edit-stocks">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><i class="fas fa-dolly"></i> &nbsp; Update Payment</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="edit_order_code">Order Number:</label>
                                                <p id="edit_order_code"></p>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="edit_customer_name">Customer:</label>
                                                <p id="edit_customer_name"></p>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="edit_customer_name">Contact Number:</label>
                                                <p id="edit_contact_number"></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="edit_product_name">Product Item:</label>
                                                <p id="edit_product_item"></p>
                                                <p id="edit_product_detail"></p>

                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="edit_price">Price:</label>
                                        <input type="text" name="payment" id="edit_price" class="form-control form-control-md" placeholder="Payment" disabled>

                                                
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="edit_status">Payment Status:</label>
                                                <br>
                                                <span class="badge bg-warning text-dark" id="">Partially Paid</span>
                                                
                                            </div>
                                        </div>


                                    <form id="editStockForm" action="functions/edit_sql.php" method="post">
                                        <input type="hidden" name="form_type" value="update_payment">
                                        <input type="hidden" name="order_item_id" id="edit_order_item_id">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="edit_payment">Partial Payment:</label>
                                                <input type="text" name="payment" id="edit_payment" class="form-control form-control-md" placeholder="">
                                            </div>
                                        </div>

                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" form="editStockForm" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>

                                    </div>
                                </div>
                            </div>
                        </div>


                                <div class="tab-pane" id="completed">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">

                                                 <!-- /.card-header -->
                                                <div class="card-body">
                                                    <table id="completed-table" class="table table-bordered table-striped table-hover"> 
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2">Customer</th>
                                                                <th colspan="4">Order Details</th>
                                                                <th rowspan="2">Action</th>
                                                            </tr>
                                                            <tr>
                                                               <th>Product</th>
                                                                <th>Total Amount</th>
                                                                <th>Payment</th>
                                                                <th>Date Ordered</th> 
                                                            </tr>
                                                        </thead>
                                                        <tbody>
<?php
                                            $query = "
                                                SELECT
                                                    o.payment,
                                                    o.order_item_id,
                                                    o.quantity,
                                                    o.unit_price,
                                                    o.total_price,
                                                    i.order_id,
                                                    i.order_date,
                                                    i.total_amount,
                                                    i.status,
                                                    p.product_id,
                                                    p.product_name,
                                                    p.quantity_in_stock,
                                                    p.price,
                                                    p.product_size,
                                                    p.product_color,
                                                    c.customer_id,
                                                    c.customer_name,
                                                    c.contact_number,
                                                    v.category_id,
                                                    v.category_name,
                                                    b.brand_id,
                                                    b.brand_name
                                                FROM order_item_table o
                                                LEFT JOIN order_table i ON o.order_id = i.order_id
                                                LEFT JOIN product_table p ON o.product_id = p.product_id
                                                LEFT JOIN customer_table c ON i.customer_id = c.customer_id
                                                LEFT JOIN category_table v ON p.category_id = v.category_id
                                                LEFT JOIN brand_table b ON p.brand_id = b.brand_id
                                                WHERE o.total_price = o.payment  ORDER BY i.order_date DESC";

                                            $result = mysqli_query($conn, $query);
                                             
                                            // Check if any orders exist
                                            if (mysqli_num_rows($result) > 0) {
                                                // Iterate through each order and display in the table
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    // Format total_amount and payment with commas and 2 decimal places
                                                    $unit_price = number_format($row['unit_price'], 2);
                                                    $formatted_item_total_price = number_format($row['unit_price']*$row['quantity'], 2);
                                                    $formatted_payment = number_format($row['payment'], 2);

                                            $orderDate = new DateTime($row['order_date']);
                                            $orderDateFormatted = $orderDate->format('g:i A, l, F j, Y'); // Format: MM dd, yyyy HH:mm pm

                                                    // Generate the order code
        $orderCode = generateOrderCode(
            $row['category_id'], 
            $row['brand_id'], 
            $row['product_id'], 
            $row['customer_id'], 
            $row['order_id'], 
            $row['order_item_id']
        );
                                            // Calculate the time difference
                                            $interval = $now->diff($orderDate);

                                            // Check if the difference is within a week or more
                                            if ($interval->y > 0) {
                                                // If the difference is more than a year
                                                $orderDateFormatted = $orderDate->format('g:i A, l, F j, Y');
                                            } elseif ($interval->m > 0) {
                                                // If the difference is more than a month
                                                $orderDateFormatted = $orderDate->format('g:i A, l, F j, Y');
                                            } elseif ($interval->d > 7) {
                                                // If the difference is more than a week
                                                $orderDateFormatted = $orderDate->format('g:i A, l, F j, Y');
                                            } elseif ($interval->d >= 1) {
                                                // If the order is from 1 day to 7 days ago
                                                $orderDateFormatted = $interval->d . " day" . ($interval->d > 1 ? "s" : "") . " ago";
                                            } elseif ($interval->h >= 1) {
                                                // If the order is from 1 hour to less than a day ago
                                                $orderDateFormatted = $interval->h . " hour" . ($interval->h > 1 ? "s" : "") . " ago";
                                            } elseif ($interval->i >= 1) {
                                                // If the order is from 1 minute to less than an hour ago
                                                $orderDateFormatted = $interval->i . " minute" . ($interval->i > 1 ? "s" : "") . " ago";
                                            } else {
                                                // If the order was placed just now
                                                $orderDateFormatted = "Just now";
                                            }
                                                        echo "<tr id='order-row-{$row['order_item_id']}'>
                                                                <td>{$row['customer_name']}</td>
                                                                <td>{$row['product_name']}</td>
                                                                <td>₱ {$formatted_item_total_price}</td>
                                                                <td>₱ {$formatted_payment}</td>
                                                                <td>{$orderDateFormatted}</td>
                                                                <td style='text-align:center;'>";?>
                                                                <button class="btn btn-primary" onclick="openViewDetailsModal(
                                                                <?php echo $row['order_item_id']; ?>,
                                                                '<?php echo $row['order_id']; ?>',
                                                                '<?php echo $row['customer_id']; ?>',
                                                                '<?php echo $row['category_id']; ?>',
                                                                '<?php echo $row['brand_id']; ?>',
                                                                '<?php echo $row['product_id']; ?>',
                                                                '<?php echo $row['customer_name']; ?>',
                                                                '<?php echo $row['contact_number']; ?>',
                                                                '<?php echo $row['category_name']; ?>',
                                                                '<?php echo $row['brand_name']; ?>',
                                                                '<?php echo $row['product_name']; ?>',
                                                                '<?php echo $row['product_size']; ?>',
                                                                '<?php echo $row['product_color']; ?>',
                                                                '<?php echo $row['status']; ?>',
                                                                <?php echo $row['quantity']; ?>,
                                                                <?php echo $row['price']; ?>,
                                                                <?php echo $row['unit_price']; ?>,
                                                                '<?php echo $formatted_total_amount; ?>',
                                                                '<?php echo $formatted_payment; ?>'
                                                            )">
                                                                View Details
                                                            </button>
                                    <?php echo "</td></tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='6'>No completed orders found.</td></tr>";
                                                }
                                                ?>

                                                        </tbody>
                                                    </table>
<!-- View Details Modal -->
<div class="modal fade" id="view-details-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-dolly"></i> &nbsp; View Order Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="view_order_code">Order Number:</label>
                        <p id="view_order_code"></p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="view_customer_name">Customer:</label>
                        <p id="view_customer_name"></p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="view_contact_number">Contact Number:</label>
                        <p id="view_contact_number"></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="view_product_name">Product Item:</label>
                        <p id="view_product_name"></p>
                        <!-- <p id="view_product_detail"></p> -->
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="view_product_name">Product Details:</label>
                        <!-- <p id="view_product_name"></p> -->
                        <p id="view_product_detail"></p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="view_status">Payment Status:</label>
                        <br>
                        <span class="badge bg-success"> Completed</span>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="view_quantity">Quantity:</label>
                        <p id="view_quantity"></p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="view_total_item_price">Price:</label>
                        <p id="view_total_item_price"></p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="view_payment">Payment:</label>
                        <p id="view_payment"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


                                                 </div>
                                                 <!-- /.card-body -->
                                             </div>
                                             <!-- /.card -->
                                         </div>
                                     </div>
                                </div>
                            </div>

                        

<!-- Place Order modal form -->
<div class="modal fade" id="add-order">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-tags"></i> &nbsp Order Product Detail: </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="functions/insert_sql.php" method="post">
                    <!-- Customer Information Section -->
                    <div class="row">
                        <h5 class="col-12"> &nbsp Customer Information:</h5>
                        <div class="col-md-6 mb-3"> <!-- Added mb-3 here for spacing -->
                            <input type="text" name="customer_name" class="form-control form-control-md" placeholder="Customer Name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" name="contact_number" class="form-control form-control-md" placeholder="Contact Number">
                        </div>
<!--                         <div class="col-md-6 mb-3">
                            <input type="text" name="email" class="form-control form-control-md" placeholder="Email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" name="address" class="form-control form-control-md" placeholder="Address">
                        </div> -->
                    </div>
                    <hr>
                    <!-- Dynamic Order Items Section -->
<div id="order-items">
<!-- Initial Product Selection -->
<div class="order-item" id="order-item-0">
    <!-- Order Detail Section -->
    <div class="row">
        <h5 class="col-12"> &nbsp Item Detail:</h5>
        <div class="col-md-4 mb-3">
            <select class="form-control form-control-md" name="category_id[]" id="categorySelect-0" onchange="fetchBrand(0)">
                <option selected hidden disabled>Product Category</option>
                <?php
                $query = "SELECT * FROM category_table";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='". $row['category_id'] ."'>". $row['category_name']."</option>";
                    }
                } else {
                    echo "<option disabled>No Categories Available</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <select class="form-control form-control-md" name="brand_id[]" id="brandSelect-0" onchange="fetchProducts(0)">
                <option selected hidden disabled>Brand</option>
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <select class="form-control form-control-md" name="product_name[]" id="productSelect-0" onchange="fetchSize(0)">
                <option selected hidden disabled>Select Item</option>
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <select class="form-control form-control-md" name="product_size[]" id="sizeSelect-0" onchange="fetchColor(0)">
                <option selected hidden disabled> Size Available</option>
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <select class="form-control form-control-md" name="product_color[]" id="colorSelect-0" onchange="fetchPrice(0)">
                <option selected hidden disabled>Color Available</option>
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <select class="form-control form-control-md" name="order_table_status[]" id="statusSelect-0" onchange="handlePaymentStatusChange(0)">
                <option selected hidden disabled>Payment Status</option>
                <option value="Completed">Full Payment</option>
                <option value="Ongoing">Partial Payment</option>
            </select>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="quantityInput-0"> Quantity </label>
            <input type="number" class="form-control" name="quantity[]" id="quantityInput-0" placeholder="Quantity" value="1" oninput="fetchPrice(0)">
        </div>
        

        <div class="col-md-4 mb-3">
            <label for="priceInput-0"> Price </label>
            <input type="text" class="form-control" name="price[]" id="priceInput-0" placeholder="Product Price (₱)" readonly>
        </div>
        <div class="col-md-4 mb-3">
            <label for="paymentInput-0"> Payment </label>
            <input type="text" class="form-control" name="payment[]" id="paymentInput-0" placeholder="Payment (₱)" oninput="validatePaymentInput(this)">
        </div>
    </div>
</div>
                    <hr>

                    <button type="button" class="btn btn-secondary" onclick="addItem()">Add Another Item</button>
                    <hr>
                    <script>
                    function validatePaymentInput(inputElement) {
                        // Remove non-numeric characters except for the decimal point
                        inputElement.value = inputElement.value.replace(/[^0-9\.]/g, '');

                        // Ensure only one decimal point is allowed
                        if ((inputElement.value.match(/\./g) || []).length > 1) {
                            inputElement.value = inputElement.value.replace(/\.(?=.*\.)/g, ''); // Remove extra decimal points
                        }
                    }

                    // Global counter for dynamically added order items
                    let itemCount = 0;

                    // Fetch brands based on selected category
                    function fetchBrand(itemId) {
                        const categoryId = document.getElementById(`categorySelect-${itemId}`).value;
                        const brandSelect = document.getElementById(`brandSelect-${itemId}`);
                        brandSelect.innerHTML = '<option selected hidden disabled>Select Brand</option>'; // Clear previous brands

                        fetch(`functions/fetch_brands.php?category_id=${categoryId}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.length > 0) {
                                    data.forEach(brand => {
                                        const option = document.createElement('option');
                                        option.value = brand.brand_id;
                                        option.textContent = brand.brand_name;
                                        brandSelect.appendChild(option);
                                    });
                                } else {
                                    const option = document.createElement('option');
                                    option.disabled = true;
                                    option.textContent = 'No Brands Available';
                                    brandSelect.appendChild(option);
                                }
                            })
                            .catch(error => console.error('Error fetching brands:', error));
                    }

                    // Fetch products based on selected brand
                    function fetchProducts(itemId) {
                        const brandId = document.getElementById(`brandSelect-${itemId}`).value;
                        const productSelect = document.getElementById(`productSelect-${itemId}`);
                        
                        fetch(`functions/fetch_products.php?brand_id=${brandId}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.length > 0) {
                                    data.forEach(product => {
                                        const option = document.createElement('option');
                                        option.value = product.product_name;  // Set product_id as the value
                                        option.textContent = product.product_name;
                                        productSelect.appendChild(option);
                                    });
                                } else {
                                    const option = document.createElement('option');
                                    option.disabled = true;
                                    option.textContent = 'No Products Available';
                                    productSelect.appendChild(option);
                                }
                            })
                            .catch(error => console.error('Error fetching products:', error));
                    }


                    // Fetch size and color based on selected product
                    function fetchSize(itemId) {
                        const productName = document.getElementById(`productSelect-${itemId}`).value;
                        const sizeSelect = document.getElementById(`sizeSelect-${itemId}`);
                        const colorSelect = document.getElementById(`colorSelect-${itemId}`);
                        
                        // Clear size and color options
                        sizeSelect.innerHTML = '<option selected hidden disabled>Select Size</option>';
                        colorSelect.innerHTML = '<option selected hidden disabled>Select Color</option>'; // Clear previous colors

                        // Fetch size for the selected product
                        fetch(`functions/fetch_size.php?product_name=${productName}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.length > 0) {
                                    data.forEach(item => {
                                        if (item.product_size !== 'N/A') {
                                            const sizeOption = document.createElement('option');
                                            sizeOption.value = item.product_size;
                                            sizeOption.textContent = item.product_size;
                                            sizeSelect.appendChild(sizeOption);
                                        }
                                    });
                                } else {
                                    const noOption = document.createElement('option');
                                    noOption.disabled = true;
                                    noOption.textContent = 'No Sizes Available';
                                    sizeSelect.appendChild(noOption);
                                }
                            })
                            .catch(error => console.error('Error fetching size:', error));
                    }

                    // Fetch color based on selected size
                    function fetchColor(itemId) {
                        const productName = document.getElementById(`productSelect-${itemId}`).value;
                        const productSize = document.getElementById(`sizeSelect-${itemId}`).value;
                        const colorSelect = document.getElementById(`colorSelect-${itemId}`);
                        
                        // Clear previous color options
                        colorSelect.innerHTML = '<option selected hidden disabled>Select Color</option>';

                        // Fetch color for the selected size
                        fetch(`functions/fetch_color.php?product_size=${productSize}&product_name=${productName}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.length > 0) {
                                    data.forEach(item => {
                                        if (item.product_color !== 'N/A') {
                                            const colorOption = document.createElement('option');
                                            colorOption.value = item.product_color;
                                            colorOption.textContent = item.product_color;
                                            colorSelect.appendChild(colorOption);
                                        }
                                    });
                                } else {
                                    const noOption = document.createElement('option');
                                    noOption.disabled = true;
                                    noOption.textContent = 'No Colors Available';
                                    colorSelect.appendChild(noOption);
                                }
                            })
                            .catch(error => console.error('Error fetching color:', error));
                    }

                        // Fetch the price based on product, size, and color
                        function fetchPrice(itemId) {
                            const product_name = document.getElementById(`productSelect-${itemId}`).value;
                            const product_color = document.getElementById(`colorSelect-${itemId}`).value;
                            const product_size = document.getElementById(`sizeSelect-${itemId}`).value;
                            const priceInput = document.getElementById(`priceInput-${itemId}`);
                            const quantityInput = document.getElementById(`quantityInput-${itemId}`); // Assuming quantity is also an input field
                            const paymentInput = document.getElementById(`paymentInput-${itemId}`);

                            fetch(`functions/fetch_price.php?product_color=${product_color}&product_name=${product_name}&product_size=${product_size}`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.price) {
                                        priceInput.value = data.price;

                                        // Calculate total price (price * quantity)
                                        const quantity = parseInt(quantityInput.value) || 1; // Default to 1 if quantity is not set
                                        const totalPrice = data.price * quantity;

                                        // If "Full Payment" is selected, set payment to the full price (totalPrice)
                                        if (document.getElementById(`statusSelect-${itemId}`).value === "Completed") {
                                            paymentInput.value = totalPrice; // Set payment to full amount
                                        }
                                    } else {
                                        priceInput.value = 'Price Not Available';
                                        paymentInput.value = '';
                                    }
                                })
                                .catch(error => console.error('Error fetching price:', error));
                        }

                        // Handle the change in payment status (Full Payment or Partial Payment)
                        function handlePaymentStatusChange(itemId) {
                            const paymentInput = document.getElementById(`paymentInput-${itemId}`);
                            const priceInput = document.getElementById(`priceInput-${itemId}`);
                            const quantityInput = document.getElementById(`quantityInput-${itemId}`);
                            const paymentStatus = document.getElementById(`statusSelect-${itemId}`).value;

                            // Calculate the total price (price * quantity)
                            const price = parseFloat(priceInput.value) || 0;
                            const quantity = parseInt(quantityInput.value) || 1; // Default to 1 if quantity is not set
                            const totalPrice = price * quantity;

                            if (paymentStatus === "Completed") {
                                // If Full Payment is selected, set payment to the total price (full payment)
                                paymentInput.value = totalPrice;
                                paymentInput.readOnly = true;  // Disable editing the payment field for full payment
                            } else if (paymentStatus === "Ongoing") {
                                // If Partial Payment is selected, allow the user to edit the payment
                                paymentInput.readOnly = false;
                                paymentInput.value = '';  // Clear payment input when partial payment is selected
                            }
                        }

                        // You can call fetchPrice function when a user selects the product
                        // Example: fetchPrice(0) when the product is selected for the first time


                        // You can call fetchPrice function when a user selects the product
                        // Example: fetchPrice(0) when the product is selected for the first time


                    // Add another order item dynamically
                    function addItem() {
                        itemCount++; // Increment item count for unique IDs

                        const orderItemsDiv = document.getElementById('order-items');
                        const newItem = document.createElement('div');
                        newItem.classList.add('order-item');
                        newItem.innerHTML = `
                            <div class="row">
                                <h5 class="col-12"> &nbsp Item ${itemCount + 1} Detail:</h5>
                                <div class="col-md-4 mb-3">
                                    <select class="form-control form-control-md" name="category_id[]" id="categorySelect-${itemCount}" onchange="fetchBrand(${itemCount})">
                                        <option selected hidden disabled>Select Category</option>
                                        <?php
                                        $query = "SELECT * FROM category_table";
                                        $result = mysqli_query($conn, $query);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='". $row['category_id'] ."'>". $row['category_name']."</option>";
                                            }
                                        } else {
                                            echo "<option disabled>No Categories Available</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <select class="form-control form-control-md" name="brand_id[]" id="brandSelect-${itemCount}" onchange="fetchProducts(${itemCount})">
                                        <option selected hidden disabled>Select Brand</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <select class="form-control form-control-md" name="product_name[]" id="productSelect-${itemCount}" onchange="fetchSize(${itemCount})">
                                        <option selected hidden disabled>Select Product</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <select class="form-control form-control-md" name="product_size[]" id="sizeSelect-${itemCount}" onchange="fetchColor(${itemCount})">
                                        <option selected hidden disabled>Select Size</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <select class="form-control form-control-md" name="product_color[]" id="colorSelect-${itemCount}" onchange="fetchPrice(${itemCount})">
                                        <option selected hidden disabled>Select Color</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <select class="form-control form-control-md" name="order_table_status[]" id="statusSelect-${itemCount}" onchange="handlePaymentStatusChange(${itemCount})">
                                        <option selected hidden disabled>Payment Status</option>
                                        <option value="Completed">Full Payment</option>
                                        <option value="Ongoing">Partial Payment</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="quantityInput-${itemCount}"> Quantity </label>
                                    <input type="number" class="form-control" name="quantity[]" id="quantityInput-${itemCount}" placeholder="Quantity" value="1" oninput="fetchPrice(${itemCount})">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="priceInput-${itemCount}"> Price </label>
                                    <input type="text" class="form-control" name="price[]" id="priceInput-${itemCount}" placeholder="Product Price (₱)" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="paymentInput-${itemCount}"> Payment </label>
                                    <input type="text" class="form-control" name="payment[]" id="paymentInput-${itemCount}" placeholder="Payment (₱)" oninput="validatePaymentInput(this)">
                                </div>
                            </div>
                        `;

                        orderItemsDiv.appendChild(newItem);
                    }

                    </script>
                </div>

                    <!-- Action Buttons -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Close</button>
                                </div>
                                <div class="col-md-6 text-right mb-3">
                                    <button type="submit" name="submit-order" class="btn btn-primary btn-md">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

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

     $(document).ready(function() {
         // Initialize shoes-table by default
             $('#order-table').DataTable({
        "paging": true,             // Enable pagination
        "lengthChange": true,       // Allow user to change number of entries shown
        "searching": true,          // Enable search functionality
        "ordering": true,           // Enable sorting
        "info": true,               // Show info (e.g., "Showing 1 to 10 of 50 entries")
        "autoWidth": true,          // Automatically adjust column widths
        "responsive": true,         // Make the table responsive
        "order": [[0, 'desc']],     // Set default sorting order to descending (on the first column)
        "scrollY": '500px',         // Set the height for the table's vertical scroll
        "scrollCollapse": true,  
        "pageLength": 5            

    });

         // Reinitialize bags-table and clothes-table when their tabs are shown
         $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
             var target = $(e.target).attr("href"); // Get the target tab

             if (target === "#ongoing") {
                 if (!$.fn.DataTable.isDataTable('#ongoing-table')) {
                     $('#ongoing-table').DataTable({
                         "paging": true,
                         "lengthChange": true,
                         "searching": true,
                         "ordering": true,
                         "info": true,
                         "autoWidth": true,
                         "responsive": true,
                         "pageLength": 10 // Display 10 items per page
                     });
                 }
             }
         });
         $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
             var target = $(e.target).attr("href"); // Get the target tab

             if (target === "#completed") {
                 if (!$.fn.DataTable.isDataTable('#completed-table')) {
                     $('#completed-table').DataTable({
                         "paging": true,
                         "lengthChange": true,
                         "searching": true,
                         "ordering": true,
                         "info": true,
                         "autoWidth": true,
                         "responsive": true,
                         "pageLength": 10 // Display 10 items per page
                     });
                 }
             }
         });
     });
// Function to open the edit modal and populate it with data
// Function to open the edit modal and populate it with data
function openEditModal(
    order_item_id, order_id, customer_id, category_id, brand_id, product_id, 
    customer_name, contact_number, category_name, brand_name, product_name, 
    product_size, product_color, status, quantity, price, unit_price, formatted_total_amount, formatted_payment
) {
    console.log('Edit Modal opened with:', arguments);
    // Set the values in the modal fields
    $('#edit_order_item_id').val(order_item_id);
    $('#edit_order_id').val(order_id);
    $('#edit_customer_id').val(customer_id);
    $('#edit_category_id').val(category_id);
    $('#edit_brand_id').val(brand_id);
    $('#edit_product_id').val(product_id);

    $('#edit_customer_name').text(customer_name);
    $('#edit_contact_number').text(contact_number);
    $('#edit_category_name').text(category_name);
    $('#edit_brand_name').text(brand_name);
    $('#edit_product_name').text(product_name);
    $('#edit_product_size').text(product_size);
    $('#edit_product_color').text(product_color);
    $('#edit_status').text(status);

    $('#edit_quantity').val(quantity);
    $('#edit_price').val(price);
    $('#edit_unit_price').text(unit_price);

    $('#edit_total_amount').text(formatted_total_amount);
    $('#edit_payment').val(formatted_payment);

    // Calculate total item price
    var total_item_price = unit_price * quantity;
    var formatted_total_item_price = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'PHP',
        minimumFractionDigits: 2,
    }).format(total_item_price);

    $('#edit_total_item_price').text(formatted_total_item_price);

    // Generate order code
    let orderNumber = generateOrderCode(category_id, brand_id, product_id, customer_id, order_id, order_item_id);
    $('#edit_order_code').text(orderNumber);

    // Generate product detail
    let productDetail = generateProductDetail(brand_name, product_size, product_color);
    $('#edit_product_detail').text(productDetail);

    // Generate product item
    let productItem = generateProductItem(product_name, quantity);
    $('#edit_product_item').text(productItem);

    // Show the modal
    $('#edit-stocks').modal('show');
}


// Function to generate the order code
function generateOrderCode(category_id, brand_id, product_id, customer_id, order_id, order_item_id) {
    // Format category_id, brand_id, and product_id with leading zeroes for single digits
    let C = 'C' + ('0' + category_id).slice(-2);  // Ensure two digits for category ID
    let B = 'B' + ('0' + brand_id).slice(-2);      // Ensure two digits for brand ID
    let P = 'P' + product_id;                     // Product ID does not need leading zeroes, as it might be a single digit
    
    // Combine them with the customer_id, order_id, and order_item_id
    let orderCode = `${C}${B}${P}-${customer_id}${order_id}${order_item_id}`;

    return orderCode;
}

function generateProductDetail( brand_name, product_size, product_color) {
    let brand = brand_name;
    let size = product_size + ' size,';
    let color = 'color ' + product_color;
    
    // Combine them into a single product detail string
    let product_detail = `${brand}, ${size} ${color}`;

    return product_detail;
}

// Generate product item
function generateProductItem(product_name, quantity) { 
    let product = product_name;
    let product_item;
    if (quantity > 1) {
        product_item = `${quantity} ${product_name}s`;  // Plural form
    } else {
        product_item = `${quantity} ${product_name}`;   // Singular form
    }
    return product_item;
}


// Function to open the view details modal and populate it with data
function openViewDetailsModal(
    order_item_id, order_id, customer_id, category_id, brand_id, product_id, 
    customer_name, contact_number, category_name, brand_name, product_name, 
    product_size, product_color, status, quantity, price, unit_price, formatted_total_amount, formatted_payment
) {
    // Set the values in the modal fields
    $('#view_order_code').text(generateOrderCode(category_id, brand_id, product_id, customer_id, order_id, order_item_id));  // Order Number
    $('#view_customer_name').text(customer_name); // Customer Name
    $('#view_contact_number').text(contact_number); // Contact Number
    $('#view_product_name').text(product_name); // Product Name
    $('#view_product_detail').text(generateProductDetail(brand_name, product_size, product_color)); // Product Details
    $('#view_unit_price').text(unit_price); 
    $('#view_price').text(price); 
    $('#view_status').text(status); // Payment Status
    $('#view_quantity').text(quantity); // Quantity
    $('#view_total_amount').text(formatted_total_amount); // Total Amount
    $('#view_payment').text(formatted_payment); // Payment

    // Calculate total item price
    var total_item_price = unit_price * quantity;

    // Format total item price to readable numbers (thousands, millions, etc.)
    var formatted_total_item_price = new Intl.NumberFormat('en-US', {
        style: 'currency', // Format as currency
        currency: 'PHP',   // Philippine Peso (you can change this if needed)
        minimumFractionDigits: 2, // Set to 2 decimal places
    }).format(total_item_price);

    // Display the formatted total item price in the modal
    $('#view_total_item_price').text(formatted_total_item_price);

    // Show the modal
    $('#view-details-modal').modal('show');
}



     function removeCategory(category_id) {
         Swal.fire({
             title: 'Are you sure?',
             text: "You won't be able to revert this!",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Yes, delete it!',
             width: '30%',  // Adjust the width here

         }).then((result) => {
             if (result.isConfirmed) {
                 // Perform AJAX request to remove category
                 var xhr = new XMLHttpRequest();
                 xhr.open("POST", "functions/delete_sql.php", true);
                 xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                 xhr.onreadystatechange = function() {
                     if (xhr.readyState == 4 && xhr.status == 200) {
                         // Parse the JSON response
                         var response = JSON.parse(xhr.responseText);

                         // Check if the removal was successful
                         if (response.status === "success") {
                             // Remove the row from the table
                             var row = document.getElementById("category-row-" + category_id);
                             if (row) {
                                 row.parentNode.removeChild(row);
                             }
                             // Show SweetAlert message
                             Swal.fire({
                                 icon: 'success',
                                 title: response.message,
                                 position: 'top-end',
                                 showConfirmButton: false,
                                 timer: 1500,
                                 customClass: {
                                     popup: 'swal2-popup'
                                 }
                             });
                         } else {
                             // Show error message
                             Swal.fire({
                                 icon: 'error',
                                 title: response.message,
                                 position: 'top-end',
                                 showConfirmButton: false,
                                 timer: 1500,
                                 customClass: {
                                     popup: 'swal2-popup'
                                 }
                             });
                         }
                     }
                 };
                 xhr.send("category_id=" + category_id);
             }
         });
     }

     function removeBrand(brand_id) {
         Swal.fire({
             title: 'Are you sure?',
             text: "You won't be able to revert this!",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Yes, delete it!',
             width: '30%',  // Adjust the width here

         }).then((result) => {
             if (result.isConfirmed) {
                 // Perform AJAX request to remove brand
                 var xhr = new XMLHttpRequest();
                 xhr.open("POST", "functions/delete_sql.php", true);
                 xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                 xhr.onreadystatechange = function() {
                     if (xhr.readyState == 4 && xhr.status == 200) {
                         // Parse the JSON response
                         var response = JSON.parse(xhr.responseText);

                         // Check if the removal was successful
                         if (response.status === "success") {
                             // Remove the row from the table
                             var row = document.getElementById("brand-row-" + brand_id);
                             if (row) {
                                 row.parentNode.removeChild(row);
                             }
                             // Show SweetAlert message
                             Swal.fire({
                                 icon: 'success',
                                 title: response.message,
                                 position: 'top-end',
                                 showConfirmButton: false,
                                 timer: 1500,
                                 customClass: {
                                     popup: 'swal2-popup'
                                 }
                             });
                         } else {
                             // Show error message
                             Swal.fire({
                                 icon: 'error',
                                 title: response.message,
                                 position: 'top-end',
                                 showConfirmButton: false,
                                 timer: 1500,
                                 customClass: {
                                     popup: 'swal2-popup'
                                 }
                             });
                         }
                     }
                 };
                 xhr.send("brand_id=" + brand_id);
             }
         });
     }
 </script>