<?php
// Database connection
    include 'functions/db_con.php';


// Function to add an order with items
function addOrderWithItems($conn, $customer_id, $items) {
    // Insert order data into order_table
    $sql = "INSERT INTO order_table (customer_id, order_date) VALUES ($customer_id, NOW())";
    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;

        // Insert each item into order_item_table
        $totalAmount = 0;
        foreach ($items as $item) {
            $product_id = $item['product_id'];
            $unit_price = $item['price'];
            $quantity = $item['quantity'];
            $totalAmount += $unit_price * $quantity;

            $sql = "INSERT INTO order_item_table (order_id, product_id, unit_price, quantity) VALUES ($order_id, $product_id, $unit_price, $quantity)";
            $conn->query($sql);
        }

        // Update total_amount in order_table
        $sql = "UPDATE order_table SET total_amount = $totalAmount WHERE order_id = $order_id";
        $conn->query($sql);

        echo "Order placed successfully! Order ID: $order_id<br>Total Amount: $totalAmount<br>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Sample data for an order with multiple items
$customer_id = 1; // Assume customer ID 1
$items = [
    ['product_id' => 3, 'price' => 15, 'quantity' => 2], // Product A: $15 x 2
    ['product_id' => 4, 'price' => 20, 'quantity' => 1], // Product B: $20 x 1
    ['product_id' => 6, 'price' => 10, 'quantity' => 3], // Product C: $10 x 3
];

// Place the order with items
addOrderWithItems($conn, $customer_id, $items);

// Retrieve and display the order and items
$order_id = $conn->insert_id; // Get last inserted order ID for display
$sql = "SELECT * FROM order_table WHERE order_id = $order_id";
$orderResult = $conn->query($sql);
$orderData = $orderResult->fetch_assoc();

echo "<h3>Order Summary</h3>";
echo "Order ID: " . $orderData['order_id'] . "<br>";
echo "Customer ID: " . $orderData['customer_id'] . "<br>";
echo "Order Date: " . $orderData['order_date'] . "<br>";
echo "Total Amount: $" . $orderData['total_amount'] . "<br><br>";

echo "<h4>Items in Order</h4>";
$sql = "SELECT * FROM order_item_table WHERE order_id = $order_id";
$itemResult = $conn->query($sql);

while ($item = $itemResult->fetch_assoc()) {
    echo "Product ID: " . $item['product_id'] . "<br>";
    echo "Price per Item: $" . $item['price'] . "<br>";
    echo "Quantity: " . $item['quantity'] . "<br>";
    echo "Total Price for Item: $" . ($item['price'] * $item['quantity']) . "<br><br>";
}

$conn->close();
?>
