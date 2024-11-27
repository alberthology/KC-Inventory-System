<?php
// get_product_details.php
include('db_con.php');

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Query to fetch product details
    $query = "
        SELECT 
            p.product_id, p.product_name, p.description, p.product_size, p.product_color, 
            c.category_id, c.category_name, b.brand_id, b.brand_name, 
            p.quantity_in_stock, p.price
        FROM product_table p
        LEFT JOIN category_table c ON p.category_id = c.category_id
        LEFT JOIN brand_table b ON p.brand_id = b.brand_id
        WHERE p.product_id = '$product_id'
    ";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        echo json_encode($product);  // Return the product as a JSON response
    } else {
        echo json_encode([]);  // Return an empty array if no product is found
    }
}
?>
