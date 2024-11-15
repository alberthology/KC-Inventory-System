<?php
session_start();
include 'db_con.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the category ID from the AJAX request
    $category_id = $_POST['category_id'];

    // Prepare the DELETE query
    $query = "DELETE FROM category_table WHERE category_id = $category_id";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Category removed successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error removing category!']);
    }

    mysqli_close($conn);
}
