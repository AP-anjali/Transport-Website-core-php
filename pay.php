<?php
require('config.php');
require('razorpay-php/Razorpay.php');
session_start();

use Razorpay\Api\Api;

// Validate session data
if (!isset($_SESSION['amount']) || empty($_SESSION['amount'])) {
    die("Invalid payment request. Please go back and try again.");
}

$amt = htmlentities($_SESSION['amount']);
$img = isset($_SESSION['img']);
$customer_name = isset($_SESSION['name']) ? htmlentities($_SESSION['name']) : "User";
$customer_email = isset($_SESSION['email']) ? htmlentities($_SESSION['email']) : "guest@example.com";
$customer_phone = isset($_SESSION['phone']) ? htmlentities($_SESSION['phone']) : "+91 7600507883";

$api = new Api($keyId, $keySecret);

$orderData = [
    'receipt'         => rand(1000, 9999),
    'amount'          => $amt * 100, // Convert amount to paise
    'currency'        => 'INR',
    'payment_capture' => 1 // Auto capture
];

try {
    $razorpayOrder = $api->order->create($orderData);
} catch (Exception $e) {
    die("Error creating Razorpay order: " . $e->getMessage());
}

$razorpayOrderId = $razorpayOrder['id'];
$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$checkout = 'automatic';
if (isset($_GET['checkout']) && in_array($_GET['checkout'], ['automatic', 'manual'], true)) {
    $checkout = $_GET['checkout'];
}

$data = [
    "key"               => $keyId,
    "amount"            => $orderData['amount'],
    "name"              => "Dream Destinations",
    "description"       => "Advance Booking for Tours",
    "image"             => "https://source.unsplash.com/100x100/?travel",
    "prefill"           => [
        "name"          => $customer_name,
        "email"         => $customer_email,
        "contact"       => $customer_phone,
    ],
    "notes"             => [
        "booking_id"    => rand(100000, 999999),
        "customer_name" => $customer_name,
    ],
    "theme"             => [
        "color"         => "#ff6600"
    ],
    "order_id"          => $razorpayOrderId,
];

$json = json_encode($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Payment | Dream Destinations</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to right, #FFB75E, #ED8F03);
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .payment-container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            color: black;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s ease-in-out;
        }
        .btn-pay {
            background: #ff6600;
            color: white;
            font-size: 18px;
            font-weight: bold;
            width: 100%;
            transition: 0.3s;
        }
        .btn-pay:hover {
            background: #cc5200;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="payment-container">
    <h2>Secure Your Dream Destination!</h2>
    <p>You're about to make an advance payment for your tour.</p>
				<img src="<?php echo $img;?>" class="img-responsive" alt="">
    <p><strong>Amount:</strong> ₹<?php echo $amt; ?></p>
    <button id="pay-button" class="btn btn-pay">Proceed to Pay</button>
</div>

<script>
var options = <?php echo $json; ?>;
options.handler = function (response) {
    alert("Payment Successful! Payment ID: " + response.razorpay_payment_id);
    window.location.href = "index.php";
};

var rzp1 = new Razorpay(options);
document.getElementById('pay-button').onclick = function(e) {
    rzp1.open();
    e.preventDefault();
};
</script>

</body>
</html>
