<?php
session_start();

include 'functions/db_con.php';

if (!isset($_SESSION['Name'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<!-- Meta -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>KC'Closet Inventory System</title>
<link rel="icon" type="image/x-icon" href="assets/images/closet.png">

<!-- Fonts and Icons -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

<!-- Bootstrap 4 -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="assets/css/main.css">
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

<!-- Scripts -->
<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <style>
        /* Custom CSS for smaller SweetAlert */
        .swal2-popup {
            font-size: 12px;
            /* Adjust font size */
            padding: 10px;
            /* Adjust padding */
            width: 250px;
            /* Set a fixed width */
        }
.comment-box {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        }
.control-number {
            font-weight: bold;
            margin-top: 5px;
            margin-bottom: 25px;
        }
.suggestion {
            margin-bottom: 5px;
            margin-top: 5px;
        }
.date{
                font-size: 14px;
                color:#808080;

}
.hyprlnk{
  color: black;
}
.hyprlnk:hover{
  color: green;
}
    </style>
</head>

<body class="hold-transition sidebar-mini">