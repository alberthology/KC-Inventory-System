<?php
session_start();
include 'db_con.php';

// Function to handle the insert and set session messages
function insertRecord($table, $columns, $values, $successMessage, $errorMessage) {
    global $conn;

    // Build the SQL insert query
    $sql = "INSERT INTO $table ($columns) VALUES ($values)";

    // Execute the query and set session message based on the result
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = $successMessage;
        $_SESSION['message_type'] = "success"; // success type
    } else {
        $_SESSION['message'] = $errorMessage . $conn->error;
        $_SESSION['message_type'] = "error"; // error type
    }
}

if (isset($_POST['submit-category'])) {
    $category = $_POST['category'];
    $description = $_POST['description'];

    // Call insert function for category
    insertRecord(
        'category_table',
        '`category_name`, `description`',
        "'$category', '$description'",
        "Category added successfully!",
        "Error adding category! Please try again. "
    );

    // Redirect to stocks-options.php
    header("Location: ../stocks-options.php");
    exit();
}

if (isset($_POST['submit-brand'])) {
    $brand = $_POST['brand'];
    $origin_country = $_POST['origin_country'];
    $description = $_POST['description'];

    // Call insert function for brand
    insertRecord(
        'brand_table',
        '`brand_name`, `description`, `country_of_origin`',
        "'$brand', '$description', '$origin_country'",
        "Brand added successfully!",
        "Error adding brand! Please try again. "
    );

    // Redirect to stocks-options.php
    header("Location: ../stocks-options.php");
    exit();
}

if (isset($_POST['submit-product'])) {
    $Product = $_POST['Product'];
    $category_id  = $_POST['category_id'];
    $brand_id = $_POST['brand_id'];
    $supplier_id = isset($_POST['supplier_id']) ? $_POST['supplier_id'] : 'NULL'; // Set to NULL if not provided
    $Quantity = $_POST['Quantity'];
    $Price = $_POST['Price'];
    $description = $_POST['description'];

    // Build values string, replacing supplier_id with NULL if it's empty
    $values = "'$Product', '$category_id', '$description', '$Quantity', '$Price', $supplier_id, '$brand_id'";

    // Call insert function for brand
    insertRecord(
        'product_table',
        '`product_name`, `category_id`, `description`, `quantity_in_stock`, `price`, `supplier_id`, `brand_id` ',
        $values,
        "Product added successfully!",
        "Error adding Product! Please try again. "
    );

    // Redirect to products.php (if uncommented)
    header("Location: ../products.php");
    exit();
}

$conn->close();
?>
