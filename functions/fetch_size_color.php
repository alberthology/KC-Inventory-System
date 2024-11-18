<?php
include 'db_con.php';

if (isset($_GET['product_name'])) {
    $product_name = $_GET['product_name'];

    // Fetch product sizes and colors based on product_name
    $query = "SELECT product_size, product_color FROM product_table WHERE product_name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $product_name);
    $stmt->execute();
    $result = $stmt->get_result();

    $sizes_and_colors = [];
    while ($row = $result->fetch_assoc()) {
        // Handle NULL values for size and color
        if (is_null($row['product_size'])) {
            $sizes_and_colors[] = ['product_size' => 'N/A', 'product_color' => $row['product_color']];
        } elseif (is_null($row['product_color'])) {
            $sizes_and_colors[] = ['product_size' => $row['product_size'], 'product_color' => 'N/A'];
        } else {
            $sizes_and_colors[] = $row;
        }
    }

    // Return JSON response
    echo json_encode($sizes_and_colors);
}

$conn->close();
?>
