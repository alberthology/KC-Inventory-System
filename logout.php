<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css'>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js'></script>

        <!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.min.css" rel="stylesheet">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.min.js"></script>
    <style type="text/css">
                * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }

   body {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #392614;
    position: relative;
}


    </style>
</head>
<body>

</body>

</html>

<?php
session_start();
session_unset();
session_destroy();
echo "
<script type='text/javascript'>
    $(document).ready(function() {
        toastr.options = {
            'closeButton': true,
            'debug': false,
            'newestOnTop': false,
            'positionClass': 'toast-top-right',
            'preventDuplicates': false,
            'onclick': null,
            'showDuration': '300',
            'hideDuration': '1000',
            'extendedTimeOut': '1000',
            'showEasing': 'swing',
            'hideEasing': 'linear',
            'showMethod': 'fadeIn',
            'hideMethod': 'fadeOut'
        };

        // Display the red toastr message
        toastr.success('Logged Out Successfully!', 'Success');
        
        setTimeout(function() {
            window.location.replace('login.php');
        }, 1000); // Redirect after 1 second
    });
</script>";
exit(); // Exit to prevent further execution
?>