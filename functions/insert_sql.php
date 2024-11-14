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

// Assuming order is placed then handle the customer and order items
if (isset($_POST['submit-order'])) {
    $customer_name = $_POST['customer_name'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Insert customer data first
    $sqlCustomer = "INSERT INTO customer_table (customer_name, contact_number, email, address) VALUES ('$customer_name', '$contact_number', '$email', '$address')";
    if ($conn->query($sqlCustomer) === TRUE) {
        $customer_id = $conn->insert_id;  // Get the new customer_id

        // Insert order data
        $sqlOrder = "INSERT INTO order_table (customer_id, total_amount) VALUES ('$customer_id', 0)";
        if ($conn->query($sqlOrder) === TRUE) {
            $order_id = $conn->insert_id;  // Get the new order_id

            // Loop through each product in the order
            $product_ids = $_POST['product_id'];
            $quantities = $_POST['quantity'];
            $prices = $_POST['price'];

            $totalAmount = 0;

            foreach ($product_ids as $index => $product_id) {
                $quantity = $quantities[$index];
                $unit_price = $prices[$index];
                $total_price = $quantity * $unit_price;

                // Insert each product into the order_item_table
                $sqlOrderItem = "INSERT INTO order_item_table (order_id, product_id, quantity, unit_price, total_price) VALUES ('$order_id', '$product_id', '$quantity', '$unit_price', '$total_price')";
                $conn->query($sqlOrderItem);

                $totalAmount += $total_price;  // Update total amount for the order
            }

            // Update total amount in order_table
            $conn->query("UPDATE order_table SET total_amount = '$totalAmount' WHERE order_id = '$order_id'");
            $_SESSION['message'] = "Order placed successfully!";
        } else {
            $_SESSION['message'] = "Error inserting order: " . $conn->error;
        }
    } else {
        $_SESSION['message'] = "Error inserting customer: " . $conn->error;
    }
}


$conn->close();
?>