<?php
include 'db_con.php';

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Fetch brands based on category_id
    $query = "SELECT brand_id, brand_name FROM brand_table WHERE category_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $brands = [];
    while ($row = $result->fetch_assoc()) {
        $brands[] = $row;
    }

    // Return JSON response
    echo json_encode($brands);
}

$conn->close();
?>
