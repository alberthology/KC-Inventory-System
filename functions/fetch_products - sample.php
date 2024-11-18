<?php
include 'db_con.php';

if (isset($_GET['brand_id'])) {
    $brand_id = $_GET['brand_id'];

    // Fetch products with size and color based on brand_id
    $query = "SELECT product_id, product_name, product_size, product_color FROM product_table WHERE brand_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $brand_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        // Format product name with size and color if available
        $product_name = $row['product_name'];
        $size = !is_null($row['product_size']) ? $row['product_size'] : '';
        $color = !is_null($row['product_color']) ? $row['product_color'] : '';

        // Combine product name with size and color if available
        if ($size) {
            $product_name .= " | $size size";
        }
        if ($color) {
            $product_name .= " | $color color";
        }

        $row['formatted_name'] = $product_name;  // Add formatted name with size and color to the row
        $products[] = $row;
    }

    // Return JSON response
    echo json_encode($products);
}

$conn->close();
?>
