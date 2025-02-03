<?php
session_start();
include 'db_con.php';


function insertRecord($table, $columns, $values, $successMessage, $errorMessage) {
    global $conn;

    // Check if $values is an array for prepared statements
    if (is_array($values)) {
        $placeholders = rtrim(str_repeat('?, ', count($values)), ', ');
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        // Prepare the SQL query
        if ($stmt = $conn->prepare($sql)) {
            // Determine the types of the parameters for bind_param
            $types = '';
            foreach ($values as $value) {
                if (is_numeric($value)) {
                    $types .= 'i'; // Integer type
                } else {
                    $types .= 's'; // String type
                }
            }

            // Bind parameters and execute the statement
            $stmt->bind_param($types, ...$values);

            if ($stmt->execute()) {
                $_SESSION['message'] = $successMessage;
                $_SESSION['message_type'] = "success";
                return $conn->insert_id; // Return the auto-generated ID
            } else {
                $_SESSION['message'] = $errorMessage . $stmt->error;
                $_SESSION['message_type'] = "error";
                return false;
            }

            $stmt->close();
        } else {
            $_SESSION['message'] = "Error preparing query: " . $conn->error;
            $_SESSION['message_type'] = "error";
            return false;
        }
    } else {
        // Handle raw SQL string values (backward compatibility)
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = $successMessage;
            $_SESSION['message_type'] = "success";
            return $conn->insert_id; // Return the auto-generated ID
        } else {
            $_SESSION['message'] = $errorMessage . $conn->error;
            $_SESSION['message_type'] = "error";
            return false;
        }
    }
}


if (isset($_POST['submit-category'])) {
    $category = $_POST['category'];
    // $description = $_POST['description'];

    $brand = $_POST['brand'];
    $origin_country = $_POST['origin_country'];
    $description = $_POST['description'];

    // Check for empty required fields
    if (empty($category) || empty($brand)) {
        $_SESSION['message'] = "Category and Brand fields are required!";
        $_SESSION['message_type'] = "error";
        header("Location: ../stocks-options.php");
        exit();
    }
    
    // Check if category already exists
    $query = "SELECT category_id FROM category_table WHERE category_name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $category);  // Bind $category as a string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Category exists, get the category_id
        $row = $result->fetch_assoc();
        $category_id = $row['category_id'];

        // Insert the brand with the existing category_id
        $brand_inserted = insertRecord(
            'brand_table',
            'brand_name, category_id, description, country_of_origin',
            [$brand, $category_id, $description, $origin_country],  // Pass values as array for prepared statements
            "Brand added successfully!",
            "Error adding brand! Please try again."
        );

        if ($brand_inserted) {
            // Redirect to stocks-options.php
            header("Location: ../stocks-options.php");
            exit();
        }
    } else {
        // Category doesn't exist, insert it first
        $category_id = insertRecord(
            'category_table',
            'category_name', // Column names (no need for backticks)
            [$category],  // Pass values as array for prepared statements
            "Category added successfully!",
            "Error adding category! Please try again."
        );

        if ($category_id) {
            // Insert the brand with the new category_id
            $brand_inserted = insertRecord(
                'brand_table',
                'brand_name, category_id, description, country_of_origin',
                [$brand, $category_id, $description, $origin_country],  // Pass values as array
                "Brand added successfully!",
                "Error adding brand! Please try again."
            );

            if ($brand_inserted) {
                // Redirect to stocks-options.php
                header("Location: ../stocks-options.php");
                exit();
            }
        }
    }
}



// Order processing logic
if (isset($_POST['submit-order'])) {
    // Step 1: Insert into customer_table
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
    /*$email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);*/
    // Insert customer record
    $customer_id = insertRecord(
        'customer_table',
        'customer_name, contact_number',
        "'$customer_name', '$contact_number'",
        "Customer added successfully!",
        "Error adding customer! Please try again."
    );

    if ($customer_id) {
        // Step 2: Insert into order_table with customer_id and payment status
        $order_date = date('Y-m-d H:i:s'); // Store the current date and time
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
            $total_amount += $quantity * $prices[$index]; // Add total price of each product to the overall total amount
        }

        // Insert the order and retrieve the order_id
        $order_id = insertRecord(
            'order_table',
            'customer_id, order_date, total_amount, status',
            "'$customer_id', '$order_date', '$total_amount', '$payment_status'",
            "Order placed successfully!",
            "Error placing order! Please try again."
        );

        if ($order_id) {
            // Step 3: Insert each product into order_item_table and log the transaction
            foreach ($product_names as $index => $product_name) {
                // Fetch product details
                $product_color = mysqli_real_escape_string($conn, $product_colors[$index]);
                $product_size = mysqli_real_escape_string($conn, $product_sizes[$index]);
                $quantity = mysqli_real_escape_string($conn, $quantities[$index]);
                $price = mysqli_real_escape_string($conn, $prices[$index]);
                $total_price = $quantity * $price;
                $payment = mysqli_real_escape_string($conn, $payments[$index]);

                // Query to get the product_id and quantity_in_stock
                $sql = "SELECT product_id, quantity_in_stock FROM product_table WHERE product_name = '$product_name' AND product_color = '$product_color' AND product_size = '$product_size' LIMIT 1";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    $product = mysqli_fetch_assoc($result);
                    $product_id = $product['product_id'];
                    $stock_quantity = $product['quantity_in_stock'];

                    // Check if there is enough stock
                    if ($stock_quantity < $quantity) {
                        // If there is not enough stock, show error message and exit
                        $_SESSION['message'] = "Error: Insufficient stock for product $product_name. Available stock: $stock_quantity.";
                        $_SESSION['message_type'] = "error";
                        header("Location: ../transactions.php"); // Redirect to the order page to show the error
                        exit();
                    }

                    // Insert the order item into the database
                    $item_values = "'$order_id', '$product_id', '$quantity', '$price', '$total_price', '$payment'";
                    insertRecord(
                        'order_item_table',
                        'order_id, product_id, quantity, unit_price, total_price, payment',
                        $item_values,
                        "Item added successfully!",
                        "Error adding item! Please try again."
                    );

                    // Update the product stock after the order is placed
                    $new_stock_quantity = $stock_quantity - $quantity;
                    $update_sql = "UPDATE product_table SET quantity_in_stock = '$new_stock_quantity' WHERE product_id = '$product_id'";
                    if ($conn->query($update_sql) === FALSE) {
                        $_SESSION['message'] = "Error updating stock for product $product_name.";
                        $_SESSION['message_type'] = "error";
                        header("Location: ../transactions.php");
                        exit();
                    }

                    // Insert into inventory_transaction_table
                    $transaction_type = 'sale'; // Set transaction type as 'sale'
                    $transaction_date = date('Y-m-d H:i:s');
                    $transaction_amount = $quantity * $price;
                    $user_id = $_SESSION['id'];
                    // $user_id = "1";

                    insertRecord(
                        'inventory_transaction_table',
                        'product_id, user_id, transaction_type, quantity, transaction_date, transaction_amount',
                        "'$product_id', '$user_id', '$transaction_type', '$quantity', '$transaction_date', '$transaction_amount'",
                        "Item added successfully!",
                        "Error logging transaction!"
                    );

                } else {
                    // Handle case where product not found
                    $_SESSION['message'] = "Error: Product not found in the product table.";
                    $_SESSION['message_type'] = "error";
                    header("Location: ../transactions.php");
                    exit();
                }
            }
            header("Location: ../transactions.php"); // Redirect to a success page
            exit();
        }
    }
}


if (isset($_POST['submit-product'])) {
    $product = $_POST['product'];
    $category_id = $_POST['category_id'];
    $brand_id = $_POST['brand_id'];
    $description = $_POST['description'];
    $size = $_POST['size'];
    $color = $_POST['color'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Remove commas from price input (e.g., "1,000" becomes "1000")
    $price = str_replace(',', '', $price);

    // Optionally, validate price is numeric and convert it to a float if needed
    $price = floatval($price); // Ensures it's treated as a float number

    // Calculate transaction amount
    $transaction_amount = $quantity * $price;

    // Get current timestamp
    $transaction_date = date('Y-m-d H:i:s');

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Insert record into the product_table
        $product_id = insertRecord(
            'product_table',
            '`product_name`, `product_size`, `product_color`, `category_id`, `description`, `quantity_in_stock`, `price`, `brand_id`',
            "'$product', '$size', '$color', '$category_id', '$description', '$quantity', '$price', '$brand_id'",
            "Product added successfully!",
            "Error adding product! Please try again."
        );

        if (!$product_id) {
            throw new Exception("Failed to insert product into product_table.");
        }

        // Insert record into the inventory_transaction_table
        $transaction_type = 'purchase'; // Setting transaction type as 'purchase'
        $user_id = $_SESSION['id']; 
        // $user_id = "1"; 

        $result = insertRecord(
            'inventory_transaction_table',
            '`product_id`, `user_id`, `transaction_type`, `quantity`, `transaction_date`, `transaction_amount`',
            "'$product_id', '$user_id', '$transaction_type', '$quantity', '$transaction_date', '$transaction_amount'",
            "Product added successfully!",
            "Error logging inventory transaction!"
        );

        if (!$result) {
            throw new Exception("Failed to insert into inventory_transaction_table.");
        }

        // Commit the transaction if both inserts succeed
        $conn->commit();

        // Redirect to stocks-options.php
        header("Location: ../stocks-options.php");
        exit();

    } catch (Exception $e) {
        // Rollback the transaction if any operation fails
        $conn->rollback();
        $_SESSION['message'] = "Transaction failed: " . $e->getMessage();
        $_SESSION['message_type'] = "error";

        // Redirect to the same page to show the error message
        header("Location: ../stocks-options.php");
        exit();
    }
}

if (isset($_POST['submit-user'])) {
    $full_name = $_POST['fullname'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if a new password is provided, and hash it if so
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);  // Hash the new password
    } else {
        // If password is empty, retain the current password (don't update it)
        $hashedPassword = null; // Will be handled in the SQL query later
    }

    // Prepare the columns and values
    $columns = [
        'full_name' => $full_name,
        'email' => $email,
        'username' => $username,
        'role' => $role,
    ];

    // Only add the hashed password to the columns if a new password is provided
    if ($hashedPassword) {
        $columns['password'] = $hashedPassword;
    } else {
        // If no password is provided, you might need to handle this case depending on your logic
        // (e.g., leaving the password as is or updating it)
    }

    // Debugging: Check if $columns has correct data
    var_dump($columns); // This will print the content of $columns to the page, so you can inspect the values.

    try {
        // Dynamically create the columns and values for SQL
        $columnNames = implode(", ", array_keys($columns));
        $columnValues = implode(", ", array_map(function ($value) {
            return "'" . $value . "'"; // Ensures string values are enclosed in quotes
        }, array_values($columns)));

        // Insert record into the user_table
        $user_id = insertRecord(
            'user_table',
            $columnNames,
            $columnValues,
            "User Account added successfully!",
            "Error adding User Account! Please try again."
        );

        if (!$user_id) {
            throw new Exception("Failed to insert into user_table.");
        }

        // Commit the transaction if both inserts succeed
        $conn->commit();

        // Redirect to users.php
        header("Location: ../users.php");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction if any operation fails
        $conn->rollback();
        $_SESSION['message'] = "Transaction failed: " . $e->getMessage();
        $_SESSION['message_type'] = "error";

        // Redirect to the same page to show the error message
        header("Location: ../users.php");
        exit();
    }
}



/*if (isset($_POST['submit-brand'])) {
    $brand = $_POST['brand'];
    $origin_country = $_POST['origin_country'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];

    insertRecord(
        'brand_table',
        '`brand_name`, `category_id`,`description`, `country_of_origin`',
        "'$brand','$category_id', '$description', '$origin_country'",
        "Brand added successfully!",
        "Error adding brand! Please try again. "
    );


    header("Location: ../stocks-options.php");
    exit();
}*/

$conn->close();
?>