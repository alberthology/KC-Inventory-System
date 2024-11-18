<?php
include 'db_con.php';

if (isset($_GET['product_color']) && isset($_GET['product_size']) && isset($_GET['product_name']) ) {
    $product_name = $_GET['product_name'];
    $product_color = $_GET['product_color'];
    $product_size = $_GET['product_size'];

    // Fetch price based on product_id
    $query = "SELECT price FROM product_table WHERE product_name = ? AND product_color = ? AND product_size = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $product_name, $product_color, $product_size);
    $stmt->execute();
    $result = $stmt->get_result();

    $product = $result->fetch_assoc();

    // Return JSON response
    echo json_encode($product);
}

$conn->close();
?>
