<?php
include 'db_con.php';

$response = [];

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Fetch category based on category_id
    $query = "SELECT * FROM category_table WHERE category_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result_category = $stmt->get_result();

    // Fetch brand based on category_id
    $query = "SELECT * FROM brand_table WHERE category_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result_brand = $stmt->get_result();

    $category = [];
    while ($row_category = $result_category->fetch_assoc()) {
        $category[] = $row_category;
    }

    $brand = [];
    while ($row_brand = $result_brand->fetch_assoc()) {
        $brand[] = $row_brand;
    }

    // $response['category'] = $category;
    // $response['brand'] = $brand;

    $category = $category;
    $response['brand'] = $brand;
} else {
    // Handle the case when no category_id is provided
    $response['error'] = 'Category ID is required.';
}

// echo json_encode($response);
    echo json_encode(['category' => $category, 'brand' => $brand]);


$conn->close();
?>
