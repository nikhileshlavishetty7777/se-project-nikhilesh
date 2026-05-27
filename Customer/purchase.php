<?php
include('config/constants.php'); // Make sure session_start() is only called once

error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Kolkata');

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['purchase'])) {

    // Collect form data
    $tran_id = $_POST['tran_id'];
    $amount = $_POST['amount'];
    $username = $_POST['username'];
    $cus_name = $_POST['cus_name'];
    $cus_email = $_POST['cus_email'];
    $cus_add1 = $_POST['cus_add1'];
    $cus_city = $_POST['cus_city'];
    $cus_phone = $_POST['cus_phone'];
    $payment_status = $_POST['payment_status'];
    $order_date = date("Y-m-d H:i:s");

    // Insert into order_manager
   $sql = "INSERT INTO phonepe 
                (tran_id, username, customer_name, customer_email, amount, status, phone_number, order_date, payment_method)
                VALUES 
                ('$tran_id', '$username', '$cus_name', '$cus_email', '$amount', '$payment_status', '$cus_phone', '$order_date', 'PhonePe')";$sql = "INSERT INTO phonepe 
                (tran_id, username, customer_name, customer_email, amount, status, phone_number, order_date, payment_method)
                VALUES 
                ('$tran_id', '$username', '$cus_name', '$cus_email', '$amount', '$payment_status', '$cus_phone', '$order_date', 'PhonePe')";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        $phonepe_link = "upi://pay?pa=superworld@ibl&pn=SuperWorldCafe&am=$amount&cu=INR&tn=Order_$tran_id";
        $qr_url = "https://api.qrserver.com/v1/create-qr-code/?data=" . urlencode($phonepe_link) . "&size=200x200";
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Redirecting to PhonePe</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background: #f8f9fa;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    flex-direction: column;
                    text-align: center;
                }
                .spinner {
                    border: 6px solid #eee;
                    border-top: 6px solid #5c2d91;
                    border-radius: 50%;
                    width: 60px;
                    height: 60px;
                    animation: spin 1s linear infinite;
                    margin-bottom: 20px;
                }
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
                button {
                    background-color: #5c2d91;
                    color: white;
                    border: none;
                    padding: 12px 24px;
                    border-radius: 30px;
                    cursor: pointer;
                    font-size: 18px;
                }
                button:hover {
                    background-color: #4a2475;
                }
                .summary {
                    margin-top: 20px;
                    font-size: 18px;
                    color: #333;
                }
                .qr {
                    margin-top: 20px;
                }
            </style>
        </head>
        <body>
            <div class="spinner"></div>
            <h2>Redirecting to PhonePe...</h2>
            <p>Please wait while we take you to the payment page.</p>

            <div class="summary">
                <p><strong>Customer:</strong> <?= htmlspecialchars($cus_name) ?></p>
                <p><strong>Amount:</strong> ₹<?= htmlspecialchars($amount) ?></p>
                <p><strong>Transaction ID:</strong> <?= htmlspecialchars($tran_id) ?></p>
            </div>

            <button onclick="window.location.replace('<?= $phonepe_link ?>')">Pay Now with PhonePe</button>

            <div class="qr" id="qrBox" style="display:none;">
                <p>Scan this QR code with PhonePe:</p>
                <img src="<?= $qr_url ?>" alt="Scan to Pay">
            </div>

            <script>
                function isMobile() {
                    return /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
                }

                setTimeout(function() {
                    if (isMobile()) {
                        window.location.replace("<?= $phonepe_link ?>");
                    } else {
                        document.getElementById("qrBox").style.display = "block";
                    }
                }, 2000);
            </script>
        </body>
        </html>
        <?php
    } else {
        echo "<script>alert('Database error while saving order.'); window.location.href='mycart.php';</script>";
    }

} else {
    echo "<script>alert('Invalid request.'); window.location.href='mycart.php';</script>";
}
?>