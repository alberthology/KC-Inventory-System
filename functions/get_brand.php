<?php
// get_brands.php
include('db_con.php'); // Include your DB connection

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Query to fetch brands based on category ID
    $query = "
        SELECT b.brand_id, b.brand_name
        FROM brand_table b
        INNER JOIN category_table c ON b.category_id = c.category_id
        WHERE b.category_id = '$category_id'
    ";
    $result = mysqli_query($conn, $query);

    $brands = array();

    // Check if any brands exist for the selected category
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $brands[] = $row;
        }
    }

    // Return the brands as JSON
    echo json_encode($brands);
}
?>
