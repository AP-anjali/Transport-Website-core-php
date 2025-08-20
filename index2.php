<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Payment | Tourism Booking</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background: linear-gradient(to right, #FFB75E, #ED8F03);
            color: white;
        }
        .payment-box {
            background: white;
            color: black;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
            margin-top: 50px;
            animation: fadeIn 1s ease-in-out;
        }
        .btn-pay {
            background: #ff6600;
            color: white;
            font-size: 18px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-pay:hover {
            background: #cc5200;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .card-details, .upi-details, .netbanking-details {
            display: none;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="payment-box">
                <h3 class="text-center">Tourism Package Booking</h3>
                <form method="post" action="pay.php">
                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Phone No:</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Amount (INR):</label>
                        <input type="text" name="amt" class="form-control" value="99" required>
                    </div>
                    <div class="form-group">
                        <label>Payment Method:</label>
                        <select name="payment_method" id="payment_method" class="form-control" required>
                            <option value="card">Credit/Debit Card</option>
                            <option value="upi">UPI</option>
                            <option value="netbanking">Net Banking</option>
                        </select>
                    </div>

                    <!-- Card Details -->
                    <div class="card-details">
                        <div class="form-group">
                            <label>Card Number:</label>
                            <input type="text" class="form-control" placeholder="1234 5678 9012 3456" required>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label>Expiry Date:</label>
                                <input type="text" class="form-control" placeholder="MM/YY" required>
                            </div>
                            <div class="col">
                                <label>CVV:</label>
                                <input type="password" class="form-control" placeholder="123" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Card Holder Name:</label>
                            <input type="text" class="form-control" required>
                        </div>
                    </div>

                    <!-- UPI Details -->
                    <div class="upi-details">
                        <div class="form-group">
                            <label>Enter UPI ID:</label>
                            <input type="text" class="form-control" placeholder="yourname@upi" required>
                        </div>
                    </div>

                    <!-- Net Banking Details -->
                    <div class="netbanking-details">
                        <div class="form-group">
                            <label>Select Bank:</label>
                            <select class="form-control">
                                <option>State Bank of India</option>
                                <option>HDFC Bank</option>
                                <option>ICICI Bank</option>
                                <option>Axis Bank</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-pay btn-block"><a herf="pay.php">Proceed to Pay</a></button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $("#payment_method").change(function() {
        $(".card-details, .upi-details, .netbanking-details").hide();
        let method = $(this).val();
        if (method == "card") $(".card-details").show();
        else if (method == "upi") $(".upi-details").show();
        else if (method == "netbanking") $(".netbanking-details").show();
    });
});
</script>
</body>
</html>
