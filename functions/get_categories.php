<?php
include('db_con.php'); 
$query = "SELECT * FROM category_table";
$result = mysqli_query($conn, $query);

$categories = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
}

echo json_encode($categories);
?>
