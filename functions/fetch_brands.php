<?php
include 'db_con.php';

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Fetch products based on category_id
    $query = "SELECT product_id, brand_id, brand_name FROM brand_table WHERE category_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $category_id);
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
