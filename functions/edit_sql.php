<?php
session_start();
include 'db_con.php';

// Function to handle updating a record in the database
// =============================== OLD VULNERABLE CODE 
// function editRecord($table, $columns, $whereCondition, $successMessage, $errorMessage)
// {
//     global $conn;

//     // Dynamically build the SQL update query with placeholders
//     $setClause = [];
//     $bindTypes = ''; // To store the types for the bind_param
//     $bindValues = []; // To store the values for bind_param

//     foreach ($columns as $column => $value) {
//         $setClause[] = "$column = ?";
//         // Dynamically determine the bind type based on the value's type
//         if (is_int($value)) {
//             $bindTypes .= 'i'; // integer
//         } elseif (is_double($value)) {
//             $bindTypes .= 'd'; // double
//         } else {
//             $bindTypes .= 's'; // string
//         }
//         $bindValues[] = $value;
//     }

//     $setClauseString = implode(", ", $setClause);

//     // Construct the full SQL query
//     $sql = "UPDATE $table SET $setClauseString WHERE $whereCondition";

//     // Prepare the statement
//     if ($stmt = $conn->prepare($sql)) {
//         // Bind parameters
//         $stmt->bind_param($bindTypes, ...$bindValues);

//         // Execute the query
//         if ($stmt->execute()) {
//             $_SESSION['message'] = $successMessage;
//             $_SESSION['message_type'] = "success";
//         } else {
//             $_SESSION['message'] = $errorMessage . $conn->error;
//             $_SESSION['message_type'] = "error";
//         }

//         // Close the prepared statement
//         $stmt->close();
//     } else {
//         $_SESSION['message'] = "Error preparing the SQL statement!";
//         $_SESSION['message_type'] = "error";
//     }
// }



//////////////////////////////



// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_type'])) {
//     $formType = $_POST['form_type'];

//     if ($formType == 'update_product') {
//         // Retrieve form inputs
//         $productId = $_POST['product_id'];
//         $productName = $_POST['product'];
//         $size = $_POST['size'];
//         $color = $_POST['color'];
//         $quantity = $_POST['quantity'];
//         $price = $_POST['price'];
//         $categoryId = $_POST['category_id'];
//         $brandId = $_POST['brand_id'];
//         $description = $_POST['description'];

//         // Fetch current product details for comparison
//         $sql = "SELECT quantity_in_stock, price FROM product_table WHERE product_id = ?";
//         $stmt = $conn->prepare($sql);
//         $stmt->bind_param('i', $productId);
//         $stmt->execute();
//         $result = $stmt->get_result();
//         $currentProduct = $result->fetch_assoc();
//         $stmt->close();

//         // Check if quantity or price changed
//         $quantityChanged = ($quantity != $currentProduct['quantity_in_stock']);
//         $priceChanged = ($price != $currentProduct['price']);

//         // Build the columns for the update query
//         $columns = [
//             'product_name' => $productName,
//             'product_size' => $size,
//             'product_color' => $color,
//             'quantity_in_stock' => $quantity,
//             'price' => $price,
//             'category_id' => $categoryId,
//             'brand_id' => $brandId,
//             'description' => $description
//         ];

//         // Perform the update using the editRecord function
//         $whereCondition = "product_id = $productId";
//         $successMessage = "Product updated successfully!";
//         $errorMessage = "Error updating product!";
//         editRecord('product_table', $columns, $whereCondition, $successMessage, $errorMessage);

//         // Insert into inventory_transaction_table if quantity or price changed
//         if ($quantityChanged || $priceChanged) {
//             $transactionType = $quantityChanged ? 'purchase' : 'price_update'; // Differentiate transaction types
//             $quantityDifference = $quantityChanged ? $quantity - $currentProduct['quantity_in_stock'] : 0;

//             // Insert transaction
//             $transactionSQL = "INSERT INTO inventory_transaction_table 
//                 (product_id, user_id, transaction_type, quantity, transaction_date, transaction_amount) 
//                 VALUES (?, ?, ?, ?, NOW(), ?)";

//             $transactionAmount = $quantityDifference * $price; // Calculate total amount for stock change
//             $userId = $_SESSION['id']; // Use session user_id in production
//             // $userId = 1; // Temporary placeholder

//             $transactionStmt = $conn->prepare($transactionSQL);
//             $transactionStmt->bind_param(
//                 'iisid',
//                 $productId,
//                 $userId,
//                 $transactionType,
//                 $quantityDifference,
//                 $transactionAmount
//             );
//             $transactionStmt->execute();
//             $transactionStmt->close();
//         }

//         // Redirect after completion
//         header("Location: ../stocks-options.php");
//         exit();
//     }
// } else {
//     $_SESSION['message'] = "Invalid request!";
//     $_SESSION['message_type'] = "error";
//     header("Location: ../transactions.php");
//     exit();
// }






// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_type'])) {

//     $formType = $_POST['form_type'];

//     if ($formType == 'update_payment') {
//         // Get the data from the form
//         $order_item_id = $_POST['order_item_id'];
//         $payment = $_POST['payment']; // The new partial payment

//         // Remove commas before processing the value
//         $payment = str_replace(',', '', $payment);

//         // Convert to float (decimal)
//         $payment = (float)$payment; // This will now be a valid decimal number

//         // Now update the payment in the order_item_table
//         $query = "
//             SELECT 
//                 o.total_price, 
//                 o.unit_price, 
//                 o.order_item_id, 
//                 i.status, 
//                 i.order_id 
//             FROM order_item_table o
//             JOIN order_table i ON o.order_id = i.order_id
//             WHERE o.order_item_id = ?";

//         if ($stmt = $conn->prepare($query)) {
//             $stmt->bind_param('i', $order_item_id);
//             $stmt->execute();
//             // Bind result for all 5 fields selected in the query
//             $stmt->bind_result($total_price, $unit_price, $order_item_id, $status, $order_id);
//             $stmt->fetch();
//             $stmt->close();

//             // Check if payment equals unit price and update the status accordingly
//             if ($payment == $unit_price && $status == 'Ongoing') {
//                 // Update the status to 'Complete'
//                 $updateStatusQuery = "UPDATE order_table SET status = 'Completed' WHERE order_id = ?";
//                 if ($updateStmt = $conn->prepare($updateStatusQuery)) {
//                     $updateStmt->bind_param('i', $order_id);
//                     $updateStmt->execute();
//                     $updateStmt->close();

//                     $_SESSION['message'] = "Payment and order status updated successfully.";
//                     $_SESSION['message_type'] = "success";
//                 } else {
//                     $_SESSION['message'] = "Error updating order status: " . $conn->error;
//                     $_SESSION['message_type'] = "error";
//                 }
//             }

//             // Now update the payment in the order_item_table
//             $updatePaymentQuery = "UPDATE order_item_table SET payment = ? WHERE order_item_id = ?";
//             if ($updateStmt = $conn->prepare($updatePaymentQuery)) {
//                 $updateStmt->bind_param('di', $payment, $order_item_id);
//                 $updateStmt->execute();
//                 $updateStmt->close();

//                 $_SESSION['message'] = "Payment updated successfully.";
//                 $_SESSION['message_type'] = "success";
//             } else {
//                 $_SESSION['message'] = "Error updating payment: " . $conn->error;
//                 $_SESSION['message_type'] = "error";
//             }
//         } else {
//             $_SESSION['message'] = "Error retrieving order details: " . $conn->error;
//             $_SESSION['message_type'] = "error";
//         }

//         header('Location: ../transactions.php'); // Redirect to appropriate page
//         exit();
//     } elseif ($formType == 'update_brand') {
//         // Check if the edit form was submitted
//         if (isset($_POST['brand_id'], $_POST['brand'], $_POST['category_id'], $_POST['origin_country'], $_POST['description'])) {
//             // Retrieve the POST data
//             $brand_id = $_POST['brand_id'];
//             $brand_name = $_POST['brand'];
//             $category_id = $_POST['category_id'];
//             $country_of_origin = $_POST['origin_country'];
//             $description = $_POST['description'];

//             // Prepare the columns and values for the update
//             $columns = [
//                 'brand_name' => $brand_name,
//                 'category_id' => $category_id,
//                 'country_of_origin' => $country_of_origin,
//                 'description' => $description
//             ];

//             // Use the editRecord function to update the brand
//             editRecord(
//                 'brand_table',          // Table name
//                 $columns,               // Columns and their new values
//                 "brand_id = $brand_id", // WHERE condition
//                 "Brand updated successfully!",  // Success message
//                 "Error updating brand! Please try again."  // Error message
//             );

//             header("Location: ../stocks-options.php");
//             exit();
//         } else {
//             $_SESSION['message'] = "Missing form data!";
//             $_SESSION['message_type'] = "error";
//             header("Location: ../stocks-options.php");
//             exit();
//         }
//     }
// } else {
//     $_SESSION['message'] = "Invalid request!";
//     $_SESSION['message_type'] = "error";
//     header("Location: ../transactions.php");
//     exit();
//     $conn->close();
// }

// =============================== UPDATED EDIT

function editRecord($table, $columns, $whereCondition, $whereParams, $successMessage, $errorMessage)
{
    global $conn;

    $setClause = [];
    $bindTypes = '';
    $bindValues = [];

    foreach ($columns as $column => $value) {
        $setClause[] = "$column = ?";
        if (is_int($value)) {
            $bindTypes .= 'i';
        } elseif (is_double($value)) {
            $bindTypes .= 'd';
        } else {
            $bindTypes .= 's';
        }
        $bindValues[] = $value;
    }

    // Add the WHERE clause params (e.g. user_id) to the same bind list
    foreach ($whereParams as $param) {
        if (is_int($param)) {
            $bindTypes .= 'i';
        } else {
            $bindTypes .= 's';
        }
        $bindValues[] = $param;
    }

    $setClauseString = implode(", ", $setClause);
    $sql = "UPDATE $table SET $setClauseString WHERE $whereCondition";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param($bindTypes, ...$bindValues);

        if ($stmt->execute()) {
            $_SESSION['message'] = $successMessage;
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = $errorMessage . $conn->error;
            $_SESSION['message_type'] = "error";
        }

        $stmt->close();
    } else {
        $_SESSION['message'] = "Error preparing the SQL statement!";
        $_SESSION['message_type'] = "error";
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_type'])) {
    $formType = $_POST['form_type'];

    if ($formType == 'update_product') {
        // Retrieve form inputs
        $productId = $_POST['product_id'];
        $productName = $_POST['product'];
        $size = $_POST['size'];
        $color = $_POST['color'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $categoryId = $_POST['category_id'];
        $brandId = $_POST['brand_id'];
        $description = $_POST['description'];

        // Fetch current product details for comparison
        $sql = "SELECT quantity_in_stock, price FROM product_table WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $currentProduct = $result->fetch_assoc();
        $stmt->close();

        // Check if quantity or price changed
        $quantityChanged = ($quantity != $currentProduct['quantity_in_stock']);
        $priceChanged = ($price != $currentProduct['price']);

        // Build the columns for the update query
        $columns = [
            'product_name' => $productName,
            'product_size' => $size,
            'product_color' => $color,
            'quantity_in_stock' => $quantity,
            'price' => $price,
            'category_id' => $categoryId,
            'brand_id' => $brandId,
            'description' => $description
        ];

        // Perform the update using the editRecord function
        editRecord(
            'product_table',
            $columns,
            "product_id = ?",
            [$productId],
            "Product updated successfully!",
            "Error updating product!"
        );

        // Insert into inventory_transaction_table if quantity or price changed
        if ($quantityChanged || $priceChanged) {
            $transactionType = $quantityChanged ? 'update' : 'price_update';
            $quantityDifference = $quantityChanged ? $quantity - $currentProduct['quantity_in_stock'] : 0;

            $transactionSQL = "INSERT INTO inventory_transaction_table 
                (product_id, user_id, transaction_type, quantity, transaction_date, transaction_amount) 
                VALUES (?, ?, ?, ?, NOW(), ?)";

            $transactionAmount = $quantityDifference * $price;
            $userId = $_SESSION['id'];

            $transactionStmt = $conn->prepare($transactionSQL);
            $transactionStmt->bind_param(
                'iisid',
                $productId,
                $userId,
                $transactionType,
                $quantityDifference,
                $transactionAmount
            );
            $transactionStmt->execute();
            $transactionStmt->close();
        }

        // Redirect after completion
        header("Location: ../admin/stocks-options.php");
        exit();
    }
} else {
    $_SESSION['message'] = "Invalid request!";
    $_SESSION['message_type'] = "error";
    header("Location: ../admin/transactions.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_type'])) {

    $formType = $_POST['form_type'];

    if ($formType == 'update_payment') {
        // Get the data from the form
        $order_item_id = $_POST['order_item_id'];
        $payment = $_POST['payment'];

        // Remove commas before processing the value
        $payment = str_replace(',', '', $payment);
        $payment = (float)$payment;

        $query = "
            SELECT 
                o.total_price, 
                o.unit_price, 
                o.order_item_id, 
                i.status, 
                i.order_id 
            FROM order_item_table o
            JOIN order_table i ON o.order_id = i.order_id
            WHERE o.order_item_id = ?";

        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('i', $order_item_id);
            $stmt->execute();
            $stmt->bind_result($total_price, $unit_price, $order_item_id, $status, $order_id);
            $stmt->fetch();
            $stmt->close();

            // Check if payment equals unit price and update the status accordingly
            if ($payment == $unit_price && $status == 'Ongoing') {
                $updateStatusQuery = "UPDATE order_table SET status = 'Completed' WHERE order_id = ?";
                if ($updateStmt = $conn->prepare($updateStatusQuery)) {
                    $updateStmt->bind_param('i', $order_id);
                    $updateStmt->execute();
                    $updateStmt->close();

                    $_SESSION['message'] = "Payment and order status updated successfully.";
                    $_SESSION['message_type'] = "success";
                } else {
                    $_SESSION['message'] = "Error updating order status: " . $conn->error;
                    $_SESSION['message_type'] = "error";
                }
            }

            // Now update the payment in the order_item_table
            $updatePaymentQuery = "UPDATE order_item_table SET payment = ? WHERE order_item_id = ?";
            if ($updateStmt = $conn->prepare($updatePaymentQuery)) {
                $updateStmt->bind_param('di', $payment, $order_item_id);
                $updateStmt->execute();
                $updateStmt->close();

                $_SESSION['message'] = "Payment updated successfully.";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Error updating payment: " . $conn->error;
                $_SESSION['message_type'] = "error";
            }
        } else {
            $_SESSION['message'] = "Error retrieving order details: " . $conn->error;
            $_SESSION['message_type'] = "error";
        }

        header('Location: ../admin/transactions.php');
        exit();
    } elseif ($formType == 'update_brand') {
        // Check if the edit form was submitted
        if (isset($_POST['brand_id'], $_POST['brand'], $_POST['category_id'], $_POST['origin_country'], $_POST['description'])) {
            $brand_id = $_POST['brand_id'];
            $brand_name = $_POST['brand'];
            $category_id = $_POST['category_id'];
            $country_of_origin = $_POST['origin_country'];
            $description = $_POST['description'];

            $columns = [
                'brand_name' => $brand_name,
                'category_id' => $category_id,
                'country_of_origin' => $country_of_origin,
                'description' => $description
            ];

            // Use the editRecord function to update the brand
            editRecord(
                'brand_table',
                $columns,
                "brand_id = ?",
                [$brand_id],
                "Brand updated successfully!",
                "Error updating brand! Please try again."
            );

            header("Location: ../admin/stocks-options.php");
            exit();
        } else {
            $_SESSION['message'] = "Missing form data!";
            $_SESSION['message_type'] = "error";
            header("Location: ../admin/stocks-options.php");
            exit();
        }
    }
} else {
    $_SESSION['message'] = "Invalid request!";
    $_SESSION['message_type'] = "error";
    header("Location: ../admin/transactions.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_type'])) {
    $formType = $_POST['form_type'];

    if ($formType == 'update_user') {
        // Get the data from the form
        $id = $_POST['id'];
        $full_name = trim($_POST['Fullname']);
        $uname = trim($_POST['username']);
        // $role = $_POST['role'];
        $email = trim($_POST['email']);
        $pass = $_POST['password'];

        // ---- Check if email is already used by ANOTHER user ----
        $checkStmt = $conn->prepare("SELECT user_id FROM user_table WHERE email = ? AND user_id != ?");
        $checkStmt->bind_param("si", $email, $id);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            $_SESSION['message'] = "Email address is already used. Please use a different email.";
            $_SESSION['message_type'] = "error";
            header("Location: ../admin/profile.php");
            exit();
        }
        $checkStmt->close();

        // Check if a new password is provided, and hash it if so
        if (!empty($pass)) {
            $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
        } else {
            $hashedPassword = null; // Keep current password
        }

        $columns = [
            'full_name' => $full_name,
            'email' => $email,
            'username' => $uname,
            // 'role' => $role
        ];

        // Only add the hashed password to the columns if a new password is provided
        if ($hashedPassword) {
            $columns['password'] = $hashedPassword;
        }

        $whereCondition = "user_id = ?";

        editRecord(
            'user_table',
            $columns,
            $whereCondition,
            [$id],   // where params
            "Your User Account updated successfully!",
            "Notice! Error updating your user details! Please try again."
        );

        header("Location: ../admin/profile.php");
        exit();
    } else {
        $_SESSION['message'] = "Missing form data!";
        $_SESSION['message_type'] = "error";
        header("Location: ../admin/profile.php");
        exit();
    }
} else {
    $_SESSION['message'] = "Invalid request!";
    $_SESSION['message_type'] = "error";
    header("Location: ../admin/profile.php");
    exit();
}

$conn->close();
