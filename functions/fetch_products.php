<?php
include 'db_con.php';

if (isset($_GET['brand_id'])) {
    $brand_id = $_GET['brand_id'];

    // Fetch products based on brand_id
    $query = "SELECT DISTINCT product_id, product_name FROM product_table WHERE brand_id = ? AND quantity_in_stock != 0 GROUP BY product_name ORDER BY MIN(product_id) ASC";
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
