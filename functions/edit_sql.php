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

// Check if the edit form was submitted
if (isset($_POST['brand_id'], $_POST['brand'], $_POST['origin_country'], $_POST['description'])) {
    // Retrieve the POST data
    $brand_id = $_POST['brand_id'];
    $brand_name = $_POST['brand'];
    $country_of_origin = $_POST['origin_country'];
    $description = $_POST['description'];

    // Prepare the columns and values for the update
    $columns = [
        'brand_name' => $brand_name,
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

    // Redirect after the operation
    header("Location: ../stocks-options.php");
    exit();
} else {
    $_SESSION['message'] = "Missing form data!";
    $_SESSION['message_type'] = "error";
    header("Location: ../stocks-options.php");
    exit();
}

$conn->close();
?>
