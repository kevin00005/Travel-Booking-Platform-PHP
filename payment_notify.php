<?php
// ✅ DB connect
$conn = new mysqli("localhost", "root", "", "reliance_travels");

// ✅ PayHere POST DATA
$merchant_id     = $_POST['merchant_id'];
$order_id        = $_POST['order_id'];      // ORDER_23
$amount          = $_POST['payhere_amount'];
$currency        = $_POST['payhere_currency'];
$status_code     = $_POST['status_code'];   // 2 = success
$md5sig          = $_POST['md5sig'];

// ✅ Sandbox secret
$merchant_secret = "MzA4NTEzNzk0OTc2MzU1MTUwMzEyMTQzODY4NTQxMjk0Mjg4NDA5";

// ✅ Generate local signature
$local_md5 = strtoupper(
    md5(
        $merchant_id .
        $order_id .
        $amount .
        $currency .
        $status_code .
        strtoupper(md5($merchant_secret))
    )
);

// ✅ Validate
if ($local_md5 !== $md5sig) {
    exit("❌ Signature mismatch");
}

// ✅ Extract booking ID from ORDER_XX
$booking_id = intval(str_replace("ORDER_", "", $order_id));

// ✅ Payment success (status_code 2)
if ($status_code == 2) {
    $conn->query("UPDATE bookings SET status='PAID' WHERE booking_id=$booking_id");
    echo "✅ Payment confirmed for booking $booking_id";
} else {
    $conn->query("UPDATE bookings SET status='FAILED' WHERE booking_id=$booking_id");
    echo "❌ Payment failed";
}
?>
