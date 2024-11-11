<?php
session_start();
include 'db_con.php';

if (isset($_POST['submit-category'])) {
    $category = $_POST['category'];

    // Insert query
    $sql = "INSERT INTO category_table (cat_name) VALUES ('$category')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Category added successfully!";
        $_SESSION['message_type'] = "success"; // success type
    } else {
        $_SESSION['message'] = "Error adding category! Please try again.";
        $_SESSION['message_type'] = "error"; // error type
    }

    // Redirect to stocks-options.php
    header("Location: ../stocks-options.php");
    exit();
}

$conn->close();
