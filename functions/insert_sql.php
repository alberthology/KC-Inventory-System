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
        return $conn->insert_id; // Return the auto-generated ID (for order_id or customer_id)
    } else {
        $_SESSION['message'] = $errorMessage . $conn->error;
        $_SESSION['message_type'] = "error"; // error type
        return false;
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
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];

    // Call insert function for brand
    insertRecord(
        'brand_table',
        '`brand_name`, `category_id`,`description`, `country_of_origin`',
        "'$brand','$category_id', '$description', '$origin_country'",
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


// Check if the form is submitted
if (isset($_POST['submit-order'])) {
    // Start a transaction to ensure atomicity (all or nothing)
    mysqli_begin_transaction($conn);

    try {
        // Insert customer data
        $customerName = mysqli_real_escape_string($conn, $_POST['customer_name']);
        $contactNumber = mysqli_real_escape_string($conn, $_POST['contact_number']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);

        $customerQuery = "INSERT INTO customer_table (customer_name, contact_number, email, address) 
                          VALUES ('$customerName', '$contactNumber', '$email', '$address')";
        if (!mysqli_query($conn, $customerQuery)) {
            throw new Exception('Error inserting customer data');
        }

        // Get the last inserted customer ID
        $customerId = mysqli_insert_id($conn);

        // Insert order data
        $orderQuery = "INSERT INTO order_table (customer_id, order_date) 
                       VALUES ('$customerId', NOW())";
        if (!mysqli_query($conn, $orderQuery)) {
            throw new Exception('Error inserting order data');
        }

        // Get the last inserted order ID
        $orderId = mysqli_insert_id($conn);

        // Insert order items data
        $categoryIds = $_POST['category_id'];  // Array of selected category IDs
        $brandIds = $_POST['brand_id'];        // Array of selected brand IDs
        $productIds = $_POST['product_id'];    // Array of selected product IDs
        $quantities = $_POST['quantity'];      // Array of product quantities
        $prices = $_POST['price'];             // Array of product prices

        for ($i = 0; $i < count($productIds); $i++) {
            // Prepare order item data for each product
            $categoryId = $categoryIds[$i];
            $brandId = $brandIds[$i];
            $productId = $productIds[$i];
            $quantity = $quantities[$i];
            $price = $prices[$i];

            // Insert data into order_item_table
            $orderItemQuery = "INSERT INTO order_item_table (order_id, product_id, category_id, brand_id, quantity, price) 
                               VALUES ('$orderId', '$productId', '$categoryId', '$brandId', '$quantity', '$price')";
            if (!mysqli_query($conn, $orderItemQuery)) {
                throw new Exception('Error inserting order item data');
            }
        }

        // Commit the transaction
        mysqli_commit($conn);
        
        // Redirect or show success message
        echo "Order has been successfully placed!";
        
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage();
    }
}

// Close the database connection

// mysqli_close($conn);

$conn->close();
?>