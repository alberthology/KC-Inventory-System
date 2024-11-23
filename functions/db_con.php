<?php
$servername = "localhost";
$username = "root";  // Replace with your MySQL username
$password = "";  // Replace with your MySQL password
$dbname = "inventory_db";

date_default_timezone_set("Asia/Manila");
$now = new DateTime();

if (!function_exists('numberToWords')) {
    function numberToWords($num) {
        $ones = [
            0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four',
            5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen',
            14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen',
            18 => 'eighteen', 19 => 'nineteen'
        ];

        $tens = [
            20 => 'twenty', 30 => 'thirty', 40 => 'forty', 50 => 'fifty',
            60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
        ];

        if ($num < 20) {
            return $ones[$num];
        } elseif ($num < 100) {
            $ten = floor($num / 10) * 10;
            $one = $num % 10;
            return $tens[$ten] . ($one > 0 ? '-' . $ones[$one] : '');
        }
        
        return $num;  // Default, in case it's larger than 99.
    }
}




// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Failed to connect to the database: " . $conn->connect_error);
}

if ($_SERVER['SERVER_NAME'] == 'yourproductiondomain.com') {
    ini_set('display_errors', 0);
    error_reporting(0);
} else {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}