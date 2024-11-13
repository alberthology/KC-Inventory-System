<?php
// Database connection
include 'functions/db_con.php';

// Sample data for a new order
$customer_id = "1";
$order_date = date("Y-m-d");
$order_items = [
    ['product_id' => 3, 'quantity' => 2, 'unit_price' => 50.00],
    ['product_id' => 6, 'quantity' => 1, 'unit_price' => 100.00]
];

// Step 1: Insert into order_table
$total_amount = 0;
foreach ($order_items as $item) {
    $total_amount += $item['quantity'] * $item['unit_price'];
}

$order_sql = "INSERT INTO order_table (customer_id, order_date, total_amount) VALUES ('$customer_id', '$order_date', $total_amount)";
if ($conn->query($order_sql) === TRUE) {
    $order_id = $conn->insert_id; // Get the last inserted order_id

    // Step 2: Insert each item into order_item_table
    foreach ($order_items as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $unit_price = $item['unit_price'];
        $total_price = $quantity * $unit_price;

        $item_sql = "INSERT INTO order_item_table (order_id, product_id, quantity, unit_price, total_price) VALUES ($order_id, $product_id, $quantity, $unit_price, $total_price)";
        
        if (!$conn->query($item_sql)) {
            echo "Error inserting order item: " . $conn->error;
        }
    }
    echo "Order created successfully with Order ID: $order_id";
} else {
    echo "Error creating order: " . $conn->error;
}

// Close the connection
$conn->close();
?>
