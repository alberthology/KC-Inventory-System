<?php
session_start();
include 'db_con.php';

// Enable error reporting for debugging purposes
ini_set('display_errors', 1);
error_reporting(E_ALL);

// The rest of your PHP code follows
function deleteRecord($table, $condition, $successMsg, $errorMsg) {
    global $conn;
    $query = "DELETE FROM $table WHERE $condition";
    if (mysqli_query($conn, $query)) {
        return ['status' => 'success', 'message' => $successMsg];
    } else {
        return ['status' => 'error', 'message' => $errorMsg];
    }
}

// Check if a brand ID is passed for deletion (GET request)
/*if (isset($_GET['brand_id'])) {
    $brand_id = $_GET['brand_id'];*/

    // Call the deleteRecord function for brand deletion
/*    $result = deleteRecord(
        'brand_table', // Table name
        "brand_id = $brand_id", // WHERE condition
        "Brand deleted successfully!",
        "Error deleting brand! Please try again."
    );*/

    // Redirect after deletion if it's a GET request for brand deletion
/*    if ($result['status'] === 'success') {
        header("Location: ../stocks-options.php");
        exit();
    } else {
        echo $result['message'];
    }
}*/

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['brand_id'])) {
    $brand_id = $_POST['brand_id'];

    // Call the deleteRecord function for category deletion
    $result = deleteRecord(
        'brand_table', // Table name
        "brand_id = $brand_id", // WHERE condition
        "Brand removed successfully!",
        "Error removing brand!"
    );

    // Return JSON response for AJAX request
    echo json_encode($result);
    
}


// Check if the request is POST for category deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];

    // Call the deleteRecord function for category deletion
    $result = deleteRecord(
        'category_table', // Table name
        "category_id = $category_id", // WHERE condition
        "Category removed successfully!",
        "Error removing category!"
    );

    // Return JSON response for AJAX request
    echo json_encode($result);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Call the deleteRecord function for category deletion
    $result = deleteRecord(
        'product_table', // Table name
        "product_id = $product_id", // WHERE condition
        "Product removed successfully!",
        "Error removing Product!"
    );

    // Return JSON response for AJAX request
    echo json_encode($result);
}

if ($conn) {
    $conn->close();
}

?>
