<?php
include 'db_con.php';

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch price based on product_id
    $query = "SELECT price FROM product_table WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $product = $result->fetch_assoc();

    // Return JSON response
    echo json_encode($product);
}

$conn->close();
?>
