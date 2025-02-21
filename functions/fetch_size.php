<?php
include 'db_con.php';

if (isset($_GET['product_name'])) {

    $product_name = $_GET['product_name'];
    // $product_name = 'Air Max 270';

    // Fetch product sizes and colors based on product_name
    $query = "SELECT product_size, product_color FROM product_table WHERE product_name LIKE ? GROUP BY product_size ORDER BY MIN(product_id) ASC";
    $product_name = '%'.$product_name.'%'; // Add wildcards before binding
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $product_name);
    $stmt->execute();
    $result = $stmt->get_result();

    $sizes_and_colors = [];
    while ($row = $result->fetch_assoc()) {
        // Handle NULL values for size and color
        if (is_null($row['product_size'])) {
            $sizes_and_colors[] = ['product_size' => 'N/A', 'product_size' => $row['product_size']];
        } else {
            $sizes_and_colors[] = $row;
        }
    }
    // echo $sizes_and_colors;
    // Return JSON response
    echo json_encode($sizes_and_colors);

        // for testing results
/*        echo '<pre>';  
        print_r($sizes_and_colors);
        echo '</pre>';

        echo '<pre>';
        var_dump($sizes_and_colors);
        echo '</pre>';*/

}

$conn->close();
?>
