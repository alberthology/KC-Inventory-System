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
            0 => 'zero', 1,-1 => 'one', 2,-2 => 'two', 3,-3 => 'three', 4,-4 => 'four',
            5,-5 => 'five', 6,-6 => 'six', 7,-7 => 'seven', 8,-8 => 'eight', 9,-9 => 'nine',
            10,-10 => 'ten', 11,-11 => 'eleven', 12,-12 => 'twelve', 13,-13 => 'thirteen',
            14,-14 => 'fourteen', 15,-15 => 'fifteen', 16,-16 => 'sixteen', 17,-17 => 'seventeen',
            18,-18 => 'eighteen', 19,-19 => 'nineteen'
        ];

        $tens = [
            20,-20 => 'twenty', 30,-30 => 'thirty', 40,-40 => 'forty', 50,-50 => 'fifty',
            60,-60 => 'sixty', 70,-70 => 'seventy', 80,-80 => 'eighty', 90,-90 => 'ninety'
        ];

         $hundreds = [
            100 => 'hundred', 1000 => 'thousand'
        ];

        if ($num < 20) {
            return $ones[$num];
        } elseif ($num < 100) {
            $ten = floor($num / 10) * 10;
            $one = $num % 10;
            return $tens[$ten] . ($one > 0 ? '-' . $ones[$one] : '');
        } elseif ($num < 1000) {
            $hundred = floor($num / 100);
            $remainder = $num % 100;
            return $ones[$hundred] . ' ' . $hundreds[100] . ($remainder > 0 ? ' and ' . numberToWords($remainder) : '');
        } elseif ($num < 10000) {
            $thousand = floor($num / 1000);
            $remainder = $num % 1000;
            return $ones[$thousand] . ' ' . $hundreds[1000] . ($remainder > 0 ? ' ' . numberToWords($remainder) : '');
        }
        
        return $num;  // Default, in case it's larger than 9999
    }
}




// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Failed to connect to the database: " . $conn->connect_error);
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

if ($_SERVER['SERVER_NAME'] == 'yourproductiondomain.com') {
    ini_set('display_errors', 0);
    error_reporting(0);
} else {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}