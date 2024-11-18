<?php
include 'db_con.php';

if (isset($_GET['product_size']) && isset($_GET['product_name'])) {
    $product_size = $_GET['product_size'];
    $product_name = $_GET['product_name'];

    // Prepare the query with placeholders for the parameters
    $query = "SELECT product_size, product_color FROM product_table WHERE product_size = ? AND product_name = ?";
    $stmt = $conn->prepare($query);

    // Bind the parameters
    $stmt->bind_param("ss", $product_size, $product_name);  // "ss" stands for two string parameters

    $stmt->execute();
    $result = $stmt->get_result();

    $product_colors = [];
    while ($row = $result->fetch_assoc()) {
        // If color is null, set as 'N/A'
        if (is_null($row['product_color'])) {
            $product_colors[] = ['product_color' => 'N/A'];
        } else {
            $product_colors[] = $row;
        }
    }

    echo json_encode($product_colors);
}

$conn->close();
?>
