<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['Name'])) {
    header("Location: ../index.php");
    exit();
}

$allowed_roles = ['user', 'developer'];


if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowed_roles)) {
    header("Location: ../admin/index.php");
    // echo 'Error Warning!<br>Unauthorize Access!<br>  Name: ' . $_SESSION['Name'] . '<br>Role: ' . $_SESSION['role'];


    exit();
}
