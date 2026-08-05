<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['Name'])) {
    header("Location: ../index.php");
    exit();
}

$allowed_roles = ['admin', 'developer'];

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowed_roles)) {
    // header("Location: ../index.php");
    // echo 'Error Warning!<br>Unauthorize Access!<br>  Name: ' . $_SESSION['Name'] . '<br>Role: ' . $_SESSION['role'];

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- Bootstrap 4 -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <title>Unauthorized Access</title>
        <style>
            body {
                background-color: #ffeea8;
            }
        </style>
    </head>

    <body>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-6 m-auto">
                            <div class="card mt-5 bg-danger">
                                <div class="card-header ">
                                    <h2 class="text-warning">Access Denied: Unauthorized Access</h2>
                                </div>
                                <div class="card-body">
                                    <p class="text-white">Unfortunately, you do not have the permission to view this page. Access to this resource is restricted to authorized personnel only. If you believe you are seeing this message in error, please contact your system administrator or log in with an account that has the required privileges. Thank you!</p>
                                </div>
                                <div class="card-footer">
                                    <a href="../logout.php" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left-short"></i> Logout
                                    </a>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>

<?php

    exit();
}
