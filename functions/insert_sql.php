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


if (isset($_POST['submit-order'])) {
    // Step 1: Insert into customer_table
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
    /*$email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);*/

    // Insert the customer and retrieve the customer_id
    $customer_id = insertRecord(
        'customer_table',
        '`customer_name`, `contact_number`',
        "'$customer_name', '$contact_number'",
        "Customer added successfully!",
        "Error adding customer! Please try again."
    );

    if ($customer_id) {
        // Step 2: Insert into order_table with customer_id and payment status
        $order_date = date('Y-m-d H:i:s'); // Store the current date and time
        // Ensure to access the first value from the array
        $payment_status = mysqli_real_escape_string($conn, $_POST['order_table_status'][0]); // Get the payment status from the form

        // Get arrays for product_name, product_color, product_size, quantity, and price
        $product_names = $_POST['product_name'];
        $product_colors = $_POST['product_color'];
        $product_sizes = $_POST['product_size'];
        $quantities = $_POST['quantity'];
        $prices = $_POST['price'];
        $payments = $_POST['payment']; // Get payment values for each product

        // Calculate the total amount for the order
        $total_amount = 0;
        foreach ($quantities as $index => $quantity) {
            $total_amount += $quantity * $prices[$index];  // Add total price of each product to the overall total amount
        }

        // Insert the order and retrieve the order_id
        $order_id = insertRecord(
            'order_table',
            '`customer_id`, `order_date`, `total_amount`, `status`',
            "'$customer_id', '$order_date', '$total_amount', '$payment_status'",
            "Order placed successfully!",
            "Error placing order! Please try again."
        );

        if ($order_id) {
            // Step 3: Insert each product into order_item_table using the order_id and payment
            foreach ($product_names as $index => $product_name) {
                // Fetch product_id using product_name, product_color, product_size
                $product_color = mysqli_real_escape_string($conn, $product_colors[$index]);
                $product_size = mysqli_real_escape_string($conn, $product_sizes[$index]);
                $quantity = mysqli_real_escape_string($conn, $quantities[$index]);
                $price = mysqli_real_escape_string($conn, $prices[$index]);
                $total_price = $quantity * $price;
                $payment = mysqli_real_escape_string($conn, $payments[$index]); // Get payment for each item

                // Query to get the product_id
                $sql = "SELECT product_id FROM product_table WHERE product_name = '$product_name' AND product_color = '$product_color' AND product_size = '$product_size' LIMIT 1";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    $product = mysqli_fetch_assoc($result);
                    $product_id = $product['product_id'];

                    // Insert the order item into the database
                    $item_values = "'$order_id', '$product_id', '$quantity', '$price', '$total_price', '$payment'";
                    insertRecord(
                        'order_item_table',
                        '`order_id`, `product_id`, `quantity`, `unit_price`, `total_price`, `payment`',
                        $item_values,
                        "Item added successfully!",
                        "Error adding item! Please try again."
                    );
                } else {
                    // Handle case where product not found
                    die("Error: Product not found in the product table.");
                }
            }

            // After inserting the order and items, redirect to a success page
            header("Location: ../transactions.php"); // Redirect to a success page
            exit();
        }
    }
}




$conn->close();
?>