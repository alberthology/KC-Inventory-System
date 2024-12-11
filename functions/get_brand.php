<?php
include('db_con.php'); 
$query = "SELECT * FROM brand_table";
$result = mysqli_query($conn, $query);

$brand = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $brand[] = $row;
    }
}

echo json_encode($brand);
?>
