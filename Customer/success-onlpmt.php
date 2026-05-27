<?php
include('config/constants.php');

if (isset($_GET['tran_id'])) {
    $tran_id = $_GET['tran_id'];

    // Update order status
    $sql = "UPDATE order_manager SET payment_status='Paid', order_status='Confirmed' WHERE transaction_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $tran_id);
    mysqli_stmt_execute($stmt);

    echo "<h2 class='text-success text-center mt-5'>✅ Payment Successful!</h2>";
    echo "<p class='text-center'>Your transaction ID: <strong>$tran_id</strong></p>";
    echo "<div class='text-center'><a href='view-orders.php' class='btn btn-primary mt-3'>View Your Orders</a></div>";
} else {
    echo "<h2 class='text-danger text-center mt-5'>❌ Invalid Access</h2>";
}
?>