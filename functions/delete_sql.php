<?php
session_start();
include 'db_con.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Add CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Ensure the response is JSON
header('Content-Type: application/json');

// Utility function for deleting records
function deleteRecord($table, $condition, $successMsg, $errorMsg) {
    global $conn;
    $query = "DELETE FROM $table WHERE $condition";
    if (mysqli_query($conn, $query)) {
        return ['status' => 'success', 'message' => $successMsg];
    } else {
        return ['status' => 'error', 'message' => $errorMsg . ': ' . mysqli_error($conn)];
    }
}

// Main logic
$response = ['status' => 'error', 'message' => 'Invalid request!'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['brand_id'])) {
        $brand_id = intval($_POST['brand_id']);
        $response = deleteRecord(
            'brand_table',
            "brand_id = $brand_id",
            "Brand removed successfully!",
            "Error removing brand"
        );
    } elseif (isset($_POST['category_id'])) {
        $category_id = intval($_POST['category_id']);
        $response = deleteRecord(
            'category_table',
            "category_id = $category_id",
            "Category removed successfully!",
            "Error removing category"
        );
    } elseif (isset($_POST['product_id'])) {
        $product_id = intval($_POST['product_id']);
        $response = deleteRecord(
            'product_table',
            "product_id = $product_id",
            "Product removed successfully!",
            "Error removing product"
        );
    }elseif (isset($_POST['user_id'])) {
        $user_id = intval($_POST['user_id']);
        $response = deleteRecord(
            'user_table',
            "user_id = $user_id",
            "User Account removed successfully!",
            "Error removing User Acocount"
        );
    }
}

// Output the JSON response
echo json_encode($response);

// Close the database connection
if ($conn) {
    $conn->close();
}
?>
