<?php
include 'db_con.php';

if (isset($_GET['brand_id'])) {
    $brand_id = $_GET['brand_id'];

    // Fetch products based on brand_id
    $query = "SELECT product_id, brand_id, product_name FROM product_table WHERE brand_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $brand_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    // Return JSON response
    echo json_encode($products);
}

$conn->close();
?>
