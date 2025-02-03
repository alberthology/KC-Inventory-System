<?php
session_start();
include 'db_con.php';

// Fetch sales data grouped by month
$query = "SELECT 
    DATE_FORMAT(i.order_date, '%Y-%m') AS month,
    SUM(o.total_price) AS total_sales
    FROM order_item_table o
    LEFT JOIN order_table i ON o.order_id = i.order_id
    GROUP BY DATE_FORMAT(i.order_date, '%Y-%m')";

$result = $conn->query($query);

$sales_data = [];
$categories = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['month'];
        $sales_data[] = $row['total_sales'];
    }
}

// Encode data for JavaScript
echo json_encode(['categories' => $categories, 'sales_data' => $sales_data]);
$conn->close();
?>
