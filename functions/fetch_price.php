<?php
include 'db_con.php';

if (isset($_GET['product_color']) && isset($_GET['product_size']) && isset($_GET['product_name']) ) {
    $product_name = $_GET['product_name'];
    $product_color = $_GET['product_color'];
    $product_size = $_GET['product_size'];

    // Fetch price and quantity_in_stock based on product_name, product_color, and product_size
    $query = "SELECT price, quantity_in_stock FROM product_table WHERE product_name = ? AND product_color = ? AND product_size = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $product_name, $product_color, $product_size);
    $stmt->execute();
    $result = $stmt->get_result();

    $product = $result->fetch_assoc();

    // Return JSON response with both price and quantity_in_stock
    echo json_encode([
        'price' => $product['price'],
        'quantity_in_stock' => $product['quantity_in_stock']
    ]);
}

$conn->close();
?>
