<?php
session_start();
include 'db_con.php';

// Function to handle updating a record in the database
function editRecord($table, $columns, $whereCondition, $successMessage, $errorMessage) {
    global $conn;

    // Dynamically build the SQL update query with placeholders
    $setClause = [];
    $bindTypes = ''; // To store the types for the bind_param
    $bindValues = []; // To store the values for bind_param

    foreach ($columns as $column => $value) {
        $setClause[] = "$column = ?";
        // Dynamically determine the bind type based on the value's type
        if (is_int($value)) {
            $bindTypes .= 'i'; // integer
        } elseif (is_double($value)) {
            $bindTypes .= 'd'; // double
        } else {
            $bindTypes .= 's'; // string
        }
        $bindValues[] = $value;
    }

    $setClauseString = implode(", ", $setClause);

    // Construct the full SQL query
    $sql = "UPDATE $table SET $setClauseString WHERE $whereCondition";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param($bindTypes, ...$bindValues);

        // Execute the query
        if ($stmt->execute()) {
            $_SESSION['message'] = $successMessage;
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = $errorMessage . $conn->error;
            $_SESSION['message_type'] = "error";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        $_SESSION['message'] = "Error preparing the SQL statement!";
        $_SESSION['message_type'] = "error";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_type'])) {

    $formType = $_POST['form_type'];

    if ($formType == 'update_payment') {
        // Get the data from the form
        $order_item_id = $_POST['order_item_id'];
        $payment = $_POST['payment']; // The new partial payment

        // Remove commas before processing the value
        $payment = str_replace(',', '', $payment);

        // Convert to float (decimal)
        $payment = (float)$payment; // This will now be a valid decimal number

        // Now update the payment in the order_item_table
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
            // Bind result for all 5 fields selected in the query
            $stmt->bind_result($total_price, $unit_price, $order_item_id, $status, $order_id);
            $stmt->fetch();
            $stmt->close();

            // Check if payment equals unit price and update the status accordingly
            if ($payment == $unit_price && $status == 'Ongoing') {
                // Update the status to 'Complete'
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

        header('Location: ../transactions.php'); // Redirect to appropriate page
        exit();
    } elseif ($formType == 'update_brand') {
        // Check if the edit form was submitted
        if (isset($_POST['brand_id'], $_POST['brand'], $_POST['category_id'], $_POST['origin_country'], $_POST['description'])) {
            // Retrieve the POST data
            $brand_id = $_POST['brand_id'];
            $brand_name = $_POST['brand'];
            $category_id = $_POST['category_id'];
            $country_of_origin = $_POST['origin_country'];
            $description = $_POST['description'];

            // Prepare the columns and values for the update
            $columns = [
                'brand_name' => $brand_name,
                'category_id' => $category_id,
                'country_of_origin' => $country_of_origin,
                'description' => $description
            ];

            // Use the editRecord function to update the brand
            editRecord(
                'brand_table',          // Table name
                $columns,               // Columns and their new values
                "brand_id = $brand_id", // WHERE condition
                "Brand updated successfully!",  // Success message
                "Error updating brand! Please try again."  // Error message
            );

            header("Location: ../stocks-options.php");
            exit();
        } else {
            $_SESSION['message'] = "Missing form data!";
            $_SESSION['message_type'] = "error";
            header("Location: ../stocks-options.php");
            exit();
        }
    }
} else {
    $_SESSION['message'] = "Invalid request!";
    $_SESSION['message_type'] = "error";
    header("Location: ../transactions.php");
    exit();
}

$conn->close();
?>
