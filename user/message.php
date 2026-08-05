<?php
// Display SweetAlert message if it exists
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];

    echo "<script>
        Swal.fire({
            icon: '$message_type',
            title: '$message',
            position: 'top-end', // Position the alert at the top-end
            showConfirmButton: false,
            timer: 1500,
            customClass: {
                popup: 'swal2-popup'
            }
        });
    </script>";

    // Clear the message after displaying it
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
