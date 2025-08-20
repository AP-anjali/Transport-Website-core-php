<?php
session_start();
if (!isset($_SESSION['name'])) {
    header("Location: payment.php");
    exit();
}
session_destroy(); // Clear session after success
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Successful</title>
    <style>
        body { text-align: center; padding: 50px; background: #D4EDDA; }
    </style>
</head>
<body>
    <h1>✅ Payment Successful!</h1>
    <p>Thank you for booking with us.</p>
    <a href="index.php">Go to Home</a>
</body>
</html>
