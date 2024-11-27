<?php

include 'db_con.php';

// Assuming you already have a database connection ($conn)
$query = "SELECT brand_id, brand_name FROM brand_table";
$result = mysqli_query($conn, $query);

$brands = [];
while ($row = mysqli_fetch_assoc($result)) {
    $brands[] = $row;
}

echo json_encode($brands);
?>
